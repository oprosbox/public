
  //--------------------скрывает элемент------------------------------------
    function hideFunct(teg,time)          
    { 
        setTimeout(function(){$(teg).fadeTo(500,0)},time);
    }     
  //------------------загружает страницу----------------------------------------
    function getPage(numPage)          
    { nPage="";
     if(numPage!==""){nPage="page="+numPage;}
      $("#centerB").load("listArticle.php",nPage);
    } 
  //-------------- получает страницу со статьей--------------------------------------------- 
      function getOneArticle(idArticle)          
    {
      $("#centerB").load("oneArticle.php","idArticle="+idArticle);
    } 
    //----------------------------------------------------------------------------------
    function getRegist(login,passw)
    {
     $("#regist").load("userInOut.php","btnInOut=1"+"&login="+login+"&password="+passw);
    }


 //---------------удаляет статью из базы----------------------------------------------- 
      function deleteArticle(idArticle)          
    {
      $(document).load("deleteArticle.php","delId="+idArticle,getPage(""));
    } 
