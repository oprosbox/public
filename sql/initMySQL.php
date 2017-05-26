<?php

include_once 'sql\baseMySQL.php';

class WDBCreate extends WDBConn
{   
      public function __construct($login,$password) {
          $report="";
          parent::__construct($login,$password,$report);
    }
    
      public function __destruct() {
       parent::__destruct();
    }
    
    public function createDB(&$report)
    {
     if($this->commands("CREATE DATABASE dbNews"
                   ,"База dbNews успешно создана"
                   ,"Ошибка при создании базы данных:"
                   ,$report)){}else{return false;}
     return true;
    }
    
      public function createTableInfo(&$report)
    {  if (mysqli_select_db($this->link, 'dbNews')){}
         else{ $report="Ошибка при создании таблицы info:" . mysqli_error($this->link) . "\n";
               return false;}
         
            if($this->commands("CREATE TABLE info(
                                id integer AUTO_INCREMENT NOT NULL,
                                header varchar(".HEADERMAX.") NOT NULL,
                                datePublic DATETIME NOT NULL,
                                annonce varchar(".ANNONCMAX.") NOT NULL,
                                text varchar(".TEXTMAX.") NOT NULL,
                                picture MEDIUMBLOB,
                                size_pic integer NOT NULL,
                                PRIMARY KEY (id))"
                               ,"таблица info успешно создана"
                               ,"Ошибка при создании таблицы info:"
                               ,$report)){}else{return false;}
                               return true;
      }
      
    public function createTableUser(&$report)
    {if (mysqli_select_db($this->link, 'dbNews')){}
         else{ $report="Ошибка при создании таблицы info:" . mysqli_error($this->link) . "\n";
               return false;}
            
              if($this->commands("CREATE TABLE site_users(
                                  id integer NOT NULL AUTO_INCREMENT,
                                  login varchar(50) NOT NULL,
                                  password varchar(50) NOT NULL,
                                  rights varchar(10) NOT NULL,
                                  PRIMARY KEY (id))"
                                  ,"таблица site_users успешно создана"
                                  ,"Ошибка при создании таблицы site_users:"
                                  ,$report)){    if($this->commands("INSERT INTO site_users VALUE(NULL,'admin','adminArticle','root')"
                                                                   ,"запись пользователя прошла успешно"
                                                                   ,"Ошибка при записи пользователя в таблицу site_users:"
                                                                   ,$report)){}
                                                                       else{return false;}}
                                            else{return false;}
       return true;
    }
    
    public function deleteDB(&$report)
    {     
           if($this->commands("DROP DATABASE dbNews"
                   ,"База dbNews успешно удалена"
                   ,"Ошибка при удалении базы данных:"
                   ,$report)){}else{return false;}
       return true;
    }
//----------------------------------------------------------------------------------------------------------------     
    public function createUser(&$report)
    { if (mysqli_select_db($this->link, 'dbNews')){}
         else{ $report="Ошибка при выборе таблицы info:" . mysqli_error($this->link) . "\n";
               return false;}
        
        if($this->commands("CREATE USER 'userSelect' IDENTIFIED BY 'passToManySelect1905';"
                   ,"пользователь 'userSelect' успешно добавлен"
                   ,"Ошибка при добавлении пользователя 'userSelect':"
                   ,$report)){}else{return false;}
        if($this->commands("GRANT SELECT ON dbNews.* TO 'userSelect'; "
                   ,"права 'userSelect' успешно добавлены"
                   ,"Ошибка при добавлении прав 'userSelect':"
                   ,$report)){}else{return false;}
        if($this->commands("CREATE USER 'userUpdate' IDENTIFIED BY 'manyPassUpdate1905';"
                   ,"пользователь 'userUpdate' успешно добавлен"
                   ,"Ошибка при добавлении пользователя 'userUpdate':"
                   ,$report)){}else{return false;}
        if($this->commands("GRANT SELECT,INSERT,UPDATE,DELETE ON dbNews.* TO 'userUpdate';"
                   ,"права 'userUpdate' успешно добавлены"
                   ,"Ошибка при добавлении прав 'userUpdate':"
                   ,$report)){}else{return false;}
        if($this->commands("FLUSH PRIVILEGES"
                   ,"привилегии обновлены"
                   ,"Ошибка при обновлении привилегий:"
                   ,$report)){}else{return false;}
          return true;         
    }
    
      public function deleteUser(&$report)
    {   if (mysqli_select_db($this->link, 'dbNews')){}
         else{ $report="Ошибка при выборе таблицы info:" . mysqli_error($this->link) . "\n";
               return false;}
               
        if($this->commands("REVOKE SELECT ON dbNews.* FROM 'userSelect'"
                   ,"привилегии пользователя 'userSelect' успешно удалены"
                   ,"Ошибка при удалении прав пользователя 'userSelect':"
                   ,$report)){}else{}
        if($this->commands("DROP USER 'userSelect';"
                   ,"пользователь 'userSelect' успешно удален"
                   ,"Ошибка при удалении пользователя 'userSelect':"
                   ,$report)){}else{}
        if($this->commands("REVOKE SELECT,INSERT,UPDATE,DELETE ON dbNews.* FROM 'userUpdate';"
                   ,"привилегии пользователя 'userUpdate' успешно удалены"
                   ,"Ошибка при удалении прав пользователя 'userUpdate':"
                   ,$report)){}else{}
        if($this->commands("DROP USER 'userUpdate'"
                   ,"пользователь 'userUpdate' успешно удален"
                   ,"Ошибка при удалении пользователя 'userUpdate':"
                   ,$report)){}else{}
        if($this->commands("FLUSH PRIVILEGES"
                   ,"привилегии обновлены"
                   ,"Ошибка при обновлении привилегий:"
                   ,$report)){}else{}
                    return true; 
    }
    
    public function createDBTables(&$tblResult)
    { $messDBStr='';
      $messTblUser='';
      $messTblInfo='';
      $messNewUsers='';
      if($this->createDB($messDBStr)){$tblResult="<p>шаг 1: ".$messDBStr."</p>\n";}
                           else{$tblResult="<p>шаг 1: ".$messDBStr."</p>\n";
                           }
      if($this->createTableUser($messTblUser)){$tblResult=$tblResult."шаг 2: ".$messTblUser."</p>\n";}
                           else{ $tblResult=$tblResult."<p>шаг 2: ".$messTblUser."</p>\n";
                                 return false;}
      if($this->createTableInfo($messTblInfo)){$tblResult=$tblResult."<p>шаг 3: ".$messTblInfo."</p>\n";}
                           else{$tblResult=$tblResult."<p>шаг 3: ".$messTblInfo."</p>\n";
                                 return false;}        
      if($this->createUser($messNewUsers)){$tblResult=$tblResult."<p>шаг 4: ".$messNewUsers."</p>\n";}
                           else{ $tblResult=$tblResult."<p>шаг 4: ".$messNewUsers."</p>\n";
                                 return false;}
      return true;
      
    }
    
     public function deleteDBTables(&$tblResult)
    { $messDBStr='';
      $messNewUsers='';
      if($this->deleteUser($messNewUsers)){$tblResult=$tblResult."<p>шаг 1: ".$messNewUsers."</p>\n";}
                           else{ $tblResult=$tblResult."<p>шаг 1: ".$messNewUsers."</p>\n";
                                 }
      if($this->deleteDB($messDBStr)){$tblResult=$tblResult."<p>шаг 2: ".$messDBStr."</p>\n";}
                           else{$tblResult=$tblResult."<p>шаг 2: ".$messDBStr."</p>\n";
                           return false;}       
     
      return true; 
    }
}


