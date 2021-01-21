<?php
class MessagesController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash', 'Js' => array('Jquery'));
    public $components = array('Flash');

    //adding a message 
    

    //show all messages list
    public function index(){
        //defining $message variable used to display data on the index.ctp and ordering it with DESC
        $this->set(
            'messages', 
            $this->Message->find(
                'all',
                array(
                    'order' => array( 'Message.id DESC' ) 
                )
            )
        );
    }
    
    //view specific message
    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $message = $this->Message->findById($id);
        if (!$message) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('message', $message);
    }
   
    //creating a new message
    public function add(){  

            if ($this->request->is('post')) {
                $this->Message->create();
                if ($this->Message->save($this->request->data)) { 
                    $this->Message->saveField('from_id',AuthComponent::user('id')); 

                    $this->Flash->success(__('Your message has been sent.'));
                    return $this->redirect(array('action' => 'index')); 
                }
                $this->Flash->error(__('Unable to send the message.'));
            } 
    
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
    
        if ($this->Message->delete($id)) {
            $this->Flash->success(
                __('The conversation id: %s has been deleted.', h($id))
            );
        } else {
            $this->Flash->error(
                __('The conversation with id: %s was not be deleted.', h($id))
            );
        }
    
        return $this->redirect(array('action' => 'index'));
    }
 

}
