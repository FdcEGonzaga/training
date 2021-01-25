<div class="container" >
 <div class="col-md-offset-2 col-md-8" >
    
        <h2>Message List</h2><br>
    
        <?php   
            echo $this->Html->link('New Message', array('controller' => 'Messages', 'action' => 'add'),
            array('class' => 'btn btn-registered'));  
            echo "<br><br>";
            echo "Shown <span id='displayedrows'>#</span> of ". $this->Paginator->params()['count'] . " conversation(s)";
        ?>  
        <br><br> 
 
        <!-- Here's where we loop through our $messages data -->  
            <?php foreach ($messages as $message): 
                
                //assigning variables 
                $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;  
                $sender_pic =   '/myuploads/'.$message['Sender']['sender_image']  ;  
                $authorID = $message['Message']['from_id'];
                $receiverID = $message['Message']['to_id'];
            ?>
             
                <div class="message-container row">
                   
                        <?php
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
                                    echo "<br><br><hr>";

                                    //Time sent
                                    echo "<small class='pull-right'>Sent:" . date('F j, Y h:i:A', strtotime($message['Message']['created']))." </small>"; 
                        
                             echo "</div>";  

                        }?>    
                </div>
                 
            <?php endforeach; ?> 

            <div class="text-center">
                <?php
                echo $this->Form->button('View More',  array('class' => 'btn btn-registered', 'id' => 'viewmore-btn'));
                ?>  
                <input type="hidden" id = "rowcount"    value="0">
                <input type="hidden" id = "rowperpage"  value="<?php echo $rowperpage ; ?>">   
                <input type="hidden" id = "totalrows"   value="<?php echo $totalrows ; ?>">
            </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        var url = "<?php echo $this->Html->url(array('controller' => 'Messages','action' => 'viewMore')); ?>";

        $('#viewmore-btn').click(function(){
            var rowperpage = Number($('#rowperpage').val());
            var totalrows = Number($('#totalrows').val());  
            var rowcount = Number($('#rowcount').val());  
            var rowcount = rowcount + rowperpage; 

            if(rowcount <= totalrows){ 
                
                $("#rowcount").val(rowcount);  
                
                $.ajax({
                    url: url,  
                    data: {
                        rowcount:rowcount,
                        rowperpage: rowperpage
                    },
                    beforeSend:function(){
                        $("#viewmore-btn").text("Viewing..."); 
                    },
                    success: function(response) { 
                        setTimeout(function() { 
                            $(".message-container:last").after(response).show(1000);  

                                if (rowcount >= totalrows) {  
                                    $('#viewmore-btn').hide(500);
                                    alert('No more messages to view');
                                } else {
                                    $("#viewmore-btn").text("View more"); 
                                } 
                        }, 500);

                    }
                });

            } else{

                $('#viewmore-btn').hide(500);
                alert('No more messages to view');
            }
        }); 

        
    });

</script>