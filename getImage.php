<?php
require_once  'sql\functMySQL.php';
 
if (isset($_GET['img'])) {   
$reportInit="";
$getFromBase=new WFunctMySQL('userSelect','passToManySelect1905',$reportInit);
$report="";
header('Content-type: image/jpeg');
$image=$getFromBase->selectImage($_GET['img'], $report);

if(is_null($image)){}
                else{echo $getFromBase->selectImage($_GET['img'], $report);}
                
}
elseif(isset($_GET['picture'])) {
    session_start();
    
if(isset($_SESSION['objAdd']))
    {header('Content-type: image/jpeg');
     echo $_SESSION['objAdd']->picture;}
    
}