<?php

require_once 'loginPassw.php';
    
$reportInit="";
$report="&nbsp;";
session_start();
$currentUser=new SUser();
//-----------------------------------------------------------------------------------------------------------
$btnValue='';
$flagInOut=true;
$inOut=new WLoginPass('userSelect','passToManySelect1905',$reportInit);
 if(isset($_SESSION[USERNAME])){$currentUser=$_SESSION[USERNAME]; $btnValue='выйти';}
                    else{$btnValue='войти';}
                            
if(isset($_GET['btnInOut']))
    {
    if(isset($_SESSION[USERNAME])){$flagInOut=$inOut->outUser($currentUser,$report);
                                    if($flagInOut===true){$btnValue='войти';}
                                    else{$btnValue='выйти';}}
                    else{$flagInOut=$inOut->inUser($currentUser,$report);
                         if($flagInOut===true){$btnValue='выйти';}
                                 else{$btnValue='войти';}
                            }
    }    
    

    
      

$result="<div class='usersReg'>"
        ."<div><a href='regForm.php'>регистрация</a></div>"
        ."<div><h4>Логин:</h4><input type='text' value='$currentUser->login' id='loginReg'/></div>"
        ."<div><h4>Пароль:</h4><input type='password' value='$currentUser->password' id='passwordReg'/></div>"
        ."<div class='endLine'><a id='btnRegistr' name='btnInOut'>$btnValue</a>"
        ."<div id='reportOutIn'>$report</div></div>"
        ."</div>"
   //скрипт отвечает за работу кнопки входа пользователя и обновления ленты новостей в случае если произошел вход или выход     
        ."<script>"
        ."\$(document).ready(function(){" 
        ."\$('#btnRegistr').click(function(){getRegist(\$('#loginReg').val(),\$('#passwordReg').val());});";
  if($flagInOut===true){$result=$result."getPage('');";}
        
 $result=$result ." hideFunct('#reportOutIn',5000);"
         ."});"  
         ."</script>"; 
 
echo $result;
?>
