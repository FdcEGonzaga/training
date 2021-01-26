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
                        
                        echo $this->Flash->render(); 

                        echo $this->Form->create('Message' ); 
                        //if logged in user is not equal to the AuthoComponent ()
                        //let receiverID be the sender  
                        
                        if ( AuthComponent::user('id') != $authorID ) {
                           //interchange the value of the receiverID and the authorID variables 
                            echo $this->Form->input( 'to_id',
                                array(
                                    'label' => false, 
                                    'value' => $authorID ,  
                                    'class' => 'form-control',
                                    'id' => 'form-receiverID',
                                    'type' => 'hidden'
                                )
                            ); 
                            echo $this->Form->input( 'from_id',
                                array(
                                    'label' => false, 
                                    'value' => $receiverID ,  
                                    'class' => 'form-control',
                                    'id' => 'form-authorID',
                                    'type' => 'hidden'
                                )
                            );
                             
                        } else { 
                            echo $this->Form->input( 'to_id',
                                array(
                                    'label' => false, 
                                    'value' => $receiverID ,  
                                    'class' => 'form-control',
                                    'id' => 'form-receiverID',
                                    'type' => 'hidden'
                                )
                            ); 
                            echo $this->Form->input( 'from_id',
                                array(
                                    'label' => false, 
                                    'value' => $authorID ,  
                                    'class' => 'form-control',
                                    'id' => 'form-authorID',
                                    'type' => 'hidden'
                                )
                            );

                        }  
  
                        echo $this->Form->input('content', array (
                            'value' => '', 
                            'id' => 'form-content',
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Edit your reply here...',
                            'rows' => '3',
                            'required' => true
                        )); 
                        //echo $this->Form->end( array( 'label' => 'Reply Message', 'class' => 'pull-right', 'id' => 'reply-btn' ));
                        echo $this->Form->button('Reply Message',  array ('class' => 'btn btn-registered pull-right', 'id' => 'reply-btn'));
                    ?>
                </div>
            </div>
            <!-- CREATING A REPLY FORM -->


            <hr style="padding: 2px; background-color: #ddd;">

            <?php   $totalrows = $this->Paginator->params()['count']; ?>
            <input type="hidden" id = "totalRows" value="<?php echo $totalrows; ?>">
            <br> 
            
            <div class="message-wrapper">

                <!-- Here's where we loop through the replies data -->  
                <?php foreach ($messagedetails as $messagedetail):
                    //assigning variables 
                    $user_pic   = '/myuploads/'.AuthComponent::user('image')  ;  
                    $sender_pic = '/myuploads/'.$messagedetail['Sender']['sender_image']  ;  
                    $authorID   = $messagedetail['Message']['from_id'];
                    $receiverID = $messagedetail['Message']['to_id'];
                    $msgID      = $messagedetail['Message']['id'];
                ?>
                
                    <div class="message-container row">
                    
                            <?php 
                            //if last message is from the user change placement
                            if ($authorID === AuthComponent::user('id')) {
                                echo "<div class='col-md-10 messagecontent'>";
                                    
                                        //Message content
                                        echo "<small>From: <b>You</b></small><br>";
                                        echo "<b style='color:#337ab7;'>".   $messagedetail['Message']['content']."</b>"; 
                                        echo "<br><br><hr>";

                                        //Time sent
                                        echo "<small>Sent: ".date('F j, Y h:i:A', strtotime($messagedetail['Message']['created']))." </small>"; 
                                        
                                echo "</div>";  
                                
                                echo "<div class='col-md-2' style='background-color: ;' > ";
                                
                                        echo $this->Html->image(
                                            $user_pic, 
                                            array('class' =>'image-responsive thumbnail' , 'height' => '100px', 'width' => '100px' )
                                        ); echo "<button  type='button' class='delete-btn btn btn-danger pull-right' data-id=".$messagedetail['Message']['id'].">Delete</button>";

                            
                                echo "</div>";

                            } else { 
                                
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
            
            </div>
            
                <div class="text-center">
                    <?php
                    echo $this->Form->button('View previous messages',  array('type' => 'button' ,'class' => 'btn btn-registered', 'id' => 'prevmsgs-btn'));
                    ?>  
                    <input type="hidden" id = "authorID"    value="<?php echo $authorID ; ?>">
                    <input type="hidden" id = "receiverID"  value="<?php echo $receiverID ; ?>">
                    <input type="hidden" id = "rowcount"    value="0">
                    <input type="hidden" id = "rowperpage"  value="<?php echo $rowperpage ; ?>">     

                </div>
 
    </div>
</div> 

<script>
$(document).ready(function() {
        var urlreply = "<?php echo $this->Html->url(array('controller' => 'Messages', 'action' => 'reply')); ?>";
        var urlview = "<?php echo $this->Html->url(array('controller' => 'Messages', 'action' => 'viewReply')); ?>";
        var urldelete = "<?php echo $this->Html->url(array('controller' => 'Messages', 'action' => 'deleteMessage')); ?>";
  
        var rowperpage  = Number($('#rowperpage').val());  
        var totalRows  = Number($('#totalRows').val());  
        $('#countDisplayed').html(rowperpage);

        $('#reply-btn').click(function(e){
            var formauthorID    = Number($('#form-authorID').val());
            var formreceiverID  = Number($('#form-receiverID').val());
            var formcontent     = $('#form-content').val(); 
            var rowcount    = Number($('#rowcount').val()); 
            var rowcount    = rowcount + rowperpage; 

            e.preventDefault();
            if(formcontent != ""){
                
                $(".message-wrapper").html("");
                $.ajax({  
                        url: urlreply, 
                        type: 'POST',   
                        data: {
                            formauthorID : formauthorID,
                            formreceiverID : formreceiverID,
                            formcontent : formcontent,
                            rowcount: rowcount,
                            rowperpage: rowperpage  
                        },
                        beforeSend:function(){
                            $("#reply-btn").text("Sending...");    
                        },
                        success: function(response) { 
                            setTimeout(function() { 
                                $(".message-wrapper").html(response);  
                                $("#reply-btn").text("Reply Message");   
                                $("#form-content").val("");   
                            }, 300); 
                        }
                });
            } else {
                $('#form-content').attr('required');   
            }
        }); 
        
        //viewing more messages
        $('#prevmsgs-btn').click(function() {
            var authorID    = Number($('#authorID').val());
            var receiverID  = Number($('#receiverID').val());
            var rowcount    = Number($('#rowcount').val()); 
            var totalRows   = Number($('#totalRows').val());    
            var rowcount    = rowcount + rowperpage; 
            var countDisplayed  = rowcount + rowperpage;
            if (rowcount <= totalRows) { 
                
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
                            $(".message-container:last").after(response).slideDown(300);   
                                if (rowcount >= totalRows) {  
                                    $('#prevmsgs-btn').fadeOut(500);
                                    // alert('All messages are already viewed.');
                                } else {
                                    if(countDisplayed >= totalRows){
                                        $('#countDisplayed').html(totalRows); 
                                        $("#prevmsgs-btn").hide(); 
                                    }else { 
                                        $('#countDisplayed').html(countDisplayed);
                                        $("#prevmsgs-btn").text("View previous messages"); 
                                    }
                                         
                                } 
                        }, 300);

                    }
                });

            } else {
 
                $('#prevmsgs-btn').fadeOut(500);
                // alert('All messages are already viewed.');
            }
        }); 

        //deleting of 1 message
        $(document).on("click", ".delete-btn", function(e){
            var id          = $(this).data('id'); 
            var container   = $(this).parents('.message-container');
            var rowcount    = Number($('#rowcount').val());  
            var rowcount    = rowcount + rowperpage; 
            var countDisplayed  = rowcount + rowperpage;

            e.preventDefault;
            if(confirm('Are you sure you want to delete this message?')){  
                $.ajax({
                    url: urldelete,  
                    type: 'POST',
                    data: {
                            id: id
                    }, success: function(){ 
                        container.fadeOut(400);  
                        if(countDisplayed >= totalRows){
                            $('#countDisplayed').html(totalRows);  
                            $('#totalRows').html(totalRows);  

                        }else { 
                            $('#countDisplayed').html(countDisplayed);  
                            $('#totalRows').html(totalRows);  
                        }

                    }
                });
            }  
        });
       
        
});

</script>

