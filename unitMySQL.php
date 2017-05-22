<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class WDBConn
{
      protected $link;
    
    public function __construct($login,$password) {
       createConnect($login,$password);
    }
    
     public function __destruct() {
       closeConnect();
    }
    
    protected function createConnect($login,$password,&$report)
    {
      $link=mysqli_connect('localhost', $login, $password, $database) ; 
    if (!$link) {$report="Ошибка соединения: " . mysql_error();
                 die('Ошибка соединения: ' . mysql_error()); return false;}
    return true;
    }
    
      protected function closeConnect()
    {
       mysqli_close($link);   
    }  
}

class WDBCreate extends WDBConn
{   
      public function __construct($login,$password) {
       WDBConn::__construct($login,$password);
    }
    
      public function __destruct() {
       WDBConn::__destruct();
    }
    
    protected function createDB(&$report)
    {
      $query="CREATE DATABASE 'dbNews'";
      if (mysql_query($query, WDBConn::$link)) {
         $report="База dbNews успешно создана\n";
         return true;
          } else {
           $report="Ошибка при создании базы данных: " . mysql_error() . "\n";
          return false;
          }      
    }
    
      protected function createTableInfo(&$report)
    {
        $query="CREATE TABLE info{'
               'id' int NOT NULL AUTO_INCREMENT PRIMARY KEY,
               'header' varchar NOT NULL,
               'datePublic' DATETIME NOT NULL
                }";
      if (mysql_query($query, WDBConn::$link)) {
          $report="таблица info успешно создана\n";
          } else {
           $report="Ошибка при создании таблицы info:" . mysql_error() . "\n";
           return false;
          } 
          return true;
      }
      
      protected function createTableUser(&$report)
      {$query="CREATE TABLE site_users{'
               'login' varchar PRIMARY KEY NOT NULL,
               'password' varchar NOT NULL,
               'rights' varchar NOT NULL,
               'annonce' varchar NOT NULL,
               'text' varchar NOT NULL,
               'picture' LONGBLOB 
                }";
      if (mysql_query($query, WDBConn::$link)) {
          $query="INSERT INTO site_users VALUE('admin','adminNewsInfo','root')";
           if (mysql_query($query, WDBConn::$link)) {
                     $report="таблица site_users успешно создана\n";
                     }
          } 
        else {
           $report="Ошибка при создании таблицы site_users: " . mysql_error() . "\n";
           return false;
          }  
          return true;
    }
    
    public function deleteDB(&$report)
    {
      $query="DROP DATABASE 'dbNews'";
      if (mysql_query($query, WDBConn::$link)) {
         $report="База dbNews успешно удалена\n";
          } else {
           $report="Ошибка при удалении базы данных: " . mysql_error() . "\n";
          }   
    }
    
    public function createDBTables(&$tblResult)
    { $dbStr='';
      $tblUser='';
      $tblInfo='';
    
      if(createDB($dbStr)){$tblResult="шаг1 - ".$dbStr."\n";}
                           else{$tblResult="шаг1 - ".$dbStr."\n";
                           return false;}
      if(createTableUser($tblUser)){$tblResult=$tblResult."шаг2 - ".$tblUser."\n";}
                           else{ $tblResult=$tblResult."шаг2 - ".$tblUser."\n";
                                 return false;}
      if(createTableInfo($tblInfo)){$tblResult=$tblResult."шаг3 - ".$tblInfo."\n";}
                           else{$tblResult=$tblResult."шаг3 - ".$tblInfo."\n";
                                 return false;}        
         
      return true;
      
    }
}

function createBase($login,$password,&$report)
{
  $DB=new  WDBCreate($login,$password);
  $flgCreate=$DB->createDBTables($report);
  return ($flgCreate);
}

?>
