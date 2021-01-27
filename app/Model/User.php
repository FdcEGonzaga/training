<?php 
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => array('lengthBetween', 5, 20),
            'message' => 'Name should be between 5 to 20 characters'
        ),
        'email' => array( 
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Email is already taken'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength' , '3'),
                'message' => 'A password is required and should be atleast 3 characters'
            )
        ),
        'password2' => array( 
            'compare'    => array(
                'rule'      => array('validate_passwords'),
                'message' => 'The passwords you entered do not match.',
            )
        ),
        'image' => array( 
                'rule' => array(
                    'extension', 
                    array( 'jpg', 'png', 'gif')
                ),
                'message' => "Please upload a jpg, png or gif photo.",
                'required' => false,
                'allowEmpty' => true 
        )
    );

    public function validate_passwords() {
        return $this->data[$this->alias]['password'] === $this->data[$this->alias]['password2'];
        
    }

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }


};

