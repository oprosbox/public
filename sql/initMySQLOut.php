<?php

include_once 'sql\initMySQL.php';
//------------------------------------------------------------------------------------------------------------------
class WInitDB extends WDBCreate
{
    
public function __construct($login, $password) {
    parent::__construct($login, $password);
}

public function __destruct() {
    parent::__destruct();
}
//---------------------------создает базу данных-------------------------------------------------------
public function createDBOut()
{ $result="";
 if(isset($_POST['createAll'])){ 
     $report="";
     if($this->createDB($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;    
}
//---------------------------по команде удаляет базу данных-------------------------------------------------------
public function deleteDBOut()
{$result="";
 if(isset($_POST['deleteAll'])){ 
 $report="";
     if($this->deleteDB($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
      }
 return $result;   
}
//---------------------------по команде создает таблицу info-------------------------------------------------------
public function createTblInfo()
{$result="";
 if(isset($_POST['createInfo'])){ 

     $report="";
     if($this->createTableInfo($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
     }
 return $result;   
}
//---------------------------по команде создает таблицу info-------------------------------------------------------
public function deleteTblInfo()
{$result="";
 if(isset($_POST['deleteInfo'])){ 

     $report="";
     if($this->deleteTableInfo($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;   
}
//---------------------------по команде создает таблицу site_users-------------------------------------------------------
public function createTblUsers()
{$result="";
 if(isset($_POST['createUsers'])){ 
 
     $report="";
     if($this->createTableUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;   
}
//---------------------------по команде удаляет таблицу site_users-------------------------------------------------------
public function deleteTblUsers()
{$result="";
 if(isset($_POST['deleteUsers'])){ 

     $report="";
     if($this->deleteTableUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;  
}
//---------------------------по команде создает пользователей базы и задаёт им права-------------------------------------------------------
public function createUserOut()
{$result="";
 if(isset($_POST['createDBUser'])){ 
 
     $report="";
     if($this->createUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";;
                       }
 }
 return $result;  
}
//---------------------------по команде удаляет пользователей базы-------------------------------------------------------
public function deleteUserOut()
{$result="";
 if(isset($_POST['deleteDBUser'])){ 
 
     $report="";
     if($this->deleteUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;  
}
//---------------------------по команде создает базы,таблицы и пользователей-------------------------------------------------------
public function createDBUser()
{
 $result="";
 if(isset($_POST['createDBUserAll'])){ 
           $report="";
            if($this->createDBTables($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                }
 return $result;    
}
//---------------------------по команде удаляет базы,таблицы и пользователей-------------------------------------------------------
public function deleteDBUser()
{
 $result="";
 if(isset($_POST['deleteDBUserAll'])){ 

     $report="";
     if($this->deleteDBTables($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;    
}
//----------------------экспортирует данные из базы на жесткий диск------------------------------------------------------
public function exportDB()
{
 $result="";
 if(isset($_POST['exportDB'])){ 
           $report="";
           $this->exportData('export.bat',$report);
           $result="<h5 style='color:blue' class='hMess'>$report</h5>";}
 return $result;    
}
//-----------------------выгружает данные из базы--------------------------------------------------------------
public function importDB()
{
 $result="";
 if(isset($_POST['importDB'])){ 
              $report="";
              $this->importData('import.bat',$report);
              $result="<h5 style='color:blue' class='hMess'>$report</h5>";}
 return $result;    
}

}

