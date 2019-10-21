<?php

class AppController extends Controller
{
    public $uses = [
        'User',
        'Page',
        'Config',
        'Info',
        'Seo',
        'Show',
        'Message',
        'Review',
        'Response',
        'Block',
        'SpecialistClinic',
        'Specialization',
        'Question',
    ];
    public $components = [
        'Auth' => [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'User',
                    'fields' => [
                        'username' => 'mail',
                        'password' => 'password',
                    ],
                ],
            ],
        ],
        'Cookie',
        'Session',
        'Paginator',
    ];
    public $validate = [
        'username' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'A username is required',
            ],
        ],
        'password' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'A password is required',
            ],
        ],
        'role' => [
            'valid' => [
                'rule' => ['inList', ['admin', 'author']],
                'message' => 'Please enter a valid role',
                'allowEmpty' => false,
            ],
        ],
    ];
    public $page_title;
    public $page_keywords;
    public $page_description;
    public $fastNav = ['/' => 'Главная'];
    public $allowed_named = ['page', 'specialization', 'specialist', 'service'];

    function beforeFilter()
    {
        //наличие слеша
        if (substr($this->here, -1, 1) != '/') {
            return $this->redirect($this->here . '/', 301);
        }

        //настройки
        $c = $this->Config->find('list', ['fields' => 'name, value']);
        $this->configs = $c;
        $this->set('global_configs', $c);
        foreach ($this->uses as $model) {
            $this->{$model}->configs = $c;
        }

        $this->Paginator->settings = $this->paginate;

        $this->User->virtualFields['is_top'] = str_replace('%top_response_count%', $this->configs['top_response_count'],
            $this->User->virtualFields['is_top']);
        $this->User->virtualFields['is_top'] = str_replace('%top_exnote_count%', $this->configs['top_exnote_count'],
            $this->User->virtualFields['is_top']);

        $this->Page->query('SET SQL_BIG_SELECTS=1');

        $this->Cookie->time = '1 Month';

        //авторизация
        $this->Auth->loginAction = ['admin' => false, 'controller' => 'user', 'action' => 'login'];
        $this->Auth->loginError = __('Неправильная пара логин/пароль');
        $this->Auth->authError = __('Необходимо авторизоваться');

        if (!empty($this->allow) && is_array($this->allow)) {
            $this->Auth->allow($this->allow);
        } else if (!empty($this->allow) && $this->allow == '*') {
            $this->Auth->allow();
        }
        $this->user = false;

        if (!$this->Auth->user()) {

            if ($this->Cookie->read('remember_id')) {

                $remember_id = $this->Cookie->read('remember_id');

                $remember_check = $this->Cookie->read('remember_check');

                $check = $this->User->findById($remember_id);

                if (md5($check['User']['id'] . $check['User']['mail'] . $_SERVER['SERVER_NAME']) == $remember_check) {
                    $this->Auth->login($check['User']);
                }
            }
        }

        if ($this->Auth->user()) {

            $this->user = $this->User->findById($this->Auth->user('id'));
            $this->user = $this->user['User'];

            if (!empty($this->user['id'])) {

                $this->User->id = $this->user['id'];
                $this->User->saveField('was', date('Y-m-d H:i:s'));
            }
        }

        foreach ($this->uses as $model) {

            $this->{$model}->languages = $this->languages;
            $this->{$model}->auth = $this->user;
        }

        //просмотры страниц
        if ($this->params['controller'] != 'admin') {

            $data = [];

            if ($page = $this->Show->findByUrl($this->here)) {

                $data['id'] = $page['Show']['id'];
                $data['count'] = $page['Show']['count'] + 1;
            } else {
                $data['count'] = 1;
            }

            $data['url'] = $this->here;

            $this->Show->save(['Show' => $data]);
        }

        $this->page_title = 'Медицина';

        //последние вопросы, ответы
        $this->set('last_reviews_title', 'Последние отзывы');
        $this->set('last_reviews', $this->Review->find('all', [
            'limit' => 3,
            'order' => 'edited DESC',
            'contain' => ['Specialist', 'User'],
            'conditions' => ['Review.specialist_id !=' => null],
        ]));

        $this->set('last_responses_title', 'Последние ответы');
        $this->set('last_responses', $this->Response->getLast());

        $this->set('best_reviews_title', 'Лучшие отзывы');
        $this->set('best_reviews', $this->Review->find('all', [
            'order' => 'thank_all_count desc',
            'limit' => 3,
            'conditions' => ['thank_all_count >' => 0],
            'contain' => ['User', 'Region'],
        ]));
    }

    function beforeRender()
    {
        if ($this->Auth->user()) {

            $this->user = $this->Auth->user();
            $this->user = $this->User->findById($this->user['id']);
            $this->user = $this->user['User'];
        }

        $this->set('auth', $this->user);

        if ($this->params['controller'] != 'admin') {
            $this->set('page_links',
                $this->Page->find('list', ['fields' => 'alias, title_short', 'conditions' => ['is_link' => 1]]));
        }

        if ($this->request->is('ajax')) {
            $this->layout = false;
        }

        //seo
        $seo_url = preg_replace('#(\/page:\d\/)#', '/', $this->here);
        $seo_url = preg_replace('/index\/$/', '', $seo_url);
        $seo = $this->Seo->findByUrl($seo_url);

        if (!empty($seo)) {

            $this->page_title = $seo['Seo']['title'];
            $this->page_description = $seo['Seo']['description'];
            $this->page_keywords = $seo['Seo']['keywords'];
        }

        if (isset($this->request->params['named']['page']) &&
            1 < $this->request->params['named']['page']) {

            $this->page_title .= " - страница {$this->request->params['named']['page']}";
        }

        if (!empty($this->page_title)) {
            $this->set('title_for_layout', $this->page_title);
        }

        if (!empty($this->page_keywords)) {
            $this->set('page_keywords', $this->page_keywords);
        }

        if (!empty($this->page_description)) {
            $this->set('page_description', $this->page_description);
        }

        if ($this->user) {
            //новые сообщения
            $this->set('new_messages_count', $this->Message->find('count', [
                'conditions' => [
                    'user_id' => $this->user['id'],
                    'read' => 0,
                ],
            ]));
        }

        $this->set('is_ajax', $this->request->is('ajax'));

        //$this->set("menu_pages", $this->Page->find("list",array("fields" => array("alias", "title_short"), "conditions" => array("is_link" => 1))));
        $this->set('fast_nav', $this->fastNav);

        //$this->set("info_banners", $this->Info->find("all", array("conditions" => array("is_hidden" => 0))));

        $bannerReviews = $this->Review->find('all', [
            'limit' => 6,
            'conditions' => ['Review.service_id != ' => null],
            'contain' => [
                'Service' => [
                    'fields' => 'title, alias',
                ],
            ],
        ]);

        $this->set('page_show', $this->Show->find('first', ['conditions' => ['url' => $this->here]]));
        $this->set('text_block', $this->Block->find('first',
            ['conditions' => ['controller' => $this->params['controller'], 'action' => $this->params['action']]]));
        $this->set('top_specialists', $this->User->getTopSpecialist());
        $specs = $this->User->getTopSpecialist();
        $totalSpecialistAll = [];
        $aggdeedCount = 0;
        foreach ($specs as $spec) {
            $clinic = $this->SpecialistClinic->find('first', [
                'contain' => ['Clinic'],
                'conditions' => [
                    'specialist_id' => $spec['User']['id'],
                ],
                'order' => 'Clinic.name',
            ]);
            if (($aggdeedCount >= 9) || !isset($clinic['Clinic'])) {
                continue;
            }
            $spec['Clinic'] = $clinic['Clinic'];
            $totalSpecialistAll[] = $spec;
            $aggdeedCount++;
        }
//        array_push($totalSpecialistAll, $top);
        $this->set('top_specialists_all', $totalSpecialistAll);

        $specialization = $this->Specialization->find('all');
        $this->set('specializations', Hash::combine($specialization, '{n}.Specialization.id', '{n}'));
    }

    function error_404()
    {
        throw new NotFoundException(__('Страница не найдена') . '!');
    }

    function seoFilter()
    {

        if ($this->request->params['named']) {

            // Не разрешённые named параметры вызывают Error 404

            foreach ($this->request->params['named'] as $named => $value) {

                if (!in_array($named, $this->allowed_named)) {
                    return $this->error_404();
                }
            }
            // Редирект на первую страницу для многостроничного списка
            if (isset($this->request->params['named']['page']) &&
                1 == $this->request->params['named']['page']) {

                return $this->redirect_301();
            }
        }
    }

    public function redirect_301()
    {
        $url_named = '';

        $named = $this->request->params['named'];

        unset($named['page']);

        foreach ($named as $key => $value) {
            $url_named .= '/' . urlencode($key) . ':' . urlencode($value);
        }

        $url_pass = '';

        foreach ($this->request->params['pass'] as $value) {
            $url_pass .= '/' . urlencode($value);
        }

        $url = $url_pass . $url_named;

        if (empty($url) && 'index' == $this->request->params['action']) {
            $url = "/{$this->request->params['controller']}";
        } else {
            $url = "/{$this->request->params['controller']}/{$this->request->params['action']}/{$url}";
        }

        return $this->redirect($url, 301);
    }

    public function setPaginate($name, $value)
    {
        if (isset($this->request->params['named']['page']) &&
            1 < $this->request->params['named']['page']) {

            if (is_array($value) && !$value) {
                $this->redirect_301();
            }
        }

        $this->set($name, $value);
    }

    public function getUserCity()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $xml = '<ipquery><fields><city/></fields><ip-list>'
            . '<ip>' . $ip . '</ip></ip-list></ipquery>';
        $ch = curl_init('http://194.85.91.253:8090/geo/geo.html');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0) {
            die('curl_errno(' . curl_errno($ch) . '), curl_error(' . curl_error($ch) . ')');
        }
        curl_close($ch);
        if (strpos($result, '<message>Not found</message>') !== false) {
            return false;
        }
        preg_match('/<city>(.*)<\/city>/', $result, $city);

        return iconv('cp1251', 'UTF-8', $city[1]);
    }

    function ajax_response($data)
    {
        echo json_encode($data);
        exit();
    }
}
