 
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
                        if($authorID === AuthComponent::user('id')){
                            echo "<div class='col-md-10 messagecontent'>";
                                   
                                    //Message content
                                    echo "<small>You sent a message to </small> <b>".$message['Receiver']['receiver_name']."</b></small><br>";  
                                    echo $this->Html->link(
                                        $message['Message']['content'],
                                        array('action' => 'view', $authorID, $receiverID)
                                    );  
                                    echo "<br><br><hr>";

                                    //Time sent
                                    echo "<small>Sent:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
                                    // echo $this->Form->postLink(
                                    //     'Delete',
                                    //     array('action' => 'delete', $message['Message']['id']),
                                    //     array('confirm' => 'Are you sure?', 'class' => 'pull-right')
                                    // );

                            echo "</div>";  
                            
                            echo "<div class='col-md-2' style='background-color: ;' > ";
                               
                                    echo $this->Html->image(
                                        $user_pic, 
                                        array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                                    ); 
                        
                            echo "</div>";

                        }else { 
                            
                            echo "<div class='col-md-2' style='background-color: ;' > ";
                               
                                    echo $this->Html->image(
                                        $sender_pic, 
                                        array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                                    ); 
                                
                            echo "</div>";

                            echo "<div class='col-md-10 messagecontent'>";
                                   
                                    //Message content
                                    echo "<b>".$message['Sender']['sender_name']."</b><small> sent you a message</small><br>";
                                    echo $this->Html->link(
                                        $message['Message']['content'],
                                        array('action' => 'view', $authorID, $receiverID)
                                    );  
                                    echo "<br><br><hr>";

                                    //Time sent
                                    echo "<small class='pull-right'>Sent:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
                        
                             echo "</div>";  

                        }?>    
                </div>
                 
            <?php endforeach; ?> 
 

  