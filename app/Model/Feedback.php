<?class Feedback extends AppModel{
	var $useTable = false;
	public $validate = array(
		'subject' => array(
			'non_empty' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Вы не указали тему обращения',
			)
		),
		'content' => array(
			'non_empty' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Вы не указали текст обращения',
			)
		),
		'mail' => array(
			'valid' => array(
				'rule' => 'email',
				'allowEmpty' => false,
				'required' => false,
				'message' => 'Вы указали неверный адрес электронной почты'
			)
		)
	);
	
}?>