<h1>LOGIN </h1>
<?php

echo $this->Form->create('Post');
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->end('Save this Post');

?>