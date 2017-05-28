<?php

require_once 'loginPassw.php';
    
$reportInit="";
$report="";
session_start();
$currentUser=new SUser();
//-----------------------------------------------------------------------------------------------------------
if(isset($_GET['btnIn'])){    
$inOut=new WLoginPass('userSelect','passToManySelect1905',$reportInit);
$inOut->inUser($currentUser,$report);
}
elseif(isset($_GET['btnOut']))
{
$inOut=new WLoginPass('userSelect','passToManySelect1905',$reportInit);
$inOut->outUser($currentUser,$report);
}
//-----------------------------------------------------------------------------------------------------------
$btnName='';
$btnValue='';
if(isset($_SESSION["loginUser"])){$currentUser=$_SESSION["loginUser"];}//если пользователь уже в системе есть
if($currentUser->login==='')
    {$btnName='btnIn';
     $btnValue='войти';
     $regVar="unregArticle";
     }
     else{$btnName='btnOut';
          $btnValue='выйти';
          $regVar="adminArticle";
          }
         
$result="<div id='userVar' name='$regVar'></div>\n"
        ."<div class='usersReg'>"
        ."<p><a href='regForm.php'><h4>регистрация</h4></a></p>"
        ."<p><input type='text' value='$currentUser->login' id='loginReg'></p>"
        ."<p><input type='password' value='$currentUser->password' id='passwordReg'></p>"
        ."<p><a id='btnRegistr' name='$btnName' style='float:left;margin-right:30px'>$btnValue</a>$report</p>"
        ."</div>";  
       

echo $result;
