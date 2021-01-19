<?php

class UsersController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'login', 'logout');
    }

    public function index() {
        $this->set('users', $this->User->find('all'));
    }

    public function success() {  
    }

    //adding a user 
    public function register() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('Thank you for registering.'));
                return $this->redirect(array('action' => 'success'));
            }
            $this->Flash->error(__('Unable to register user.'));
        }
    }

 
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));
                return $this->redirect($this->Auth->redirectUrl()); 
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }



    public function edit($id = null) {

        if ($this->request->is(array('post', 'put'))) {
            $this->User->id = $id; 
            echo "<pre>"; 
            exit();
            // if ($this->User->save($this->request->data)) {
            //     $this->Flash->success(__('Your Profile has been updated.'));
            //     return $this->redirect(array('action' => 'index'));
            // }
            $this->Flash->error(__('Unable to update your Profile.'));
        }
    
        // if (!$this->request->data) {
        //     $this->request->data = $user;
        // }
    }
}
