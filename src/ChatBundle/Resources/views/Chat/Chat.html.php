

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta http-equiv="Content-Type" content="text/javascript; charset=utf-8" />
     <meta http-equiv="Content-Type" content="text/css; charset=utf-8"/>
    
    <title>Chat</title>
 <link href="<?php echo $view['assets']->getUrl('css/chat_style.css')  ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo $view['assets']->getUrl('css/bootstrap.min.css')  ?>" rel="stylesheet" type="text/css" />

  <link href="<?php echo $view['assets']->getUrl('css/stylesheet.css')  ?>" rel="stylesheet"/>
 <link href="<?php echo $view['assets']->getUrl('css/jquery.emojiarea.css')  ?>" rel="stylesheet"/>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"/>
  <link href="<?php echo $view['assets']->getUrl('css/fontello/css/fontello.css')  ?>" rel="stylesheet"/
 
      
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    
  
    
   
    
    
    
    
    <script >
    
    /* 
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(){
	if(!instanse){
		 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "http://localhost:1234/my_project_name/web/app_dev.php/chat/processing",
			   data: {  
			   			'function': 'getState',
						'file': file
						},
			   dataType: "json",
			   
			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
			});
	}	 
}

//Updates the chat
function updateChat(){
	 if(!instanse){
		 instanse = true;
	     $.ajax({
			   type: "POST",
			   url: "http://localhost:1234/my_project_name/web/app_dev.php/chat/processing",
			   data: {  
			   			'function': 'update',
						'state': state,
						'file': file
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }								  
				   }
				   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 }
}

//send the message
function sendChat(message, nickname)
{       
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "http://localhost:1234/my_project_name/web/app_dev.php/chat/processing",
		   data: {  
		   			'function': 'send',
					'message': message,
					'nickname': nickname,
					'file': file
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}

    
    
    
    
    </script>
    
 

    
    
    
</head>

<body onload="setInterval('chat.update()', 1000)">
    <div class="header">
        
    </div>
     <div class="olinechat"> 
    </div>
    <div id="page-wrap">
        
        <p id="name-area"></p>
        
        <div id="chat-wrap">
            
            
            <div id="chat-area"></div>
                
        </div>

         
              
              
        <form id="send-message-area" >
         
            
            <textarea class="emojis-wysiwyg" maxlength = '100' ></textarea>
             

        </form>
        
    <textarea class="value" name="hide"  id="emojis-wysiwyg-value"></textarea>
        
        </div>
  

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>  
  <script src="<?php echo $view['assets']->getUrl('js/jquery.emojiarea.js')  ?>"></script>
  <script src="<?php echo $view['assets']->getUrl('js/basic/emojis.js')  ?>"></script>
   <script src="<?php echo $view['assets']->getUrl('js/text_xchat.js')  ?>"></script>
      

  
   


    <script type="text/javascript">
    
        // ask user for name with popup prompt    
       name="vasea";
    	// kick off chat
        var chat =  new Chat();
    	$(function() {
    	
    		 chat.getState(); 
    		 
    		 // watch textarea for key presses
             $("#send-message-area").keydown(function(event) {  
             
                 var key = event.which;  
           
                 //all keys including return.  
                 if (key >= 33) {
                   
                     
                     
                     // don't allow new content if length is maxed out
                     
                  }  
    		 																																																});
    		 // watch textarea for release of key press
    		 $('#send-message-area').keyup(function(e) {	
    		 					 
    			  if (e.keyCode == 13) { 
    			  
                    var text = $('.value').val();
    				
                    
                     
    			        chat.send(text, name);	
    			        
    			        
              
    				
    				
    			  }
             });
            
    	});
    </script>

 

	
    
    
    
    
</body>

</html>


 
<!--http://www.tipocode.com/jquery/smiley-insertion-system-using-jquery/-->