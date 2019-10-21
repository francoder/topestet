<?php

class ReviewsController extends AppController
{
    public $layout = 'index';
    public $allow = ['index', 'cosmetology', 'plastica', 'view'];
    public $helpers = ['Display', 'Js' => ['Prototype'],];
    public $components = ['RequestHandler'];
    public $uses = [
        'Region',
        'Service',
        'User',
        'SpecialistService',
        'Review',
        'SpecialistClinic',
        'Clinic',
        'Comment',
        'Photo', 'Service',
        'Specialization',
        'Thank',
        'Photo',
        'Photospec',
        'Rate',
        'ReviewAdd',
        'Question',
        'PostService',
        'Post',
    ];
    public $paginate = [
        'Review' => [
            'limit' => 1,
            'contain' => ['User', 'Region', 'Service', 'Clinic', 'Photo'],
        ],
        'Comment' => [
            'limit' => 50,
            'order' => 'Comment.created ASC',
            'contain' => ['User'],
        ],
    ];

    public function index()
    {
        $this->reviewCatalogLogic(null, null);
    }

    public function cosmetology($serviceAlias = null)
    {
        $this->reviewCatalogLogic('cosmetology', $serviceAlias);
        return $this->render('index');
    }

    public function plastica($serviceAlias = null)
    {
        $this->reviewCatalogLogic('plastica', $serviceAlias);
        return $this->render('index');
    }

    public function view($id = null)
    {
        $this->autoRender = false;
        $this->RequestHandler->addInputType('json', ['json_decode', true]);

        // Добавление коммента
        if ($this->request->is('post')) {
            try {
                $data = $this->request->data;

                $entity = $this->Comment->save($data);

                if ($entity) {
                    return json_encode([
                        'error' => 'false',
                        'message' => "<span style='color: green'>Комментарий успешщно добавлен</span>",
                        'redirect' => $this->referer(),
                    ]);
                } else {
                    return json_encode([
                        'error' => 'true',
                        'message' => "<span style='color: red'>Ошибка сохранения комментария!</span>",
                        'redirect' => $this->referer(),
                    ]);
                }
            } catch (Exception $e) {
                return json_encode([
                    'error' => 'true',
                    'message' => "<span style='color: red'>" . $e->getMessage() . '</span>',
                    'redirect' => $this->referer(),
                ]);
            }
        }

        $review = $this->Review->find('first', [
            'contain' => [
                'User',
                'Specialist',
                'Clinic',
                'Service',
                'Region',
                'Photo',
                'ReviewAdd' => ['limit' => 1],
            ],
            'conditions' => ['Review.id' => $id],
        ]);

        $photos = $this->Photo->find('all', [
            'conditions' => ['Photo.parent_id' => $id],
        ]);

        if (empty($review)) {
            return $this->error_404();
        }

        $comments = $this->paginate('Comment', [
            'belongs_id' => $id,
            'belongs' => 'Review',
        ]);

        $this->set('review', $review);
        $pageTitle = $review['Review']['subject'] . ' - отзыв';
        if ($review['Review']['specialist_name'] !== null && $review['Review']['specialist_name'] !== '') {
            $pageTitle .= ' о специалисте ' . $review['Review']['specialist_name'];
        }
        $this->page_title = $pageTitle;

        $reviewBy = '';
        $reviewBy .= isset($review['Service']['title_prepositional'])
            ? $review['Service']['title_prepositional'] . ' ' : '';

        $byPrefix = $reviewBy === '' ? 'о ' : 'от ';
        if (isset($review['Review']['specialist_name'])) {
            $reviewBy .=  $byPrefix. $review['Review']['specialist_name'];
        } else if (isset($review['Review']['clinic_name'])) {
            $reviewBy .= $byPrefix . $review['Review']['clinic_name'];
        }

        if (isset($review['Region']['title_genitive'])) {
            $reviewBy .= ' в ' . $review['Region']['title_genitive'];
        }

        if ($reviewBy !== '') {
            $reviewBy = 'Отзыв ' . $reviewBy;
        }

        $this->page_description = "{$review['Review']['subject']}. {$reviewBy}";

        $this->set('comments', $comments);

        $this->set('photos', $photos);

        $this->render('view');
    }

