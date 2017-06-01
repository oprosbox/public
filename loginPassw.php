<?php
require_once 'sql/functMySQL.php';

class WLoginPass extends WFunctMySQL
{
//------------------------------------------------------------------------------------------------------------------------------    
    public function inUser(&$currentUser,&$report)
    {
     $report="<h6 style='color:red'>повторите попытку</h6>";
     $flgResult=false;
     if(isset($_SESSION[USERNAME]))//если пользователь уже в системе
                     {$currentUser=$_SESSION[USERNAME];
                      $report="<h6 style='color:red;'>произведите выход</h6>";}
                     elseif(isset($_GET['login'])and isset($_GET['password']))//если в системе нет пользователя
                              { $login=$_GET['login'];$password=$_GET['password'];
                                $reportOut='';
                                $rights=$this->selectUser($login, $password, $reportOut);//проверка пользователя на его регистрацию
                                  if($rights)//пользователь существует в базе данных - проводим вход в систему
                                   {$flgResult=true;
                                    $_SESSION[USERNAME]=new SUser($login,$password,$rights);
                                    $currentUser=$_SESSION[USERNAME];
                                    $report="<h6 style='color:green'>вход произведен</h6>";}            
                              }                                  
    return $flgResult;
    }
//-----------------------------------------------------------------------------------------------------------------------------------    
    public function outUser(&$currentUser,&$report)
    {$currentUser->__construct();
     $report="<h6 style=color:green'>выход произведен</h6>";
     if(isset($_GET['btnInOut'])){if(isset($_SESSION[USERNAME])){unset($_SESSION[USERNAME]);}
                                  return true;
                                 }
    return false;   
    }
    
    public function testLoginPassword(&$report,$login="",$password="")
    {
     if(($login=="")or($password=="")){$report=$report."должны быть введены все данные";return false;} 
     return true;
    }
//---------------------------------------------------------------------------------------------------------------------    
    public function registrUser(&$currentUser,&$report)
    {
     //$currentUser->__construct();
     $out=false;
     $report='';
      if(isset($_GET['login'])and(isset($_GET['password'])))//если получены логин и пароль
                              {
                                $login=$_GET['login'];$password=$_GET['password'];
                                $flagGood=$this->testLoginPassword($report,$login,$password);
                                if($flagGood===false){return false;}
                                $notexist=$this->selectOnlyUser($login, $report);//проверка пользователя на его регистрацию
                                if($notexist===false){$report="<h6 style=color:green'>пользователь с таким логином уже есть</h6>";return false;}
                                $this->outUser($currentUser,$report);
                                //если пользователь с таким логином не зарегистрирован;
                                                    if($this->insertUser($login, $password, $report))
                                                                {//пользователь успешно добавлен
                                                                 $out=true;
                                                                 $this->inUser($currentUser,$report);
                                                                 $report="<h6 style=color:green'>пользователь успешно зарегистрирован</h6>";}
                                                          else{//не удалось добавить пользователя в БД
                                                                 $report=$report."<h6 style=color:green'>не удалось добавить пользователя</h6>";}
                                                   
                                                   
                              }
    return $out;   
    }
     
}


 
