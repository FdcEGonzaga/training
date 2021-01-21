<?php

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Message extends AppModel {
    
    public $validate = array(
        'to_id' => array(
            'rule' => 'notBlank'
        ),
        'name' => array(
            'rule' => 'notBlank'
        ),
        'content' => array(
            'rule' => 'notBlank'
        ) 
    );

};

