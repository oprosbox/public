
<?php

include_once 'sql\functMySQLOut.php';
// в данном модуле хранится 
//объект наследник SNews предназначен для обработки и хранения информации о 1 статье находящейся на редактировании
//посредством объекта происходит взаимодействие с формой пользователя
class WNews extends SNews
{   
  public 
  $flgHeader, //флаг корректности заголовка
  $flgDatePublic, //флаг корректности даты публикации
  $flgAnnonce, //флаг корректности аннотации
  $flgText, //флаг корректности текста статьи
  $flgPicture; //флаг корректности введеной картинки
  public 
  $flgFirst; //флаг первой инициализации 
// функция просто выводит сообщенния в зависимости от флага  
 public function resultOperat($flg)
 {if ($this->flgFirst){}
      elseif($flg){return "<p><h5 style='color:green'>корректно!</h5>";}
           else{return "<p><h5 style='color:red'>откорректируйте!</h5>";}
 }
//---------------------------------вытаскивает и проверяет картинку----------------------------------------------
protected function isGoodPict($name,&$pict,&$size_pict,&$report)
{ $flgResult=false;$size=0;
 if(isset($_POST['rbImage']))//если поступила команда добавить
 { if($_POST['rbImage']=='rbAdd'){ 
                                  $pictNew=$this->get_image($name,$size,$report);//извлечение полученой картинки
                                  if ($size !== 0)
                                        {$flgResult=true;//картинка получена и перезаписана в объекте
                                         $pict=$pictNew;
                                         $size_pict=$size;}}
                                elseif($_POST['rbImage']=='rbDell'){$pict='';//картинка удалена из объекта успешно
                                                                  $size_pict=0;
                                                                  $flgResult=true;}
                                          }  
   return $flgResult; 
} 
//-------------------------------вытаскивает и проверяет время из запроса--------------------------
protected function isGoodDate($name,&$date,&$report)
{
 if(isset($_POST[$name]))  
 {$date=$_POST[$name];$report='время получено';return true;}
   else{$report='время не пришло';return false;}
} 
//--------------------------вытаскивает и проверяет текст, приходящий в запросе--------------------------------
protected function isGoodText($name,&$text,$maxlen,$minlen,&$report)
{
    if(isset($_POST[$name]))  
    {$text=($_POST[$name]);
      return $this->isGoodText_($text,$maxlen,$minlen,$report);}
       else{return false;}
}
//--------------------проверка картинки -----------------------------------------------------
protected function isGoodPict_($size_pict,&$report)
{ 
  if ($size_pict !== 0)
      {$report='картинка загружена';return true;}
       else{$report='картинка не загружена';return false;} 
} 
//------------------------------проверка времени на коректность---------------------------------------- 
protected function isGoodDate_(&$date,&$report)
{
 if(isset($date))  
 {$report=$report.'время задано';return true;}
   else{$report=$report.'задайте время';return false;}
} 
//---------------------------условие корректноста текстового поля------------------------------------------
protected function isGoodText_(&$text,$maxlen,$minlen,&$report)
{
    if(isset($text))  
    {$size=strlen($text);
    if(($size>$maxlen)or($size<$minlen))
         {$report=$report."текст длинной $size должен быть в интервале от $minlen до $maxlen";}
          else{$report=$report."текст введен успешно";
               return true;}
    }
    return false;
}
//---------------условие при котором информация на 1 статью пришла и готова для записи в базу------------
public function isGood()
{
  if(($this->flgHeader)and
     ($this->flgDatePublic)and
     ($this->flgAnnonce)and
     ($this->flgText))
          {
          return true;
          }  
          else return false;
}
//------конструктор объекта зануляет значения при инициализации---------------------------
public function __construct() {
        $this->header="заголовок";
        $this->datePublic= date("Y-m-dTH:i");
        $this->datePublic=str_replace("U", "", $this->datePublic);
        $this->datePublic=str_replace("C", "", $this->datePublic);
        $this->annonce="аннотация";
        $this->text="текст статьи";
        $this->picture="";
        $this->flgHeader=false;
        $this->flgDatePublic=false;
        $this->flgAnnonce=false;
        $this->flgText=false;
        $this->flgPicture=false;
        $this->flgFirst=true;
        $this->size_pic=0;
        $this->id=0;
        }
//---------------------функция проверяет  пришедшие данные, форматирует их и выставляет флаги----------------    
public function setParamsFromPost()
{ $report='';
  $this->flgHeader=$this->isGoodText("header",$this->header,HEADERMAX,HEADERMIN,$report);
  $this->flgDatePublic=$this->isGoodDate('datePublic',$this->datePublic,$report);
  $this->flgAnnonce=$this->isGoodText('annonce',$this->annonce,ANNONCMAX,ANNONCMIN,$report);
  $this->flgText=$this->isGoodText('text',$this->text,TEXTMAX,TEXTMIN,$report);
  $this->flgPicture=$this->isGoodPict('picture',$this->picture,$this->size_pic,$report); 
}
 
//----------------функция проверяет текущие данные и выставляет флаги------------------------------------------
public function setParamsFromText()
{ $report='';
  $this->flgHeader=$this->isGoodText_($this->header,HEADERMAX,HEADERMIN,$report);
  $this->flgDatePublic=$this->isGoodDate_($this->datePublic,$report);
  $this->flgAnnonce=$this->isGoodText_($this->annonce,ANNONCMAX,ANNONCMIN,$report);
  $this->flgText=$this->isGoodText_($this->text,TEXTMAX,TEXTMIN,$report);
  $this->flgPicture=$this->isGoodPict_($this->size_pic,$report); 
}
//----------------------проверка условия что картинка пришла,
//извлечение полученой картинки из временного хранилища и загрузка её в оперативную память
protected function get_image($name,&$image_size,&$ErrorDescription){
  // Проверяем не пустали глобальная переменная $_FILES
    $image_size=0;
  if(!empty($_FILES)){
	$image_size=$_FILES['picture']['size'];// Ограничение на размер файла, в моём случае 1Мб
	if($image_size>1024*1024||$image_size==0)
	{
		 $ErrorDescription="Каждое изображение не должно привышать 1Мб! 
			".$_FILES[$name]['size'] ;
                if($image_size!=0)unlink($_FILES['picture']['tmp_name']);
			return '';
	}
	// Если файл пришел, то проверяем графический
	// ли он (из соображений безопасности)
	if(substr($_FILES[$name]['type'], 0, 5)=='image')
	{
		//Читаем содержимое файла
		$image=file_get_contents($_FILES[$name]['tmp_name']);
                
		//Экранируем специальные символы в содержимом файла
		unlink($_FILES[$name]['tmp_name']);
                return $image;      
	}else{  unlink($_FILES[$name]['tmp_name']);
		$ErrorDescription="Вы загрузили не изображение";
			return '';
	}    
  }else{
	$ErrorDescription="Вы не загрузили изображение, поле пустое";
		return '';}	
}

} 



