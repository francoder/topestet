<?class ReviewAdd extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	public $adminSchema = array(
		'review_id' => array(
			'type' => 'list',
			'title' => 'Отзыв',
			'edit_link' => true
		),
		'content' => array(
			'title' => 'Содержание',
			'type' => 'text'
		),
		'created' => array(
            'title' => 'Добавлен',
            'type' => 'string'
        )
	);
	
	
	public $validate = array(
		'content' => array(
			'content' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Заполните, пожалуйста, поле дополнения',
			)
		)
	);
	
	public $belongsTo = array(
		'Review' => array(
			'counterCache' => true,
			'fieldList' => 'subject'
		)
	);
	
	 var $adminTitles = array(
        'single' => 'дополнение к отзыву',
        'plurial' => 'Дополнения к отзывам',
        'genitive' => 'дополнения к отзыву'
    );
    
    public $order = 'ReviewAdd.created DESC';
	
	function afterSave($created, $data=array()){
		parent::afterSave($created);
		$this->Review->id = $this->data['ReviewAdd']['review_id'];
		$this->Review->saveField("updated", date("Y-m-d H:i:s"));
		return true;
	}
	
}?>