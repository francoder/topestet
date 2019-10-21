<?class Photo extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	public $validate = array(
		'picture' => array(
			'main' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => '_image',
				'on' => 'create',
				'message' => 'Неверный формат одного из изображений'
			),
			'size' => array(
				'rule' => '_image_size',
				'allowEmpty' => false,
				'required' => true,
				'on' => 'create',
				'message' => 'Размер изображение не должен превышать 10 мБ'
			)
		)
	);
	

    var $images = array(
		'picture' => array(
			'main' => array(
				
			),
			'thumbnail' => array(
				'width' => 300,
				'height' => 300
			),
			'mini' => array(
				'width' => 200,
				'height' => 148
			),
			'thumbnail' => array(
				'width' => 68,
				'height' => 68
			)
		)
	);
	
	var $adminTitles = array(
		'single' => 'фото',
		'plurial' => 'Фотографии',
		'genitive' => 'фотографии'
	);
	
	public $adminSchema = array(
		"picture" => array(
			"title" => "Изображение",
			"type" => "image"
		),
		"alias" => array(
			"type" => "list",
			"values" => array(
				"question" => "к вопросу",
				"review" => 'к обзору'
			)
		),
		'parent_id' => array(
			'title' => 'Род.элемент',
			'type' => 'integer'
		),
		'is_adult' => array(
			'title' => '18+',
			'type' => 'bool'
		),
		'content' => array(
			'type' => 'text',
			'title' => 'Описание',
			'note' => 'не всегда отображается на сайте'
		)
	);
	
	public $belongsTo = array(
		'Review' => array(
			'foreignKey' => 'parent_id',
			'counterCache' => array(
				'photo_count' => 'Photo.alias = "review"'
			),
			'conditions' => array(
				'Photo.alias' => 'review'
			),
			'fieldList' => 'subject'
		),
		'Question' => array(
			'foreignKey' => 'parent_id',
			'conditions' => array(
				'Photo.alias' => 'review'
			),
			'counterCache' => array(
				'photo_count' => 'Photo.alias = "question"'
			),
			'fieldList' => 'subject'
		)
	);
	
	function _image($data){
		if (!empty($data['picture']['tmp_name'])){
			if (!empty($data['picture']['tmp_name'])){
				if (in_array(mime_content_type($data['picture']['tmp_name']), array("image/jpeg", "image/gif", "image/png"))){
					return true;
				}
			}
			return false;
		} else {
			return true;
		}
	}
	
	function _image_size($data){
		$data = $data[key($data)];
		if (!empty($data['tmp_name'])){
			if (($data['size'] <= 10*1024*1024)){
				return true;
			}
			return false;
		} else {
			return false;
		}
	}
}?>