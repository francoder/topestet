<?php

class AdminController extends AppController
{
  var $uses = array(
    'User',
    'Page',
    'Info',
    'Post',
    'Region',
    'Specialization',
    'Service',
    'SpecialistService',
    'SpecialistClinic',
    'Review',
    'Seo',
    'Question',
    'Photo',
    'Message',
    'Comment',
    'PostCategory',
    'PostService',
    'PostSpecialist',
    'Opinion',
    'Block',
    'ReviewAdd',
    'Photospec'
  );

  var $layout = "admin";

  var $helpers = array("Display", "Form", "Admin");

  var $components = array("Session", "Email");

  var $paginate = array();

  function beforeFilter()
  {
    parent::beforeFilter();

    if ($this->user && 1 > $this->user['is_admin']) {
      return $this->error_404();
    }

    $this->menu_moderator = array(
      array('/admin/' => 'Главная'),
      array(
        '/admin/self_list/Review/' => 'Отзывы',
        'sub' => array(
          '/admin/self_list/Review/' => 'Отзывы пользователей',
          '/admin/self_list/Review/service_id:0/' => 'Отзывы без услуги',
          '/admin/self_list/Question/' => 'Вопросы пользователей',
          '/admin/self_list/Question/service_id:0/' => 'Вопросы без услуги',
          '/admin/self_list/Photo/alias:review/' => 'Фото к обзорам',
          '/admin/self_list/Photo/alias:question/' => 'Фото к вопросам',
          '/admin/comments/' => 'Комментарии'
        ),
        'also' => array(
          '/admin/self_item/Review/',
          '/admin/self_item/Question/',
          '/admin/self_item/Photo/',
          '/admin/self_list/Photo/'
        )
      ),
      array(
        '/admin/self_list/Page/' => 'Страницы, блог',
        'sub' => array(
          '/admin/self_list/Page/' => 'Текстовые страницы',
          '/admin/self_list/Block/' => 'Текстовые блоки',
        ),
        'also' => array(
          '/admin/self_item/Page/',
          '/admin/self_item/Block/'
        )
      ),
      array('/user/logout/' => 'Выход')
    );

    if (1 == $this->user['is_admin']) {

      foreach ($this->menu_moderator as $item) {

        foreach ($item as $key => $value) {

          if ($key != "sub" && $key != "also") {
            $urls[] = $key;

          } elseif($key == "sub") {

            foreach ($value as $kkey => $vvalue) {
              $urls[] = $kkey;
            }
          } else {

            foreach ($value as $kkey => $vvalue) {
              $urls[] = $vvalue;
            }
          }
        }
      }

      $allow = false;

      foreach ($urls as $url) {
        $parts = explode("/", $url);

        if ($parts[1] == $this->params['controller']) {

          if (empty($parts[2])) $action = "index"; else $action = $parts[2];

          if ($action == $this->params['action']) {

            if (!empty($this->params['pass'])) {

              if (!empty($parts[3]) && strpos($parts[3], ":") === false) {

                if ($this->params['pass'][0] == $parts[3]) {
                  $allow = true;
                }
              }
            } else {
              $allow = true;
              break;
            }
          }
        }
      }

      if (!$allow) return $this->redirect("/admin/");
    }
  }

  function index() {}

  function additions()
  {
    return $this->render("empty");
  }

  function comments()
  {
    $this->set("page_title", $this->Comment->getTitle('plurial'));

    $conditions = array();

    if (!empty($this->params['named'])){

      foreach ($this->params['named'] as $key => $value) {

        if (isset($this->Comment->_schema[$key]) ||
            isset($this->Comment->virtualFields[$key])) {

          $conditions[$key] = $value;
        }
      }
    }

    if (isset($this->Comment->conditions)) {
      $conditions = array_merge($conditions, $this->Comment->conditions);
    }

    $this->paginate['Comment']['limit'] = 15;

    if (isset($this->Comment->adminOrder)) {
      $this->paginate['Comment']['order'] = $this->Comment->adminOrder;
    }


    $this->set("items", $this->paginate('Comment', $conditions));
  }

