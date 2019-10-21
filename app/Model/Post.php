<?class Post extends AppModel{
	var $adminSchema = array(
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок записи',
			'edit_link' => true
		),
		'alias' => array(
			'type' => 'string',
			'title' => 'Алиас',
			'inlist' => false
		),
		'post_category_id' => array(
			'type' => 'list',
			'title' => 'Категория'
		),
		'region_id' => array(
            'type' => 'list',
            'title' => 'Регион поста',
            'inlist' => false
        ),
		'page_title' => array(
			'type' => 'string',
			'title' => 'Сео-заголовок'
		),
		'page_description' => array(
			'type' => 'string',
			'title' => 'Сео-описание страницы'
		),
		'description' => array(
			'title' => 'Краткое описание',
			'type' => 'text',
			'editor' => true,
			'inlist' => false
		),
		'content' => array(
			'title' => 'Содержимое записи',
			'type' => 'text',
			'editor' => true,
			'inlist' => false
		),
		'image' => array(
			'title' => 'Изображение к записи',
			'type' => 'image'
		),
		'hide_pic' => array(
			'title' => 'Скрыть изображение в статье',
			'type' => 'bool',
			'inlist' => false
		),
		'service_id' => array(
			'type' => 'habtm',
			'title' => 'Услуги привязанные'
		),
		'specialist_id' => array(
			'type' => 'habtm',
			'title' => 'Специалисты привязанные'
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана'
		),
	);
	
	var $adminTitles = array(
		'single' => 'запись',
		'plurial' => 'Записи блога',
		'genitive' => 'записи'
	);
	
	var $order = 'Post.created DESC';
	
	var $images = array(
		'image' => array(
			'main' => array(
				
			),
			'entity' => array(
				'width' => 200,
				'height' => 150
			),
			'thumbnail' => array(
				'width' => 150
			),
			'preview' => array(
				'width' => 64,
				'height' => 64
			)
		)
	);
	
	public $belongsTo = array(
    'PostCategory' => array(
      'foreignKey' => 'post_category_id',
      'type' => "INNER"
    ),
    'Region'
  );

	public $hasMany = array(
		'Opinion' => array(
			'dependent' => true
		)
	);
	
	public $hasAndBelongsToMany = array(
		'Service' => array(
            'className' => 'Service',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'service_id',
            'order' => 'title',
            'with' => 'PostService',
            'unique' => true
        ),
        'Specialist' => array(
            'className' => 'User',
            'joinTable' => 'post_specialists',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'specialist_id',
            'order' => 'name',
            'with' => 'PostSpecialist',
            'unique' => true,
            'conditionsList' => array(
            	'is_specialist >' => 0
            ),
            'fieldList' => 'name'
        )
	);
}?>