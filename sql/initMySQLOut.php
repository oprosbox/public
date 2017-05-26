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

public function createDBOut()
{ $result="";
 if(isset($_POST['createAll'])){ 
     $report="";
     if($this->createDB($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;    
}

public function deleteDBOut()
{$result="";
 if(isset($_POST['deleteAll'])){ 
 $report="";
     if($this->deleteDB($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
      }
 return $result;   
}

public function createTblInfo()
{$result="";
 if(isset($_POST['createInfo'])){ 

     $report="";
     if($this->createTableInfo($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
     }
 return $result;   
}

public function deleteTblInfo()
{$result="";
 if(isset($_POST['deleteInfo'])){ 

     $report="";
     if($this->deleteTableInfo($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;   
}

public function createTblUsers()
{$result="";
 if(isset($_POST['createUsers'])){ 
 
     $report="";
     if($this->createTableUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;   
}

public function deleteTblUsers()
{$result="";
 if(isset($_POST['deleteUsers'])){ 

     $report="";
     if($this->deleteTableUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;  
}

public function createUserOut()
{$result="";
 if(isset($_POST['createDBUser'])){ 
 
     $report="";
     if($this->createUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";;
                       }
 }
 return $result;  
}

public function deleteUserOut()
{$result="";
 if(isset($_POST['deleteDBUser'])){ 
 
     $report="";
     if($this->deleteUser($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;  
}

public function createDBUser()
{
 $result="";
 if(isset($_POST['createDBUserAll'])){ 

     $report="";
     if($this->createDBTables($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;    
}

public function deleteDBUser()
{
 $result="";
 if(isset($_POST['deleteDBUserAll'])){ 

     $report="";
     if($this->deleteDBTables($report)){$result=GOOD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
                  else{$result=BAD."<br/><br/><h5 style='color:blue' class='hMess'>$report</h5>";}
 }
 return $result;    
}


}

