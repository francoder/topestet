<?class Info extends AppModel{
	var $adminSchema = array(
		'is_hidden' => array(
			'title' => 'Не показывать в блоке',
			'title_short' => 'Не отбр.',
			'type' => 'bool',
			'icons' => array(
    			1 => '/img/admin/off.png',
    			0 => '/img/admin/on.png'
    		)
		),
		'type' => array(
			'type' => 'list',
			'title' => 'Способ отображения',
			'values' => array(
    			0 => 'Текст',
    			1 => 'Изображение',
    			2 => 'Текст и изображение'
    		)
		),
		'link_target' => array(
			'type' => 'list',
			'title' => 'Открывать ссылку',
			'values' => array(
    			'_self' => 'В текущем окне',
    			'_blank' => 'В новом окне'
    		),
    		'inlist' => false
		),
		'title' => array(
			'type' => 'string',
			'title' => 'Заголовок блока',
			'edit_link' => true
		),
		'link' => array(
			'type' => 'string',
			'title' => 'Ссылка',
		),
		'description' => array(
			'type' => 'text',
			'title' => 'Подпись к блоку',
			'editor' => true,
			'inlist' => false
		),
		'img' => array(
			'title' => 'Изображение баннера',
			'type' => 'image'
		),
		'order' => array(
			'type' => 'integer',
			'title' => 'Сортировка',
			'inlist' => false
		),
		'created' => array(
			'type' => 'datetime',
			'title' => 'Создана',
			'inform' => false
		),
	);
	
	var $adminTitles = array(
		'single' => 'инф.блок',
		'plurial' => 'Информационные блоки',
		'genitive' => 'инф.блока'
	);
	
	var $order = 'order desc, title desc';

	var $images = array(
		'img' => array(
			'main' => array(
				'width' => 300
			),
			'thumbnail' => array(
				'width' => 100,
			)
		)
	);
}?>