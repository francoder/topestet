<?class Specialization extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	var $adminSchema = array(
		'title' => array(
			'type' => 'string',
			'title' => 'Название специализации',
			'edit_link' => true
		),
		'alias' => array(
			'title' => 'Алиас',
			'type' => 'string',
			'note' => 'Слово латинскими буквами для формирования ссылки'
		),
		'specialist' => array(
			'title' => 'Специалист',
			'type' => 'string'
		),
		'specialist_plural' => array(
			'title' => 'Специалист (м.ч.)',
			'note' => 'Указывается во множественном числе',
			'type' => 'string'
		),
		'title_clinic_one' => array(
			'title' => 'Название для клиник (ед.ч.)',
			'type' => 'string'
		),
		'title_clinic' => array(
			'title' => 'Название для клиник (мн.ч.)',
			'type' => 'string'
		),
		'order_title' => array(
			'title' => 'Сортировка для заголовка',
			'type' => 'integer',
			'inlist' => false
		),
		'service_count' => array(
			'type' => 'link',
			'title' => 'Услуги',
			'template' => '/admin/self_list/Service/specialization_id:::id::/',
			'inform' => false
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'специализация',
		'plurial' => 'Специализации специалистов',
		'genitive' => 'специализации'
	);
	
	public $hasMany = array(
		'Service' => array(
      'dependent' => true,
      'foreignKey' => 'specialization_id',
      'className' => 'Service'
		)
	);
	
	var $order = 'title';
}?>