<?php
// скрипт выводит форму с логином паролем и позволяет проводить вход/выход пользователя в систему
require_once 'loginPassw.php';
    
$reportInit="";
$report="&nbsp;";
session_start();
$currentUser=new SUser();
//-----------------------------------------------------------------------------------------------------------
$btnValue='';
$flagInOut=true;
$inOut=new WLoginPass('userSelect','passToManySelect1905',$reportInit);
 if(isset($_SESSION[USERNAME]))//в зависимости от наличия пользователя выставляем надпись на кнопке
              {$currentUser=$_SESSION[USERNAME]; $btnValue='выйти';}
                    else{$btnValue='войти';}
                            
if(isset($_GET['btnInOut']))
    {//если была нажата кнопка btnInOut
    if(isset($_SESSION[USERNAME])){//Если в системе уже есть пользователь происходит выход 
                                    $flagInOut=$inOut->outUser($currentUser,$report);
                                    if($flagInOut===true){$btnValue='войти';}//пеняем надпись на кнопке
                                    else{$btnValue='выйти';}}
                    else{$flagInOut=$inOut->inUser($currentUser,$report);//Если в системе нет пользователя происходит попытка входа
                         if($flagInOut===true){$btnValue='выйти';} //пеняем надпись на кнопке в зависимости от результата
                                 else{$btnValue='войти';}
                            }
    }    
    
//форма выводит логин пароль пользователя 
$result="<div class='usersReg'>"
        ."<div><a href='regForm.php' class='linkText'>регистрация</a></div>"
        ."<div><h4>Логин:</h4><input type='text' value='$currentUser->login' id='loginReg'/></div>"
        ."<div><h4>Пароль:</h4><input type='password' value='$currentUser->password' id='passwordReg'/></div>"
        ."<div><a id='btnRegistr' name='btnInOut' class='linkText'>$btnValue</a>"
        ."<div id='reportOutIn' style='float:right;padding-top:12px'>$report</div></div>"
        ."</div>"
   //скрипт отвечает за работу кнопки входа пользователя и обновления ленты новостей в случае если произошел вход или выход     
        ."<script>"
        ."\$(document).ready(function(){" 
        ."\$('#btnRegistr').click(function(){getRegist(\$('#loginReg').val(),\$('#passwordReg').val());});";
  if($flagInOut===true){//если было событие входа или выхода перерисуем список статей
                          $result=$result."getPage('');";}    
 $result=$result ." hideFunct('#reportOutIn',5000);"
         ."});"  
         ."</script>"; 
echo $result;
?>
