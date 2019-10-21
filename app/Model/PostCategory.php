<?class PostCategory extends AppModel{
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
		'post_count' => array(
			'type' => 'link',
			'title' => 'Посты',
			'template' => '/admin/self_list/Post/post_category_id:::id::/',
			'inform' => false
		),
		'description' => array(
			'title' => 'Описание',
			'type' => 'text',
			'editor' => true,
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
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'категория блога',
		'plurial' => 'Категории блога',
		'genitive' => 'категории блога'
	);

  public $hasMany = array(
    'Post' => array(
      'className' => 'Post',
      'foreignKey' => 'post_category_id',
    ),
  );
	
}?>