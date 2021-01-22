<?php
class MessagesController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash', 'Js' => array('Jquery'));
    public $components = array('Flash');

    //adding a message 
    

    //show all conversations from other users  
    public function index(){
            
            //defining $message variable used to display data on the index.ctp and ordering it with DESC 
            $authId = AuthComponent::user('id');          
            $perpage = 10;    
            $count = 2;

            
            $this->paginate = array(
                'Message' => array(
                    'fields' => array(
                        'Message.*',
                        'Sender.id as sender_id',
                        'Sender.name as sender_name',
                        'Sender.image as sender_image',
                        'Receiver.id as receiver_id',
                        'Receiver.name as receiver_name',
                        'Receiver.image as receiver_image'
                    ), 
                    'conditions' => array(
                        "Message.id IN 
                        (SELECT
                            MAX(messages.id)
                            FROM   messages 
                            WHERE   (messages.from_id = {$authId} OR messages.to_id = {$authId})
                                GROUP BY
                                LEAST(from_id, to_id),
                                GREATEST(from_id, to_id))",
                    ),
                    'joins' => array(       
                        array(
                            'type' => 'LEFT',
                            'table' => 'users',
                            'alias' => 'Sender',
                            'conditions' => 'Sender.id = Message.from_id'
                        ),
                        array(
                            'type' => 'LEFT',
                            'table' => 'users',
                            'alias' => 'Receiver',
                            'conditions' => 'Receiver.id = Message.to_id'
                        )
                    ),
                    'order' => 'Message.created DESC',
                    'limit' => $count
                )
             );
 
        $messages = $this->paginate('Message');  
        // $this->layout = false;
        $this->set(compact('messages', 'count', 'perpage'));
 
    }
    
    
    //view converstion with another user
    public function view($authorid) { 

        //get all conversations with the author and your id interchangeably
 
        // if ($viewmessages) {  //if queried
        //     $this->set('message', $viewmessages);
        // }else { 
        //     throw new NotFoundException(__('Invalid post'));
        // }
    }
   
//     public function view2(){
            
//         //defining $message variable used to display data on the index.ctp and ordering it with DESC 
         
//         $perpage = 10;    
//         $count = 2;

        
//         $this->paginate = array(
//             'Message' => array(
//                 'fields' => array(
//                     'Message.*',
//                     'Sender.id as sender_id',
//                     'Sender.name as sender_name',
//                     'Sender.image as sender_image',
//                     'Receiver.id as receiver_id',
//                     'Receiver.name as receiver_name',
//                     'Receiver.image as receiver_image'
//                 ), 
//                 'conditions' => array(
//                     "Message.id IN 
//                     (SELECT 
//                         FROM   messages 
//                         WHERE   (messages.from_id = {$authId} OR messages.to_id = {$authId})
//                             GROUP BY
//                             LEAST(from_id, to_id),
//                             GREATEST(from_id, to_id))",
//                 ),
//                 'joins' => array(       
//                     array(
//                         'type' => 'LEFT',
//                         'table' => 'users',
//                         'alias' => 'Sender',
//                         'conditions' => 'Sender.id = Message.from_id'
//                     ),
//                     array(
//                         'type' => 'LEFT',
//                         'table' => 'users',
//                         'alias' => 'Receiver',
//                         'conditions' => 'Receiver.id = Message.to_id'
//                     )
//                 ),
//                 'order' => 'Message.created DESC',
//                 'limit' => $count
//             )
//          );

//     $messagedetails = $this->paginate('Message');  
//     // $this->layout = false;
//     $this->set(compact('messagedetails'));

// }


    //creating a new message
    public function add(){  

            if ($this->request->is('post')) {
                $this->Message->create();
                if ($this->Message->save($this->request->data)) { 
                    $this->Message->saveField('from_id',AuthComponent::user('id')); 
 
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
