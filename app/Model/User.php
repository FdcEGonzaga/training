<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
        'name' => array(
            'required' => true,
            'allowEmpty' => false,
            'rule' => array('lengthBetween', 5, 20),
            'message' => 'Between 5 to 20 characters'
        ),
        'email' => array( 
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'Email is already taken'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A password is required'
            )
        ),
        'password2' => array( 
            'compare'    => array(
                'rule'      => array('validate_passwords'),
                'message' => 'The passwords you entered do not match.',
            )
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

