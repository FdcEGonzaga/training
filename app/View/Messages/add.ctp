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
                        array('label' => false, 
                            'class' => 'select2class  form-control'  
                        )
                    );
              
        
                echo $this->Form->input( 'content', 
                        array('class' => 'form-control', 
                            'placeholder' => 'Enter your message here...'
                        )
                    ); 
 
        
        echo $this->Form->end('Send Message'); 
        ?>

    </div>
</div>   

<script type="text/javascript">
$(document).ready(function() {

    var url = "<?php echo $this->Html->url(array('controller' => 'users','action' => 'usersList')); ?>";
    $('.select2class').select2({
        placeholder: 'Enter receiver\'s name here',
        ajax: {
            url: url,
            dataType: 'json',
            delay: 100,
            data: function (data) {
                return {
                    //searching the term assigning to variable searchTerm
                    searchTerm: data.term 
                };
            },
            processResults: function (response) {
                return {
                    results:response
                };
            },
            cache: true
        },
        templateResult: formatState , 
        templateSelection: formatPic

    }); 

        
    function formatState (userdata) {
        console.log(userdata);
    
        if (userdata.loading) {
            return userdata.text;
        }

        var $directory = "<?php echo $this->webroot; ?>/myuploads/" ;
        var $container = $(
             "<div><img height='20' width='20' src='" + $directory + userdata.image + "' >" + userdata.text + "</div>"
        );

        return $container;
    };

    function formatPic(userdata) {
        var $directory = "<?php echo $this->webroot; ?>/myuploads/" ;
        var $span = $(
             "<div><img height='20' width='20' src='" + $directory + userdata.image + "' >" + userdata.text + "</div>"
        );

        return $span;
    }

    
 


});


</script>