<?php
//скрипт загружает список статей с аннонсами
  include_once 'sql\functMySQLOut.php';
        session_start();
        $reportInit="";      
        $page=0;
        $getFromBase=new WFunctMySQLOut('userSelect','passToManySelect1905',$reportInit);//инициализация, подключение к mySQL
          if(isset($_SESSION[USERNAME])) //пользователь уже зарегистрирован в системе
                       {$page=$_SESSION[USERNAME]->page;
                         if(isset($_GET['page'])) //если получаем номер страницы, который следует отобразить 
                                {$page=$_GET['page'];$_SESSION[USERNAME]->page=$page;}//запоминаем номер на сервере
                           if($_SESSION[USERNAME]->rights==='root'){echo $getFromBase->getPageListAdmin($page,$reportInit);}//выводим страницу пользователя администратора
                           if($_SESSION[USERNAME]->rights==='user'){echo $getFromBase->getPageListReg($page,$reportInit);}//выводим страницу зарегестрированного пользователя
                           }
                  elseif(isset($_SESSION["page"])) //пользователь не зарегистрирован но вход уже не первый
                                 {$page=$_SESSION["page"];
                                  if(isset($_GET['page'])) //если получаем номер страницы, который следует отобразить  
                                     {$page=$_GET['page'];$_SESSION['page']=$page;}//запоминаем номер страницы на сервере
                                  echo $getFromBase->getPageListUnreg($page,$reportInit); //выводим страницу незарегестрированного пользователя    
                                   }
                            else{$_SESSION['page']=$page; //не зарегистрированный пользователь первый вход
                                 echo $getFromBase->getPageListUnreg($page,$reportInit);}
  