  function qcomments()
  {
    $this->set("page_title", $this->Qcomment->getTitle('plurial'));

    $conditions = array();

    if (!empty($this->params['named'])){

      foreach ($this->params['named'] as $key => $value) {

        if (isset($this->Qcomment->_schema[$key]) ||
            isset($this->Qcomment->virtualFields[$key])) {

          $conditions[$key] = $value;
        }
      }
    }

    if (isset($this->Qcomment->conditions)) {
      $conditions = array_merge($conditions, $this->Qcomment->conditions);
    }

    $this->paginate['Qcomment']['limit'] = 15;

    if (isset($this->Qcomment->adminOrder)) {
      $this->paginate['Qcomment']['order'] = $this->Qcomment->adminOrder;
    }

    $this->paginate["Qcomment"]["contain"] = array("User");

    $this->set("items", $this->paginate('Qcomment', $conditions));
  }

  function self_list($model){
    $this->set("page_title", $this->{$model}->getTitle('plurial'));
    $this->set("model", $model);

    $this->set("schema", $this->{$model}->adminSchema);

    $this->{$model}->locale = $this->languages[0];

    $conditions = array();
    if (!empty($this->params['named'])){
      foreach ($this->params['named'] as $key => $value) {
        if (isset($this->{$model}->_schema[$key]) ||
            isset($this->{$model}->virtualFields[$key])) {
          $conditions[$key] = $value;
        }
      }
    }

    if (isset($this->{$model}->conditions)) {
      $conditions = array_merge($conditions, $this->{$model}->conditions);
    }

    $params = array();

    $filters = array();

    if (isset($this->params['named'])) {

      $params = $this->params['named'];

      foreach ($params as $key => $value) {

        if (!isset($this->{$model}->adminSchema[$key])) {
          unset($params[$key]);
        }
      }

      $conditions = array_merge($conditions, $params);

      //подписи к фильтрам
      if (!empty($params)) {

        foreach ($params as $param => $data) {

          $filter = str_replace("_id", "", $param);
          $filter = explode("_", $filter);
          $filter = ucwords(implode(" ", $filter));
          $filter = str_replace(" ", "", $filter);
          if ($this->{$filter}) {

            if (isset($this->{$filter}->filterField)) {
              $filterField = $this->{$filter}->filterField;
            } else {
              $filterField = "title";
            }

            $element = $this->{$filter}->find("first",
              array("conditions" => array("id" => $data), "fields" => $filterField));

            if (!empty($element)) {
              $filters[] = "Для " .
                           $this->{$filter}->adminTitles['genitive'] . " &laquo;" .
                           $element[$filter][$filterField] . "&raquo;";
            }
          }
        }
      }
    }


    $this->paginate[$model] = array('limit' => 30);

    if (isset($this->{$model}->adminOrder)) {
      $this->paginate[$model] = array('order' => $this->{$model}->adminOrder);
    }

    //применяемые фильтры
    if (isset($this->params['named']['applying_filter']) && isset($this->{$model}->applyingFilters[$this->params['named']['applying_filter']])){
      $conditions = array_merge($conditions, $this->{$model}->applyingFilters[$this->params['named']['applying_filter']]);
    }

    $this->set("items", $this->paginate($model, $conditions));

    if (isset($this->{$model}->links)) {
      $this->set("links", $this->{$model}->links);
    }

    if (isset($this->{$model}->adminGroupOperations)) {
      $this->set("group_operations", $this->{$model}->adminGroupOperations);
    }


    $this->self_make_lists($model);

    if (!empty($params)) {
      $this->set("params_named", $params);
    }

    $this->set("filters", $filters);

  }

