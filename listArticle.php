<?php

  include_once 'sql\functMySQLOut.php';
        session_start();
        $reportInit="";
       
        $page=0;
        $getFromBase;
        $getFromBase=new WFunctMySQLOut('userSelect','passToManySelect1905',$reportInit);//инициализация, подключение к mySQL
          if(isset($_SESSION[USERNAME])) //пользователь зарегистрирован
                       {$page=$_SESSION[USERNAME]->page;
                         if(isset($_GET['page']))  
                           {$page=$_GET['page'];$_SESSION[USERNAME]->page=$page;}
                           if($_SESSION[USERNAME]->rights==='root'){echo $getFromBase->getPageListAdmin($page,$reportInit);}
                           if($_SESSION[USERNAME]->rights==='user'){echo $getFromBase->getPageListReg($page,$reportInit);}
                           }
                       elseif(isset($_SESSION["page"])) //пользователь не зарегистрирован но вход уже не первый
                                {$page=$_SESSION["page"];
                                  if(isset($_GET['page']))  
                                     {$page=$_GET['page'];$_SESSION['page']=$page;}
                                 echo $getFromBase->getPageListUnreg($page,$reportInit);     
                                }
                                else{$_SESSION['page']=$page; //не зарегистрированный пользователь первый вход
                                     echo $getFromBase->getPageListUnreg($page,$reportInit);}
  
