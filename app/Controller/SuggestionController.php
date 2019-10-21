<?php

class SuggestionController extends AppController
{
    public $layout = 'fullWidthInner';
    public $allow = '*';
    public $helpers = ['Display'];
    public $uses = ['Page', 'Post', 'Region', 'SpecialistService', 'Service', 'Specialization', 'Comment'];
    public $paginate = [
        'User' => [
            'limit' => 15,
            'order' => 'User.is_adv DESC, User.name',
        ],
        'SpecialistService' => [
            'limit' => 15,
        ],
    ];
    public $components = [
        'Paginator' => [
            'Comment' => [
                'limit' => 10,
                'order' => 'Comment.created ASC',
                'contain' => ['User'],
                'parent_id' => null,
            ],
            'User' => [
                'limit' => 2,
                'order' => 'User.is_adv DESC, User.name',
            ],
        ],
    ];

    private static function mbUcfirst($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }

    function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->params['type'] == 'clinics') {
            $this->fastNav['/catalog/clinic'] = 'Каталог клиник';
        } else {
            $this->fastNav['/catalog/'] = 'Каталог специалистов';
        }

        parent::seoFilter();

        $parts = explode('/', $this->here);
        if ($parts[2] == 'clinics') {
            return $this->redirect(str_replace('/clinics/', '/clinic/', $this->here));
        }
    }

    public function specialist()
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_GET['search_string'])) {
            echo json_encode([]);
            exit();
        }

        $searchString = $_GET['search_string'];
        if (!empty($searchString)) {

            $conditions['is_specialist'] = 1;
            $conditions['name LIKE'] = "%{$searchString}%";

            if (!empty($_GET['service_id'])) {
                $specialists = $this->SpecialistService->find('list',
                    [
                        'fields' => 'user_id',
                        'limit' => 10,
                    ]);
                $conditions['id'] = $specialists;
            }

            echo json_encode($this->User->find('list', ['conditions' => $conditions]), JSON_UNESCAPED_UNICODE);
        }

        exit();
    }

    public function clinic()
    {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_GET['search_string'])) {
            echo json_encode([]);
            exit();
        }

        $searchString = $_GET['search_string'];
        if (!empty($searchString)) {

            $conditions['is_specialist'] = 2;
            $conditions['name LIKE'] = "%{$searchString}%";

            if (!empty($_GET['service_id'])) {
                $specialists = $this->SpecialistService->find('list',
                    [
                        'fields' => 'user_id',
                        'limit' => 10,
                    ]);
                $conditions['id'] = $specialists;
            }

            echo json_encode($this->User->find('list', ['conditions' => $conditions]), JSON_UNESCAPED_UNICODE);
        }

        exit();
    }

    public function region()
    {
        header('Content-Type: application/json; charset=utf-8');

        $searchString = $_GET['search_string'];

        $conditions['title LIKE'] = "%{$searchString}%";
        $conditions['parent_id <>'] = null;
        $conditions['child_count'] = 0;

        echo json_encode($this->Region->find(
            'list',
            [
                'limit' => 10,
                'conditions' => $conditions
            ]
        ), JSON_UNESCAPED_UNICODE);

        exit();
    }

    public function service()
    {
        header('Content-Type: application/json; charset=utf-8');

        $searchString = $_GET['search_string'];

        $conditions['title LIKE'] = "%{$searchString}%";
        $conditions['title <>'] = '';

        echo json_encode($this->Service->find(
            'list',
            [
                'limit' => 10,
                'conditions' => $conditions
            ]
        ), JSON_UNESCAPED_UNICODE);

        exit();
    }
}
