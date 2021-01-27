 <!--

    This is for loading previous replies on the Message Details view.

-->
<?php  
foreach ($replies as $reply):  
        //assigning variables 
        $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;  
        $sender_pic =   '/myuploads/'.$reply['Sender']['sender_image']  ;  
        $authorID = $reply['Message']['from_id'];
        $receiverID = $reply['Message']['to_id'];
    ?>
    
        <div class="message-container row">
        
                <?php
                //if last message is from the user change placement
                if ($authorID === AuthComponent::user('id')) {

                    echo "<div class='col-md-10 messagecontent'>"; 
                            //Message content
                            echo "<small>From: <b>You</b></small><br>";
                            echo "<b style='color:#337ab7;'>".   $reply['Message']['content']."</b>"; 
                            echo "<br><br><hr>"; 
                            //Time sent
                            echo "<small>Sent: ".date('F j, Y h:i:A', strtotime($reply['Message']['created']))." </small>"; 
                    echo "</div>";  
                    
                    echo "<div class='col-md-2'>"; 
                            echo $this->Html->image(
                                $user_pic, 
                                array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                            ); 
                            echo "<button  type='button' class='delete-btn btn btn-danger pull-right' data-id=".$reply['Message']['id'].">Delete</button>";
                    echo "</div>";

                } else {  

                    echo "<div class='col-md-2'>"; 
                            echo $this->Html->image(
                                $sender_pic, 
                                array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                            );  
                    echo "</div>"; 

                    echo "<div class='col-md-10 messagecontent'>"; 
                            //Message content
                            echo "<small>From: <b>".$reply['Sender']['sender_name']."</b></small><br>";
                            echo "<b style='color:#337ab7;'>".   $reply['Message']['content']."</b>"; 
                            echo "<br><br><hr>";  
                            //Time sent
                            echo "<small class='pull-right'>Sent:" . date('F j, Y h:i:A', strtotime($reply['Message']['created']))." </small>"; 
                    echo "</div>";    
                            
                 }?>    
        </div>
        
<?php endforeach; ?> 