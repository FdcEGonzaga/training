<div class="container" >
    <div class="col-md-offset-2 col-md-8" >
       
        <?php
            echo $this->Html->link('Back', array('action' => 'index'));
        ?>

        <h2>Message Detail </h2>

            <!-- Input field -->
            <div class="row">
                <div class=" col-md-8 pull-right">
                    <?php  
                        echo $this->Form->create('Message'); 
                        echo $this->Form->input('content', array(
                            'value' => '', 
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Edit your reply here...',
                            'rows' => '3'
                        )); 
                        echo $this->Form->end( array( 'label' => 'Reply Message', 'class' => 'pull-right' ));
                    ?>
                </div>
            </div>
            <hr>

            <!-- Messages -->    
            <!-- Here's where we loop through our $messages data -->  
            <?php foreach ($messagedetails as $message): 
                
                //assigning variables 
                $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;  
                $sender_pic =   '/myuploads/'.$message['Sender']['sender_image']  ;  
                $authorID = $message['Message']['from_id'];
            ?>
             
                <div class="message-container row">
                   
                        <?php
                        //if last message is from the user change placement
                        if($authorID === AuthComponent::user('id')){
                            echo "<div class='col-md-10 messagecontent'>";
                                   
                                    //Message content
                                    echo "<small>From: <b>You</b></small><br>";
                                    echo $this->Html->link(
                                        $message['Message']['content'],
                                        array('action' => 'view', $authorID)
                                    ); 
                                    echo "<br><br><hr>";

                                    //Time sent
                                    echo "<small class='pull-right'>Time:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
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
                                    echo "<small>From: <b>".$message['Sender']['sender_name']."<b></small><br>";
                                    echo $this->Html->link(
                                        $message['Message']['content'],
                                        array('action' => 'view', $authorID)
                                    ); 
                                    echo "<br><br><hr>";

                                    //Time sent
                                    echo "<small class='pull-right'>Time:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
                        
                             echo "</div>";  

                        }?>    
                </div>
                 
            <?php endforeach; ?> 

    </div>
</div> 