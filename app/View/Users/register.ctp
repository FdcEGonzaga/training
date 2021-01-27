
<div class="col-md-offset-4 col-md-4"  style="box-shadow: #eee 2px 0px 4px 5px; padding: 20px;">

    <h2 class="text-center">REGISTRATION </h2>
    <?php
        //error renderer
        echo $this->Flash->render(); 

        //Registration form 
        echo $this->Form->create('User');
        echo $this->Form->input('name', array('class' => 'form-control'));
        echo $this->Form->input('email', array('class' => 'form-control'));
        echo $this->Form->input('password', array('class' => 'form-control'));
        echo $this->Form->input('password2', array('label'=>'Confirm password:', 'type' => 'password','class' => 'form-control'));
        echo "</br>";
        echo $this->Form->end(array('class' => 'btn btn-primary signin-btn', 'label' => 'Register'));
    ?>
    
    <p class="text-center mytext-padding"> Already have an account? 
         <?php echo $this->Html->link('Login', array('action' => 'login')); ?>
    </p>
    
</div>

