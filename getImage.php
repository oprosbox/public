<?php
require_once  'sql\functMySQL.php';
//по запросу от клиента выгружает картинку из базы данных и передает ему
if (isset($_GET['img'])) {   
$reportInit="";
$getFromBase=new WFunctMySQL('userSelect','passToManySelect1905',$reportInit);
$report="";
header('Content-type: image/jpeg');
header("Cache-Control: no-store, no-cache, must-revalidate");
$image=$getFromBase->selectImage($_GET['img'], $report);//выгружает картинку по id статьи
if(is_null($image)){}
                else{echo $image;} //если картинка была выгружена добавляет на отправку клиенту              
}