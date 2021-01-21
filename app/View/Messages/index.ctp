<div class="container" >
 <div class="col-md-offset-2 col-md-8" >
    
        <h2>Message List</h2><br>
    
        <?php   
            echo $this->Html->link('New Message', array('controller' => 'Messages', 'action' => 'add'),
            array('class' => 'btn btn-registered')); 

             
        ?>  
        <br><br>




        <!-- Here's where we loop through our $messages data -->

            <?php foreach ($messages as $message): ?>
             
                <div class="message-container">
                    
                    <?php

                        $userID = AuthComponent::user('id');
                        $authorID = $message['Message']['from_id'];

                        echo $this->Html->link(
                            $message['Message']['content'],
                            array('action' => 'view', $authorID)
                        );
                        echo "<br>";
 
                    ?> 

                     
                    <?php // From ID
                        echo "<small>Author: </small>". $authorID; 
                    ?><br>
                        
                    <?php echo "<small>Time: </small>" . date('F j, Y h:i:A', strtotime($message['Message']['created'])); ?>
                    
                    <div class="pull-right">
                        <?php  
                            //User can delete if he's the author of the message
                            if($authorID === $userID){
                                echo $this->Form->postLink(
                                    'Delete',
                                    array('action' => 'delete', $message['Message']['id']),
                                    array('confirm' => 'Are you sure you want to delete conversation '.$message['Message']['id'] .'?')
                                );
                            } 
                         ?> 
                    </div>
                </div>
                 
            <?php endforeach; ?> 

    </div>
</div>