 
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
      //-------------- получает страницу со статьей--------------------------------------------- 
      function getFormAdd(idArticle)          
    { strAdd='';
      if(idArticle!=''){strAdd="idArticle="+idArticle;}  
      $("#centerB").load("infoCreate.php",strAdd);
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

//---------------------комманды редактирования информации---------------------------------
    function btnComm(command)          
    {
     
      var fmData =  new FormData(document.getElementById('postFormAdd'));
      fmData.append(command,'1');
      $.ajax({
             url: 'infoCreate.php',
             data: fmData,
             cache:false,
             processData: false,
             contentType: false,
             type: 'POST',
             success:function(msg){$("#centerB").html(msg);}
         });   
    }
    