  function self_item($model, $id = null)
  {
    if ($this->data) {

      $data = $this->data;

      if (isset($this->{$model}->validate_admin)) {
        $this->{$model}->validate = $this->{$model}->validate_admin;
      }

      //для пароля
      foreach ($this->{$model}->adminSchema as $name => $element) {

        if (isset($this->{$model}->virtualFields[$name])) continue;

        if ($element['type'] == "password") {

          if (empty($data[$model][$name])) {
            unset($data[$model][$name]);
          } else {
            $data[$model][$name."_original"] = $data[$model][$name];
            $data[$model][$name] = $this->Auth->password($data[$model][$name]);
          }
        }
      }

      if ($this->{$model}->save($data)) {

        $field = array_search(array("type" => "file"), $this->{$model}->adminSchema);

        if ($field) {

          foreach ($this->{$model}->adminSchema as $name => $params) {

            if (isset($params['type']) &&
                $params['type'] == "file" &&
                !empty($data[$model][$name])) {

              $file = $data[$model][$name];

              if (!empty($file['tmp_name'])) {

                $dir = @$params['dir'];

                if (!empty($params['filename'])) {
                  $filename = str_replace("::id::", $this->{$model}->id, $params['filename']);
                } else {
                  $filename = $file['name'];
                }

                copy($file['tmp_name'], WWW_ROOT.$dir.$filename);
              }
            }
          }
        }

        //сохраняем HABTM
        if (isset($this->{$model}->hasAndBelongsToMany)) {
          foreach ($this->{$model}->hasAndBelongsToMany as $associated_model => $params) {
            $field = strtolower($associated_model."_id");
            if (isset($this->data[$params['with']]) && is_array($this->data[$params['with']])) {
              foreach ($this->data[$params['with']] as $habtm_id => $habtm_data) {
                if ($habtm_data[$field] <> 0) {
                  $data_to_check = array(
                    $field => $habtm_id,
                    $params['foreignKey'] => (!empty($this->data[$model]['id']))?$this->data[$model]['id']:$this->{$model}->id
                  );
                  $data_to_save[$params['with']] = $habtm_data;
                  $data_to_save[$params['with']][$params['foreignKey']] = $data_to_check[$params['foreignKey']];
                  $entity = $this->{$params['with']}->find("first", array("conditions" => $data_to_check));
                  if (!empty($entity)) {
                    $data_to_save[$params['with']]['id'] = $entity[$params['with']]['id'];
                  }
                  $this->{$params['with']}->id = null;
                  $this->{$params['with']}->save($data_to_save);
                } else {
                  $this->{$params['with']}->deleteAll(array(
                    $field => $habtm_id,
                    $params['foreignKey'] => $this->data[$model]['id']
                  ));
                }
              }
            }
          }
        }

        $this->Session->setFlash("Данные сохранены", "message");

        //$this->redirect("/admin/self_list/$model/");
        $this->redirect($this->referer());
      }
    } elseif (!is_null($id)) {

      $this->{$model}->locale = $this->languages[0];

      $data = $this->{$model}->find("first", array("conditions" => array("$model.id" => $id)));

      if (isset($this->{$model}->actsAs['Translate'])) {

        $langs = $this->languages;

        unset($langs[0]);

        foreach ($langs as $lang) {

          $this->{$model}->locale = $lang;

          $d = $this->{$model}->find("first", array("conditions" => array("$model.id" => $id)));

          $data['Language'][$lang] = $d[$model];
        }
      }

      $this->data = $data;

    } elseif (!empty($this->params['named'])) {
      $this->data = array($model => $this->params['named']);
    }

    //списки для выпадалок
    $this->self_make_lists($model);

    //выбранные значения для HABTM
    if (isset($this->{$model}->hasAndBelongsToMany)) {
      foreach ($this->{$model}->hasAndBelongsToMany as $joinModel => $params) {
        $field = $params['associationForeignKey'];
        if (isset($this->{$model}->adminSchema[$field]) && !empty($this->data[$model]['id'])) {
          $this->set(strtolower($joinModel."_saved_values"),
            $v = $this->{$params['with']}->find("all",
              array("conditions" => array(
                $params['foreignKey'] => $this->data[$model]['id'])

              )
            )
          );
        }
      }
    }

    $this->set("page_title", ((is_null($id))?"Добавление ":"Редактирование ") .
                             $this->{$model}->getTitle('genitive'));

    $this->set("model", $model);

    $this->set("schema", $this->{$model}->adminSchema);

    $this->set("image", isset($this->{$model}->images));

    if (isset($this->{$model}->images)) {
      $this->set("images_data", $this->{$model}->images);
    }

    if (isset($this->{$model}->actsAs['Translate'])) {
      $this->set("translate", $this->{$model}->actsAs['Translate']);
    }

    if (isset($this->{$model}->hasAndBelongsToMany)){
      $this->set('habtms', $this->{$model}->hasAndBelongsToMany);
    }
  }

