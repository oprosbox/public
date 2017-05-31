 
 
<?php

include_once 'sql\functMySQL.php';
include_once 'formAddNews.php';
//-------------------------------------------------------------------------------------------------------------------------
class WFunctMySQLOut extends WFunctMySQL 
{
  //функция проверяет пришедшие данные и в случае успеха заносит их в БД
public function setData(&$SNews,&$report)
{ 
  $SNews->setParamsFromPost();
  //если данные заполнены все
 if($SNews->isGood())
          {
          //добавляем в базу данных 
           $this->insertArticle($SNews, $report);
          }
    else{$report="откорректируйте, пожалуйста!";}
          
}

  //функция проверяет пришедшие данные и в случае успеха заносит их в БД
public function updateData(&$SNews,&$report)
{ if($SNews->id===0){$report=$report."добавьте статью, для того чтобы её изменить. ";
                     return 0;}
  $SNews->setParamsFromPost();
  //если данные заполнены все
 if($SNews->isGood())
          {
          //добавляем в базу данных 
           $this->updateArticle($SNews, $report);
          }
    else{$report=$report."откорректируйте, пожалуйста! ";}
          
}   
//---------------------------функция проверяет пришедшие данные-----------------------
public function refreshData(&$SNews,&$report)
{ 
  $SNews->setParamsFromPost();
  //если данные заполнены все
 if($SNews->isGood()){ }
                     else{$report="откорректируйте, пожалуйста! ";}       
}
//---------------------------функция проверяет пришедшие данные-----------------------
public function deleteData(&$SNews,&$report)
{ if($SNews->id===0){$report=$report."выберите статью ";} 
     else{if($this->deleteNews($SNews->id, $report))
                          {$SNews->__construct();
                            $sNews->flgFirst=false;}}      
}
//------------------------------------------------------------------------------------------------------------------------------
public function getPageData($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<div class='article'><a onclick=\"getPage('')\" class='linkText'>вернуться</a>"
              ."<h1>$outRes->datePublic - $outRes->header</h1></br>";
   if($outRes->size_pic!=0){$outResult=$outResult."<div class ='artImg'><img src='getImage.php?img=$id' width='100%'></img></div>";}
               $outResult=$outResult."<div class ='textArt'><h4>$outRes->text</h4></br></div></div>"; 
   return $outResult;
 } 
 else {return "error";} 
}

//------------------------------------------------------------------------------------------------------------------------------
public function getPageDataAdmin($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<div class='article'><a href='index.php' class='linkText'>на главную</a>"
              ."<h1 >$outRes->datePublic - $outRes->header</h1></br>";
           
   if($outRes->size_pic!=0){$outResult=$outResult."<div><img src='getImage.php?img=$id' width='98%'></img></div>";}
            $outResult=$outResult ."<div><h4>".nl2br($outRes->text)."</h4></div>"
                    ."<div><a href='InfoCreate.php?idArticle=$outRes->id' class='linkText'>редактировать</a>"
                    ."<h4 onclick='deleteArticle($outRes->id)' class='linkText'>удалить</h4>"
                    . "</div></div>";
                    
                          
   return $outResult;
 } 
 else {return "error";} 
}
//----------------------------------------------------------------------------------------------------------------------------
protected function getLine($num,$size,$MaxOut)
{
  $page="<div class='pagging'><h4>страницы:</h4><ul>";
   
    if($size<$MaxOut)
   {//максимальное количество елементов < максимального индекса
     for($i=0;$i<$size;$i++) 
     {$page=$page."<li><a onclick='getPage($i)' style='float:left;'>".($i+1)."</a></li>";}
   }else{if($num<$MaxOut){//индекс находится спереди
                         for($i=0;$i<$MaxOut-1;$i++) 
                         {$page=$page."<li><a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a></li>".$space;}
                          $page=$page."<li><h4>...</h4a></li>".$space;
                          $page=$page."<li><a onclick='getPage(".($size-1).")'><h4 >".($i+1)."</h4></a></li>";
                          }
            elseif($size-$num<$MaxOut){//индекс находится сзади
                                      $page=$page."<li><a onclick='getPage(0)'><h4 >".($i+1)."</h4></a></li>".$space;
                                      $page=$page."<li><h4> ...</h4></li>".$space;  
                                      for($i=1;$i<$MaxOut;$i++) 
                                      {$page=$page."<li><a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a></li>".$space;}}
                 else{//индекс находится всередине
                       $page=$page."<li><a onclick='getPage(0)'><h4 >".($i+1)."</h4></a></li>".$space;
                       $page=$page."<li><h4>...</h4></li>";
                       for($i=0;$i<$MaxOut-2;$i++) 
                       {$page=$page."<li><a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a></li>".$space;}
                        $page=$page."<li><h4>...</h4></li>".$space;
                        $page=$page."<li><a onclick='getPage(".($size-1).")'><h4 >".($i+1)."</h4></a></li>";
                       }
         }
  $page=$page."</ul></div>";
                           
return $page;
 }
 //------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListUnreg($Num,&$report)
{$page="";$report='';
  $news=$this->selectNews($Num, $report);
  if($news)
  {  $page="<ul>"; 
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<li class='post'><h1 onclick='getOneArticle($outRes->id)'>$outRes->datePublic - $outRes->header</h1></br>"
                ."<div class='postText'><h4>$outRes->annonce</h4></div></li>\n";}
    $page=$page."</ul><br/>";
    $totalPage=$this->getCountButtons($report);
    $page=$page.$this->getLine($Num,$totalPage,10);
  }
   //в случае если удалили последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
    if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListUnreg($Num,$report);}
 return $page;
}
//------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListReg($Num,&$report)
{$page="";$report='';
  $news=$this->selectNews($Num, $report);
  if($news)
  { $page="<ul>";   
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<li class='postUser'><h1 onclick='getOneArticle($outRes->id)'>$outRes->datePublic - $outRes->header</h1></br>"
                ."<div class='postTextUser'><h4>$outRes->annonce</h4></div></li>\n";}
    $page=$page."</ul><br/>";
    $totalPage=$this->getCountButtons($report);
    $page=$page.$this->getLine($Num,$totalPage,5);
  }
  //в случае если удалили последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
    if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListReg($Num,$report);}
 return $page;
}  

//------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListAdmin($Num,&$report)
{$page="";$report='';
$news=$this->selectNews($Num, $report);
  if($news)
  {  $page="<a href='infoCreate.php' class='linkText'>добавить статью</a> <ul>";
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<li class='postUser'><h1 onclick='getOneArticle($outRes->id)'>$outRes->datePublic - $outRes->header</h1></br>"
                ."<div class='postTextUser'><h4>$outRes->annonce</h4></div></br>\n"
                ."<a onclick='deleteArticle($outRes->id)' class='linkText'>удалить</a>"
                ."<a href='InfoCreate.php?idArticle=$outRes->id' class='linkText'>редактировать</a></li>";}
    $page=$page."</ul><br/>"; 
    $totalPage=$this->getCountButtons($report);
    $page=$page.$this->getLine($Num,$totalPage,5);
    }
 //в случае если удалили последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
   if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListAdmin($Num,$report);}
 return $page;
}  
}
