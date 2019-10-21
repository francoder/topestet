<?php

class ForumController extends AppController
{
    public $layout = 'index';
    public $allow = [
        'index', 'answer', 'service', 'all', 'response_del', 'without_response', 'cosmetology', 'plastica',
    ];
    public $helpers = ['Display'];
    public $components = ['RequestHandler'];
    public $uses = [
        'Service', 'User', 'Question', 'SpecialistService', 'Review', 'Response', 'Rate', 'Comment', 'Photo', 'Post',
    ];
    public $paginate = [
        'Question' => [
            'limit' => 15,
            'order' => 'Question.is_main DESC, Question.created DESC',
            'contain' => ['User', 'Service'],
        ],
        'User' => [
            'limit' => 10,
            'order' => 'User.response_count DESC',
        ],
        'Comment' => [
            'limit' => 10,
            'order' => 'Comment.created ASC',
            'contain' => ['User'],
            'parent_id' => null,
        ],
    ];

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->set('last_photos', $this->Photo->find('all', [
            'limit' => 3, 'order' => 'created DESC', 'conditions' => ['is_adult' => 0],
        ]));
        parent::seoFilter();
    }

    function index2()
    {
        $this->page_title = 'Вопросы специалистам';

        $this->RequestHandler->addInputType('json', ['json_decode', true]);

        $servicesFilter = null;
        $orderFilter = null;
        $searchTitle = '';

        if ($this->request->is('post')) {
            $servicesFilter = isset($_POST['services']) ? $_POST['services'] : null;
            $orderFilter = isset($_POST['order']) ? $_POST['order'] : null;
            $searchTitle = isset($_POST['title']) ? $_POST['title'] : '';
        }

        if ($this->request->is('get')) {
            $queryParameters = explode('&', htmlspecialchars($this->request->query('services')));
            foreach ($queryParameters as $queryParameter) {
                if (!empty($queryParameter)) {
                    list($key, $value) = explode('=', $queryParameter);
                    $tmpKey = preg_replace('/([amp;%5B%5D])/', '', $key);
                    if ($value && is_numeric($value)) {
                        $servicesFilter[] = $value;
                    } else {
                        $orderFilter = $value;
                    }

                    if ($tmpKey === 'title') {
                        $searchTitle = urldecode($value);
                    }
                }
            }
        }

        if (isset($servicesFilter)) {
            $this->Paginator->settings = [
                'limit' => 10,
                'conditions' => [
                    'Question.service_id in (' . implode(',', $servicesFilter) . ')',
                    'Question.subject like ' => '%' . $searchTitle . '%',
                ],
                'contain' => ['User', 'Service'],
                'order' => $orderFilter === 'comment' ? ['Question.comment_count' => 'DESC'] : ['Question.created' => 'DESC'],
            ];
        } else {
            $this->Paginator->settings = [
                'limit' => 10,
                'contain' => ['User', 'Service'],
                'conditions' => ['Question.subject like ' => '%' . $searchTitle . '%'],
                'order' => $orderFilter === 'comment' ? ['Question.comment_count' => 'DESC'] : ['Question.created' => 'DESC'],
            ];
        }
        $this->set('reviews', $this->paginate('Question'));

        $this->set('last_reviews', $this->Review->find('all',
            ['order' => 'Review.edited desc', 'limit' => 3, 'contain' => ['Region', 'User', 'Specialist']]));

        $specializations = $this->Specialization->find('all',
            [
                'order' => ['title' => 'ASC'],
                'contain' => [
                    'Service' => ['order' => ['title' => 'ASC']],
                ],
            ]);

        $this->set('question_specializations', $specializations);

        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service'],
                'group' => 'User.id',
                'order' => 'User.rate DESC',
                'limit' => $this->configs['best_specialists_cnt'],
                'conditions' => ['User.rate >= ' => 5, 'is_specialist' => 1],
            ])
        );

        if ($this->request->is('ajax')) {
            $this->render('ajax/ajax_results', 'ajax'); // View, Layout
        }

        $useFullArticlesSlider = $this->Post->find(
            'all',
            [
                'contain' => 'PostCategory',
                'limit' => 14,
                'order' => ['Post.comment_count' => 'DESC'],
            ]
        );

        $this->set('useFullArticlesSlider', $useFullArticlesSlider);
    }

    public function index()
    {
        $this->indexLogic(null, null);
    }

    public function cosmetology($serviceAlias = null)
    {
        $this->indexLogic('cosmetology', $serviceAlias);
        return $this->render('index');
    }

    public function plastica($serviceAlias = null)
    {
        $this->indexLogic('plastica', $serviceAlias);
        return $this->render('index');
    }

    public function forum($specializationAlias = null, $serviceAlias = null)
    {
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

        $this->page_title = 'Поиск вопрос и ответов';
        $h1 = 'Давайте уточним запрос';
        $this->set('currentSpecialization', $currentSpecialization);
        $this->set('currentService', $currentService);

        $conditions = [];
        $orderFilter = null;

        if ($currentService !== null) {
            $h1 = 'Вопросы ' . $currentService['title_prepositional'];
            $conditions[] = ['Service.id' => $currentService['id']];
        }
        if ($currentSpecialization !== null) {
            $conditions[] = ['Service.specialization_id' => $currentSpecialization['id']];
        }

        $this->Paginator->settings = [
            'limit' => 10,
            'conditions' => $conditions,
            'contain' => ['Response', 'User', 'Service', 'Photo'],
            'order' => ['Question.created' => 'DESC'],
        ];

        $this->set('questions', $this->paginate('Question'));

        $servicesConditions = ['title != ' => ''];
        if ($currentSpecialization !== null) {
            $servicesConditions['specialization_id'] = $currentSpecialization['id'];
        }
        $this->set(
            'services',
            $this->Service->find('all', [
                'order' => ['title ASC'],
                'conditions' => $servicesConditions,
            ])
        );

        $bestSpecialistConditions = ['is_specialist' => 1];
        if ($currentService !== null) {
            $bestSpecialistConditions['service_id'] = $currentService['id'];
        }
        if ($currentSpecialization !== null) {
            $bestSpecialistConditions['specialization_id'] = $currentSpecialization['id'];
        }
        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service', 'User.Clinic'],
                'group' => 'User.id',
                'order' => 'User.review_count DESC',
                'limit' => $this->configs['best_specialists_cnt'],
                'conditions' => $bestSpecialistConditions,
            ])
        );

        $bestQuestionsCondition = [];
        if ($currentService !== null) {
            $bestQuestionsCondition['Question.service_id'] = $currentService['id'];
        }

        $this->set('last_responses', $this->Response->find('all', [
            'conditions' => $bestQuestionsCondition,
            'limit' => 3,
            'fields' => [
                '*',
            ],
            'order' => 'Response.created DESC',
            'contain' => ['Question'],
        ]));

        $this->set('top_services',
            $this->Service->find('all', [
                'order' => 'review_count DESC, Service.title',
                'limit' => 21,
                'contain' => ['Specialization'],
            ])
        );
        $this->set('h1', $h1);
    }

    public function add()
    {
        $this->layout = 'fullWidthInner';
        $this->fastNav['/forum/add/'] = 'Добавить вопрос';

        if ($this->request->is('post')) {
            //проверяем капчу
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=6LfxqhgUAAAAADgYp8Y16tXmsUnr6xYSXF9ojga1&response=' . $_POST['g-recaptcha-response']);
            $out = curl_exec($curl);
            $out = json_decode($out, true);
            if ($out['success'] != true) die('Captcha!');

            $data = $this->data;
            $data['Question']['user_id'] = $this->user['id'];

            foreach ($data['Photo'] as $i => $photo) {
                if (empty($photo['picture']['tmp_name'])) {
                    unset($data['Photo'][$i]);
                }
            }

            if (empty($data['Photo'])) {
                unset($data['Photo']);
            }

            $data['Question']['service_title'] = strip_tags($data['Question']['service_title'], '<br><b>');
            $data['Question']['subject'] = strip_tags($data['Question']['subject'], '<br><b>');
            $data['Question']['content'] = strip_tags($data['Question']['content'], '<br><b>');

            if ($this->Question->saveAssociated($data, ['validate' => 'first'])) {
                if (!empty($data['Question']['service_id'])) {
                    $specialists_id = $this->SpecialistService->find('list', [
                        'conditions' => ['service_id' => $data['Question']['service_id']], 'fields' => 'user_id',
                    ]);
                    $mails = $this->User->find('list', [
                        'fields' => 'mail',
                        'conditions' => [
                            'id' => $specialists_id,
                            'mail IS NOT NULL',
                            'is_specialist' => 1,
                            'send_notification' => 1,
                        ],
                    ]);
                    If (!empty($mails)) {
                        App::uses('CakeEmail', 'Network/Email');
                        $email = new CakeEmail();
                        $email->from('no-reply@' . str_replace('www.', '', $_SERVER['SERVER_NAME']));
                        $email->to($mails);
                        //$email->to('kail.sazerland@gmail.com');
                        $email->subject("Новый вопрос на сайте {$_SERVER['SERVER_NAME']} в вашей специальности");
                        $email->emailFormat('html');
                        $email->viewVars(['question' => $data, 'question_id' => $this->Question->id]);
                        $email->template('new_question');
                        $email->send();
                        $this->set('done', true);
                    }
                }
                $this->set('done', true);
                $this->set('question_id', $this->Question->id);
            }
        }

        // если для услуги

        $service_id = null;

        if (!empty($this->params['named']['service'])) {
            $service = $this->Service->findById($this->params['named']['service']);

            if (empty($service)) {
                return $this->error_404();
            }

            $this->set('service', $service);
            $service_id = $service['Service']['id'];
        }

        //если для специалиста

        $specialist_id = null;

        if (!empty($this->params['named']['specialist'])) {
            $specialist = $this->User->find('first',
                [
                    'conditions' => [
                        'id' => $this->params['named']['specialist'],
                        'is_specialist' => 1,
                    ],
                ]);

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

        $this->set('services', $this->Service->getListWithSpec($specialist_id));

        $this->set('specialists', $this->User->getListWithServ($service_id));
    }

    public function service($alias)
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
        return $this->redirect('/forum/' . $service['Specialization']['alias'] . '/' . $alias . '/', 301);
    }

    function answer($question_id)
    {
        $this->layout = 'fullWidthInner';
        $question = $this->Question->find('first',
            [
                'conditions' => [
                    'Question.id' => $question_id,
                ],
                'contain' => ['Service', 'Photo', 'Response' => ['Specialist'], 'User'],
            ]
        );

        if (empty($question)) {
            return $this->error_404();
        }

        if ($this->request->is('post') && $this->user) {

            $data = $this->data;

            if (($this->user['is_specialist'] || $this->user['is_admin']) && isset($data['Response'])) {
                $data['Response']['specialist_id'] = $this->user['id'];
                $data['Response']['question_id'] = $question_id;
                $data['Response']['content'] = strip_tags($data['Response']['content'], '<br><b><p>');

                if ($this->Response->save($data)) {
                    $this->set('done', 'response');
                    //отправляем ответ на почту
                    if (!empty($question['User']['mail'])) {
                        App::uses('CakeEmail', 'Network/Email');
                        $email = new CakeEmail();
                        $email->from('no-reply@' . str_replace('www.', '', $_SERVER['SERVER_NAME']));
                        $email->to($question['User']['mail']);
                        //$email->to('kail.sazerland@gmail.com');
                        $email->subject("Ответ на ваш вопрос на сайте {$_SERVER['SERVER_NAME']}");
                        $email->emailFormat('html');
                        $email->viewVars(['user' => $question, 'question' => $question]);
                        $email->template('new_response');

                        $email->send();
                    }
                    $this->data = [];
                }
            } else {
                if ($this->user && isset($data['Comment'])) {
                    if (empty($data['Comment']['parent_id'])) {
                        unset($data['Comment']['parent_id']);
                    }

                    $data['Comment']['user_id'] = $this->user['id'];
                    $data['Comment']['url'] = $this->here;
                    if ($this->Comment->save($data)) {
                        if (!empty($question['User']['mail'])) {
                            App::uses('CakeEmail', 'Network/Email');
                            $email = new CakeEmail();
                            $email->from('no-reply@' . str_replace('www.', '', $_SERVER['SERVER_NAME']));
                            $email->to($question['User']['mail']);
                            //$email->to('kail.sazerland@gmail.com');
                            $email->subject("Ответ на ваш вопрос на сайте {$_SERVER['SERVER_NAME']}");
                            $email->emailFormat('html');
                            $email->viewVars(['user' => $question, 'question' => $question]);
                            $email->template('new_response');

                            $email->send();
                        }
                        $this->set('done', 'comment');
                        $this->data = [];
                    }
                }
            }
        }

        $question = $this->Question->find('first',
            [
                'conditions' => [
                    'Question.id' => $question_id,
                ],
                'contain' => ['Service', 'Photo', 'Response' => ['Specialist'], 'User'],
            ]
        );

        $this->page_title = $question['Question']['subject'];

        $descPrefix  = isset($question['Service']['title_dative']) ? "Вопрос по {$question['Service']['title_dative']}.  " : '';
        $this->page_description = $descPrefix . "{$question['Question']['subject']}. ";
        $this->fastNav["/service/info/{$question['Service']['alias']}/"] = $question['Service']['title'];
        $this->fastNav["/forum/service/{$question['Service']['alias']}/"] = 'Вопросы-ответы';
        $this->fastNav["/forum/answer/$question_id/"] = $question['Question']['subject'];

        $this->set('question', $question);

        $voted = [];

        if ($this->user) {
            $response_ids = $this->Response->find('list', ['conditions' => ['question_id' => $question_id]]);

            $voted = $this->Rate->find('list',
                [
                    'conditions' => [
                        'user_id' => $this->user['id'],
                        'parent_model' => 'Response',
                        'parent_id' => $response_ids,
                    ],
                    'fields' => 'parent_id, note',
                ]);
        }

        $this->set('voted', $voted);

        $this->set('last_reviews_title', 'Последние отзывы ' . $question['Service']['title_prepositional']);
        $this->set('last_reviews',
            $this->Review->find('all',
                [
                    'order' => 'edited desc', 'limit' => 3,
                    'conditions' => ['service_id' => $question['Service']['id']],
                ]));
        $this->set('last_responses_title', 'Последние вопросы ' . $question['Service']['title_prepositional']);
        $this->set('last_responses',
            $this->Response->getLast([
                'question_id' => $this->Question->find('list',
                    [
                        'conditions' => ['service_id' => $question['Service']['id']],
                        'fields' => ['id'],
                    ]),
            ]));
        $this->set('comments', $this->paginate('Comment', ['belongs_id' => $question_id, 'belongs' => 'Question']));
        if (!empty($question['Question']['service_id'])) {
            $this->set('similar_questions', $this->Question->find('all', [
                'conditions' => [
                    'service_id' => $question['Question']['service_id'],
                    'response_count >' => 0,
                    'id <>' => $question_id,
                ],
                'limit' => 3,
                'order' => 'rand()',
            ]));
        }

        $topSpecialistByService = $this->Response->find('all', [
            'conditions' => ['Question.service_id' => $question['Service']['id']],
            'limit' => 3,
            'fields' => [
                'Specialist.*',
                'COUNT(Response.specialist_id) as specialist_answer_count',
            ],
            'group' => ['Response.specialist_id'],
            'order' => 'specialist_answer_count DESC',
            'contain' => ['Question' => 'Service', 'Specialist' => 'Clinic'],
        ]);
        $this->set('topSpecialistByService', $topSpecialistByService);

        $relativePosts = $this->Post->find(
            'all',
            [
                'conditions' => [
                    'OR' => [
                        'Post.content LIKE' => "%{$question['Service']['title']}%",
                        'Post.title LIKE' => "%{$question['Service']['title']}%",
                    ],
                ],
                'limit' => 5,
                'order' => ['Post.comment_count' => 'DESC'],
            ]
        );
        $this->set('serviceTitle', mb_strtolower($question['Service']['title']));
        $this->set('relativePosts', $relativePosts);

        $useFullArticlesSlider = $this->Post->find(
            'all',
            [
                'contain' => 'PostCategory',
                'limit' => 14,
                'order' => ['Post.comment_count' => 'DESC'],
            ]
        );

        $this->set('useFullArticlesSlider', $useFullArticlesSlider);
    }

    function vote_response($response_id, $note)
    {
        $data['user_id'] = $this->user['id'];
        $data['parent_id'] = $response_id;
        $data['parent_model'] = 'Response';

        if ($this->Rate->find('count', ['conditions' => $data]) == 0 || $this->user['is_admin']) {
            $data['note'] = ($note == 1) ? 1 : -1;

            $this->Rate->save(['Rate' => $data]);

            $response = $this->Response->find('first', ['conditions' => ['id' => $response_id]]);

            $result = ['count' => $response['Response']['rate'], 'note' => $note];
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

    public function all()
    {
        $this->page_title = 'Все вопросы специалистам';

        $this->paginate['Question']['order'] = 'Question.created DESC';
        $this->paginate['Question']['limit'] = 10;
        $this->paginate['Question']['contain'] = ['Response', 'Service'];

        $this->setPaginate('questions', $this->paginate('Question'));
    }

    function response_edit()
    {
        $result = ['error' => true];

        if ($this->user &&
            $this->user['is_admin'] &&
            $this->request->is('ajax')
        ) {

            if (!empty($_POST['edit_text']) &&
                0 < intval($_POST['id'])
            ) {

                $this->Response->id = intval($_POST['id']);
                $this->Response->save(['content' => $_POST['edit_text']]);

                $result['error'] = false;
                $result['response'] = $_POST['edit_text'];
            } else {
                $result['error_message'] = 'Ответ не может быть пустым';
            }
        } else {
            $result['error_message'] = 'У вас недостаточно прав на данное действие';
        }

        echo json_encode($result);

        exit();
    }

    function response_del($response_id = 0)
    {
        $result = ['error' => true];

        if ($this->user &&
            $this->user['is_admin'] &&
            $this->request->is('ajax')
        ) {

            if (0 < $response_id) {
                $result['error'] = false;
                $result['response_id'] = $response_id;

                $this->Response->delete($response_id);
            }
        } else {
            $result['error_message'] = 'У вас недостаточно прав на данное действие';
        }

        echo json_encode($result);

        exit();
    }

    function without_response()
    {
        $this->page_title = 'Вопросы без ответов';

        $this->paginate['Question']['order'] = 'Question.created DESC';
        $this->paginate['Question']['limit'] = 10;
        $this->paginate['Question']['contain'] = ['Response', 'Service'];

        $this->set('questions', $r = $this->paginate('Question', ['Question.response_count' => 0]));
        return $this->render('all');
    }

    private function indexLogic($specializationAlias = null, $serviceAlias = null)
    {
        $pageTitle = 'Поиск вопрос и ответов';
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

            $pageTitle = "Вопросы по {$currentService['title_dative']}. Часто задаваемые вопросы о и ответы специалистов {$currentService['title_prepositional']}.";
            $h1 = "Вопросы {$currentService['title_prepositional']}";

            $specialistCount = $this->SpecialistService->find('count', [
                'fields' => 'user_id',
                'joins' => [
                    [
                        'table' => 'services',
                        'alias' => 'Service',
                        'type' => 'LEFT',
                        'conditions' => ['Service.id = SpecialistService.service_id',],
                    ],
                ],
                'conditions' => [
                    'Service.id' => $currentService['id'],
                ],
            ]);

            $this->page_description = "Задавайте вопросы и получайте ответы по {$currentService['title_dative']} от {$specialistCount} специалистов. ";
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
            $conditions[] = ['Service.id' => $currentService['id']];
        }
        if ($currentSpecialization !== null) {
            $conditions[] = ['Service.specialization_id' => $currentSpecialization['id']];
        }

        $this->Paginator->settings = [
            'limit' => 10,
            'conditions' => $conditions,
            'contain' => ['Response', 'User', 'Service', 'Photo'],
            'order' => ['Question.created' => 'DESC'],
        ];

        $this->set('questions', $this->paginate('Question'));

        $servicesConditions = ['title != ' => ''];
        if ($currentSpecialization !== null) {
            $servicesConditions['specialization_id'] = $currentSpecialization['id'];
        }
        $this->set(
            'services',
            $this->Service->find('all', [
                'order' => ['title ASC'],
                'conditions' => $servicesConditions,
            ])
        );

        $bestSpecialistConditions = ['is_specialist' => 1];
        if ($currentService !== null) {
            $bestSpecialistConditions['service_id'] = $currentService['id'];
        }
        if ($currentSpecialization !== null) {
            $bestSpecialistConditions['specialization_id'] = $currentSpecialization['id'];
        }
        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service', 'User.Clinic'],
                'group' => 'User.id',
                'order' => 'User.review_count DESC',
                'limit' => $this->configs['best_specialists_cnt'],
                'conditions' => $bestSpecialistConditions,
            ])
        );

        $bestQuestionsCondition = [];
        if ($currentService !== null) {
            $bestQuestionsCondition['Question.service_id'] = $currentService['id'];
        }

        $this->set('last_responses', $this->Response->find('all', [
            'conditions' => $bestQuestionsCondition,
            'limit' => 3,
            'fields' => [
                '*',
            ],
            'order' => 'Response.created DESC',
            'contain' => ['Question'],
        ]));

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
