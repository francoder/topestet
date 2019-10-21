<?php

class Question extends AppModel{
    var $actsAs = array('Containable');
    var $recursive = -1;
    
    public $validate = array(
        'service_id' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Укажите услугу',
            ),
            'is_region' => array(
                'rule' => '_service',
                'message' => 'Мухлюете?'
            )
        ),
        'subject' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Укажите заголовок вопроса',
            )
        ),
        'content' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Заполните вопрос',
            )
        ),
        'antispam' => array(
        	'rule' => '_antispam',
        	'message' => 'Пожалуйста, ответьте на контрольный вопрос'
        )
    );
    
    public $adminSchema = array(
        'subject' => array(
            'type' => 'string',
            'title' => 'Заголовок вопроса',
            'edit_link' => true
        ),
        "user_id" => array(
            "type" => "integer",
            "title" => "Пользователь"
        ),
        'service_id' => array(
            'type' => 'list',
            'title' => 'Услуга',
        ),
        'service_title' => array(
            'type' => 'string',
            'title' => 'Название услуги',
            'inlist' => false,
            'note' => 'Заполняется в случае, если услуга отсутствовала в списке'
        ),
        'specialist_id' => array(
            'type' => 'list',
            'title' => 'Специалист',
            'inlist' => false
        ),
        'photo_count' => array(
            'type' => "link",
            'template' => "/admin/self_list/Photo/alias:question/parent_id:::id::/",
            'title' => 'Фото'
        ),
        'is_main' => array(
        	'type' => 'bool',
        	'title' => 'Основной вопрос',
        	'icons' => array(
        		0 => '',
        		1 => '/img/admin/check.png'
        	)
        ),
        'created' => array(
        	'type' => 'datetime',
        	'title' => 'Создан'
        ),
        'content' => array(
            'type' => 'text',
            'title' => 'Описание вопроса',
            'inlist' => false
        )
    );
    
    var $adminTitles = array(
        'single' => 'вопрос пользователя',
        'plurial' => 'Вопросы пользователей',
        'genitive' => 'вопроса пользователя'
    );
    
    public $order = "Question.created desc";
    
    public $belongsTo = array(
        'Service' => array(
            'counterCache' => true
        ),
        'User' => array(
            'fieldList' => 'name'
        ),
        'Specialist' => array(
            'className' => "User",
            'foreignKey' => 'specialist_id',
            'fieldList' => 'name',
            'conditionsList' => array(
                'is_specialist' => 1
            )
        ),
        /*'Question' => array(
        	'counterCache' => true
        )*/
    );
    
    public $hasMany = array(
        'Photo' => array(
            'dependent' => true,
            'foreignKey' => 'parent_id',
            'conditions' => array(
                "alias" => "question"
            )
        ),

        'Response' => array(
            'dependent' => true,
            'order' => 'Response.rate DESC, Response.created'
        ),

        'Qcomment' => array(
            'dependent' => true,
            'order' => 'Qcomment.created'
        ),
    );
    
    function _service($data){
        $service = $this->Service->findById($data['service_id']);
        return !empty($service) || $data['service_id'] == 0;
    }
    
    function afterSave($created, $data= []){
        parent::afterSave($created);
        return true;
    }

    function _antispam($data){
    	if (!empty($this->configs['antispam_question'])){
    		return ($this->configs['antispam_response'] == $data['antispam']);
    	}
    	return true;
    }
}
