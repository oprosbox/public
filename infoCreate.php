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
        <script src="scripts/jquery-3.1.1.min.js"></script>
        <script src="scripts/scriptsToWork.js"></script>
        <title></title>
    </head>
    <body>
        <div id="addressWin">
  <div id="info"></div>
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
         $_SESSION['objAdd']=$sNews;}
         
    if(isset($_GET['idArticle']))
        {$sNews->id=$_GET['idArticle'];
         $addToBase->selectOneNewsRefresh($sNews->id, $sNews, $report);
         $sNews->datePublic=str_replace(" ", "T", $sNews->datePublic);
         $sNews->setParamsFromText();}
    if(isset($_POST['add'])){$addToBase->setData($sNews,$report);}//функция проверяет пришедшие данные, в случае успеха заносит их в БД, отправляет результат обработки  
     elseif(isset($_POST['refresh'])){$addToBase->refreshData($sNews, $report);}//функция проверяет пришедшие данные и отправляет результат обработки
         elseif(isset($_POST['update'])){$addToBase->updateData($sNews, $report);}
            elseif(isset($_POST['delete'])){$addToBase->deleteData($sNews, $report);}
     ?>
    
  <form action='InfoCreate.php' method='POST' name='formAdd' enctype="multipart/form-data">
      
 <?php echo "<h4 onclick='getOneArticle($sNews->id)' class='linkText' style='float:left'>посмотреть</h4>" ?>
     
  <a href='index.php' class='linkText'>на главную</a> 
  <hr/>
 <div>  
      <input type='submit' value='проверить' name='refresh'/>
   </div>
 <hr/>
 <h4>заголовок</h4><h5>(обязательное для заполнения поле)</h5>
 <textarea  rows='3'  name='header' required='required'><?php echo "$sNews->header"?></textarea> 
 <?php echo $sNews->resultOperat($sNews->flgHeader); ?>
    <hr/>
    <h4>аннотация</h4><h5>(обязательное для заполнения поле)</h5>
    <textarea  rows='3' name='annonce' required='required' ><?php echo "$sNews->annonce"?></textarea> 
    <?php
     echo $sNews->resultOperat($sNews->flgAnnonce);
     ?>
    <hr/>
    <h4>текст статьи</h4><h5>(обязательное для заполнения поле)</h5>
    <textarea  rows='20' name='text' required='required'><?php echo "$sNews->text"?></textarea> 
    <?php
    echo $sNews->resultOperat($sNews->flgText);
    ?>
    <hr/>
    <h4>время публикации</h4><h5>(обязательное для заполнения поле)</h5>
    <input type='datetime-local' name='datePublic' value=
    <?php
    echo "'$sNews->datePublic'";
    ?>
    />
    <?php
    echo $sNews->resultOperat($sNews->flgDatePublic);
    ?>    
<br/>
  <hr/>
 <div><input type='submit' value='редактировать' name='update'/>
      <input type='submit' value='добавить' name='add'/>
      <input type='submit' value='удалить' name='delete'/>
 </div>
<hr/><br/>
<div style=''>   
   <h4 >картинка </h4 ><h5>(*необязательное для заполнения поле)</h5>
      <fieldset>
         <legend>добавьте картинку</legend>
         <input type='radio' value='rbAdd' name='rbImage' checked='true' style='float:left'/><h5>добавить/обновить (если выбран файл)</h5>
         <input type='radio' value='rbDell' name='rbImage' style='float:left'/><h5>удалить изображение (если в базе уже имеется изображение)</h5>
         <br/>
         <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
       <input type='file' name='picture' accept='image/jpeg'/>         
      </fieldset>
</div>
 <?php   
    echo $sNews->resultOperat($sNews->flgPicture);
  ?>  
  <hr/>     
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
