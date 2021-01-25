<?php
class MessagesController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash', 'Js' => array('Jquery'));
    public $components = array('Flash', 'Paginator');

    //loading more content
    public function viewMore(){ 
            $authId = AuthComponent::user('id');       
            $start = $_GET['rowcount']; //new value of rowcount 
            $rowcount = $_GET['rowperpage'];

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
                    'offset' => $start,
                    'limit' => $rowcount
                )
             );
 
        $messages = $this->paginate('Message');  
        $this->layout = false;
        $this->set(compact('messages')); 
    }
    

    //show all conversations from other users  
    public function index(){
            
            //defining $message variable used to display data on the index.ctp and ordering it with DESC 
            $authId = AuthComponent::user('id');        
            $rowperpage = 4;
            
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
                    'limit' => $rowperpage
                )
             );
             
             
        $totalrows = $this->Message->find('count' , array(
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
            )
            )
        );

        $messages = $this->paginate('Message');  
        $this->set(compact('messages', 'rowperpage', 'totalrows')); 
 
    }
     
   
    public function reply(){    
        if ($this->request->is('post')) {
            $this->Message->create();
                if ($this->Message->save($this->request->data)) {   
                    echo "<script> alert('Sent'); ?>";
                }
            $this->Flash->error(__('Unable to send the message.'));
        }  
    }

    public function viewReply(){
                   
        $authorID = $_GET['authorID'];
        $receiverID = $_GET['receiverID'];
        $start = $_GET['rowcount'];  
        $rowcount = $_GET['rowperpage'];
            
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
                        'OR' => array (
                            array('Message.to_id' => $authorID , "Message.from_id" => $receiverID),
                            array( 'Message.to_id' => $receiverID , "Message.from_id" => $authorID )   
                        )                  
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
                    'offset' => $start,
                    'limit' => $rowcount
                )
            );
 
        $replies = $this->paginate('Message');     
        $this->layout = false;
        $this->set(compact('replies', 'rowperpage'));
            
    }


    public function view($authorID, $receiverID){
            
        //defining $message variable used to display data on the index.ctp and ordering it with DESC 
    
        $rowperpage = 2;
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
                    'OR' => array (
                        array('Message.to_id' => $authorID , "Message.from_id" => $receiverID),
                        array( 'Message.to_id' => $receiverID , "Message.from_id" => $authorID )   
                    )                  
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
                'limit' => $rowperpage
            )
         );
      
    $messagedetails = $this->paginate('Message');   
    $this->set(compact('authorID', 'receiverID','messagedetails', 'rowperpage'));

 }


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
