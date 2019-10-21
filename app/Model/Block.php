<?class Block extends AppModel{
	var $adminSchema = array(
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок страницы'
		),
		'controller' => array(
			'type' => 'string',
			'title' => 'Контроллер'
		),
		'action' => array(
			'type' => 'string',
			'title' => 'Действие'
		),
		'content' => array(
			'title' => 'Содержимое блока',
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
		'single' => 'текстовый блок',
		'plurial' => 'Текстовые блоки',
		'genitive' => 'текстового блока'
	);
	
}?>