  private function self_make_lists($model){
    if (isset($this->{$model}->belongsTo) ||
        isset($this->{$model}->hasAndBelongsToMany)) {
      $links = array_merge(isset($this->{$model}->belongsTo) ? $this->{$model}->belongsTo : array(),
        isset($this->{$model}->hasAndBelongsToMany) ? $this->{$model}->hasAndBelongsToMany : array());
      foreach ($links as $assoc_model => $item) {

        if (!is_array($item)) {
          $assoc_model = $item;
        } elseif (isset($item['className'])) {
          $assoc_model = $item['className'];
        } elseif (isset($item['with'])){
          $assoc_model = $item['with'];
        }
        if (is_array($item) && isset($item['associationForeignKey'])) {
          $key = $item['associationForeignKey'];
        } elseif (isset($item['foreignKey'])) {
          $key = $item['foreignKey'];
        } else {
          $key = strtolower($assoc_model)."_id";
        }

        if (!isset($this->{$model}->adminSchema[$key]) || ($this->{$model}->adminSchema[$key]['type'] != 'list' && $this->{$model}->adminSchema[$key]['type'] != 'habtm')) continue;

        $var = str_replace("_id", "", $key);

        $var = "{$var}_values";

        if (isset($item['fieldList'])) {
          $field = $item['fieldList'];
        } else {
          $field = "title";
        }

        $conditions = array();

        if (isset($item['conditionsList'])) {
          $conditions = $item['conditionsList'];
        }
        //echo $assoc_model;
        $this->set("$var", $this->{$assoc_model}->find("list", array(
            "order" => "$field",
            "fields" => "id, $field",
            "conditions" => $conditions)
        ));
      }
    }
  }

  function self_item_del($model, $id)
  {
    $this->{$model}->delete($id);

    if (@$_GET['redirect']){
      $redirect = $_GET['redirect'];
    } else {
      $redirect = $this->referer();
    }
    return $this->redirect($redirect);
  }

  function img_delete($model, $alias, $model_id, $filename){
    if (isset($this->{$model}->images[$alias])) {

      preg_match("/_([a-z]+)\./", $filename, $type);

      $type = $type[1];

      $ex = pathinfo($filename);

      $ex = $ex['extension'];

      preg_match("/_([0-9]+)_/", $filename, $id);

      $id = $id[1];

      if (isset($this->{$model}->images[$alias]['hasMany']) &&
          $this->{$model}->images[$alias]['hasMany']){

        $hasMany = $this->{$model}->images[$alias]['hasMany'];
      }

      unset($this->{$model}->images[$alias]['hasMany']);

      foreach ($this->{$model}->images[$alias] as $key => $img_data) {

        if ($hasMany) {

          if ($key == $main) $t = ""; else $t = "_$key";

          @unlink($f = "image/".strtolower($model)."/{$alias}_{$model_id}/{$alias}_$id".$t.".$ex");

          echo $f;
        }
      }
    }

    return $this->redirect($this->referer());
  }

