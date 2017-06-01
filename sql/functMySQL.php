<?php

include_once 'sql\baseMySQL.php';

define("MAXNEWS", 5);

class SNews
{   
  public $header,//заголовок
  $datePublic,//дата публикации
  $annonce,//анонс
  $text,//текст статьи
  $picture,//картинка
  $id,//id-статьи
  $size_pic;//размер картинки
}

class SUser
{
 public $login,
        $password,
        $rights,//права пользователя
        $page; //страница, на которой он находится
 public function __construct($login="",$password="",$rights='user') {
     $this->login=$login;$this->password=$password;$this->rights=$rights;
     $this->page=0;
 }
}

define("USERNAME","loginUser");//константа с параметром для обращения к сессиям

class WFunctMySQL extends WDBConn 
{
//----------------------------------------------------------------------------------------------------------------   
    public function __construct($login,$password,&$report) {
           parent::__construct ($login,$password,$report,'dbNews');
    }
    
     public function __destruct() {
         parent::__destruct();
    }
//------------------Вставляет статью в базу данных---------------------------------------------  
    public function insertArticle($objInsert,&$report)
    {$report="";
      $header=mysqli_real_escape_string($this->link,$objInsert->header);
      $annonce=mysqli_real_escape_string($this->link,$objInsert->annonce);
      $text=nl2br(mysqli_real_escape_string($this->link,$objInsert->text));
      if(isset($objInsert->picture)){ $query="INSERT INTO info VALUE(NULL,'$header','$objInsert->datePublic','"
                                                  . "$annonce','$text','".addslashes($objInsert->picture)
                                                  ."','$objInsert->size_pic')";}
                                  else{$query="INSERT INTO info VALUE(NULL,'$header','$objInsert->datePublic','"
                                                  . "$annonce','$text',NULL"
                                                  .",'0')";}
 
       if($this->commands($query
                           ,"статья добавлена"
                           ,"info: ошибка записи "
                           ,$report)){$objInsert->id=mysqli_insert_id($this->link);}else{return false;}
       return true;
    }
 //----------------обновляет статью в базе данных------------------------------------------------------------------  
    public function updateArticle($objInsert,&$report)
    {$report="";
      $header=mysqli_real_escape_string($this->link,$objInsert->header);
      $annonce=mysqli_real_escape_string($this->link,$objInsert->annonce);
      $text=mysqli_real_escape_string($this->link,$objInsert->text);
      if(isset($objInsert->picture)){ $query="UPDATE info SET header='$header',datePublic='$objInsert->datePublic',"
                                                  ."annonce='$annonce',text='$text',picture='".addslashes($objInsert->picture)
                                                  ."',size_pic='$objInsert->size_pic' WHERE id='$objInsert->id'";}
                                  else{$query="UPDATE info SET header='$header',datePublic='$objInsert->datePublic',"
                                                  ."annonce='$annonce',text='$text',picture=NULL"
                                                  .",size_pic='0' WHERE id='$objInsert->id'";}
 
       if($this->commands($query
                           ,"статья обновлена"
                           ,"info: ошибка обновления "
                           ,$report)){}else{return false;}
       return true;
    }
//---------------------вставляет пользователя сайтом в базу данных------------------------------------------------------------------    
    public function insertUser($user,$password,&$report)
    { $report=""; 
      if($this->commands("INSERT INTO site_users VALUE(NULL,'$user','$password','user')"
                   ,"site_users: запись прошла успешно"
                   ,"site_users ошибка записи: "
                   ,$report)){}else{return false;}
       return true;
    }
 //функция проверяет наличие пользователей в базе данных
//-------функция выводит false - ошибка запроса;""-не найдено ни одного подходящего пользователя;"права пользователя" в случае успеха;   
    public function selectUser($user,$password,&$report)
    { $report="";
      $query="SELECT login,password,rights FROM site_users WHERE(login='$user' and password='$password')";
      $result =mysqli_query($this->link,$query); 
           if ($result===false) {
                                $report="site_users: ошибка при чтении ".mysql_error()."\n";
                                return false;
                               }   
      $rows = mysqli_num_rows($result); 
      
      if($rows==1) {$row = mysqli_fetch_row($result);
                     return $row[2];}
          elseif($rows==0){return false;}
    }
 //при регистрации функция ищет пользователей с таким логином в базе данных
 //-------функция выводит false - ошибка запроса;""-не найдено ни одного подходящего пользователя;"права пользователя" в случае успеха;   
    public function selectOnlyUser($user,&$report)
  { $report="";
      $query="SELECT rights FROM site_users WHERE(login='$user')";
      $result =mysqli_query($this->link,$query); 
           if ($result===false) {
                                $report="site_users: ошибка при чтении ".mysql_error()."\n";
                                return false;
                                }   
      $rows = mysqli_num_rows($result); 
      
         if($rows==0){return true;}
                     else{return false;}
  }
  //-----------------------запрос необходимый для формирования ленты новостей. Выдает MAXNEWS новостей отсортированные по убыванию времени--------------------------------------------------------
    public function selectNews($number,&$report)
    { $report="";
      $query="SELECT id,header,datePublic,annonce FROM info ORDER BY  datePublic DESC LIMIT ".($number*MAXNEWS).",".MAXNEWS;
      $result =mysqli_query( $this->link,$query); 
           if ($result===false) {
                                $report="info: ошибка при чтении ".mysqli_error($this->link)."\n";
                                return false;
                               }
      $report="чтение прошло успешно";                     
      $rows = mysqli_num_rows($result); 
      //$tempVal=new SNews;
      for($i=0;$i<$rows;$i++)
      { $tempVal=new SNews;
        $line=mysqli_fetch_row($result); 
        $tempVal->id=$line[0];
        $tempVal->header=$line[1];
        $tempVal->datePublic=$line[2];
        $tempVal->annonce=$line[3];
        $arrayResult[$i]=$tempVal;
      }
      if(isset($arrayResult))
                 {return $arrayResult;}
                    else{return false;}
    }
    //------------------максимально возможное число страниц в ленте новостей-----------------------------------------------
      public function getCountButtons(&$report)
    {
      $res = mysqli_query($this->link,"SELECT COUNT(*) FROM info");
      if ($res===false) { $report=$report."info: ошибка при чтении COUNT(*)".mysqli_error($this->link)."\n";
                                return false;
                               }
      $row = mysqli_fetch_row($res);
      $total = $row[0]; // всего записей
      $All=intdiv($total,MAXNEWS);
      if($All!=0){
             if($total-$All*MAXNEWS!=0){++$All;}
                               else{}}
             else{++$All;}
             
      return $All; 
    }
     //----------------------------достает одну статью из базы данных------------------------------------------------------
    public function selectOneNews($id,&$outRes,&$report)
    { 
      $query="SELECT id,header,datePublic,text,size_pic FROM info WHERE id='$id'";
      $result =mysqli_query( $this->link,$query); 
           if ($result===false) {
                                $report=$report."<br/>info: ошибка при чтении ".mysqli_error($this->link)."\n";
                                return false;
                               }
      $report=$report."<br/>чтение прошло успешно";                      
      $line=mysqli_fetch_row($result); 
      $outRes->id=$line[0];
      $outRes->header=$line[1];
      $outRes->datePublic=$line[2];
      $outRes->text=$line[3];
      $outRes->size_pic=$line[4];
      return true;
    }
    
//----------------достает статью вместе с картинкой------------------------------------------------------
    public function selectOneNewsRefresh($id,&$outRes,&$report)
    { 
      $query="SELECT id,header,annonce,datePublic,text,picture,size_pic FROM info WHERE id='$id'";
      $result =mysqli_query( $this->link,$query); 
           if ($result===false) {
                                $report=$report."<br/>info: ошибка при чтении ".mysqli_error($this->link)."\n";
                                return false;
                               }
      $report=$report."<br/>чтение прошло успешно";                      
      $line=mysqli_fetch_row($result); 
      $outRes->id=$line[0];
      $outRes->header=$line[1];
      $outRes->annonce=$line[2];
      $outRes->datePublic=$line[3];
      $outRes->text=$line[4];
      $outRes->picture=$line[5];
      $outRes->size_pic=$line[6];
      return true;
    }
 //---------------достает картинку из БД---------------------------------------------------------
    public function selectImage($id,&$report)
    { 
      $query="SELECT picture FROM info WHERE id='$id'";
      $result =mysqli_query( $this->link,$query); 
           if ($result===false) {
                                $report=$report."<br/>info: ошибка при чтении ".mysqli_error($this->link)."\n";
                                return false;
                               }
      $report=$report."<br/>чтение прошло успешно";                      
      $line=mysqli_fetch_row($result); 
     
      return $line[0];

    }
//-----------------удаляет статью вместе с картинкой---------------------------------------------------------------------------    
     public function deleteNews($id,&$report)
    {                           
      $report=""; 
      if($this->commands("DELETE FROM info WHERE id='$id'"
                   ,"info: удаление прошло успешно"
                   ,"info ошибка при удалении: "
                   ,$report)){}else{return false;}
       return true;
       
     }
 //----------------удаляет пользователя----------------------------------------------------------------------------    
    public function deleteUsers($login,&$report)
    { 
       $report=""; 
      if($this->commands("DELETE FROM site_users WHERE login='$login'"
                   ,"site_users: удаление прошло успешно"
                   ,"site_users ошибка при удалении: "
                   ,$report)){}else{return false;}
       return true;
     }
}
