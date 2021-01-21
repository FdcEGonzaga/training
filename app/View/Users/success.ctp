
<div class="col-md-offset-2 col-md-8 text-center">
    <?php  
        //Login greetings
        echo $this->Flash->render();  
    ?> 
         
            <?php echo $this->Html->link(  
                'Back to Homepage',   array('controller' => 'users' , 'action' => 'profile'),
                 array('class' => 'btn btn-registered')       
             ); ?>
         

</div>
 