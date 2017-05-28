<?php

  include_once 'sql\functMySQLOut.php';
        session_start();
        $reportInit="";
        $getFromBase=new WFunctMySQLOut('userSelect','passToManySelect1905',$reportInit);//инициализация подключения к mySQL
        $page=0;
          if(isset($_SESSION[USERNAME])) 
                       {$page=$_SESSION[USERNAME]->page;}
          if(isset($_GET['page']))  
                       {$page=$_GET['page'];$_SESSION[USERNAME]->page=$page;}
         echo $getFromBase->getPageListReg($page,$reportInit);


