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
    function getPage(numPage)          
    { nPage="";
     if(numPage!==""){nPage="page="+numPage;}
      $("#centerB").load($("#userVar").attr("name")+".php",nPage);
    }   
    
    $(document).ready(function(){ 
         userVar='unreg';
        
        $("#regist").load("userInOut.php");
        
         $(document).ajaxStop(function(){
              $("#btnRegistr").click(function(){  
                                     $("#regist").load("userInOut.php",$("#btnRegistr").attr("name")+"=1"+
                                                                       "&login="+$("#loginReg").val()+
                                                                       "&password="+$("#passwordReg").val());                         
                     }); 
               if(userVar!=$("#userVar").attr("name"))                           
                                    {
                                      getPage("");
                                      userVar=$("#userVar").attr("name");
                                    }
                  });       
      
          
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
