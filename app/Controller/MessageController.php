<?php

class MessageController extends AppController 
{
    public $layout = "inner";
    public $helpers = array("Display");
    public $uses = array("User", "Message", 'Question', 'Comment', 'Region');

    public $paginate = array(
        "Message" => array(
            "limit" => 15,
            "order" => "Message.created DESC",
            "contain" => array("User", "Sender")
        ),
        'Comment' => array(
        	'limit' => 20,
        	'order' => 'Comment.created DESC',
        	'contain' => array('User')
        )
    );
    
    function beforeFilter()
    {
        parent::beforeFilter();

        $this->fastNav['/message/'] = "Сообщения";  

        parent::seoFilter();
    }
    
    function index()
    {
        $this->set("list", $this->Message->getCorrespondentsList($this->user['id']));
    }
    
    function send($user_id)
    {
        $reciver = $this->User->findById($user_id);

        if (empty($reciver) || $user_id == $this->user['id']) {
            return $this->error_404();
        }
        
        $this->fastNav['/message/send/' . $reciver['User']['id'] . "/"] = $reciver['User']['name'];
        
        if ($this->request->is("post")) {

            $data = $this->data;
            $data['Message']['user_id'] = $user_id;
            $data['Message']['sender_id'] = $this->user['id'];
            $data['Message']['read'] = 0;

            if ($this->Message->save($data)) {

                if (!$reciver['User']['online'] && !empty($reciver['User']['mail'])) {

                    App::uses('CakeEmail', 'Network/Email');
                    $email = new CakeEmail();
                    $email->from('no-reply@'.str_replace("www.", "", $_SERVER['SERVER_NAME']));
                    $email->to($reciver['User']['mail']);
                    $email->subject("Новое сообщение на сайте {$_SERVER['SERVER_NAME']}");
                    $email->emailFormat("html");
                    $email->viewVars(array("user" => $reciver));
                    $email->template('new_message');
                    $email->send();
                }

                $this->data = array();
                $this->set("done", true);
            }
        }
        
        $this->Message->updateAll(array("read" => 1), array("user_id" => $this->user['id']));
        
        $this->setPaginate("messages", $this->paginate("Message", array("OR" => array(
            array(
                "sender_id" => $this->user['id'],
                "user_id" => $user_id
            ),
            array(
                "sender_id" => $user_id,
                "user_id" => $this->user['id']
            )
        ))));

        $this->set("reciver", $reciver);
    }
    
    function del($message_id)
    {
        $message = $this->Message->find("first", array("conditions" => array(
            "id" => $message_id,
            "OR" => array(
                "sender_id" => $this->user['id'],
                "user_id" => $this->user['id']
            )
        )));

        if (!empty($message)) {
            $this->Message->delete($message_id);
        }

        return $this->redirect($this->referer());
    }
    
    function comments(){
    	$this->fastNav['/message/comments/'] = 'Комментарии';
    	
    	$conditions['OR'] = array(
    		array(
    			'belongs' => 'Review',
    			'belongs_id' => $this->Review->find('list', array('conditions' => array('user_id' => $this->user['id'])))
    		),
    		array(
    			'belongs' => 'Question',
    			'belongs_id' => $this->Question->find('list', array('conditions' => array('user_id' => $this->user['id'])))
    		)
    	);
    	$this->set('comments', $this->paginate('Comment', $conditions));

    }
}
