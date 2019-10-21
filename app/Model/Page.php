<?class Page extends AppModel{
	var $adminSchema = array(
		'is_link' => array(
			'title' => 'Ссылка в шапке сайта',
			'title_short' => 'В меню',
			'type' => 'bool',
			'icons' => array(
    			0 => '',
    			1 => '/img/admin/check.png'
    		)
		),
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок страницы',
			'inlist' => false
		),
		'title_short' => array(
			'type' => 'string',
			'title' => 'Короткий заголовок',
			'edit_link' => true
		),
		'alias' => array(
			'type' => 'string',
			'title' => 'Ссылка (англ.)',
		)/*,
		'order' => array(
			'type' => 'integer',
			'title' => 'Сортировка'
		)*/,
		'content' => array(
			'title' => 'Содержимое страницы',
			'type' => 'text',
			'editor' => true,
			'inlist' => false
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'страница',
		'plurial' => 'Страницы',
		'genitive' => 'страницы'
	);
	
	var $order = 'order desc, title desc';
	
	public function afterSave($created, $data =[]){
		parent::afterSave($data);
		if (isset($this->data['Page']['is_link']) && $this->data['Page']['is_link'] == 1){
			$this->updateAll(array("is_link" => 0), array("Page.id <>" => $this->id));
		}
	}
}?>