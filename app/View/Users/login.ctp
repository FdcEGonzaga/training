
<div class="col-md-offset-4 col-md-4" >

     <h2 class="text-center">LOGIN </h2>
     <?php
          //error thrower
          echo $this->Flash->render(); 

          //login form 
          echo $this->Form->create('User');
          echo $this->Form->input('email', array('class'=>'form-control'));
          echo $this->Form->input('password', array('class'=>'form-control'));
          echo "</br>";
          echo $this->Form->end(array('class' => 'btn btn-primary signin-btn', 'label' => 'Login'));
     ?>
    
     <p class="text-center mytext-padding">Not yet Registered? 
         <a href = "http://localhost/cakephp/users/register">Sign Up</a>
    </p>
 </div>
