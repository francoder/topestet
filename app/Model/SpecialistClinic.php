<?
App::uses('Model', 'Model');

class SpecialistClinic extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	var $adminSchema = array(
		'specialist_id' => array(
			'type' => 'list',
			'title' => 'Специалист',
		),
		'clinic_id' => array(
			'type' => 'list',
			'title' => 'Клиника',
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'специалист в клинике',
		'plurial' => 'Специалисты в клиниках',
		'genitive' => 'специалисту в клинику'
	);
	
	var $belongsTo = array(
		'Specialist' => array(
			'conditionsList' => array(
				'is_specialist' => 1
			),
			'fieldList' => 'name',
			'counterCache' => true,
			'foreignKey' => 'specialist_id'
		),
		'Clinic' => array(
			'conditionsList' => array(
				'is_specialist' => 2
			),
			'fieldList' => 'name',
			'counterCache' => true,
			'foreignKey' => 'clinic_id'
		)
	);
}
?>