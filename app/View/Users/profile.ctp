<div  class="container " >
    <div class="col-md-offset-2 col-md-8 "  >
        
            <h2>User Profile</h2> 

            <div class="col-md-4">
                 <img src="
                    <?php 
                        $default_pic = "https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg";
                        $user_pic = AuthComponent::user('image');

                        if (empty($user_image)) {
                            echo $default_pic;
                        } else {
                            echo $user_pic;
                        }
                     ?>" 
                     class="thumbnail" height="200" width="200" alt="Profile picture">
            </div>

            <div class="col-md-8"> 
                <br> 
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
                    echo  (empty(AuthComponent::user('birthdate')) ? "Not specified" : AuthComponent::user('birthdate'))
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
                        echo $this->Html->link(  'Edit', 
                            array('action' => 'edit')
                            ) ;
                        
                    ?>  
            </div>


    </div> 
</div>


 