    public function add_review()
    {
//        var_dump($this->params['named']);
        $this->fastNav['/reviews/add_review/'] = 'Новый отзыв';
        $this->layout = 'fullWidthInner';

        //если для услуги
        if (!empty($this->params['named']['service'])) {

            $service = $this->Service->findById($this->params['named']['service']);

            if (empty($service)) {
                return $this->error_404();
            }

            $this->set('service', $service);
        }

        //если для специалиста
        $specialist_id = null;

        if (!empty($this->params['named']['specialist'])) {

            $specialist = $this->User->find('first',
                ['conditions' => ['id' => $this->params['named']['specialist'], 'is_specialist' => 1]]);

            if (empty($specialist)) {
                return $this->error_404();
            }

            if (!empty($service)) {

                $check = $this->SpecialistService->find('count',
                    [
                        'conditions' => [
                            'user_id' => $specialist['User']['id'],
                            'service_id' => $service['Service']['id'],
                        ],
                    ]);

                if ($check == 0) {
                    return $this->error_404();
                }
            }
            $specialist_id = $specialist['User']['id'];
            $this->set('specialist', $specialist);
        }

        if (!empty($this->params['named']['clinic'])) {

            $clinic = $this->User->find('first',
                ['conditions' => ['id' => $this->params['named']['clinic'], 'is_specialist' => 2]]);

            if (empty($specialist)) {
                return $this->error_404();
            }

            if (!empty($service)) {

                $check = $this->SpecialistService->find('count',
                    [
                        'conditions' => [
                            'user_id' => $clinic['User']['id'],
                            'service_id' => $service['Service']['id'],
                        ],
                    ]);

                if ($check == 0) {
                    return $this->error_404();
                }
            }
            $clinic_id = $clinic['User']['id'];
            $this->set('clinic', $clinic);
        }

        //добавляем в БД
        if ($this->request->is('post')) {

            $data = $this->request->data;

            if(empty($data['g-recaptcha-response'])) {
                return json_encode([
                    'error' => 'true',
                    'message' => "<span style='color: red'>Вы не заполнили капчу!</span>",
                    'redirect' => $this->referer(),
                ]);
            } else {
                $g_captcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $g_captcha_key = '6LcJD68UAAAAAJzlneAaGCKXF9CqIZNCZsJp8nND';
                $g_query = $g_captcha_url.'?secret='.$g_captcha_key.'&response='.$data['g-recaptcha-response'].
                    '&remoteip='.$_SERVER['REMOTE_ADDR'];
                $g_request = json_decode(file_get_contents($g_query));
                if(false == $g_request->success) {
                    return json_encode([
                        'error' => 'true',
                        'message' => "<span style='color: red'>Вы не прошли капчу!</span>",
                        'redirect' => $this->referer(),
                    ]);
                }
            }

            if (!empty($service)) {
                $data['Review']['service_id'] = $service['Service']['id'];
            }
            if ($data['Review']['service_id'] == 0) {
                unset($data['Review']['service_id']);
            }

            $data['Review']['user_id'] = $this->user['id'];
            $data['Review']['coast'] = str_replace(' ', '', $data['Review']['coast']);
            $data['Review']['edited'] = date('Y-m-d H:i:s');

            $data['Review']['service_title'] = strip_tags($data['Review']['service_title'], '<br><b>');
            $data['Review']['subject'] = strip_tags($data['Review']['subject'], '<br><b>');
            $data['Review']['description'] = strip_tags($data['Review']['description'], '<br><b>');
            $data['Review']['specialist_name'] = strip_tags($data['Review']['specialist_name'], '<br><b>');
            $data['Review']['comment_note'] = strip_tags($data['Review']['comment_note'], '<br><b>');

            foreach ($data['Photo'] as $i => $photo) {

                if (empty($photo['picture']['tmp_name'])) {
                    unset($data['Photo'][$i]);
                }
            }

            if ($this->Review->saveAssociated($data, ['validate' => 'first'])) {
                $this->set('done', true);
                $this->set('review_id', $this->Review->id);

                return $this->redirect('/reviews/' . $this->Review->id);
            }
        }

        $this->set('services', $this->Service->getListWithSpec($specialist_id));
        $this->set('regions', $this->Region->getList());
    }

