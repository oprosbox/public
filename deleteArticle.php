<?php

if (isset($_GET['delId'])) {   
$reportInit="";
$getFromBase=new WFunctMySQL('userUpdate','manyPassUpdate1905',$reportInit);
$report="";
$getFromBase->deleteNews($_GET['delId'], $report);
                
}

