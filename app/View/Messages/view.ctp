<div class="container" >
    <div class="col-md-offset-2 col-md-8" >
       
        <?php
            echo $this->Html->link('Back', array('action' => 'index'));
        ?>

        <h2>Message Details </h2>

            <!-- CREATING A REPLY FORM -->
            <div class="row">
                <div class=" col-md-10 pull-right">
                    <?php  

                        echo $this->Form->create(false, array(
                            'url' => array(
                                'controller' => 'Messages', 
                                'action' => 'reply')
                            )
                        ); 
                        
                        echo $this->Form->input( 'to_id',
                            array(
                                'label' => false, 
                                'value' => $receiverID ,  
                                'class' => 'form-control',
                                'id' => 'form-receiverID',
                                'type' => 'text'
                            )
                        );

                        echo $this->Form->input( 'from_id',
                            array(
                                'label' => false, 
                                'value' =>  AuthComponent::user('id'),  
                                'class' => 'form-control',
                                'id' => 'form-authorID',
                                'type' => 'text'
                            )
                        );
                        
                        echo $this->Form->input('content', array(
                            'value' => '', 
                            'id' => 'form-content',
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Edit your reply here...',
                            'rows' => '3',
                            'required' => true
                        )); 
                        echo $this->Form->end( array( 'label' => 'Reply Message', 'class' => 'pull-right', 'id' => 'reply-btn' ));
                    ?>
                </div>
            </div>
            <!-- CREATING A REPLY FORM -->


            <hr style="padding: 2px; background-color: #ddd;">

            <?php   echo "Shown # of ". $totalrows = $this->Paginator->params()['count']; ?><br><br>

                <!-- Here's where we loop through the replies data -->  
                <?php foreach ($messagedetails as $messagedetail):
                    //assigning variables 
                    $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;  
                    $sender_pic =   '/myuploads/'.$messagedetail['Sender']['sender_image']  ;  
                    $authorID = $messagedetail['Message']['from_id'];
                    $receiverID = $messagedetail['Message']['to_id'];
                ?>
                
                    <div class="message-container row">
                    
                            <?php 
                            //if last message is from the user change placement
                            if($authorID === AuthComponent::user('id')){
                                echo "<div class='col-md-10 messagecontent'>";
                                    
                                        //Message content
                                        echo "<small>From: <b>You</b></small><br>";
                                        echo "<b style='color:#337ab7;'>".   $messagedetail['Message']['content']."</b>"; 
                                        echo "<br><br><hr>";

                                        //Time sent
                                        echo "<small>Sent:" . date('F j, Y h:i:A', strtotime($messagedetail['Message']['created']))." </small>"; 
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
                                        echo "<small>From: <b>".$messagedetail['Sender']['sender_name']."</b></small><br>";
                                        echo "<b style='color:#337ab7;'>".   $messagedetail['Message']['content']."</b>"; 
                                        echo "<br><br><hr>"; 

                                        //Time sent
                                        echo "<small class='pull-right'>Sent:" . date('F j, Y h:i:A', strtotime($messagedetail['Message']['created']))." </small>"; 
                            
                                echo "</div>";  

                            }?>    
                    </div>
            
                <?php endforeach; ?> 

                <div class="text-center">
                    <?php
                    echo $this->Form->button('View previous messages',  array('class' => 'btn btn-registered', 'id' => 'prevmsgs-btn'));
                    ?>  
                    <input type="hidden" id = "authorID"   value="<?php echo $authorID ; ?>">
                    <input type="hidden" id = "receiverID"   value="<?php echo $receiverID ; ?>">
                    <input type="hidden" id = "rowcount"    value="0">
                    <input type="hidden" id = "rowperpage"  value="<?php echo $rowperpage ; ?>">   
                    <input type="hidden" id = "totalrows"   value="<?php echo $totalrows ; ?>">
                </div>
 
    </div>
</div> 

<script>
    $(document).ready(function(){
        var urlview = "<?php echo $this->Html->url(array('controller' => 'Messages', 'action' => 'viewReply')); ?>";
        var urlreply = "<?php echo $this->Html->url(array('controller' => 'Messages', 'action' => 'reply')); ?>";
  
        $('#reply-btn').click(function(){
            var formreceiverID = Number($('#form-receiverID').val());
            var formauthorID = Number($('#form-authorID').val());
            var formcontent = $('#form-content').val();

            $.ajax({
                    url: urlreply,  
                    type: 'POST',
                    data: {
                        formauthorID : authorID,
                        formreceiverID : receiverID,
                        formcontent: content
                    },
                    beforeSend:function(){
                        $("#reply-btn").text("Sending..."); 
                       
                    },
                    success: function(response) { 
                        setTimeout(function() { 
                            // $(".message-container:last").after(response).show(300);  

                            //     if (rowcount >= totalrows) {  
                            //         $('#prevmsgs-btn').hide(500);
                            //         alert('All messages are already viewed.');
                            //     } else {
                            //         $("#prevmsgs-btn").text("View previous messages"); 
                            //     } 
                        }, 300);

                    }
                });

            

        });

        $('#prevmsgs-btn').click(function(){
            var authorID = Number($('#authorID').val());
            var receiverID = Number($('#receiverID').val());
            var rowcount = Number($('#rowcount').val());
            var rowperpage = Number($('#rowperpage').val());
            var totalrows = Number($('#totalrows').val());    
            var rowcount = rowcount + rowperpage; 

            if(rowcount <= totalrows){ 
                
                $("#rowcount").val(rowcount);  
                
                $.ajax({
                    url: urlview,  
                    data: {
                        authorID: authorID,
                        receiverID: receiverID,
                        rowcount:rowcount,
                        rowperpage: rowperpage
                    },
                    beforeSend:function(){
                        $("#prevmsgs-btn").text("Viewing..."); 
                       
                    },
                    success: function(response) { 
                        setTimeout(function() { 
                            $(".message-container:last").after(response).show(300);  

                                if (rowcount >= totalrows) {  
                                    $('#prevmsgs-btn').hide(500);
                                    alert('All messages are already viewed.');
                                } else {
                                    $("#prevmsgs-btn").text("View previous messages"); 
                                } 
                        }, 300);

                    }
                });

            } else{

                $('#prevmsgs-btn').hide(500);
                alert('All messages are already viewed.');
            }
        }); 

        
    });

</script>

