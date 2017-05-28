<?php

  include_once 'sql\functMySQLOut.php';
        session_start();
        $reportInit="";
        $getFromBase=new WFunctMySQLOut('userSelect','passToManySelect1905',$reportInit);//инициализация подключения к mySQL
        $page=0;
          if(isset($_SESSION["page"])) 
                       {$page=$_SESSION["page"];}
          if(isset($_GET['page']))  
                       {$page=$_GET['page'];$_SESSION['page']=$page;}
         echo $getFromBase->getPageListUnreg($page,$reportInit);