    public function add_comment($id = null)
    {

    }

    private function reviewCatalogLogic($specializationAlias = null, $serviceAlias = null)
    {
        $pageTitle = 'Поиск отзывов';
        $h1 = 'Давайте уточним запрос';
        $currentService = null;
        $currentSpecialization = null;
        if ($serviceAlias !== null) {
            $service = $this->Service->find('first',
                [
                    'conditions' => [
                        'Service.alias' => $serviceAlias,
                    ],
                    'contain' => 'Specialization',
                ]
            );
            if (empty($service)) {
                return $this->error_404();
            }
            $currentService = $service['Service'];
            $currentSpecialization = $service['Specialization'];

            $whatDo = $currentService['specialization_id'] === '7' ? 'операции' : 'процедуры';
            $pageTitle = "{$currentService['title_accusative']} отзывы. Негативные и положительные отзывы о {$whatDo} {$currentService['title_accusative']}.";
            $h1 = "{$currentService['title_accusative']} отзывы";
            $this->page_description = "Отрицательные и положительные отзывы {$currentService['title_prepositional']} . Вы можете изучить реальные отзывы, оставленные другими пользователям, а также оставить свой отзыв.";
        } else if ($specializationAlias !== null) {
            $specialization = $this->Specialization->find('first',
                [
                    'conditions' => [
                        'Specialization.alias' => $specializationAlias,
                    ],
                ]
            );
            if (empty($specialization)) {
                return $this->error_404();
            }
            $currentSpecialization = $specialization['Specialization'];
        }

        $this->set('currentSpecialization', $currentSpecialization);
        $this->set('currentService', $currentService);

        $conditions = [];
        $orderFilter = null;

        if ($currentService !== null) {
            $this->set('h1', 'Отзывы ' . $currentService['title_prepositional']);
            $conditions[] = ['Service.id' => $currentService['id']];
        }
        if ($currentSpecialization !== null) {
            $conditions[] = ['Service.specialization_id' => $currentSpecialization['id']];
        }

        $this->Paginator->settings = [
            'limit' => 10,
            'conditions' => $conditions,
            'contain' => ['User', 'Service', 'Photo', 'Clinic', 'Specialist'],
            'order' => $orderFilter === 'comment' ? ['Review.comment_count' => 'DESC'] : ['Review.created' => 'DESC'],
        ];

        $this->set('reviews', $this->paginate('Review'));

        $this->set('last_reviews', $this->Review->find('all',
            ['order' => 'Review.edited desc', 'limit' => 3, 'contain' => ['Region', 'User', 'Specialist']]));

        $servicesConditions = ['title != ' => ''];
        if ($currentSpecialization !== null) {
            $servicesConditions[] = [
                'specialization_id' => $currentSpecialization['id'],
            ];
        }

        $this->set(
            'services',
            $this->Service->find('all', [
                'order' => ['title ASC'],
                'conditions' => $servicesConditions,
            ])
        );

        $this->set(
            'review_specializations',
            $this->Specialization->find('all', [
                'order' => 'id asc',
                'contain' => [
                    'Service' => [
                        'order' => ['Service.title' => 'ASC'],
                    ],
                ],
            ])
        );

        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service'],
                'group' => 'User.id',
                'order' => 'User.rate DESC',
                'limit' => $this->configs['best_specialists_cnt'],
                'conditions' => ['User.rate >= ' => 5, 'is_specialist' => 1],
            ])
        );

        $this->set('specializationsList', $this->Specialization->find('all',
            [
                'order' => ['title' => 'ASC'],
                'field' => [
                    'Service.*',
                ],
                'contain' => [
                    'Service' => ['order' => ['title' => 'ASC']],
                ],
            ])
        );

        $this->set('top_services',
            $this->Service->find('all', [
                'order' => 'review_count DESC, Service.title',
                'limit' => 21,
                'contain' => ['Specialization'],
            ])
        );

        $this->page_title = $pageTitle;
        $this->set('h1', $h1);
    }
}


