<?class Message extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	var $virtualFields = array(
		"thread" => 'CONCAT(if(`user_id` > `sender_id`, `sender_id`, `user_id`), "-", if(`user_id` < `sender_id`, `sender_id`, `user_id`))'
	);
	
	public $validate = array(
		'content' => array(
			'non_empty' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Заполните тело сообщения',
			)
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'className' => "User",
			'foreignKey' => 'user_id',
			'fieldList' => 'name'
		),
		'Sender' => array(
			'className' => "User",
			'foreignKey' => 'sender_id',
			'fieldList' => 'name'
		)
	);
	
	public $order = "Message.created DESC";
	
	public $adminSchema = array(
		'read' => array(
			'type' => 'bool',
			'title' => 'Новое',
			'icons' => array(
				0 => '/img/admin/on.png',
				1 => '/img/admin/off.png'
			)
		),
		'sender_id' => array(
			'type' => 'integer',
			'title' => 'Отправитель'
		),
		'user_id' => array(
			'type' => "integer",
			'title' => 'Получатель'
		),
		'content' => array(
			'type' => 'text',
			'title' => 'Сообщение'
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Отправлено',
			'inform' => false
		)
	);
	
	var $adminTitles = array(
		'single' => 'сообщение',
		'plurial' => 'Сообщения',
		'genitive' => 'сообщения'
	);
	
	function getCorrespondentsList($user_id){
		$last_messages = $this->find("all", array(
			"conditions" => array(
				"OR" => array(
					"user_id" => $user_id,
					"sender_id" => $user_id
				)
			),
			"fields" => "*, max(Message.id) as message_id, count(*) as cnt, sum(`read`) as cnt_new, max(Message.created) as last_message",
			"order" => "last_message DESC",
			"group" => "thread",
		));
		$result = array();
		foreach ($last_messages as $i => $message){
			$result[$i] = array_merge($message, $this->find("first", array("conditions" => array("Message.id" => $message[0]['message_id']), "contain" => array("User", "Sender"))));
			$result[$i][0]['cnt_new'] = $this->find("count", array(
				'conditions' => array(
					'read' => 0,
					'user_id' => $user_id,
					'thread' => $message['Message']['thread']
				)
			));
		}
		return $result;
	}
}?>