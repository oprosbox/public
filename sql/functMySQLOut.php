 
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
//---------------------------функция проверяет пришедшие данные и не добавляя в базу обновляет флаги допустимых значений-----------------------
public function refreshData(&$SNews,&$report)
{ 
  $SNews->setParamsFromPost();
  //если данные заполнены все
 if($SNews->isGood()){ }
                     else{$report="откорректируйте, пожалуйста! ";}       
}
//---------------------------удаление статьи из базы данных и очищает объект в котором происходит редактирование статьи-----------------------
public function deleteData(&$SNews,&$report)
{ if($SNews->id===0){$report=$report."выберите статью ";} //статья не назначена
     else{if($this->deleteNews($SNews->id, $report))
                          {$SNews->__construct();
                            $SNews->flgFirst=false;}}      
}
//---------------------получает страницу со статьей(обычный пользователь)-------------------------------------------------------------
public function getPageData($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<div class='article'><h4 onclick=\"getPage('')\" class='linkText'>вернуться</h4>"
              ."<h1>$outRes->datePublic - $outRes->header</h1></br>";
   if($outRes->size_pic!=0){$outResult=$outResult."<div class ='artImg'><img src='getImage.php?img=$id' width='100%'></img></div>";}
               $outResult=$outResult."<div class ='textArt'><h4>$outRes->text</h4></br></div></div>"; 
   return $outResult;
 } 
 else {return "error";} 
}

//------------------------получает страницу со статьей(администратор)--------------------------------------------------------------
public function getPageDataAdmin($id,&$report)
{$outRes=new SNews;
 if($this->selectOneNews($id, $outRes, $report))
 { 
   $outResult="<div class='article'><h4 onclick=\"getPage('')\" class='linkText'>на главную</h4>"
              ."<h1 >$outRes->datePublic - $outRes->header</h1></br>";
           
   if($outRes->size_pic!=0){$outResult=$outResult."<div><img src='getImage.php?img=$id' width='98%'></img></div>";}
            $outResult=$outResult ."<div><h4>".nl2br($outRes->text)."</h4></div>"
                    ."<h4 onclick='getFormAdd($outRes->id)' class='linkText'>редактировать</h4>"
                    ."<h4 onclick='deleteArticle($outRes->id)' class='linkText'>удалить</h4>"
                    . "</div></div>";
                    
                          
   return $outResult;
 } 
 else {return "error";} 
}
//--------------линия с номерами страниц новостей----------------------------------------------------
protected function getLine($num,$size,$MaxOut)//$Num-номер страницы $size-размер ленты $MaxOut-максимальное число выводимых кнопок со страницами
{
  $page="<div class='pagging'><h4>страницы:</h4><ul>";
   
    if($size<=$MaxOut)
   {//максимальное количество елементов < максимального индекса
     for($i=0;$i<$size;$i++) 
     {$page=$page."<li><a onclick=\"getPage($i)\" >".($i+1)."</a></li>";}
   }else{if($num+2<$MaxOut){//"текущий индекс находится спереди";
                         for($i=0;$i<$MaxOut-1;$i++) 
                         {$page=$page."<li><a onclick=\"getPage(".($i).")\">".($i+1)."</a></li>";}
                          $page=$page."<li><h4>...</h4></li>";
                          $page=$page."<li><a onclick=\"getPage(".($size-1).")\">".($size)."</a></li>";
                          }
            elseif($size-$num+1<$MaxOut){//"текущий индекс находится сзади";
                                      $page=$page."<li><a onclick=\"getPage(0)\">".(1)."</a></li>";
                                      $page=$page."<li><h4> ...</h4></li>";  
                                      for($i=1;$i<$MaxOut;$i++) 
                                      {$page=$page."<li><a onclick=\"getPage(".($size-$MaxOut+$i).")\">".($size-$MaxOut+$i+1)."</a></li>";}}
                 else{//"текущий индекс находится по середине";
                       $page=$page."<li><a onclick=\"getPage(0)\">".(1)."</a></li>";
                       $page=$page."<li><h4>...</h4></li>";
                       for($i=0;$i<$MaxOut-2;$i++) 
                       {$page=$page."<li><a onclick=\"getPage(".($num+$i-1).")\">".($num+$i)."</a></li>";}
                        $page=$page."<li><h4>...</h4></li>";
                        $page=$page."<li><a onclick=\"getPage(".($size-1).")\">".($size)."</a></li>";
                       }
         }
  $page=$page."</ul></div>";
                           
return $page;
 }
 //------------------------------------формирует список новостей(незарегистрированный пользователь)--------------------------------------------------------
public function getPageListUnreg($Num,&$report)//$Num-номер страницы
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
    $page=$page.$this->getLine($Num,$totalPage,8);
  }
   //в случае если не находит последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
    if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListUnreg($Num,$report);}
 return $page;
}
//------------------------------------формирует список новостей(зарегестрированный пользователь)--------------------------------------------------------
public function getPageListReg($Num,&$report)//$Num-номер страницы
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
    $page=$page.$this->getLine($Num,$totalPage,8);
  }
  //в случае если не находит последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
    if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListReg($Num,$report);}
 return $page;
}  

//------------------------------------формирует список новостей(администратор)--------------------------------------------------------
public function getPageListAdmin($Num,&$report)//$Num-номер страницы
{$page="<h4 onclick=\"getFormAdd('')\" class='linkText'>добавить</h4>";$report='';
$news=$this->selectNews($Num, $report);
  if($news)
  { $page=$page."<ul>"; 
    for($i=0;$i<count($news);$i++) 
    {$outRes=$news[$i];
     $page=$page."<li class='postUser'><h1 onclick='getOneArticle($outRes->id)'>$outRes->datePublic - $outRes->header</h1></br>"
                ."<div class='postTextUser'><h4>$outRes->annonce</h4></div></br>\n"
                ."<h4 onclick='deleteArticle($outRes->id)' class='linkText'>удалить</h4>"
                ."<h4 onclick='getFormAdd($outRes->id)' class='linkText'>редактировать</h4></li>";}
    $page=$page."</ul><br/>"; 
    $totalPage=$this->getCountButtons($report);
    $page=$page.$this->getLine($Num,$totalPage,8);
    }
 //в случае если удалили последнюю запись на странице рекурсивно подгружает последнюю не пустую страницу
   if(($news===false)and($report=="чтение прошло успешно")and($Num!='0')){$Num=$Num-1;
                                                                          $page=$this->getPageListAdmin($Num,$report);}
 
 return $page;
}  
}
