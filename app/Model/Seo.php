<?class Seo extends AppModel{
	var $useTable = "seo";
	var $adminSchema = array(
		'url' => array(
			'type' => 'string',
			'title' => 'Url',
			'edit_link' => true
		),
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок страницы',
			'edit_link' => true
		),
		'description' => array(
			'type' => 'string',
			'title' => 'Описание',
			'inlist' => false
		),
		'keywords' => array(
			'type' => 'string',
			'title' => 'Ключевые слова',
			'inlist' => false
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		)
	);
	
	var $validate = array(
		'url' => array(
			'notempty' => array(
				'rule' => array('minLength', 1),
				'allowEmpty' => false,
				'required' => true,
				'message' => 'URL-страницы не может быть пустым'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Настройки можно задавать только для одноко URL'
			)
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('minLength', 1),
				'allowEmpty' => false,
				'required' => true,
				'message' => 'Заголовок страницы не может быть пустым'
			)
		)
	);
	
	var $adminTitles = array(
		'single' => 'парметры страницы',
		'plurial' => 'Seo-настройки страниц',
		'genitive' => 'параметров страницы'
	);
	var $order = '`created` desc';
}?>