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
        <title></title>
    </head>
        <script type="text/javascript">
    $(document).ready(
  function(){
      
    $(document).ajaxStop(function(){
              
               $("#btnRegistr").click(function(){
                    // string=$("#btnRegistr").attr("name")+"=1"+
                    //                                       "&login="+$("#loginReg").val()+
                    //                                       "&password="+$("#passwordReg").val();
                    //      $("#centerB").html("<h4>"+string+"</h4>");   
                         $("#info").load("userInOut.php",$("#btnRegistr").attr("name")+"=1"+
                                                           "&login="+$("#loginReg").val()+
                                                           "&password="+$("#passwordReg").val());   
                          });    
               });       
    $("#info").load("userInOut.php");
    });
    </script>
    <body>
        
<div id="addressWin">
  <div id="info"></div>
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
