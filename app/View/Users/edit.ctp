<div  class="container " >
    <div class="col-md-offset-2 col-md-8 "  > 
        
    <?php
           //Back button
           echo $this->Html->link('Back', array('controller' => 'users', 'action' => 'profile') ); 
            
    ?>
        


      <h2>Editing Profile</h2> 

        <div class="row">
            <?php 
                echo $this->Flash->render();
                echo $this->Form->create('User', array('type'=>'file'));
                $default_pic = "https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg";
                $profile_pic = AuthComponent::user('image') ? '/myuploads/'.AuthComponent::user('image') : $default_pic; 
                
                    echo $this->Html->image(
                        $profile_pic, array( 
                        'id' => 'profile-pic' , 'height' => '200px', 'width' => '200px' , 'style' => 'margin-left: 10px'
                        )
                    );

                    echo $this->Form->input(
                        'image', 
                        array( 'type'=> 'file', 'class' => 'form-control',
                            'id' => 'profile'  )
                        );

                       
                     

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
                            'separator'=> '<div></div>',
                            'style' => 'margin-left: 7px' ) 
                        );

                    //birthdate
                    
                    $birthdate = AuthComponent::user('birthdate') ? date('m/d/Y', strtotime(AuthComponent::user('birthdate'))) : '';
                    echo $this->Form->input(
                        'birthdate', 
                        array(
                            'id'=>'datepicker', 
                            'type' => 'text', 
                            'class' => 'form-data',
                            'value' => $birthdate,
                            'class'=>'form-control')
                        );   

                    echo $this->Form->input(
                        'hubby', 
                        array(
                            'rows' => '4', 
                            'class' => 'form-control',
                            'value'=> AuthComponent::user('hubby'))
                        );
                    echo $this->Form->input('id', array('type' => 'hidden' , 'value'=> AuthComponent::User('id')));
                
                    echo $this->Form->end('Save Post', array('class'=>'btn')); 

          
             

                
            ?>

        </div> 
    </div>
</div>

<script>

    $(function(){
        $("#datepicker").datepicker();       
    }); 

    $(document).ready(function() {
        $("#profile").change(function() {
            readURL(this);
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
    

