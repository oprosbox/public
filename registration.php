<?php

require_once 'loginPassw.php';

$currentUser=new SUser();
$reportInit='';
$flgGood=false;
$report="&nbsp;";
session_start();

if(isset($_GET['newRegistr'])){ 
           $inOut=new WLoginPass('userUpdate','manyPassUpdate1905',$reportInit);
           $flgGood=$inOut->registrUser($currentUser,$report);
           }
              $btnName='newRegistr';
              $btnValue='регистрация';        

  $result="<div class='addUsersReg'>"
        ."<div><a href='index.php'>на главную</a></div><br/>"
        ."<div><h4>Логин:</h4><input type='text' value='$currentUser->login' id='loginR'/></div>"
        ."<div><h4>Пароль:</h4><input type='password' value='$currentUser->password' id='passwordR'/></div><br/>"
        ."<div><a id='btnNewRegistr' name='$btnName' onClick=''>$btnValue</a></div>"
        ."<div><h5 id='report'>$report</h5></div>"
        ."</div>"; 
        
  echo $result;
  ?>
 <script type='text/javascript'>  
        $(document).ready(function(){hideFunct("#report",5000);});
 </script>

