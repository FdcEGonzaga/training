<h1>Make a post: </h1>
<?php

echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows'=> '5'));
echo $this->Form->end('Save this Post');

?>