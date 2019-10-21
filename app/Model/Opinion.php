<?class Opinion extends AppModel{
	var $adminSchema = array(
		'post_id' => array(
			'type' => 'list',
			'title' => 'Запись блога'
		),
		'specialist_id' => array(
			'type' => 'list',
			'title' => 'Специалист'
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
		'content' => array(
			'title' => 'Содержимое мнения',
			'type' => 'text',
			'editor' => true,
			'inlist' => false
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		)
	);
	
	var $adminTitles = array(
		'single' => 'мнение специалиста',
		'plurial' => 'Мнения специалиста',
		'genitive' => 'мнения специалиста'
	);
	
	var $order = 'Opinion.created DESC';
	
	
	public $belongsTo = array(
		'Post',
		'Specialist' => array(
			'className' => 'User',
			'foreignKey' => 'specialist_id',
			'fieldList' => 'name',
            'conditionsList' => array(
                'is_specialist' => 1
            ),
		)
	);
	
}?>