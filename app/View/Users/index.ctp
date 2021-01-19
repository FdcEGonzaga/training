 

    <div style="margin: 50px 20%" class="mycontainer" >
        <h2 id="user-profile">User Profile</h2> 
         <?php echo AuthComponent::user('image'); ?> </br>
        <lable>Gender: </label>
        <?php  
            $gender = AuthComponent::user('gender'); 
            if ($gender == 1) {
                echo "Male";
            } elseif ($gender == 2) {
                echo "Female";
            } else {
                echo "Not Specified";
            }
        
        ?> </br>
        <lable>Birthdate: </label>
            <?php echo AuthComponent::user('birthdate'); ?> </br>
        <lable>Joined: </label>
            <?php echo date( 'F j, Y h A', strtotime(AuthComponent::user('created')) ); ?> </br>
        <lable>Last Login: </label>
            <?php echo date( 'F j, Y h A', strtotime(AuthComponent::user('last_login_time')) ); ?> </br></br>
        <lable>Hubby: </label>
            <?php echo  AuthComponent::user('hubby'); ?> </br></br>
        
        
        <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', AuthComponent::user('id'))
                ) ;
            ?>
    
    </div>


 


