<?

class Review extends AppModel
{
  public $virtualFields = array(
    'thank_all_count' => '`%model%`.thank_manual_count + `%model%`.thank_count',
  );
  var $actsAs = array('Containable');
  var $recursive = -1;

  public $validate = array(
    'service_id'  => array(
      /*'non_empty' => array(
          'allowEmpty' => false,
          'required' => true,
          'rule' => array('minLength',1),
          'message' => 'Укажите услугу',
      ),*/
      'is_service' => array(
        'rule'    => '_service',
        'message' => 'Мухлюете?',
      ),
    ),
    'subject'     => array(
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Укажите заголовок отзыва',
      ),
    ),
    'coast'       => array(
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Укажите стоимость услуги',
      ),
      'num'       => array(
        'rule'    => 'numeric',
        'message' => 'Стоимость указывается в виде целого числа (в рублях)',
      ),
    ),
    'description' => array(
      'lenght'    => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 500),
        'message'    => 'Отзыв должен быть длиннее 500 символов',
      ),
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Заполните отзыв',
      ),
    ),
    'region_id'   => array(
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Укажите город проведения операции',
      ),
      'is_region' => array(
        'rule'    => '_region',
        'message' => 'Мухлюете?',
      ),
    ),
    'note_result' => array(
      'non_empty' => array(
        'allowEmpty' => false,
        'required'   => true,
        'rule'       => array('minLength', 1),
        'message'    => 'Оцените результат операции',
      ),
      'list'      => array(
        'rule'    => array('inList', array("0", "1", "2", "3")),
        'message' => 'Неверная оценка результата',
      ),
    )/*,
        'specialist_name' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Укажите специалиста'
            )
        ),
        'note_specialist' => array(
            'non_empty' => array(
                'allowEmpty' => false,
                'required' => true,
                'rule' => array('minLength',1),
                'message' => 'Оцените работу специалиста',
            ),
            'list' => array(
                'rule' => array("inList", array(1,2,3,4,5)),
                'message' => "Неверная оценка работы специалиста"
            )
        ),*/
  );

  public $adminSchema = array(
    'subject'            => array(
      'type'      => 'string',
      'title'     => 'Заголовок отзыва',
      'edit_link' => true,
    ),
    'review_add_count'   => array(
      'type'     => 'link',
      'title'    => 'Кол-во дополнений',
      'template' => '/admin/self_list/ReviewAdd/review_id:::id::/',
    ),
    "user_id"            => array(
      "type"  => "integer",
      "title" => "Пользователь",
    ),
    'service_id'         => array(
      'type'  => 'list',
      'title' => 'Услуга',
    ),
    'photo_count'        => array(
      'type'     => "link",
      'template' => "/admin/self_list/Photo/alias:review/parent_id:::id::/",
      'title'    => 'Фото',
    ),
    'region_id'          => array(
      'type'   => 'list',
      'title'  => 'Регион услуги',
      'inlist' => false,
    ),
    'specialist_id'      => array(
      'type'   => 'list',
      'title'  => 'Специалист',
      'inlist' => false,
    ),
    'specialist_name'    => array(
      'type'   => 'string',
      'title'  => 'Имя специалиста',
      'inlist' => false,
      'note'   => 'Отображается в случае если не указан специалист выше',
    ),
    'clinic_id'          => array(
      'type'   => 'list',
      'title'  => 'Клиника',
      'inlist' => false,
    ),
    'clinic_name'        => array(
      'type'   => 'string',
      'title'  => 'Название клиники',
      'inlist' => false,
      'note'   => 'Отображается в случае если не указана клиника выше',
    ),
    'service_title'      => array(
      'type'   => 'string',
      'title'  => 'Название услуги',
      'inlist' => false,
      'note'   => 'Заполняется в случае, если услуга отсутствовала в списке',
    ),
    'coast'              => array(
      'type'   => 'integer',
      'title'  => 'Стоимость',
      'inlist' => false,
    ),
    'description'        => array(
      'type'   => 'text',
      'title'  => 'Описание услуги',
      'inlist' => false,
      'editor' => true,
    ),
    'note_result'        => array(
      'type'   => 'list',
      'title'  => 'Оценка результата',
      'inlist' => false,
      'values' => array(
        0 => 'Процедура не делалась',
        1 => 'Не рекомендую',
        2 => 'Затрудняюсь ответить',
        3 => 'Рекомендую',
      ),
    ),
    'comment_note'       => array(
      'type'   => 'text',
      'title'  => 'Отзыв к работе специалиста',
      'inlist' => false,
      'editor' => true,
    ),
    'thank_manual_count' => array(
      'title' => 'Корректировка "Спасибо"',
      'type'  => 'integer',
    ),
    'note_specialist'    => array(
      'type'   => 'list',
      'title'  => 'Оценка работы специалиста',
      'inlist' => false,
      'values' => array(
        1 => 'Очень плохо',
        2 => 'Плохо',
        3 => 'Удовлетворительно',
        4 => 'Хорошо',
        5 => 'Отлично',
      ),
    ),
    'is_adv'             => array(
      'type'  => 'bool',
      'title' => 'Рекламный',
      'icons' => array(
        '0' => '',
        '1' => '/img/admin/check.png',
      ),
    ),
    'is_translated'      => array(
      'type'  => 'bool',
      'title' => 'Перевод',
      'icons' => array(
        '0' => '',
        '1' => '/img/admin/check.png',
      ),
    ),
    'ip'                 => array(
      'type'   => 'string',
      'title'  => 'IP',
      'inform' => false,
    ),
    'created'            => array(
      'title' => 'Добавлен',
      'type'  => 'string',
    ),
    'edited'             => array(
      'title' => 'Отредактирован',
      'type'  => 'string',
    ),
  );

  var $adminTitles = array(
    'single'   => 'отзыв пользователя',
    'plurial'  => 'Отзывы пользователей',
    'genitive' => 'отзыва пользователя',
  );

  public $order = "Review.created desc";
  public $adminOrder = "Review.id desc";
  public $filterField = 'subject';
  public $belongsTo = array(
    'Service'    => array(
      'counterCache' => true,
    ),
    'Region',
    'User'       => array(
      'fieldList' => 'name',
    ),
    'Specialist' => array(
      'className'      => "User",
      'foreignKey'     => 'specialist_id',
      'fieldList'      => 'name',
      'conditionsList' => array(
        'is_specialist' => 1,
      ),
      'counterCache'   => array(
        'review_count'    => '1=1',
        'review_ex_count' => 'note_specialist = 5',
      ),
    ),
    'Clinic'     => array(
      'className'      => "User",
      'foreignKey'     => 'clinic_id',
      'fieldList'      => 'name',
      'conditionsList' => array(
        'is_specialist' => 2,
      ),
      'counterCache'   => array(
        'review_count'    => '1=1',
        'review_ex_count' => 'note_specialist = 5',
      ),
    ),
  );

  public $applyingFilters = array(
    'filter1' => array(
      'Review.specialist_name <>' => '',
      'Review.specialist_id IS NULL',
    ),
    'filter2' => array(
      'Review.clinic_name <>' => '',
      'Review.clinic_id IS NULL',
    ),
  );

  public $hasMany = array(
    'Photo'     => array(
      'dependent'  => true,
      'foreignKey' => 'parent_id',
      'conditions' => array(
        "alias" => "review",
      ),
      'order'      => 'Photo.created ASC',
    ),
    'ReviewAdd' => array(
      'dependent' => true,
      'order'     => 'ReviewAdd.created ASC',
    ),
  );

  public $reviewNotes = array(
    0 => "Процедура еще не сделана",
    1 => "Не рекомендую",
    2 => "Сомневаюсь",
    3 => "Рекомендую",
  );

  function _image($data)
  {
    if ( ! empty($data['avatar']['tmp_name'])) {
      if ( ! empty($data['avatar']['tmp_name'])) {
        if (in_array(mime_content_type($data['avatar']['tmp_name']), array("image/jpeg", "image/gif", "image/png"))) {
          return true;
        }
      }

      return false;
    } else {
      return true;
    }
  }

  function _region($data)
  {
    $region = $this->Region->findById($data['region_id']);

    return ! empty($region);
  }

  function _service($data)
  {
    $service = $this->Service->findById($data['service_id']);

    return ! empty($service) || $data['service_id'] == 0;
  }

  function afterSave($created, $data = [])
  {
    parent::afterSave($created);
    if (isset($this->data['Review']['service_id'])) {
      //средняя стоимость
      $this->Service->id = $this->data['Review']['service_id'];
      $avg               = $this->find("all", array(
        "fields"     => "AVG(`coast`) as `avg`",
        "conditions" => array("service_id" => $this->Service->id, "coast <>" => 0),
      ));
      $this->Service->saveField("coast_avg", $avg[0][0]['avg']);

      //рейтинг в % услуги
      //note_result
      $this->Service->recalcRate($this->data['Review']['service_id']);

      //рейтинг специалиста
      if ( ! empty($this->data['Review']['note_specialist']) && ! empty($this->data['Review']['specialist_id'])) {
        $note_specialist = $this->find("all", array(
          "fields"     => "AVG(`note_specialist`) as `avg`",
          "conditions" => array("specialist_id" => $this->data['Review']['specialist_id']),
        ));
        $note_specialist = round($note_specialist[0][0]['avg'], 2);
        $this->User->id  = $this->data['Review']['specialist_id'];
        $this->User->saveField("rate", $note_specialist);
      }
    }
    if ( ! empty($this->data['Review']['specialist_id'])) {
      //средняя стоимость специалиста
      $this->User->id = $this->data['Review']['specialist_id'];
      $avg            = $this->find("all", array(
        "fields"     => "AVG(`coast`) as `avg`",
        "conditions" => array("specialist_id" => $this->data['Review']['specialist_id'], "coast <>" => 0),
      ));
      $this->User->saveField("coast_avg", $avg[0][0]['avg']);
    }
    if ( ! empty($this->data['Review']['clinic_id'])) {
      //средняя стоимость специалиста
      $this->User->id = $this->data['Review']['clinic_id'];
      $avg            = $this->find("all", array(
        "fields"     => "AVG(`coast`) as `avg`",
        "conditions" => array("clinic_id" => $this->data['Review']['clinic_id'], "coast <>" => 0),
      ));
      $this->User->saveField("coast_avg", $avg[0][0]['avg']);
    }

    return true;
  }
}
