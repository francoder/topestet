<?class SpecialistService extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	var $adminSchema = array(
		'user_id' => array(
			'type' => 'list',
			'title' => 'Специалист',
		),
		'service_id' => array(
			'type' => 'list',
			'title' => 'Услуга',
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'услуга специалиста',
		'plurial' => 'Услуги специалистов',
		'genitive' => 'услуги специалиста'
	);
	
	var $belongsTo = array(
		'User' => array(
			'conditionsList' => array(
				'is_specialist >' => 0
			),
			'fieldList' => 'name',
			'counterCache' => true
		),
		'Service' => array(
			'counterCache' => true
		)
	);
}?>