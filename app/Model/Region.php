<? class Region extends AppModel
{
  var $actsAs = array('Containable');
  var $recursive = -1;

  var $adminSchema = array(
    'title'                  => array(
      'type'      => 'string',
      'title'     => 'Название региона',
      'edit_link' => true,
    ),
    'title_genitive'         => array(
      'type'   => 'string',
      'title'  => 'Название региона (род.падеж)',
      'inlist' => false,
      'note'   => "Кого? Чего?",
    ),
    'title_with_preposition' => array(
      'type'   => 'string',
      'title'  => 'Название региона с предолгом "в"',
      'inlist' => false,
      'note'   => "во Владимире",
    ),
    'alias'                  => array(
      'type'    => 'string',
      'title'   => 'Англ.название',
      'in_list' => false,
    ),
    'child_count'            => array(
      'type'     => 'link',
      'title'    => 'Под.регионы',
      'template' => '/admin/self_list/Region/parent_id:::id::/',
      'inform'   => false,
    ),
    'specialist_count'       => array(
      'type'     => 'link',
      'title'    => 'Спец.',
      'template' => '/admin/self_list/User/region_id:::id::/',
      'inform'   => false,
    ),
    'parent_id'              => array(
      'type'   => 'list',
      'title'  => 'Родительский регион',
      'inlist' => false,
    ),
    'order'                  => array(
      'type'   => 'integer',
      'title'  => 'Сортировка для списка',
      'inlist' => false,
    ),
    'order_select'           => array(
      'type'   => 'integer',
      'title'  => 'Сортировка для выпадалки',
      'inlist' => false,
    ),
    'created'                => array(
      'type'   => 'datetime',
      'title'  => 'Создана',
      'inform' => false,
    ),
  );

  var $adminTitles = array(
    'single'   => 'регион',
    'plurial'  => 'Регионы',
    'genitive' => 'региона',
  );

  var $order = 'order DESC, title';

  public $belongsTo = array(
    'Parent' => array(
      'counterCache' => array(
        'child_count' => 'Region.parent_id IS NOT NULL',
      ),
      'className'    => 'Region',
    ),
  );

  function getTree($parent_id = null)
  {
    $tree = $this->find("all", array("conditions" => array("parent_id" => $parent_id), "order" => "order DESC, title"));
    foreach ($tree as $i => $data) {
      if ($data['Region']['child_count'] > 0) {
        $tree[$i]['Region']['childs'] = $this->getTree($data['Region']['id']);
      }
    }

    return $tree;
  }

  function getList()
  {
    $result = false;
    $firsts = $this->find("list", array("conditions" => array("parent_id" => "")));
    foreach ($firsts as $first_id => $first_title) {
      $seconds    = $this->find("list", array("conditions" => array("parent_id" => $first_id)));
      $second_ids = array_keys($seconds);
      if (empty($seconds)) {
        $result[$first_id] = $first_title;
      } else {
        $third_ids = $this->find("list",
          array("conditions" => array("parent_id" => $second_ids), "fields" => "id", "order" => "`order` DESC, title"));
        if ( ! empty($third_ids)) {
          $seconds              = $this->find("list",
            array("conditions" => array("parent_id" => $first_id, "child_count" => 0)));
          $second_ids           = array_keys($seconds);
          $result[$first_title] = $this->find("list",
            array("conditions" => array("id" => array_merge($third_ids, $second_ids))));
        } else {
          $result[$first_title] = $seconds;
        }
      }
    }

    return $result;
  }

  public function getCities($type = 'all')
  {
    $cities = $this->find($type,
      array(
        'conditions' => array('parent_id'),
        'order' => array('Region.order' => 'DESC')
      )
    );

    return $cities;
  }
} ?>