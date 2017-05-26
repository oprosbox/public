
<?php

include_once 'sql\functMySQLOut.php';

class WNews extends SNews
{   
  public 
  $flgHeader,
  $flgDatePublic,
  $flgAnnonce,
  $flgText,
  $flgPicture;
  public $flgFirst,
  $count;
  
 public function resultOperat($flg)
 {if ($this->flgFirst){}
      elseif($flg){return "<p><h5 style='color:green'>успешно!</h5>";}
           else{return "<p><h5 style='color:red'>откорректируйте!</h5>";}
 }
 //----------------------функция создает и заполняет форму 
 public function formForAdd(&$form)
 {$form="";
 $pict=$this->resultOperat($this->flgPicture);
 $head=$this->resultOperat($this->flgHeader);
 $annon=$this->resultOperat($this->flgAnnonce);
 $txt=$this->resultOperat($this->flgText);
 $dateAdd=$this->resultOperat($this->flgDatePublic);
  //создаю форму 
$form="<form action='InfoCreate.php' method='POST' name='formAdd'>
    <p>
    <h4>картинка</h4><p>
    <input type='file' name='picture' /><br />
    $pict
    <hr>
    <h4>заголовок</h4><p>
    <textarea cols='100' rows='3'  name='header' required='required'> $this->header </textarea> 
    $head
    <hr>
    <h4>аннотация<h4><p>
    <textarea cols='100' rows='3' name='annonce' required='required'> $this->annonce </textarea> 
    $annon
    <hr>
    <h4>текст статьи<h4><p>
    <textarea cols='100' rows='20' name='text' required='required'> $this->text </textarea> 
    $txt
    <hr>
    <h4>время добавления<p></h4>
    <input type='datetime-local' name='datePublic' value='$this->datePublic'/>
    $dateAdd
<hr><p>
    <input type='submit' value='добавить' name='add'><p>";
//если заходит в первый раз, тогда ничего не пишет.
if ($this->flgFirst){$this->flgFirst=false;}
     elseif ($this->isGood()){
            $form=$form."<h4 style='color:green'>добавлено успешно!</h4>";
                             }
                             else{$form=$form."<h4 style='color:red'>откорректируйте, пожалуйста!</h4>";
                             }
        
$form=$form."</form>"; 
  }

protected function isGoodPict($name,&$pict,&$size_pict,&$report)
{$size_pict=0;
  //if(isset($_POST[$name])){ 
  $pict=$this->get_image($name,$size_pict,$report);
  if ($pict !== ''){
        return true;
  }
  //}else{$report=$report.$_FILES[$name]['error'];}
   return false; 
} 

protected function isGoodDate($name,&$date,&$report)
{
 if(isset($_POST[$name]))  
 {$date=$_POST[$name];
   return true;
    }
    return false;
} 

protected function isGoodText($name,&$text,$maxlen,$minlen,&$report)
{
    if(isset($_POST[$name]))  
    {$text=($_POST[$name]);
    if((strlen($text)>$maxlen)or(strlen($text)<$minlen)){}
          else{return true;}
    }
    return false;
}
//---------------условие при котором информация на 1 статью пришла и заполнены полностью
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
//----------------------------------------------------------------
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
        $this->count=0;
        $this->size_pic=0;
        }
//функция проверяет  пришедшие данные, и форматирует их    
public function setParamsFromPost()
{ $report='';
  $this->flgHeader=$this->isGoodText("header",$this->header,HEADERMAX,HEADERMIN,$report);
  $this->flgDatePublic=$this->isGoodDate('datePublic',$this->datePublic,$report);
  $this->flgAnnonce=$this->isGoodText('annonce',$this->annonce,ANNONCMAX,ANNONCMIN,$report);
  $this->flgText=$this->isGoodText('text',$this->text,TEXTMAX,TEXTMIN,$report);
  $this->flgPicture=$this->isGoodPict('picture',$this->picture,$this->size_pic,$report); 
//echo $report;  
}
  
protected function get_image($name,&$image_size,&$ErrorDescription){
  // Проверяем не пустали глобальная переменная $_FILES
  if(!empty($_FILES)){
	$image_size=$_FILES['picture']['size'];
        
	// Ограничение на размер файла, в моём случае 1Мб
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
		$ErrorDescription="Вы загрузили не изображение,
			поэтому оно не может быть добавлено.";
			return '';
	}    
  }else{
	$ErrorDescription="Вы не загрузили изображение, поле пустое,
		поэтому файл в базу не может быть добавлен.";
		return '';
  }
	
}

} 



