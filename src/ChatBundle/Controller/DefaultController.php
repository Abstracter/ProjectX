<?php

namespace ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    
    

     
    public function indexAction()
    {
     
  return $this->render(
        'ChatBundle:Chat:Chat.html.php');
    }
    public function processAction()
    {   
    $request = $this->get('request');
        //request your data
        $function = $request->get('function');
        //or in one line
        $function =  $this->get('request')->request->get('function');
    
    $log = array();
    
    switch($function) {
    
    	 case('getState'):
        	 if(file_exists('..//web/chat.txt')){
               $lines = file('..//web/chat.txt');
        	 }
             $log['state'] = count($lines); 
        	 break;	
    	
    	 case('update'):
        	 $request = $this->get('request');
        //request your data
        $state = $request->get('state');
        //or in one line
        $state =  $this->get('request')->request->get('state');
        	if(file_exists('..//web/chat.txt')){
        	   $lines = file('..//web/chat.txt');
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;
        		 
        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }
         
                        }
        			 $log['text'] = $text; 
        		 }
        	  
             break;
    	 
    	 case('send'):
             
              $request = $this->get('request');
        //request your data
        $nickname = $request->get('nickname');
        //or in one line
        $nickname =  $this->get('request')->request->get('nickname');
		  
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                     $request = $this->get('request');
        //request your data
        $message = $request->get('message');
        //or in one line
        $message =  $this->get('request')->request->get('message');    
                         
			  
		 if(($message) != "\n"){
        	
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				} 
			 
        	
        	 fwrite(fopen('..//web/chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
		 }
        	 break;
    	
    }
return new JsonResponse( $log );

}
}
