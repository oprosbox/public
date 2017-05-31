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
   <script type="text/javascript">
  //-----------------------------------------------------------------------------------
    $(document).ready(function(){ 
        //getRegist("",""); 
        
        $("#regist").load("userInOut.php");
        getPage("");
        //getRegist("","");
        //$("#btnRegistr").click(function(){getRegist($("#loginReg").val(),$("#passwordReg").val());});
        });
    </script>
<body>
    
    <div id="addressWin">
          <div id="regist"></div>
    </div> 
     <div id="centrWinB">  
          <div class="h40"></div> 
          <div id="centerB"></div>
          <div class="h40"></div> 
    </div>
</body>
</html>
