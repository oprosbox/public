
<?php

if (isset($_GET['delId'])) {   
include_once 'sql\functMySQL.php';
$reportInit="";
$getFromBase=new WFunctMySQL('userUpdate','manyPassUpdate1905',$reportInit);
$report="";
$getFromBase->deleteNews($_GET['delId'], $report);             
}

