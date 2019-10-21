<?php

class ClinicController extends AppController
{
    public $layout = "index";
    public $allow = "*";
    public $helpers = ["Display"];
    public $components = ['RequestHandler'];
    public $uses = [
        "Page",
        "Region",
        "SpecialistService",
        "Service",
        "Specialization",
        "Review",
        'SpecialistClinic',
        'Response',
        'Rate',
    ];
    public $paginate = [
        "Review" => [
            "limit" => 5,
            "order" => "Review.created DESC",
            "contain" => ["User", "Region", "Service"],
        ],
        "Response" => [
            "limit" => 10,
            "order" => "Response.rate DESC, Response.created ASC",
            "contain" => ["Question" => 'Service', "Specialist"],
        ],
    ];

    function beforeFilter()
    {
        parent::beforeFilter();

        parent::seoFilter();
    }

    function index()
    {
        $this->redirect("/catalog/");
    }

    function profile($specialist_id, $preload = false)
    {

        $this->autoRender = false;

        if ($this->request->is('post')) {
            try {
                $this->RequestHandler->addInputType('json', ['json_decode', true]);

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
                    'message' => "<span style='color: red'>" . $e->getMessage() . "</span>",
                    'redirect' => $this->referer(),
                ]);
            }
        }

        $services = $this->Service->find("list", [
            "conditions" => ["Service.title !=" => ''],
        ]);
        $cities = $this->Region->getCities('list');

        $this->set('services', $services);
        $this->set('cities', $cities);

        $specialist = $this->User->find("first", [
            "conditions" => [
                "id" => $specialist_id,
                "is_specialist" => 2,
            ],
            "contain" => [
                "Service",
                'Post',
                "Photospec" => ["limit" => 3, "order" => "Photospec.created ASC"],
            ],
        ]);
        if (empty($specialist)) {
            return $this->error_404();
        }

        $service_ids = $this->SpecialistService->find("list",
            ["fields" => "service_id", "conditions" => ["user_id" => $specialist['User']['id']]]);
        $specialization_ids = $this->Service->find("list",
            ["fields" => "specialization_id", "conditions" => ["Service.id" => $service_ids]]);
        $specializations = array_unique($this->Specialization->find("list", [
            "fields" => (($specialist['User']['is_specialist'] == 1) ? "specialist" : "title_clinic_one"),
            "conditions" => ["id" => $specialization_ids],
            "order" => "order_title DESC, specialist ASC",
        ]));

        $this->page_title = $specialist['User']['name'] . " &mdash; " . mb_strtolower(implode(", ", $specializations),
                "utf-8") . ". Отзывы пациентов и цены";

        $this->set("specialist", $specialist);
        $this->Paginator->settings = ['limit' => 5, 'contain' => ['User', 'Service', 'Specialist', 'Photo']];

        $myPage = $this->paginate('Review',
            [
                'OR' =>
                    [
                        'clinic_id' => $specialist_id,
                    ],
            ]);

        $this->set("reviews", $myPage);

        $this->set('best_specialists', $this->SpecialistService->find('all',
            [
                'contain' => ['User', 'Service'],
                'order' => 'SpecialistService.rating_manual DESC, SpecialistService.rating DESC, User.response_count DESC',
                'limit' => $this->configs['best_specialists_cnt'],
            ])
        );
        $specialistList = $this->SpecialistClinic->find('all', [
            'contain' => ['Specialist'],
            'conditions' => ['clinic_id' => $specialist_id],
            'order' => 'Specialist.rate DESC',
        ]);
        $this->set('specialistes', $specialistList);

        $this->set('responses', $this->Response->find('all', [
            'conditions' => ['Response.specialist_id' => $specialist_id],
            'order' => 'rate DESC, Response.created ASC',
            'limit' => 10,
            'contain' => ['Question' => 'Service'],
        ]));

        $this->set('responses_count', $this->Response->find('count', [
            'conditions' => ['Response.specialist_id' => $specialist_id],
            'order' => 'rate DESC, Response.created ASC',
        ]));

        if ($this->user) {
            $this->set('rates', $r = $this->Rate->find('list', [
                'fields' => 'parent_id, note',
                'conditions' => [
                    'parent_model' => 'SpecialistService',
                    'user_id' => $this->user['id'],
                    'parent_id' => $this->SpecialistService->find("list",
                        ["fields" => "id", "conditions" => ["user_id" => $specialist['User']['id']]]),
                ],
            ]));
        }

        $otherClinics = $this->User->find('all', [
            'conditions' => [
                'is_specialist' => 2,
                'id !=' => $specialist_id,
            ],
            'limit' => 5,
            'contain' => [
                'Photospec' => [
                    'fields' => 'count(Photospec.id) as cnt',
                    'order' => 'cnt DESC',
                ],
            ],
        ]);

        $this->set('other_clinics', $otherClinics);
//        $geo = isset($cities[$specialist['User']['region_id']]) ? $cities[$specialist['User']['region_id']] : '';
        $this->page_title = "{$specialist['User']['name']} - Клиника пластической хирургии и косметологии | отзывы пациентов, специалисты, адрес, цены.";
        $specCoun = count($specialistList);
        $this->page_description = "{$specialist['User']['name']} - Клиника пластической хирургии и косметологии, {$specCoun} специалистов, {$specialist['User']['review_count']} отзывов. На нашем сайте можно записаться на прием в  {$specialist['User']['name']} - адреса, схема проезда.";
        $this->set('h1', $specialist['User']['name']);
        $this->render('profile');
    }

    function responses($specialist_id)
    {
        $specialist = $this->User->find("first",
            ["conditions" => ["id" => $specialist_id, "is_specialist >" => 0]]);
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
