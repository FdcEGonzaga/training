<h1>REGISTER </h1>
<?php

echo $this->Form->create('Post');
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->input('password2');
echo $this->Form->end('Register');

?>