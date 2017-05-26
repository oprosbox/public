<?php

define("HEADERMAX",200);
define("HEADERMIN",1);
define("ANNONCMAX",1000);
define("ANNONCMIN",20);
define("TEXTMAX",8000);
define("TEXTMIN",50); 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class WDBConn
{
     protected $link;
     
     public function is_connected()
     {        
        if (!$this->link) {$report="Ошибка соединения";
                           return false;}
                           else{return  true;}
      }


    public function __construct($login,$password,&$report,$base=false) {
       
         if($base===false){$this->createConnect($login,$password,$report);}
                       else{$this->createConnectBase($login,$password,$report,$base);}
    }
    
     public function __destruct() {
       $this->closeConnect();
    }
    
    protected function createConnect($login,$password,&$report)
    {
      $this->link=mysqli_connect('localhost', $login, $password) ; 
    if (!$this->link) {$report="Ошибка соединения ($login, $password) ";
                 return false;}
    return true;
    }
    
     protected function createConnectBase($login,$password,$base,&$report)
    {
      $this->link=mysqli_connect('localhost', $login, $password) ; 
      if (!$this->link) {$report="Ошибка соединения ($login, $password,$base)";
                         return false;}
      if (mysqli_select_db($this->link, 'dbNews')){}
         else{ $report="Ошибка выбора БД: " . mysqli_error($this->link) . "\n";
               return false;}
    return true;
    }
    
      protected function closeConnect()
    {
      if (!$this->link){}else{mysqli_close($this->link);}   
    }  
    
//----------------------------------------------------------------------------------------------------------------    
     public function commands($query,$good,$bad,&$report)
    {
     if (mysqli_query($this->link,$query)) {
         $report=$report."<p>".$good."</p>";
         return true;
          } else {
           $report=$report."<p>".$bad . mysqli_error($this->link) . "</p>";
           return false;
          }    
     }
}
