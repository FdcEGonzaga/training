<div style="margin: 50px 20%" >

    <h1>Editing Profile</h1>
    <?php
        echo $this->Form->create('User', array('type'=>'file'));
        echo $this->Form->input('image', array( 'type'=> 'file', 'class'=>'form-control') );
        echo $this->Form->input(
            'name', 
            array(
                'value' => AuthComponent::user('name'),
                'class'=>'form-control'  )
            ); 
        echo $this->Form->input(
            'gender', 
            array(
                'options' => array('1' => 'Male', '2' => 'Female'),
                'value' => AuthComponent::user('gender'),
                'type' => 'radio',
                'separator'=> '<div></div>' ) 
            );
        echo $this->Form->input('birthdate', 
            array(
                'id'=>'datepicker', 
                'type' => 'text', 
                'class' => 'form-data',
                'value' => AuthComponent::user('birthdate'),
                'class'=>'form-control')
            );  
        echo $this->Form->input('hubby', 
             array(
                'rows' => '4', 
                'class' => 'form-control',
                'value'=> AuthComponent::user('hubby'))
            );
        echo $this->Form->input('id', array('type' => 'hidden'));
        echo "<br><br>";
        echo $this->Form->end('Save Post', array('class'=>'btn'));
    ?>

</div>

<script>
    $(function(){
        $("#datepicker").datepicker();       
    }); 

</script>
    

