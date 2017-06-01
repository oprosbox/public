<!-- страница регистрации пользователей-->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" charset="utf-8" />
        <link href="css/cssStyle.css" rel="stylesheet" type="text/css" />
        <script src="scripts/jquery-3.1.1.min.js"></script>
        <script src="scripts/scriptsToWork.js"></script>
       <title></title>
    </head>
      <script type="text/javascript">
    $(document).ready(
  function(){
    $(document).ajaxStop(function(){
                 $("#btnNewRegistr").click(function(){//при последующем обновлении приходит кнопка и на неё вешается Ajax-запрос
                         $("#info").load("registration.php","newRegistr=1"+
                                                                 "&login="+$("#loginR").val()+
                                                                 "&password="+$("#passwordR").val()
                                                                 
                                                                 );   
                          });          
                          
               });       
    $("#info").load("registration.php");//первый старт(функция запрашивает окно регистрации)
    });
    </script>
    
    <body>
    <div id="addressWin">
         <div id="info"></div>
    </div> 
    </body>
    
</html>
