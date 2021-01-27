
<div class="col-md-offset-2 col-md-8 text-center">
    <?php  
        //Login or Registration greetings renderer
        echo $this->Flash->render();  
  
        //Back to Homepage Button
         echo $this->Html->link(  
            'Back to Homepage',   array('controller' => 'users' , 'action' => 'profile'),
                array('class' => 'btn btn-registered')       
        ); 
    ?> 
</div>
 