  function get_list($model)
  {
    $req = $_GET['q'];

    $req = mysql_escape_string($req);

    $list = $this->{$model}->find("list", array("conditions" => array("title LIKE" => "$req%")));

    foreach ($list as $el) {
      echo "$el\n";
    }

    exit();
  }

  function config()
  {
    if ($this->data){

      foreach ($this->data['Configs'] as $key => $value) {

        $conf = $this->Config->findByName($key);

        if (!empty($conf)) {

          $this->Config->id = $conf['Config']['id'];
          $this->Config->saveField("value", $value);
        }
      }

      $this->set("done", true);
    }

    $this->set("configs", $this->Config->find("all", array("order" => "id")));
  }

  function group_adding_services(){
    if ($this->data){
      $cond['user_id'] = $this->User->find('list', array('fields' => 'id', 'conditions' => array($this->data['Group']['is_specialist'])));
      if ($this->data['Group']['have'] == 0){
        $cond['NOT'] = array('SpecialistService.service_id' => $this->data['Group']['service_have_id']);
      } else {
        $cond['SpecialistService.service_id'] = $this->data['Group']['service_have_id'];
      }
      $users_ids = $this->SpecialistService->find('list', array('conditions' => $cond, 'fields' => 'user_id'));

      foreach ($users_ids as $user_id){
        $this->SpecialistService->id = null;
        $data_to_save = array('user_id' => $user_id, 'service_id' => $this->data['Group']['service_id']);
        if ($this->SpecialistService->find('count', array('conditions' => $data_to_save)) == 0){
          if ($this->SpecialistService->save(array('SpecialistService' => $data_to_save))){
            $this->set('done', true);
          }
        }
      }
    }
    $this->set('services', $this->Service->find('list'));
  }

  function users_csv(){
    if ($this->request->is('post')){
      $data = $this->request->data;
      $conditions = array('mail <>' => '');

      if (!empty($data['Mail']['mail'])){
        $conditions['mail LIKE'] = $data['Mail']['mail'];
      }
      if (!empty($data['Mail']['mail_not'])){
        $conditions['mail NOT LIKE'] = $data['Mail']['mail_not'];
      }
      if (($data['Mail']['is_specialist']) != ''){
        $conditions['is_specialist'] = $data['Mail']['is_specialist'];
      }
      if (($data['Mail']['active']) != ''){
        $conditions['active'] = $data['Mail']['active'];
      }


      $mails = $this->User->find('list', array('fields' => 'mail', 'conditions' => $conditions));
      if (count($mails) > 0){
        $fname = 'image/mails.csv';
        $f = fopen($fname, 'w');
        foreach ($mails as $mail){
          fwrite($f, $mail."\r\n");
        }
        fclose($f);
        $this->set('fname', $fname);
      }

      $this->set('cnt', count($mails));
      $this->set('done', true);
    }
  }

  public function users_clear() {
    if ($this->request->is('post')){
      $cnt = $this->User->find('count', array('conditions' => $cond = array('User.active' => 0, 'User.created  < DATE_SUB(NOW(), INTERVAL 1 MONTH)')));
      $this->User->deleteAll($cond);
      $this->set('done', true);
      $this->set('cnt', $cnt);
    }
  }


