<?php

require_once 'loginPassw.php';

$currentUser=new SUser();
$reportInit='';
$flgGood=false;
$report='';
session_start();

if(isset($_GET['newRegistr'])){ 
$inOut=new WLoginPass('userUpdate','manyPassUpdate1905',$reportInit);
$flgGood=$inOut->registrUser($currentUser,$report);
}

$btnGet='';
if ($flgGood){ $btnGet="<a href='listArticle.php'>перейти</a>";}
          else {}
              $btnName='newRegistr';
              $btnValue='регистрация';        

  $result="<div class='addUsersReg'>"
        ."<p><a href='index.php'><h4>перейти</h4></a></p>"
        ."<p><input type='text' value='$currentUser->login' id='loginR'></p>"
        ."<p><input type='password' value='$currentUser->password' id='passwordR'></p>"
        ."<p><a id='btnNewRegistr' name='$btnName' onClick=''>$btnValue</a></p>"
        ."<p><h4>$report</h4></p>"
        . "$btnGet"
        ."</div>"; 
  echo $result;

