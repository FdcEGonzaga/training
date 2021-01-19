<div style="container">
 <div class="col-md-offset-4 col-md-4">
     <h2>LOGIN </h2>
     <?php
          echo $this->Form->create('User');
          echo $this->Form->input('email', array('class'=>'form-control'));
          echo $this->Form->input('password', array('class'=>'form-control'));
          echo $this->Form->end('Login');
     ?>

     <a href = "http://localhost/cakephp/users/register">Register</a>
 </div>

</div>