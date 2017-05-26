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
        include_once 'sql\functMySQLOut.php';
        session_start();
         $reportInit="";
         $getFromBase=new WFunctMySQLOut('userUpdate','manyPassUpdate1905',$reportInit);
         $page=0;
          if(isset($_SESSION['page'])){$page=$_SESSION['page'];}
          if(isset($_GET['page'])){$page=$_GET['page'];$_SESSION['page']=$page;}
         echo $getFromBase->getPageList($page,$reportInit);
        ?>
    
    </div>
<div class="h40"></div> 
</div>

    </body>
</html>
