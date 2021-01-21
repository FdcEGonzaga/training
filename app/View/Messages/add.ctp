<div class="container" >
    <div class="col-md-offset-2 col-md-8" >
        <?php
            echo $this->Html->link('Back', array('action' => 'index'));
        ?>
 
        <h2>New Message: </h2>

        <?php 
 

        //Message form
        echo $this->Form->create('Message'); 
                
                echo "<label>Send To:</label>"; 
                    echo $this->Form->input( 'to_id',
                        array('label' => false, 'class' => 'select2class form-control')
                    );
              
        
                echo $this->Form->input( 'content', 
                        array('class' => 'form-control', 
                        'placeholder' => 'Enter your message here...')
                    ); 
 
        
        echo $this->Form->end('Send Message'); 
        ?>

    </div>
</div>   

<script type="text/javascript">
$(document).ready(function() {
    var url = "<?php echo $this->Html->url(array('controller' => 'users','action' => 'userList')); ?>";
    $('.select2class').select2({
        placeholder: 'Enter receiver\'s name here',
        ajax: {
            url: url,
            dataType: 'json',
            delay: 100,
            data: function (data) {
                return {
                    searchTerm: data.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        }
    });
});
</script>