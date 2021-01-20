<?php

class UsersController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'login', 'logout');
        date_default_timezone_set('Asia/Manila');
    }


    //adding a user 
    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) { 
                if($this->Auth->login()){
                    $ip = $this->request->clientIp();
                    $this->User->saveField('created_ip', "'$ip'");
                    $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));

                    $this->Flash->success(__('Thank you for registering!'));
                    return $this->redirect(array('action' => 'success'));
                }
            }
            $this->Flash->error(__('Unable to register user.'));
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));
                $this->Flash->success(__('You\'re back online!'));
                return $this->redirect(array('action' => 'success'));

            } 
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
 
    public function profile() {
    }

    public function success() {  
    }
     

    public function edit() {
        //has any form data been posted?
        if ($this->request->is('post')) {   // = 1     
           
            // array to hold all new data
            $dataholder = array(); 
            $this->User->set($this->request->data);              
        
                
                //if gender field has a value
                if(!empty($this->request->data['User']['gender'])){
                    $gender = $this->request->data['User']['gender'];
                    $dataholder['gender'] = "'$gender'";
                }

                // //if birthdate field has a value
                if(!empty($this->request->data['User']['birthdate'])){
                    $birthdate = date('Y-m- d', strtotime($this->request->data['User']['birthdate']));
                    $dataholder['birthdate'] = "'$birthdate'"; 
                }

                // //if hubby field has a value
                if($this->request->data['User']['hubby']) {
                    $hubby = $this->request->data['User']['hubby'];
                    $dataholder['hubby'] = "'$hubby'";
                }

                //if image field is empty unset the validation
                if(empty($this->request->data['User']['image']) || empty($this->request->data['User']['image']['tmp_name'])){ 
                    unset($this->User->validate['image']);
                } 
                
              
                // validating the form
                if($this->User->validates($this->request->data)){
                    $name = $this->request->data['User']['name']; 
                    $usedip = $this->request->clientIp();

                    $dataholder['name'] = "'$name'";
                    $dataholder['modified_ip'] = "'$usedip'";

                    //if image is not empty and if file is uploaded
                 

                    //updating the database using the id
                        if($this->User->updateAll( $dataholder, array('id' => $this->Auth->user('id')))){ 
                
                            //refresh the session to display the changes
                            $this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
                            $user = $this->User->field('name', array($this->redirect( array('action' => 'profile'))));

                        }else {  
                             $this->Flash->error(__('Database not updated.'));
                        }
 
                } 

        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

}
