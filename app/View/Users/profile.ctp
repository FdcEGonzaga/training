<div  class="container " >
    <div class="col-md-offset-2 col-md-8 "  >
        
        <h2>User Profile</h2> 

            <div class="col-md-4"> 
            <?php  
                //User's Image
                $user_pic =   '/myuploads/'.AuthComponent::user('image')  ;   
                
                echo $this->Html->image(
                    $user_pic, 
                    array('class' =>'image-responsive thumbnail' , 'height' => '200px', 'width' => '200px' )
                ); 
            ?>
            </div>

            <div class="col-md-8"> 
                 
                <h3><?php echo AuthComponent::user('name'); ?> </h3>
                <p>Gender: 
                    <?php  
                        $gender = AuthComponent::user('gender'); 
                        if ($gender == 1) {
                            echo "Male";
                        } elseif ($gender == 2) {
                            echo "Female";
                        } else {
                            echo "Not Specified";
                        } 
                    ?> 
                </p>
                <p>Birthdate: 
                    <?php 
                     echo AuthComponent::user('birthdate') ? date('m/d/Y', strtotime(AuthComponent::user('birthdate'))) : 'Not Specified'
                     ?> 
                </p>
                <p>Joined:
                    <?php echo date( 'F j, Y ha', strtotime(AuthComponent::user('created')) ); ?> 
                </p>
                <p>Last Login: 
                    <?php echo date( 'F j, Y ha', strtotime(AuthComponent::user('last_login_time')) ); ?> 
                </p>
          
            </div> 

            <div class="col-md-12">     
                <lable>Hubby: </label><br>
                <?php echo (empty(AuthComponent::user('hubby')) ? "Not yet Edited" : AuthComponent::user('hubby')); ?> 
                </br></br>

                <?php
                    echo $this->Html->link(  'Edit Profile', 
                        array('action' => 'edit'), 
                        array('class' => 'btn btn-registered ')
                    ); 
                ?>  
            </div>


    </div> 
</div>


 


