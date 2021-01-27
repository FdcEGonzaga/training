 <!--

    This is for loading more conversation on the Message List view.

-->
<?php foreach ($messages as $message): 
    
    //assigning variables 
    $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;  
    $sender_pic =   '/myuploads/'.$message['Sender']['sender_image']  ;  
    $authorID = $message['Message']['from_id'];
    $receiverID = $message['Message']['to_id'];
?>
    
    <div class="message-container row">
        
            <?php
            //if last message is from the user change placement
            //if last message is from the user flush right
            if($authorID === AuthComponent::user('id')){
                echo "<div class='col-md-10 messagecontent'>"; 
                        
                        //Message content
                        echo "<small>You sent a message to <b>".$message['Receiver']['receiver_name']."</b></small><br>";  
                        echo $this->Html->link(
                            substr($message['Message']['content'], 0, 20)."...",
                            array('action' => 'view', $authorID, $receiverID)
                        );  
                        echo "<br><br><hr>";

                        //Time sent
                        echo "<small>Sent:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>";  
                echo "</div>";  
                
                echo "<div class='col-md-2' style='background-color: ;' > "; 
                        echo $this->Html->image(
                            $user_pic, 
                            array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                        );  
                        //Delete Button
                        echo "<button  type='button' class='delete-btn btn btn-danger pull-right' data-id="
                            .$authorID ." data-rec="
                            .$receiverID.">Delete</button>";
                echo "</div>";

            }else { 
                
                echo "<div class='col-md-2'  > ";  
                        echo $this->Html->image(
                            $sender_pic, 
                            array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                        ); 
                    
                echo "</div>";

                echo "<div class='col-md-10 messagecontent'>";
                        
                        //Message content
                        echo "<b>".$message['Sender']['sender_name']."</b><small> sent you a message</small><br>";
                        echo $this->Html->link(
                            substr($message['Message']['content'], 0, 20)."...",
                            array('action' => 'view', $authorID, $receiverID)
                        );   
                        //Time sent
                        echo "<hr><small class='pull-right'>Sent:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
                        //Delete Button
                        echo "<br>";
                            echo "<button  type='button' class='delete-btn btn btn-danger pull-right' data-id="
                            .$authorID ." data-rec="
                            .$receiverID.">Delete</button>";

                echo "</div>";  

            }?>    
    </div>
        
<?php endforeach; ?> 
 

  