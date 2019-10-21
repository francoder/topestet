<?class Thank extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	var $belongsTo = array(
		'Review' => array(
			'counterCache' => true
		)
	);
}?>