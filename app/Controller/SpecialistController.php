<?php
//require_once(__DIR__ . '/../../vendors/autoload.php');

class SpecialistController extends AppController
{
    public $layout = 'index';
    public $allow = '*';
    public $helpers = ['Display'];
    public $components = ['RequestHandler'];
    public $uses = [
        'Page',
        'Region',
        'SpecialistService',
        'Service',
        'Specialization',
        'Review',
        'SpecialistClinic',
        'Response',
        'Rate',
        'Post',
        'Region',
        'User',
    ];
    public $paginate = [
        'Review' => [
            'limit' => 10,
            'order' => 'Review.created DESC',
            'contain' => ['User', 'Region', 'Service', 'Clinic', 'Photo'],
        ],
        'Response' => [
            'limit' => 10,
            'order' => 'Response.rate DESC, Response.created ASC',
            'contain' => ['Question' => 'Service', 'Specialist'],
        ],
    ];

    function beforeFilter()
    {
        parent::beforeFilter();

        parent::seoFilter();
    }

    function index()
    {
        $this->redirect('/catalog/');
    }

    function profile($specialist_id, $preload = false)
    {
        if (mb_strpos($this->request->url, 'doctors/') !== false) {
            return $this->redirect('/specialist/profile/' . $specialist_id . '/', 301);
        }
        $this->autoRender = false;
        $this->RequestHandler->addInputType('json', ['json_decode', true]);

        if ($this->request->is('post')) {
            try {
                $data = $this->request->data;

                $entity = $this->Review->save($data);

                if ($entity) {
                    return json_encode([
                        'error' => 'false',
                        'message' => "<span style='color: green'>Отзыв добавлен</span>",
                        'redirect' => $this->referer(),
                    ]);
                } else {
                    return json_encode([
                        'error' => 'true',
                        'message' => "<span style='color: red'>Ошибка сохранения отзыва!</span>",
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

        $specialist = $this->User->find('first', [
            'conditions' => [
                'id' => $specialist_id,
                'is_specialist' => ((isset($this->params['type']) && $this->params['type'] == 'clinic') ? 2 : 1),
            ],
            'contain' => ['Service', 'Post', 'Photospec' => ['limit' => 3, 'order' => 'Photospec.created ASC']],
        ]);
        if (empty($specialist)) {
            return $this->error_404();
        }

        $service_ids = $this->SpecialistService->find('list',
            ['fields' => 'service_id', 'conditions' => ['user_id' => $specialist['User']['id']]]);

        $specialization_ids = $this->Service->find('list',
            ['fields' => 'specialization_id', 'conditions' => ['Service.id' => $service_ids]]);

        $services = $this->Service->find('list', [
            'conditions' => ['Service.title !=' => ''],
        ]);
        $cities = $this->Region->getCities('list');

        $this->set('services', $services);
        $this->set('cities', $cities);

        $specializations = array_unique($this->Specialization->find('list', [
            'fields' => (($specialist['User']['is_specialist'] == 1) ? 'specialist' : 'title_clinic_one'),
            'conditions' => ['id' => $specialization_ids],
            'order' => 'order_title DESC, specialist ASC',
        ]));

        $this->set('specialist', $specialist);
        $this->Paginator->settings = [
            'limit' => 5,
            'contain' => ['User', 'Service', 'Clinic', 'Photo'],
        ];
        $this->set('reviews', $this->paginate('Review',
            [
                'OR' =>
                    [
                        'specialist_id' => $specialist_id,
                        'clinic_id' => $specialist_id,
                    ],
            ]));

        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service'],
                'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
                'limit' => $this->configs['best_specialists_cnt'],
            ])
        );

        if ($specialist['User']['is_specialist'] == 1) {
            $this->set('clinics', $this->SpecialistClinic->find('all', [
                'contain' => ['Clinic'],
                'conditions' => ['specialist_id' => $specialist_id],
                'order' => 'Clinic.name',
            ]));
            $this->fastNav['/catalog/'] = 'Каталог специалистов';
        } else if ($specialist['User']['is_specialist'] == 2) {
            $this->fastNav['/catalog/clinic'] = 'Каталог клиник';
            $this->set('specialistes', $s = $this->SpecialistClinic->find('all', [
                'contain' => ['Specialist'],
                'conditions' => ['clinic_id' => $specialist_id],
                'order' => 'Specialist.name',
            ]));
        }

        $this->fastNav["/specialist/profile/{$specialist_id}/"] = $specialist['User']['name'];

        $this->set('responses', $this->Response->find('all', [
            'conditions' => ['Response.specialist_id' => $specialist_id],
            'order' => 'rate DESC, Response.created ASC',
            'limit' => 10,
            'contain' => ['Question' => 'Service'],
        ]));

        $this->set('review_count', $this->Review->find('count', [
            'conditions' => ['Review.specialist_id' => $specialist_id],
        ]));
        //$this->set('responses', $this->paginate('Response', array('Response.specialist_id' => $specialist_id)));

        if ($this->request->is('ajax')) {
            if ($preload == 'review') {
                return $this->render('reviews');
            } else if ($preload == 'response') {
                return $this->render('ajax_responses');
            }
        }
        if ($this->user) {
            $this->set('rates', $r = $this->Rate->find('list', [
                'fields' => 'parent_id, note',
                'conditions' => [
                    'parent_model' => 'SpecialistService',
                    'user_id' => $this->user['id'],
                    'parent_id' => $this->SpecialistService->find('list',
                        ['fields' => 'id', 'conditions' => ['user_id' => $specialist['User']['id']]]),
                ],
            ]));
        }

        $useFullArticlesSlider = $this->Post->find('all', [
            'contain' => 'PostCategory',
            'limit' => 7,
        ]);

        $this->set('useFullArticlesSlider', $useFullArticlesSlider);

        $this->set('last_responses_title', 'Последние ответы специалиста');
        $this->set('last_responses', $this->Response->getLast([
            'Response.specialist_id' => $specialist['User']['id'],
        ]));

        $geo = isset($cities[$specialist['User']['region_id']]) ? $cities[$specialist['User']['region_id']] : '';
        $this->page_title = "{$specialist['User']['name']} - {$specialist['User']['profession']} в городе {$geo}. Отзывы, результаты работ, цены. ";
        $this->set('h1', $specialist['User']['name']);

        $nameE = $specialist['User']['name_genitive'] !=='' ? $specialist['User']['name_genitive'] : $specialist['User']['name'];
        $nameY = $specialist['User']['name_dative'] !== '' ? $specialist['User']['name_dative'] :$specialist['User']['name'];
        $this->page_description = "{$specialist['User']['profession']} {$specialist['User']['name']}. На нашем сайте вы найдете подробную информацию на {$nameE} - отзывы, цены, биографию, статьи и результаты работ. Запись на прием к {$nameY}";

        $this->render('profile');
    }

    function responses($specialist_id)
    {
        $specialist = $this->User->find('first',
            ['conditions' => ['id' => $specialist_id, 'is_specialist >' => 0]]);
        if (empty($specialist)) {
            return $this->error_404();
        }

        $this->fastNav["/specialist/profile/{$specialist_id}/"] = $specialist['User']['name'];
        $this->fastNav["/specialist/responses/{$specialist_id}/"] = 'Ответы на вопросы';

        $this->set('responses', $this->paginate('Response', ['Response.specialist_id' => $specialist_id]));
        $this->set('specialist', $specialist);
    }

    function service_note()
    {
        if ($this->request->is('ajax')) {
            $response = [];
            $data = [
                'user_id' => $this->user['id'],
                'parent_model' => 'SpecialistService',
                'parent_id' => $this->data['id'],
            ];
            $rate = $this->Rate->find('first', ['conditions' => $data]);
            if (!empty($rate)) {
                $data['id'] = $rate['Rate']['id'];
            }
            $data['note'] = $this->data['note'];
            $response['ser_spec_id'] = $this->data['id'];
            if ($this->Rate->save($data)) {
                $specialist_service = $this->SpecialistService->findById($this->data['id']);
                $response['rate'] = $specialist_service['SpecialistService']['rate'];
                $response['cnt'] = $specialist_service['SpecialistService']['rate_count'];
            }

            return $this->ajax_response($response);
        } else {
            return $this->error_404();
        }
    }
}
