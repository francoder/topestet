<?php

class ServiceController extends AppController
{
    public $layout = 'index';
    public $allow = [
        'index',
        'info',
        'rate',
        'list_specialist',
        'review',
        'photos',
        'pic',
        'reviews_photos',
        'photo_specialist',
        'all_reviews',
        'price',
        'art',
        'rating',
        'plastica',
        'cosmetology',
    ];
    public $helpers = ['Display'];
    public $components = [
        'Paginator' => [
            'Photospec' => [
                'order' => 'id asc',
                'contain' => ['User', 'Service'],
            ],
        ],
    ];
    public $uses = [
        'Service',
        'Specialization',
        'Review',
        'Region',
        'SpecialistService',
        'Thank',
        'Comment',
        'Photo',
        'Photospec',
        'Rate',
        'ReviewAdd',
        'Question',
        'PostService',
        'Post',
    ];
    public $paginate = [
        'Service' => [
            'contain' => ['Specialization'],
            'conditions' => ['Service.title !=' => ''],
            'order' => ['Service.title' => 'DESC'],
        ],
        'Review' => [
            'order' => 'Review.created DESC, Review.is_adv DESC',
            'limit' => 5,
            'contain' => ['User', 'Region', 'Photo', 'Specialist', 'Service',],
        ],
        'Photospec' => [
            'order' => 'Photospec.created DESC',
            'contain' => 'User',
        ],
    ];

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->fastNav['/service/'] = 'Рейтинг услуг';

        $this->set('review_notes', $this->Review->reviewNotes);

