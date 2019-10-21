<?class Rate extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	var $belongsTo = array(
		'Photospec' => array(
			'foreignKey' => 'parent_id',
			'conditions' => array(
				'parent_model' => 'Photospec'
			)
		),
		'Response' => array(
			'foreignKey' => 'parent_id',
			'conditions' => array(
				'parent_model' => 'Response'
			)
		),
		'SpecialistService' => array(
			'foreignKey' => 'parent_id',
			'conditions' => array(
				'parent_model' => 'SpecialistService'
			),
			'counterCache' => array(
				'rate_count' => array(
					'parent_model' => 'SpecialistService'
				)
			)
		)
	);
	
	function afterSave($created, $data = array()){
		$rate = $this->find("all", array("fields" => "SUM(`note`) as `sum`", "conditions" => array("parent_id" => $this->data['Rate']['parent_id'], "parent_model" => $this->data['Rate']['parent_model'])));
		$rate = $rate[0][0]['sum'];
 		$this->{$this->data['Rate']['parent_model']}->id = $this->data['Rate']['parent_id'];
		$this->{$this->data['Rate']['parent_model']}->saveField("rate", $rate);
		return true;
	}
}?>