  function beforeRender()
  {
    parent::beforeRender();

    $menu = array(
      array('/admin/' => 'Главная',),
      array(
        '/admin/self_list/Specialization/' => 'Услуги',
        'sub' => array(
          '/admin/self_list/Specialization/' => 'Специализации',
          '/admin/self_list/Service/' => 'Услуги',
          '/admin/self_list/SpecialistService/' => 'Услуги специалистов'
        ),
        'also' => array(
          '/admin/self_item/Specialization/',
          '/admin/self_item/Service/',
          '/admin/self_item/SpecialistService/'
        )
      ),
      array(
        '/admin/self_list/Review/' => 'Отзывы',
        'sub' => array(
          '/admin/self_list/Review/' => 'Отзывы пользователей',
          '/admin/self_list/ReviewAdd/' => 'Доп. к отзывам',
          '/admin/self_list/Review/service_id:0/' => 'Отзывы без услуги',
          '/admin/self_list/Review/applying_filter:filter1/' => 'Отзывы с текстом хирург, но не в списке',
          '/admin/self_list/Review/applying_filter:filter2/' => 'Отзывы с текстом клиника, но не в списке',
          '/admin/self_list/Photo/alias:review/' => 'Фото к обзорам',
          '/admin/self_list/Photospec/' => 'Фото специалистов',
          '/admin/self_list/Comment/' => 'Комментарии'
        ),
        'also' => array(
          '/admin/self_item/Review/',
          '/admin/self_item/Question/',
          '/admin/self_item/Photo/',
          '/admin/self_list/Photo/',
          '/admin/self_list/Comment/',
          '/admin/self_item/Photospec/'
        )
      ),
      array(
        '/admin/self_list/Question/' => 'Вопросы',
        'sub' => array(
          '/admin/self_list/Question/' => 'Вопросы пользователей',
          '/admin/self_list/Question/service_id:0/' => 'Вопросы без услуги',
          '/admin/self_list/Photo/alias:question/' => 'Фото к вопросам'
        ),
        'also' => array(
          '/admin/self_item/Question/'
        )
      ),
      array(
        '/admin/self_list/Page/' => 'Страницы, блог',
        'sub' => array(
          '/admin/self_list/Page/' => 'Текстовые страницы',
          '/admin/self_list/Block/' => 'Текстовые блоки',
          '/admin/self_list/Post/' => 'Блог',
          '/admin/self_list/PostCategory/' => 'Категории блога',
          '/admin/self_list/Opinion/' => 'Мнения специалистов',
          '/admin/self_list/Info/' => 'Информационные баннеры'
        ),
        'also' => array(
          '/admin/self_item/Info/',
          '/admin/self_item/Page/',
          '/admin/self_item/Block/',
          '/admin/self_item/Post/',
          '/admin/self_item/Opinion/',
          '/admin/self_item/PostCategory/'

        )
      ),
      array(
        '/admin/self_list/User/' => 'Пользователи',
        'sub' => array(
          '/admin/self_list/User/' => 'Список пользователей',
          '/admin/self_list/User/is_specialist:1/' => 'Специалисты',
          '/admin/self_list/User/is_specialist:2/' => 'Клиники',
          '/admin/self_list/User/has_request:1/' => 'Заявки в специалисты',
          '/admin/self_item/User/' => 'Добавить пользователя',
          '/admin/self_list/Message/' => 'Сообщения',
          '/admin/group_adding_services/' => 'Добавление услуг массовое',
          '/admin/users_csv/' => 'CSV-база адресов',
          '/admin/users_clear/' => 'Удалить неактивных'
        ),
        'also' => array(
          '/admin/self_item/User/',
          '/admin/self_item/Message/'
        )
      ),
      array(
        '/admin/config/' => 'Настройки, прочее',
        'sub' => array(
          '/admin/config/' => 'Настройки',
          '/admin/self_list/Seo/' => 'SEO-установки',
          '/admin/self_list/Region/' => 'Регионы',
          '/cron/raiting_service/' => 'Пересчет рейтинга'
        ),
        'also' => array(
          '/admin/config/',
          '/admin/self_item/Region/',
          '/admin/self_item/Seo/'
        )
      ),
    );

    if ($this->user['is_admin'] == 1) {
      $menu = $this->menu_moderator;
    }

    $this->set("menu", $menu);

    $auth = false;

    if ($this->user) {
      $auth = $this->User->findById($this->user['id']);
      $auth = $auth['User'];
    }

    $this->set("auth", $auth);
    $this->set("languages", $this->languages);
  }
}
