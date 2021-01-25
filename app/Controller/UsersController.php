<?php

class UsersController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash', 'Js' => array('Jquery'));
    public $components = array('Flash');

    //adding a user 
    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) { 
                if($this->Auth->login()){
                    $ip = $this->request->clientIp();  
                    $this->User->saveField('created_ip', "'$ip'");
                    $this->User->saveField('image', 'defaultpic.jpg');
                    $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));

                    $this->Flash->success(__('Thank you for registering!'));
                    return $this->redirect(array('action' => 'success'));
                }
            }
            $this->Flash->error(__('Unable to register user.'));
        }
    }

    //login
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
        //refresh the session to display the default image
        $this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id'))); 
    }

    //users folder redirection
    public function index() {  
        return $this->redirect(array('action' => 'login'));
    }
     

    public function edit() {
        //has any form data been posted?
        if ($this->request->is('post')) {   // if true 
           
            // array to hold all new data
            $dataholder = array(); 
            $this->User->set($this->request->data);              
            // echo '<pre>';
            // print_r(  $this->request->data );
            // exit;
                
                //if gender field has a value
                if(!empty($this->request->data['User']['gender'])){
                    $gender = $this->request->data['User']['gender'];
                    $dataholder['gender'] = "'$gender'";
                }

                // //if birthdate field has a value
                if(!empty($this->request->data['User']['birthdate'])){
                    $birthdate = date('Y-m-d',strtotime($this->request->data['User']['birthdate']));
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
                    $usedip = $this->request->clientIp();
                    $name = $this->request->data['User']['name']; 
                    $editedInfo = date('Y-m-d H:i:s');


                    $dataholder['modified'] = "'$editedInfo'" ;  
                    $dataholder['modified_ip'] = "'$usedip'";
                    $dataholder['name'] = "'$name'";

                        //if image is not empty and a photo has been selected/uploaded, explode 
                        //and get the file name then move the uploaded file.
                        if(!empty($this->request->data['User']['image']['tmp_name']) 
                        && is_uploaded_file($this->request->data['User']['image']['tmp_name'])){
                            
                            $temp = explode('.' ,  $this->request->data['User']['image']['name']);
                            $newFileName = 'pic'.round(time(true)).'.'.end($temp);
                            $directory = 'myuploads/';
                            
                            move_uploaded_file( $this->request->data['User']['image']['tmp_name'],WWW_ROOT.DS.$directory.$newFileName
                            );

                            //assign to dataholder array
                            $dataholder['image'] = "'$newFileName'"; 

                        }

                        

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

    //view sender name on the Message list
    public function viewSenderPic($id){
        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('user', $user);
    }
 
    //Users list checker
    public function usersList() {
        $result = array();
        if($this->request->is('get')) {
            $term = $this->request->query['searchTerm'];
            $users = $this->User->find('all', array(
                'conditions' => array(
                    'User.name LIKE' => '%'.$term.'%'
                )
            ));

            $result = array();
            foreach($users as $key => $user) {
                $result[$key]['id'] = (int) $user['User']['id'];
                $result[$key]['text'] = $user['User']['name']; 
                $result[$key]['image'] = $user['User']['image']; 
            }
        }
        
        echo json_encode($result);
        exit;
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }


}
