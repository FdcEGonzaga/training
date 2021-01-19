<div style="padding: 0 20%;">

    <h2>REGISTRATION </h2>
    <?php

    echo $this->Flash->render();
    echo $this->Form->create('User');
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('password2', array('label'=>'Confirm password:', 'type' => 'password'));
    echo $this->Form->end('Register');

    ?>

    <a href = "http://localhost/cakephp/users/login">Login</a>


</div>

