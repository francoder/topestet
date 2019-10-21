<?class PostService extends AppModel{
	
	public $belongsTo = array(
		'Service' => array(
			'counterCache' => array(
				'article_count' => '1 = 1'
			)
		)
	);
	
}?>