        parent::seoFilter();
        $this->set('last_photos', $l = $this->Photo->find('all',
            ['limit' => 3, 'order' => 'created DESC', 'conditions' => ['is_adult' => 0]]));
    }

    public function index($page = null)
    {
        $alias = isset($this->request->params['alias']) ? $this->request->params['alias'] : null;

        if ($alias !== null) {
            return $this->makeServicePage($alias);
        }

        $specializations = $this->Specialization->find('all',
            [
                'order' => 'id asc',
            ]);

        $services = $this->Service->find('all', [
            'contain' => ['Specialization'],
            'conditions' => ['Specialization.id' => ['6', '7']],
            'order' => ['Service.title' => 'ASC'],
        ]);

        if (!empty($services)) {
            $this->set('rating_specializations', $specializations);

            if ($this->request->is('post')) {
                $dataOrders = $this->request->data;
                $order = [
                    'Service.title' => 'ASC',
                    'Service.rate' => 'ASC',
                    'Service.coast_avg' => 'ASC',
                    'Service.review_count' => 'ASC',
                ];

                if (!empty($dataOrders)) $order = [];

                foreach ($dataOrders as $key => $value) {
                    $order['Service.' . $key] = 'DESC';
                }

                $services = $this->Service->find('all', [
                    'contain' => ['Specialization', 'Review'],
                    'conditions' => ['Specialization.id' => ['6', '7']],
                    'order' => $order,
                ]);
            }

            $this->set('services', $services);

            if ($this->request->is('ajax')) {
                return $this->render('ajax/rows');
            } else {
                return $this->render('rating');
            }
        } else {
            return $this->error_404();
        }
    }

    public function all_reviews()
    {
        $this->redirect('/reviews/', 301);
        $this->page_title = 'Все отзывы о медицинских услугах';

        $this->fastNav['/service/all_reviews/'] = 'Все отзывы';
        $this->components['Paginator']['Review']['order'] = 'Review.edited DESC';
        $this->setPaginate('reviews', $this->Paginator->paginate('Review'));
    }

    public function plastica($id = null)
    {
        $service = $this->Service->find('first', [
            'conditions' => ['Service.id = ' => $id],
            'contain' => [],
        ]);

        if (!empty($service)) {
            return $this->redirect('/service/' . $service['Service']['alias'], 301);
        }

        return $this->error_404();
    }

    public function cosmetology($id = null)
    {
        $service = $this->Service->find('first', [
            'conditions' => ['Service.id = ' => $id],
            'contain' => [],
        ]);

        if (!empty($service)) {
            return $this->redirect('/service/' . $service['Service']['alias'], 301);
        }

        return $this->error_404();
    }

    function info($alias)
    {
        $service = $this->Service->find('first',
            [
                'conditions' => [
                    'Service.alias' => $alias,
                ],
                'contain' => 'Specialization',
            ]
        );
        if (empty($service)) {
            return $this->error_404();
        }
        return $this->redirect('/reviews/' . $service['Specialization']['alias'] . '/' . $alias . '/', 301);
    }

    function rate()
    {
        return $this->index();
    }

    function add_review()
    {
        $this->redirect('/reviews/add_review/', 301);
    }

    function list_specialist($is_specialist = 1)
    {
        $request = $_GET['search'];

        if (!empty($request)) {

            $conditions['is_specialist'] = $is_specialist;
            $conditions['name LIKE'] = "%{$_GET['search']}%";

            if (!empty($_GET['service_id'])) {
                $specialists = $this->SpecialistService->find('list',
                    [
                        'fields' => 'user_id',
                        'conditions' => ['service_id' => $_GET['service_id']],
                    ]);
                $conditions['id'] = $specialists;
            }

            echo json_encode($this->User->find('list', ['conditions' => $conditions]));
        }

        exit();
    }

    function review($review_id)
    {
        $this->redirect('/reviews/' . $review_id . '/');
    }

    function review_thanks($review_id)
    {
        $review = $this->Review->find('first',
            ['conditions' => ['Review.id' => $review_id, 'Review.user_id <>' => $this->user['id']]]);

        if (empty($review)) {
            return $this->error_404();
        }

        $check = $this->Thank->find('count',
            ['conditions' => ['user_id' => $this->user['id'], 'review_id' => $review_id]]);

        if ($check == 0 || $this->user['is_admin']) {
            $this->Thank->save(['Thank' => ['user_id' => $this->user['id'], 'review_id' => $review_id]]);
        }

        if ($this->request->is('ajax')) {
            echo json_encode(['ok' => 1]);
            exit();
        } else {
            return $this->redirect($this->referer());
        }
    }

    function reviews_photos($alias)
    {
        $service = $this->Service->find('first',
            ['conditions' => ['Service.alias' => $alias], 'contain' => 'Specialization']);

        if (empty($service)) {
            return $this->error_404();
        }

        $filters = $this->User->getFilters($service['Service']['id'], ['photo_count >' => 0]);
        $review_conditions = ['service_id' => $service['Service']['id']];

        //фильтры
        $users_id_s = array_unique($this->Review->find('list',
            ['conditions' => ['service_id' => $service['Service']['id']], 'fields' => 'user_id']));

        if (!empty($_GET['sex'])) {
            $users_id = $this->User->find('list',
                ['conditions' => ['id' => $users_id_s, 'sex' => $_GET['sex']], 'fields' => 'id']);
            $review_conditions['user_id'] = $users_id;
        }

        if (!empty($_GET['age'])) {

            $cond_age = [];

            foreach ($_GET['age'] as $age) {
                if (key_exists($age, $filters['age']['values'])) {
                    $ages = explode('-', $age);
                    $cond_age['OR'][] = [
                        'age >=' => $ages[0],
                        'age <=' => $ages[1],
                    ];
                }
            }

            if (!empty($cond_age)) {

                $cond_age['id'] = $users_id_s;
                $users_id = $this->User->find('list', ['conditions' => $cond_age, 'fields' => 'id']);

                if (isset($review_conditions['user_id'])) {
                    $review_conditions['user_id'] = array_intersect($review_conditions['user_id'], $users_id);
                }
            }
        }

        $review_ids = $this->Review->find('list', ['fields' => 'id', 'conditions' => $review_conditions]);

        $this->fastNav["/service/info/{$service['Service']['alias']}/"] = $service['Service']['title'];
        $this->fastNav["/service/photo/{$service['Service']['alias']}/"] = 'Фотографии до и после';
        $this->fastNav["/service/reviews_photos/{$service['Service']['alias']}/"] = 'Фотографии из отзывов пользователей';

        $this->set('service', $service);
        $this->setPaginate('photos',
            $this->Paginator->paginate('Photo', ['parent_id' => $review_ids, 'alias' => 'review']));
        $this->set('filters', $filters);
    }

    function pic($photo_id)
    {
        $photo = $this->Photospec->find('first',
            ['conditions' => ['Photospec.id' => $photo_id], 'contain' => ['User', 'Service']]);

        if (empty($photo)) {
            return $this->error_404();
        }

        $this->fastNav["/service/info/{$photo['Service']['alias']}/"] = $photo['Service']['title'];
        $this->fastNav["/service/photo/{$photo['Service']['alias']}/"] = 'Фотографии до и после';
        $this->fastNav["/service/pic/{$photo['Photospec']['id']}/"] = 'Изображение';

        $this->page_description = $photo['Photospec']['content'];

        $voted = false;

        if ($this->user) {

            $voted = $this->Rate->find('first',
                [
                    'conditions' => [
                        'parent_id' => $photo_id,
                        'user_id' => $this->user['id'],
                        'parent_model' => 'Photospec',
                    ],
                ]);

            if ($voted) {
                $voted = $voted['Rate']['note'];
            }
        }

        $this->set('photo', $photo);
        $this->set('voted', $voted);
        $this->set('nav',
            $this->Photospec->find('neighbors',
                [
                    'field' => 'id',
                    'value' => $photo['Photospec']['id'],
                    'order' => 'Photospec.created DESC',
                    'conditions' => ['service_id' => $photo['Photospec']['service_id']],
                ]));

        $this->set('last_reviews_title', 'Последние отзывы ' . $photo['Service']['title_prepositional']);
        $this->set('last_reviews',
            $this->Review->find('all',
                [
                    'order' => 'edited desc', 'limit' => 3,
                    'conditions' => ['service_id' => $photo['Service']['id']],
                ]));
        $this->set('last_responses_title', 'Последние вопросы ' . $photo['Service']['title_prepositional']);
        $this->set('last_responses',
            $this->Response->getLast([
                'question_id' => $this->Question->find('list',
                    [
                        'conditions' => ['service_id' => $photo['Service']['id']],
                        'fields' => ['id'],
                    ]),
            ]));
        $this->set('best_reviews_title', 'Лучшие отзывы ' . $photo['Service']['title_prepositional']);
        $this->set('best_reviews', $this->Review->find('all',
            [
                'order' => 'thank_all_count desc',
                'limit' => 3,
                'conditions' => ['service_id' => $photo['Service']['id'], 'thank_all_count >' => 0],
                'contain' => ['User', 'Region'],
            ]));
    }

    function photos()
    {
        $this->layout = 'fullWidthInner';
        $this->Paginator->options = $this->paginate;
        $alias = $this->params['alias'];
        $service = $this->Service->find('first',
            ['conditions' => ['Service.alias' => $alias], 'contain' => 'Specialization']);

        if (empty($service)) {
            return $this->error_404();
        }

        $this->fastNav["/service/info/{$service['Service']['alias']}/"] = $service['Service']['title'];
        $this->fastNav["/service/photos/{$service['Service']['alias']}/"] = 'Фотографии до и после';

        if ($this->user) {
            $this->set('permision',
                $this->SpecialistService->find('count',
                    [
                        'conditions' => [
                            'user_id' => $this->user['id'],
                            'service_id' => $service['Service']['id'],
                        ],
                    ]));
        }

        $this->setPaginate('photos', $this->Paginator->paginate('Photospec', ['service_id' => $service['Service']['id']]));
        $this->set('service', $service);

        $this->set('last_responses_title', 'Последние вопросы ' . $service['Service']['title_prepositional']);
        $this->set('last_responses',
            $this->Response->getLast([
                'question_id' => $this->Question->find('list',
                    [
                        'conditions' => ['service_id' => $service['Service']['id']],
                        'fields' => ['id'],
                    ]),
            ]));
        $this->set('best_reviews_title', 'Лучшие отзывы ' . $service['Service']['title_prepositional']);
        $this->set('best_reviews', $this->Review->find('all',
            [
                'order' => 'thank_count desc',
                'limit' => 3,
                'conditions' => ['service_id' => $service['Service']['id'], 'thank_count >' => 0],
                'contain' => ['User', 'Region'],
            ]));
        $this->set('best_specialists', $this->SpecialistService->find('all', [
            'limit' => $this->configs['best_specialists_cnt'],
            'conditions' => [
                'service_id' => $service['Service']['id'],
            ],
            'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
            'contain' => 'User',
        ])
        );
    }

    function photo_add($service_id)
    {
        $service = $this->Service->find('first', ['conditions' => ['id' => $service_id]]);

        if (empty($service)) {
            return $this->error_404();
        }

        if ($this->SpecialistService->find('count',
                ['conditions' => ['user_id' => $this->user['id'], 'service_id' => $service['Service']['id']]]) == 0
        ) {
            return $this->error_404();
        }

        if ($this->request->is('post')) {

            $data = $this->data;
            $data['Photospec']['service_id'] = $service_id;
            $data['Photospec']['user_id'] = $this->user['id'];

            if ($data['Photospec']['type'] == 1) {

                unset($data['Photospec']['before']);
                unset($data['Photospec']['after']);
                unset($this->Photospec->validate['before']);
                unset($this->Photospec->validate['after']);
            } else {
                unset($data['Photospec']['both']);
                unset($this->Photospec->validate['both']);
            }

            if ($this->Photospec->save($data)) {

                $this->set('done', true);
                $this->set('photospec_id', $this->Photospec->id);
            }
        }

        $this->set('service', $service);
    }

    function photo_specialist($specialist_id)
    {
        $this->layout = 'fullWidthInner';
        $specialist = $this->User->find('first',
            [
                'conditions' => [
                    'id' => $specialist_id,
                    'is_specialist' => 1
                ]
            ]
        );

        if (empty($specialist)) {
            return $this->error_404();
        }

        $this->fastNav['/catalog/'] = 'Каталог специалистов';
        $this->fastNav["/specialist/profile/{$specialist['User']['id']}/"] = $specialist['User']['name'];
        $this->fastNav["/service/photo_specialist/{$specialist['User']['id']}/"] = 'Фотографии &laquo;до&raquo; и &laquo;после&raquo;';

        $this->setPaginate('photos', $this->Paginator->paginate('Photospec', ['user_id' => $specialist_id]));
        $this->set('specialist', $specialist);
    }

    function vote_photo($photo_id, $note)
    {
        $data['user_id'] = $this->user['id'];
        $data['parent_id'] = $photo_id;
        $data['parent_model'] = 'Photospec';

        if ($this->Rate->find('count', ['conditions' => $data]) == 0 || $this->user['is_admin']) {

            $data['note'] = ($note == 1) ? 1 : -1;
            $this->Rate->save(['Rate' => $data]);

            $photospec = $this->Photospec->find('first', ['conditions' => ['id' => $photo_id]]);
            $result = ['count' => $photospec['Photospec']['rate'], 'note' => $note];
        } else {
            $result = ['error' => 1];
        }

        if ($this->request->is('ajax')) {

            if (isset($_GET['id'])) {
                $result['id'] = $_GET['id'];
            }

            echo json_encode($result);
            exit();
        } else {
            return $this->redirect($this->referer());
        }
    }

    function review_add($review_id)
    {
        $review = $this->Review->find('first',
            [
                'conditions' => ['Review.id' => $review_id, 'user_id' => $this->user['id']],
                'contain' => ['Service', 'ReviewAdd', 'Photo'],
            ]);

        if (empty($review)) {
            return $this->error_404();
        }

        if ($this->data) {

            $data = $this->data;
            $data['Review'] = array_merge($review['Review'], $this->data['Review']);
            unset($data['Review']['updated']);
            unset($data['Review']['created']);
            unset($this->Review->validate['description']);
            $data['Review']['edited'] = date('Y-m-d H:i:s');

            foreach ($data['Photo'] as $i => $photo) {

                if (empty($photo['picture']['tmp_name'])) {
                    unset($data['Photo'][$i]);
                }
            }

            if (empty($data['Photo'])) {
                unset($data['Photo']);
            }

            if ($this->Review->saveAssociated($data, ['validate' => 'first'])) {
                $this->set('done', true);
            }
        } else {
            $this->data = $review;
        }

        $this->fastNav["/service/info/{$review['Service']['alias']}/"] = $review['Service']['title'];
        $this->fastNav["/service/review/{$review['Review']['id']}/"] = 'Ваш отзыв';
        $this->fastNav["/service/review_add/{$review['Review']['id']}/"] = 'Дополнить отзыв';

        $this->set('service', $review);
        $this->set('review', $review);
    }

    function review_edit($review_id)
    {
        $review = $this->Review->find('first',
            [
                'conditions' => [
                    'Review.id' => $review_id,
                    'user_id' => $this->user['id'],
                    'DATE_ADD(`Review`.`created`, INTERVAL 30 MINUTE) > NOW()',
                ],
                'contain' => ['Service', 'Photo'],
            ]);

        if (empty($review)) {

            if ($this->user && $this->user['is_admin']) {
                $review = $this->Review->find('first',
                    ['conditions' => ['Review.id' => $review_id], 'contain' => ['Service', 'Photo']]);
            } else {
                return $this->error_404();
            }
        }

        $this->fastNav["/service/info/{$review['Service']['alias']}/"] = $review['Service']['title'];
        $this->fastNav["/service/review/{$review['Review']['id']}/"] = $review['Review']['subject'];
        $this->fastNav["/service/review_edit/{$review['Review']['id']}/"] = 'Редактирование';

        if ($this->data) {

            $data = $this->data;
            $data['Review']['id'] = $review_id;
            $data['Review']['coast'] = str_replace(' ', '', $data['Review']['coast']);
            $data['Review']['edited'] = date('Y-m-d H:i:s');

            foreach ($data['Photo'] as $i => $photo) {
                if (empty($photo['picture']['tmp_name'])) {
                    unset($data['Photo'][$i]);
                }
            }

            if ($this->Review->saveAssociated($data)) {
                $this->set('done', true);
                $this->set('review_id', $this->Review->id);
            }
        } else {
            $this->data = ['Review' => $review['Review'], 'Photo' => $review['Photo']];
        }

        $this->set('regions', $this->Region->getList());
        $this->set('services', $this->Service->getListWithSpec());
        $this->set('edit', true);
        $this->layout = 'index';
        $this->render('add_review');
    }

    function comment_del($comment_id)
    {
        if (!$this->user['is_admin']) {
            return $this->error_404();
        }
        $this->Comment->delete($comment_id);

        return $this->redirect($this->referer());
    }

    function price($alias)
    {
        $service = $this->Service->find('first', ['conditions' => ['alias' => $alias]]);

        if (empty($service)) {
            return $this->error_404();
        }

        $this->fastNav["/service/info/$alias/"] = $service['Service']['title'];
        $this->fastNav["/service/price/$alias/"] = 'Сколько стоит ' . mb_strtolower($service['Service']['title'],
                'utf-8') . '?';

        $this->page_title = "Сколько стоит {$service['Service']['title']} – цены";

        $this->page_description = "Стоимость {$service['Service']['title_genitive']} в Москве, Санкт-Петербурге и других городах, средние цены на {$service['Service']['title_accusative']}";

        $price_min = $this->Review->find('first',
            [
                'fields' => '*, min(coast) as min_coast',
                'conditions' => ['service_id' => $service['Service']['id'], 'coast <>' => 0],
            ]);

        if (!empty($price_min[0]['min_coast'])) {
            $this->set('price_min',
                $this->Review->find('first',
                    [
                        'conditions' => [
                            'service_id' => $service['Service']['id'], 'coast' => $price_min[0]['min_coast'],
                        ],
                        'order' => 'Review.created ASC',
                        'contain' => ['Region', 'Specialist'],
                    ]));
        }

        $price_max = $this->Review->find('first',
            [
                'fields' => '*, max(coast) as max_coast',
                'conditions' => ['service_id' => $service['Service']['id'], 'coast <>' => 0],
            ]);

        if (!empty($price_max[0]['max_coast'])) {
            $this->set('price_max',
                $this->Review->find('first',
                    [
                        'conditions' => [
                            'service_id' => $service['Service']['id'], 'coast' => $price_max[0]['max_coast'],
                        ],
                        'order' => 'Review.created ASC',
                        'contain' => ['Region', 'Specialist'],
                    ]));
        }

        $this->set('service', $service);
        $this->set('reviews',
            $this->Review->find('all',
                [
                    'conditions' => ['service_id' => $service['Service']['id']],
                    'limit' => 10,
                    'order' => 'edited DESC',
                ]));
        $this->set('best_specialists', $this->SpecialistService->find('all', [
            'limit' => $this->configs['best_specialists_cnt'],
            'conditions' => [
                'service_id' => $service['Service']['id'],
            ],
            'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
            'contain' => 'User',
        ])
        );
    }

    function comment_edit()
    {
        if (!$this->user['is_admin']) {
            return $this->error_404();
        }

        if ($this->data) {
            $this->Comment->save($this->data);
        }

        return $this->redirect($this->referer());
    }

    function art($service_alias)
    {
        $service = $this->Service->find('first',
            ['conditions' => ['Service.alias' => $service_alias], 'contain' => 'Specialization']);
        if (empty($service)) {
            return $this->error_404();
        }

        $this->page_title = 'Новости и статьи ' . $service['Service']['title_prepositional'];

        $ids = $this->PostService->find('list',
            ['fields' => 'post_id', 'conditions' => ['service_id' => $service['Service']['id']]]);
        $this->set('best_specialists', $this->SpecialistService->find('all', [
            'limit' => $this->configs['best_specialists_cnt'],
            'conditions' => [
                'service_id' => $service['Service']['id'],
            ],
            'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
            'contain' => 'User',
        ])
        );
        $this->set('entries', $this->paginate('Post', ['Post.id' => $ids]));
        $this->set('service', $service);
    }

    function rating($alias)
    {
        $service = $this->Service->find('first', [
            'conditions' => ['Service.alias' => $alias, 'Service.is_child' => false],
            'contain' => ['Parent', 'Specialization'],
        ]);
        if (empty($service)) {
            return $this->error_404();
        }

        $this->set('specialists', $this->SpecialistService->find('all', [
            'limit' => 15,
            'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
            'conditions' => [
                'SpecialistService.rating >' => 0,
                'service_id' => $service['Service']['id'],
            ],
            'contain' => ['User'],
        ]));
        if (empty($service)) {
            return $this->error_404();
        }
        $this->set('service', $service);
    }

    private function makeServicePage(
        $alias = null
    )
    {
        if (!empty($alias)) {
            $service = $this->Service->find('first', [
                'conditions' => ['Service.alias = ' => $alias],
                'contain' => ['Photospec', 'Specialization', 'Review'],
            ]);

            if (empty($service)) {
                $specializations = $this->Specialization->find('all',
                    [
                        'order' => 'id asc',
                    ]);

                $services = $this->Service->find('all', [
                    'contain' => ['Specialization'],
                    'conditions' => ['Specialization.alias = ' => $alias],
                    'order' => ['Service.title' => 'ASC'],
                ]);

                $log = $this->Service->getDataSource()->getLog(false, false);

                //Debugger::dump($log);

                if (!empty($services)) {
                    $this->set('rating_specializations', $specializations);

                    if ($this->request->is('post')) {
                        $dataOrders = $this->request->data;
                        $order = [
                            'Service.title' => 'ASC',
                            'Service.rate' => 'ASC',
                            'Service.coast_avg' => 'ASC',
                            'Service.review_count' => 'ASC',
                        ];

                        if (!empty($dataOrders)) $order = [];

                        foreach ($dataOrders as $key => $value) {
                            $order['Service.' . $key] = 'DESC';
                        }

                        $services = $this->Service->find('all', [
                            'contain' => ['Specialization', 'Review'],
                            'conditions' => ['Specialization.alias = ' => $alias],
                            'order' => $order,
                        ]);
                    }

                    $this->set('services', $services);

                    if ($this->request->is('ajax')) {
                        return $this->render('ajax/rows');
                    } else {
                        return $this->render('rating');
                    }
                } else {
                    $service = $this->Service->find('first', [
                        'conditions' => ['Service.id = ' => $alias],
                        'contain' => [],
                    ]);

                    if (!empty($service)) {
                        return $this->redirect('/service/' . $service['Service']['alias'], 301);
                    }
                    return $this->error_404();
                }
            }

            $this->page_title = $service['Service']['title'];

            $this->set('service', $service);
        }

        $specialization = $this->Specialization->find('first', [
            'conditions' => ['id' => $service['Service']['specialization_id']],
        ]);

        $this->page_title = $specialization['Specialization']['title'];

        $this->set('specialization', $specialization);

        $this->set(
            'reviews',
            $this->paginate(
                'Review',
                [
                    'Service.alias =' => $alias,
                ]
            )
        );

        $this->set('last_interest', $this->Post->find('all', [
            'contain' => [
                'PostCategory' => [
                    'conditions' => ['PostCategory.alias' => 'star'],
                ],
            ],
            'limit' => 5,
        ]));

        $joins = [
            [
                'table' => 'specialist_services',
                'alias' => 'SpecialistService',
                'type' => 'INNER',
                'conditions' => [
                    'SpecialistService.user_id = User.id',
                    'SpecialistService.service_id' => $service['Service']['id'],
                ],
            ],
            [
                'table' => 'services',
                'alias' => 'Service',
                'type' => 'INNER',
                'conditions' => ['Service.id = SpecialistService.service_id',],
            ],
        ];

        $bestForService = $this->User->find('all', [
                'limit' => 6,
                'conditions' => ['User.rate >=' => 5, 'User.is_specialist =' => 1],
                'contain' => [
                    'Clinic',
                ],
                'joins' => $joins,
            ]
        );

        $averageCost = $this->User->find('all', [
                'limit' => 3,
                'conditions' => ['is_specialist =' => 2,],
                'contain' => [
                    'Service' => [
                        'order' => 'Service.coast_avg DESC',
                        'conditions' => ['Service.id' => $service['Service']['id']],
                    ],
                ],
            ]
        );

        $this->set('average_cost', $averageCost);

        $this->set('best_for_service', $bestForService);
        $this->set('alias', $alias);

        $this->set('last_reviews', $this->Review->find('all',
            [
                'order' => 'Review.edited desc',
                'limit' => 3,
                'contain' => ['Region', 'User', 'Specialist'],
                'conditions' => ['Review.specialist_id !=' => null],
            ]));

        $this->set('top_services',
            $this->Service->find('all', [
                'order' => 'review_count DESC, Service.title',
                'limit' => 21,
                'contain' => ['Specialization'],
            ])
        );

        return $this->render('index');
    }
}

