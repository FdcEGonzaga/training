
<div class="col-md-offset-2 col-md-8 text-center">
    <?php  
        //Login greetings
        echo $this->Flash->render();  
    ?> 
        <button class="btn btn-registered ">
            <?php echo $this->Html->link(  'Back to Homepage', 
            array('controller' => 'users' , 'action' => 'profile')); ?>
        </button> 

</div>
 