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
                        echo $this->Form->end( array( 'label' => 'Reply Message', 'class' => 'pull-right'));
                    ?>
                </div>
            </div>
            <hr>

            <!-- Messages -->    
            <div class="message-container"> 
                <!-- <p>Msg ID: <?php echo $message['Message']['id']; ?></p> -->
                <!-- <p>Your ID: <?php echo $message['Message']['to_id']; ?></p> -->


                <p>From ID: <?php echo $message['Message']['from_id']; ?></p> 
                <p>Content: <?php echo $message['Message']['content']; ?></p>
                <p>Created: <?php echo $message['Message']['created']; ?></p>
                <!--  <p><?php echo h($message['Message']['body']); ?></p> -->

            </div>

    </div>
</div> 