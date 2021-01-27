<?php
class MessagesController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash', 'Js' => array('Jquery'));
    public $components = array('Flash', 'Paginator');
    
    //show all conversations from other users  
    public function index(){
                
        $authId = AuthComponent::user('id');        
        $rowperpage = 1;
        
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
            
        
        $messages = $this->paginate('Message');  
        $this->set(compact('messages', 'rowperpage')); 

    }


    //viewing the conversation
    public function view($authorID, $receiverID){
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

    //Viewing more conversations
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
    

    
     
    // replying action on the Message Details reply form
    public function reply(){      
      
        $authorId = $this->request->data['formauthorID'];
        $receiverId = $this->request->data['formreceiverID'];  
        $formcontent = $this->request->data['formcontent'];  
        $rowcount = $this->request->data['rowcount'];   

        $this->request->data['Message']['from_id'] = $authorId;
        $this->request->data['Message']['to_id'] = $receiverId; 
        $this->request->data['Message']['content'] = $formcontent; 
        

        if ($this->request->is('post')) {
            $this->Message->create();
            if ($this->Message->save($this->request->data)) {  

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
                                array('Message.to_id' => $authorId , "Message.from_id" => $receiverId),
                                array( 'Message.to_id' => $receiverId , "Message.from_id" => $authorId )   
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
                        'limit' => $rowcount
                    )
                );
          
                $replies = $this->paginate('Message');    
                $this->layout = false;
                $this->set(compact('replies'));

            } else {
                $this->Flash->error(__('Unable to send the message.'));
            }
        } 
 
    }

    //viewing the previous messages inside the conversation
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
        $this->set(compact('replies'));
            
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

    //deleting messages on Message List
    public function deleteConversation() {  
        $authorId = $this->request->data['aid']; 
        $receiverId = $this->request->data['rid'];  
        $this->Message->deleteAll(  
            array("(Message.to_id = {$authorId} AND Message.from_id = {$receiverId}) OR 
            (Message.to_id = {$receiverId} AND Message.from_id = {$authorId}) ")
        );   
        exit;
        
    } 
 
    //deleting messages on the Message Detail 
    public function deleteMessage() { 
 
        $msgId = $this->request->data['id']; 
        $this->Message->delete($msgId);   
        exit;
    }

}
