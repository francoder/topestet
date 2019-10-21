<?class Photospec extends AppModel{
	var $actsAs = array('Containable');
	var $recursive = -1;
	
	public $validate = array(
		'both' => array(
			'main' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => '_image',
				'message' => 'Неуказано изображение или оно имеет неверный формат'
			),
			'size' => array(
				'rule' => '_image_size',
				'message' => 'Размер изображение не должен превышать 10 мБ'
			)
		),
		'before' => array(
			'main' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => '_image',
				'message' => 'Неуказано изображение "до" или оно имеет неверный формат'
			),
			'size' => array(
				'rule' => '_image_size',
				'message' => 'Размер изображение "до" не должен превышать 10 мБ'
			)
		),
		'after' => array(
			'main' => array(
				'rule' => '_image',
				'allowEmpty' => false,
				'required' => true,
				'message' => 'Неуказано изображение "после" или оно имеет неверный формат'
			),
			'size' => array(
				'rule' => '_image_size',
				'message' => 'Размер изображение "после" не должен превышать 10 мБ'
			)
		),
		'title' => array(
			'not_empty' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Укажите заголовок к фото',
			)
		),
		'content' => array(
			'content' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Укажите описание к фото',
			)
		)
	);
	
	public $adminSchema = array(
		'service_id' => array(
			'type' => 'list',
			'title' => 'Услуга'
		),
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок',
			'editlink' => true
		),
		'description' => array(
			'type' => 'string',
			'title' => 'Описание',
			'inlist' => false
		),
		'before' => array(
			'type' => 'image',
			'title' => 'Фото "до"'
		),
		'after' => array(
			'type' => 'image',
			'title' => 'Фото "после"'
		),
		'both' => array(
			'type' => 'image',
			'title' => 'Фото совмещенноеs'
		)
	);
	
	var $validate_admin = array(
		'content' => array(
			'content' => array(
				'allowEmpty' => false,
				'required' => true,
				'rule' => array('minLength',1),
				'message' => 'Укажите описание к фото',
			)
		)
	);
	
    var $images = array(
		'before' => array(
			'main' => array(
				
			),
			'middle' => array(
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
		),
		'after' => array(
			'main' => array(
				
			),
			'middle' => array(
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
		),
		'both' => array(
			'main' => array(
				
			),
			'middle' => array(
				'width' => 600,
				'height' => 300
			),
			'mini' => array(
				'width' => 400,
				'height' => 148
			),
			'thumbnail' => array(
				'width' => 136,
				'height' => 68
			)
		)
	);
	
	public $belongsTo = array(
		'Service' => array(
			'counterCache' => true
		),
		'User'
	);
	
	function _image($data){
		$data = $data[key($data)];
		if (!empty($data['tmp_name'])){
			if (in_array(mime_content_type($data['tmp_name']), array("image/jpeg", "image/gif", "image/png"))){
				return true;
			}
			return false;
		} else {
			return false;
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