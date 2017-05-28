
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
  //функция проверяет пришедшие данные
public function refreshData(&$SNews,&$report)
{ 
  $SNews->setParamsFromPost();
  //если данные заполнены все
 if($SNews->isGood()){ }
                     else{$report="откорректируйте, пожалуйста!";}       
}
//------------------------------------------------------------------------------------------------------------------------------
public function getPageData($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<h1 >$outRes->datePublic - $outRes->header</h2></br>";
   if($outRes->size_pic!=0){$outResult=$outResult."<div><img src='getImage.php?img=$id' height='200px' width='200px'></img></div>";}
   $outResult=$outResult."<div><h4>$outRes->text</h4></br><div>"; 
   return $outResult;
 } 
 else {return "error";} 
}

//------------------------------------------------------------------------------------------------------------------------------
public function getPageDataAdmin($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<h1 >$outRes->datePublic - $outRes->header</h2></br>";
   if($outRes->size_pic!=0){$outResult=$outResult."<div><img src='getImage.php?img=$id' height='200px' width='200px'></img></div>";}
   $outResult=$outResult."<div><h4>$outRes->text</h4></br><div>"
                         ."<a href='deleteArticle.php?delId=$outRes->id'>удалить</a></br>"
                         ."<a href='InfoCreate.php?idArticle=$outRes->id'>редактировать</a>"; 
   return $outResult;
 } 
 else {return "error";} 
}
//----------------------------------------------------------------------------------------------------------------------------
protected function getLine($num,$size,$MaxOut)
{$page="";
    if($size<$MaxOut)
   {//максимальное количество елементов < максимального индекса
     for($i=0;$i<$size;$i++) 
     {$page=$page."<a onclick='getPage($i)'><h4 >".($i+1)."</h4></a>";}
   }else{if($num<$MaxOut){//индекс находится спереди
                         for($i=0;$i<$MaxOut-1;$i++) 
                         {$page=$page."<a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a>";}
                          $page=" ... ";
                          $page=$page."<a onclick='getPage(".($size-1).")'><h4 >".($i+1)."</h4></a>";
                          }
            elseif($size-$num<$MaxOut){//индекс находится сзади
                                      $page=$page."<a onclick='getPage(0)'><h4 >".($i+1)."</h4></a>";
                                      $page=" ... ";
                                      for($i=1;$i<$MaxOut;$i++) 
                                      {$page=$page."<a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a>";}}
                 else{//индекс находится всередине
                       $page=$page."<a onclick='getPage(0)'><h4 >".($i+1)."</h4></a>";
                       $page=" ... ";
                       for($i=0;$i<$MaxOut-2;$i++) 
                       {$page=$page."<a onclick='getPage(".($num+$i).")'><h4 >".($i+1)."</h4></a>";}
                        $page=" ... ";
                        $page=$page."<a onclick='getPage(".($size-1).")'><h4 >".($i+1)."</h4></a>";  
                       }
         }
return $page;
 }
//------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListUnreg($Num,&$report)
{$page="";
  $news=$this->selectNews($Num, $report);
  if($news)
  {   
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<a href='oneArticle.php?page=$outRes->id'><h1 >$outRes->datePublic - $outRes->header</h1></a></br>"
                ."<div><h4>$outRes->annonce</h4></div></br>\n";}
    $totalPage=$this->getCountButtons($report);
    $page=$page."страница:".$this->getLine($Num,$totalPage,10);
  }
 return $page;
}
//------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListReg($Num,&$report)
{$page="";
  $news=$this->selectNews($Num, $report);
  if($news)
  {   
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<a href='oneArticle.php?page=$outRes->id'><h1 >$outRes->datePublic - $outRes->header</h1></a></br>"
                ."<div><h4>$outRes->annonce</h4></div></br>\n";}
    $totalPage=$this->getCountButtons($report);
    $page=$page."страница:".$this->getLine($Num,$totalPage,5);
  }
 return $page;
}    
//------------------------------------формирует список новостей--------------------------------------------------------
public function getPageListAdmin($Num,&$report)
{$page="";
  $news=$this->selectNews($Num, $report);
  if($news)
  {   
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<a href='oneArticle.php?pageAdmin=$outRes->id'><h1 >$outRes->datePublic - $outRes->header</h1></a></br>"
                ."<div><h4>$outRes->annonce</h4></div></br>\n"
                ."<a href='deleteArticle.php?delId=$outRes->id'>удалить</a></br>"
                ."<a href='InfoCreate.php?idArticle=$outRes->id'>редактировать</a>";}
    $totalPage=$this->getCountButtons($report);
    $page=$page."страница:".$this->getLine($Num,$totalPage,5);
  }
 return $page;
}  
}
