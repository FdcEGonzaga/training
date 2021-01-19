<h1 >Hi ! <?php echo AuthComponent::user('name'); ?></h1>

<button style="padding: 15px; background-color: #ada; border-radius:10px;"><?php echo $this->Html->link(
    'Back to Homepage',
    array('controller' => 'posts', 'action' => 'index')
); ?>
</button>
