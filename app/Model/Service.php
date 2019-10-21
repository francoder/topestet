<? class Service extends AppModel
{
  var $actsAs = array('Containable');
  var $recursive = -1;

  var $adminSchema = array(
    'title'                    => array(
      'type'      => 'string',
      'title'     => 'Название услуги',
      'edit_link' => true,
    ),
    'title_genitive'           => array(
      'type'   => 'string',
      'title'  => 'Название услуги (Род.падеж)',
      'inlist' => false,
      'note'   => "Родительный падеж (Для кого? Для чего?)",
    ),
    'title_dative'             => array(
      'type'   => 'string',
      'title'  => 'Название услуги (Дат.падеж)',
      'inlist' => false,
      'note'   => "Дательный падеж (Кому? Чему?)",
    ),
    'title_accusative'         => array(
      'type'   => 'string',
      'title'  => 'Название услуги (Винит.падеж)',
      'inlist' => false,
      'note'   => "Винительный падеж (Кого? Что?)",
    ),
    'title_prepositional'      => array(
      'type'   => 'string',
      'title'  => 'Название услуги (Пред.падеж)',
      'inlist' => false,
      'note'   => "Предложный падеж (О ком? О Чём?)",
    ),
    'specialization_id'        => array(
      'type'  => 'list',
      'title' => 'Специализация услуги',
    ),
    'parent_id'                => array(
      'type'  => 'list',
      'title' => 'Родительская услуга',
    ),
    'alias'                    => array(
      'title' => 'Алиас',
      'type'  => 'string',
      'note'  => 'Слово латинскими буквами для формирования ссылки',
    ),
    'description'              => array(
      'title'  => 'Описание услуги',
      'type'   => 'text',
      'inlist' => false,
    ),
    'description_forum'        => array(
      'title'  => 'Описание услуги',
      'type'   => 'text',
      'note'   => 'для раздела вопросов',
      'inlist' => false,
    ),
    'description_photo'        => array(
      'title'  => 'Описание услуги',
      'type'   => 'text',
      'note'   => 'для раздела фотографий',
      'inlist' => false,
    ),
    'image'                    => array(
      'type'   => 'image',
      'title'  => 'Изображение',
      'inlist' => false,
    ),
    'review_count'             => array(
      'type'     => 'link',
      'template' => '/admin/self_list/Review/service_id:::id::/',
      'title'    => 'Обзоры',
      'inform'   => false,
    ),
    'specialist_service_count' => array(
      'type'     => 'link',
      'template' => '/admin/self_list/SpecialistService/service_id:::id::/',
      'title'    => 'Специалисты',
      'inform'   => false,
    ),
    'is_hidden'                => array(
      'type'   => 'bool',
      'title'  => 'Не отображать в рейтинге',
      'inlist' => false,
    ),
    'is_child'                 => array(
      'type'   => 'bool',
      'title'  => 'Дочерняя, не имеет страниц отзывов',
      'inlist' => false,
    ),
    'rating_manual'            => array(
      'title' => 'Админский рейтинг',
      'type'  => 'integer',
    ),
    'created'                  => array(
      'type'   => 'datetime',
      'title'  => 'Создана',
      'inform' => false,
    ),
  );

  var $adminTitles = array(
    'single'   => 'услуга',
    'plurial'  => 'Услуги',
    'genitive' => 'услуги',
  );

  var $order = 'Service.title';

  var $belongsTo = array(
    'Specialization' => array(
      'className'      => 'Specialization',
      'foreignKey' => 'specialization_id',
      'counterCache' => true,
    ),
    'Parent'         => array(
      'className'      => 'Service',
      'foreignKey'     => 'parent_id',
      'conditionsList' => array(
        'parent_id IS NULL',
      ),
    ),
  );

  public $hasMany = array(
    'SpecialistService' => array(
      'dependent' => true,
    ),
    'Photospec'         => array(
      'dependent' => true,
    ),
    'Question'          => array(
      'dependent' => true,
    ),
    'Review'            => array(
      'dependent' => true,
    ),
  );

  public $images = array(
    'image' => array(
      'main'      => array(),
      'thumbnail' => array(
        'width'  => 400,
        'height' => 168,
      ),
      'mini'      => array(
        'width'  => 400,
        'height' => 168,
      ),
    ),
  );

  public $hasAndBelongsToMany = array(
    'Specialist' => array(
      'className'             => 'User',
      'joinTable'             => 'specialist_services',
      'foreignKey'            => 'service_id',
      'associationForeignKey' => 'user_id',
      'order'                 => 'name',
      'fields'                => 'id, name, profession, address',
    ),
  );

  function getListWithSpec($specialist_id = null)
  {
    $result          = array();
    $specializations = $this->Specialization->find("list", array("conditions" => array("service_count >" => 0)));
    foreach ($specializations as $id => $specialization) {
      $conditions = array("specialization_id" => $id);
      if ($specialist_id) {
        $conditions['id'] = $this->SpecialistService->find("list",
          array("fields" => array("service_id"), "conditions" => array("user_id" => $specialist_id)));
      }
      $preresult = $this->find("list", array("conditions" => $conditions));
      if ( ! empty($preresult)) {
        $result[$specialization] = $preresult;
      }
    }

    return $result;
  }

  function recalcRate($service_id)
  {
    $service = $this->findById($service_id);
    if (empty($service)) {
      return false;
    }
    $service_ids[] = $service_id;
    $childs        = $this->find('list', array('conditions' => array('parent_id' => $service_id), 'fields' => 'id'));
    $service_ids   = array_merge($service_ids, $childs);

    $count_all     = $this->Review->find("count",
      array("conditions" => array("service_id" => $service_ids, "note_result >" => 0)));
    $count_positiv = $this->Review->find("count",
      array("conditions" => array("service_id" => $service_ids, "note_result" => 3)));
    $count_notsure = $this->Review->find("count",
        array("conditions" => array("service_id" => $service_ids, "note_result" => 2))) / 2;
    $this->id      = $service_id;
    $this->saveField("rate", round((($count_positiv + $count_notsure) / $count_all) * 100));
    if ( ! empty($service['Service']['parent_id'])) {
      $this->recalcRate($service['Service']['parent_id']);
    }
  }
} ?>
