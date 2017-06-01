
<?php
// скрипт удаляет статью из базы данных (строку из таблицы info)
if (isset($_GET['delId'])) {   
include_once 'sql\functMySQL.php';
$reportInit="";
$getFromBase=new WFunctMySQL('userUpdate','manyPassUpdate1905',$reportInit);
$report="";
$getFromBase->deleteNews($_GET['delId'], $report);             
}

