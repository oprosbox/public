<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" charset="utf-8" />
        <link href="css/cssStyle.css" rel="stylesheet" type="text/css" />
        <title></title>
    </head>
    <body>
          <?php
      //инициализация
      include_once 'sql\initMySQLOut.php';
      session_start();
      define("GOOD","<h4 style='color:green' class='hOut'>успешно!</h4>");
      define("BAD","<h4 style='color:red' class='hOut'>неудача!</h4>");
         ?>
       <div id="centrWinB">  
           <div class="h40"></div> 
<div id="centerB">
    <hr/>
    <h4>войти в базу данных</h4>
      <form action='install.php' method='POST'>
        <input type='text' value='root' name='login'><br /><br />
        <input type='password' name='password'><br /><br />
        <input type='submit' value='Войти' name='btnLog'>
      <?php
        echo addLogPassToSession();
         ?>
    </form>
        <form action='install.php' method='POST'>
        <h4 style='display:inline'>создать базу и пользователей</h4><input type='submit' value='создать' name='createDBUserAll' class="inputCRDB"/>
       <?php
       if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->createDBUser();}
         ?>
    </form> 
      <form action='install.php' method='POST'>
        <h4 style='display:inline'>удалить базу и пользователей</h4><input type='submit' value='удалить' name='deleteDBUserAll' class="inputCRDB"/>
       <?php
       if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->deleteDBUser();}
         ?>
    </form> 
    <hr/><br />
    <form action='install.php' method='POST'>
        <h4 style='display:inline'>создать базу данных</h4><input type='submit' value='создать' name='createAll' class="inputCRDB"/>
       <?php
       if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->createDBOut();}
         ?>
    </form>   
     <form action='install.php' method='POST'>
        <h4 style='display:inline'>удалить базу данных</h4><input type='submit' value='удалить' name='deleteAll' class="inputCRDB"/>
     <?php
     if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->deleteDBOut();}
         ?>
     </form>
    <hr style='clear:both'/><br />
    <form action='install.php' method='POST'>
        <h4 style='display:inline'>создать таблицу info</h4><input type='submit' value='создать' name='createInfo' class='inputCRDB'/>
      <?php
      if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->createTblInfo();}
         ?>
    </form>
    <form action='install.php' method='POST'>
        <h4 style='display:inline'>создать таблицу site_users</h4><input type='submit' value='создать' name='createUsers' class='inputCRDB'/>
      <?php
      if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->createTblUsers();}
         ?>
    </form><hr/><br />
        <form action='install.php' method='POST'>
        <h4 style='display:inline'>создать пользователей</h4><input type='submit' value='создать' name='createDBUser' class='inputCRDB'/>
      <?php
    if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->createUserOut();} 
         ?>
    </form>
     <form action='install.php' method='POST'>
        <h4 style='display:inline'>удалить пользователей</h4><input type='submit' value='удалить' name='deleteDBUser' class='inputCRDB'/>
      <?php
      if(isset($GLOBALS["db"])){ echo $GLOBALS["db"]->deleteUserOut();}
      ?>
     </form><hr/><br />
</div>
<div class="h40"></div> 
</div>

    </body>
</html>

<?php

function addLogPassToSession()
{  
   if((isset($_POST["login"])) and (isset($_POST["password"])))
                { $login=htmlentities($_POST["login"]);
                  $password=htmlentities($_POST["password"]);
                  
                 $con=new WDBConn($login,$password,$report);
                 if($con->is_connected())
                     {
                      $_SESSION["login"]=$login;
                      $_SESSION["password"]=$password;
                     }
                } 
                
   if((isset($_SESSION["login"])) and (isset($_SESSION["password"])))
                {
                 
                if(!isset($GLOBALS["db"]))
                        {$GLOBALS["db"]=new WInitDB($_SESSION["login"],$_SESSION["password"]);
                         return "<h4 style='color:green' class='hOut'>логин и пароль назначены</h4>";
                          }
                          
                }
                else{
                    return "<h4 style='color:red' class='hOut'>логин и пароль не заданы </h4>";
                    }
}