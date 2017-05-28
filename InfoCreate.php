<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" charset="utf-8" />
        <link href="css/cssStyle.css" rel="stylesheet" type="text/css" />
        <title></title>
    </head>
    <body>
        <div id="addressWin">
  <div id="info">Разработчик сайта: Лень В. В.</div>
</div> 
       <div id="centrWinB">  
           <div class="h40"></div> 
<div id="centerB">
    
<?php
//startOfPage()
include_once 'sql\functMySQLOut.php';
session_start();
$report="";
$addToBase=new WFunctMySQLOut('userUpdate','manyPassUpdate1905',$report);
//----------------------при первом запуске скрипта создается объект и помещается в сессииж 
if(isset($_SESSION['objAdd']))
    {//повторное использование
     $sNews=$_SESSION['objAdd'];}
    else{//первый запуск
        $sNews=new WNews;
         $_SESSION['objAdd']=$sNews;
    }
    if(isset($_GET['idArticle']))
        {$addToBase->selectOneNewsRefresh($_GET['idArticle'], $sNews, $report);
         $sNews->datePublic=str_replace(" ", "T", $sNews->datePublic);
         $sNews->setParamsFromPost();}
    if(isset($_POST['add']))
     {$addToBase->setData($sNews,$report);}//функция проверяет пришедшие данные, в случае успеха заносит их в БД, отправляет результат обработки  
     elseif(isset($_POST['refresh'])){$addToBase->refreshData($sNews, $report);}//функция проверяет пришедшие данные и отправляет результат обработки
         else{};
     ?>
    
  <form action='InfoCreate.php' method='POST' name='formAdd' enctype="multipart/form-data">
    <p> <h4>картинка</h4><p>
    <fieldset>
    <legend>добавьте картинку</legend>
<input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
<p><input type='file' name='picture' accept='image/jpeg'/></p>
      </fieldset>
 <?php   
    echo $sNews->resultOperat($sNews->flgPicture);
  ?>      
 <hr>
 <h4>заголовок</h4><p>
 <textarea cols='100' rows='3'  name='header' required='required'><?php echo "$sNews->header"?></textarea> 
    <?php
    echo $sNews->resultOperat($sNews->flgHeader);
    ?>
    <hr>
    <h4>аннотация<h4><p>
    <textarea cols='100' rows='3' name='annonce' required='required' ><?php echo "$sNews->annonce"?></textarea> 
    <?php
     echo $sNews->resultOperat($sNews->flgAnnonce);
     ?>
    <hr>
    <h4>текст статьи<h4><p>
    <textarea cols='100' rows='20' name='text' required='required'><?php echo "$sNews->text"?></textarea> 
    <?php
    echo $sNews->resultOperat($sNews->flgText);
    ?>
    <hr>
    <h4>время добавления<p></h4>
    <input type='datetime-local' name='datePublic' value=
    <?php
    echo "'$sNews->datePublic'";
    ?>
    />
    <?php
    echo $sNews->resultOperat($sNews->flgDatePublic);
    ?>
<hr><p>
    <input type='submit' value='записать' name='add' class='inputCRDB'>
    <input type='submit' value='обновить' name='refresh' class='refreshCRDB'><p>
        
<?php
 //если заходит в первый раз, тогда ничего не пишет.
if ($sNews->flgFirst){$sNews->flgFirst=false;}
     elseif ($sNews->isGood()){
            echo "<h4 style='color:green'>$report</h4>";
                             }
                             else{echo "<h4 style='color:red'>$report</h4>";
                             }  
?>
        
</form>
</div>
<div class="h40"></div> 
</div>
<div id="addressWin">
  <div id="info">Разработчик сайта: Лень В. В.</div>
</div> 
    </body>
</html>


<?php

function startOfPage()
{
   
}

function finalOfPage()
{
 
}
 