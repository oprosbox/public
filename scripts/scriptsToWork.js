 
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


    function btnComm(command)          
    {
     // dataInf=$('#postFormAdd').serializeArray();
     // dataInf.push({name: command, value: "1"});
     // dataInf.push({name: "picture", value: fileImage});
      var fmData =  new FormData(document.getElementById('postFormAdd'));
      fmData.append(command,'1');
      $.ajax({
             url: 'infoCreate.php',
             data: fmData,
             processData: false,
             contentType: false,
             type: 'POST',
             success:function(msg){$("#centerB").html(msg);}
         });
  
         // request.done();
       //$("#centerB").css('background-color','red');
     // $("#centerB").load('infoCreate.php',data); 
      //$.ajax({type: "POST",
      //        url: "infoCreate.php",
              //processData: false,
              //cache: false,
              //dataType: 'json',
              //contentType: "multipart/form-data",
      //        data: dataInf}).done(function(msg) {
      // $("#centerB").html(msg)});
       
       /*$.ajax({
        url: 'infoCreate.php',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function( respond, textStatus, jqXHR ){$("#centerB").html(respond);
                // Если все ОК
                 if( typeof respond.error === 'undefined' ){ }
                // Файлы успешно загружены, делаем что нибудь здесь
                // выведем пути к загруженным файлам в блок '.ajax-respond'
                //var files_path = respond.files;
                //var html = '';
                //$.each( files_path, function( key, val ){ html += val +'<br>'; } )
                //$('.ajax-respond').html( html );}
                
                 else{//console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
                      }
                 },
        error: function( jqXHR, textStatus, errorThrown ){
            //console.log('ОШИБКИ AJAX запроса: ' + textStatus );
        }
         });*/
        
    }
    