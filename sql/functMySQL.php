<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of functMySQL
 *
 * @author ЛВВ
 */
include_once 'sql\baseMySQL.php';

class SNews
{   
  public $header,
  $datePublic,
  $annonce,
  $text,
  $picture,
  $id,
  $size_pic;
}

class SUser
{
 public $login,$password,$rights,$page; 
 public function __construct($login="",$password="",$rights='user') {
     $this->login=$login;$this->password=$password;$this->rights=$rights;
     $this->page=0;
 }
}

define("USERNAME","loginUser");

class WFunctMySQL extends WDBConn 
{
//----------------------------------------------------------------------------------------------------------------   
    public function __construct($login,$password,&$report) {
           parent::__construct ($login,$password,$report,'dbNews');
    }
    
     public function __destruct() {
         parent::__destruct();
    }
//------------------------------------------------------------------------------------------------------------------  
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
                           ,$report)){}else{return false;}
       return true;
    }
//---------------------------------------------------------------------------------------------------------------------    
    public function insertUser($user,$password,&$report)
    { $report=""; 
      if($this->commands("INSERT INTO site_users VALUE(NULL,'$user','$password','user')"
                   ,"site_users: запись прошла успешно"
                   ,"site_users ошибка записи: "
                   ,$report)){}else{return false;}
       return true;
    }
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
  //----------------------------------------------------------------------------------------------------------------------
    public function selectNews($number,&$report)
    { $report="";
      $query="SELECT id,header,datePublic,annonce FROM info ORDER BY  datePublic DESC LIMIT ".($number*5).",5";
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
      return $arrayResult;
    }
    //-----------------------------------------------------------------------------------------------------------------------
      public function getCountButtons(&$report)
    {
      $res = mysqli_query($this->link,"SELECT COUNT(*) FROM info");
      if ($res===false) { $report=$report."info: ошибка при чтении COUNT(*)".mysqli_error($this->link)."\n";
                                return false;
                               }
      $row = mysqli_fetch_row($res);
      $total = $row[0]; // всего записей
      $All=intdiv($total,5);
      if($All!=0){
             if($total-$All*5!=0){++$All;}
                               else{}}
             else{++$All;}
             
      return $All; 
    }
     //----------------------------------------------------------------------------------------------------------------------
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
    
      //----------------------------------------------------------------------------------------------------------------------
    public function selectOneNewsRefresh($id,&$outRes,&$report)
    { 
      $query="SELECT id,header,annonce,datePublic,text,size_pic FROM info WHERE id='$id'";
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
      $outRes->size_pic=$line[5];
      return true;
    }
        //----------------------------------------------------------------------------------------------------------------------
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
//---------------------------------------------------------------------------------------------------------------------------    
     public function deleteNews($id,&$report)
    {                           
      $report=""; 
      if($this->commands("DELETE FROM info WHERE id='$id'"
                   ,"info: удаление прошло успешно"
                   ,"info ошибка при удалении: "
                   ,$report)){}else{return false;}
       return true;
       
     }
 //---------------------------------------------------------------------------------------------------------------------------    
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
