
        <?php
//скрипт выподит страницу со статьёй по id этой статьи        
       
if(isset($_GET['idArticle']))
 { include_once 'sql\functMySQLOut.php';
         session_start();
         $reportInit="";
         $getFromBase=new WFunctMySQLOut('userSelect','passToManySelect1905',$reportInit);
          if(isset($_SESSION[USERNAME]))//если пользователь в системе есть
        {
            if($_SESSION[USERNAME]->rights==='root')    
                            {//администратор
                              echo $getFromBase->getPageDataAdmin($_GET['idArticle'], $reportInit);}    
                       elseif($_SESSION[USERNAME]->rights==='user')
                                      {//зарегестрированный пользователь
                                       echo $getFromBase->getPageData($_GET['idArticle'], $reportInit);}
                               else{ echo "<h4>таких прав не существует</h4>";}}
          else{ //пользователя в системе нету(не зарегестрированный пользователь)
                echo $getFromBase->getPageData($_GET['idArticle'], $reportInit);}
 }

