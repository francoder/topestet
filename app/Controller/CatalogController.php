<?php

class CatalogController extends AppController
{
    public $layout = 'fullWidthInner';
    public $allow = '*';
    public $helpers = ['Display'];
    public $uses = [
        'Page', 'Post', 'Region', 'SpecialistService', 'Service', 'Specialization', 'Comment', 'SpecialistClinic',
    ];
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

    public function index()
    {
        $this->specialistCatalogLogic('all', null, null);
    }

    public function cosmetology($serviceAlias = null)
    {
        $this->specialistCatalogLogic('all', 'cosmetology', $serviceAlias);
        return $this->render('index');
    }

    public function plastica($serviceAlias = null)
    {
        $this->specialistCatalogLogic('all', 'plastica', $serviceAlias);
        return $this->render('index');
    }

    public function all(
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $this->specialistCatalogLogic('all', $specializationAlias, $serviceAlias);
        return $this->render('index');
    }

    public function region(
        $regionAlias = 'all',
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $this->specialistCatalogLogic($regionAlias, $specializationAlias, $serviceAlias);
        return $this->render('index');
    }

    public function specialistCatalogLogic(
        $regionAlias = 'all',
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $pageTitle = 'Поиск специалиста';
        $h1 = 'Поиск специалиста';
        $currentRegion = null;
        $currentService = null;
        $currentSpecialization = null;
        if ($regionAlias !== 'all' && $regionAlias) {
            $region = $this->Region->find('first', [
                'conditions' => [
                    'Region.alias' => $regionAlias,
                ],
            ]);
            if (empty($region)) {
                return $this->error_404();
            }
            $currentRegion = $region['Region'];
        }
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

            $whoPart = $currentService['specialization_id'] === '7' ? 'пластические хирурги' : 'косметологи';
            $who2Part = $currentService['specialization_id'] === '7' ? 'пластических хирургов' : 'косметологов';
            $who3Part = $currentService['specialization_id'] === '7' ? 'пластических хирургах' : 'косметологах';
            $geoPart = $currentRegion !== null ? ' ' . $currentRegion['title_with_preposition'] : '';
            if ($currentRegion !== null && $currentRegion['title_with_preposition'] === '') {
                $geoPart = ' в ' . $currentRegion['title_genitive'];
            }

            $pageTitle = "Лучшие {$whoPart} по {$currentService['title_dative']}{$geoPart} . Рейтинг {$who2Part} по {$currentService['title_dative']}.";

            $h1 = self::mbUcfirst($whoPart) . " по {$currentService['title_dative']}{$geoPart}";

            if ($this->request->query('s') !== null) {
//                Debugger::dump($currentRegion);
            }
            $this->page_description = "Проверенные  {$whoPart} по {$currentService['title_dative']}{$geoPart}. Независимый рейтинг {$who2Part} по {$currentService['title_dative']}. Изучайте и оставляйте отзывы о {$who3Part}. ";
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

        $this->set('currentRegion', $currentRegion);
        $this->set('currentSpecialization', $currentSpecialization);
        $this->set('currentService', $currentService);

        $conditions = ['User.is_specialist' => 1];
        if ($currentService !== null) {
            $specialists = $this->SpecialistService->find('list', [
                'fields' => 'user_id',
                'conditions' => [
                    'service_id' => $currentService['id'],
                ],
            ]);
            $conditions['id'] = $specialists;
        } else if ($currentSpecialization !== null) {
            $specialists = $this->SpecialistService->find('list', [
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
                    'Service.specialization_id' => $currentSpecialization['id'],
                ],
            ]);

            $conditions['id'] = $specialists;
        }
        if ($currentRegion !== null) {
            $conditions['User.region_id'] = $currentRegion['id'];
        }

        if (!empty($this->request->query('coast'))) {
            $coast = $this->request->query('coast');
            if ($coast === 'min') {
                $conditions['User.coast_avg <'] = 30000;
            }
            if ($coast === 'mid') {
                $conditions['User.coast_avg >'] = 30000;
                $conditions['User.coast_avg <'] = 100000;
            }
            if ($coast === 'max') {
                $conditions['User.coast_avg > '] = 100000;
            }
        }
        if (!empty($this->request->query('with_reviews'))) {
            $conditions['User.review_count >'] = 0;
        }
        if (!empty($this->request->query('only_high_rate'))) {
            $conditions['User.rate >='] = '4.7';
        }

        $this->Paginator->settings = [
            'limit' => 10,
            'contain' => ['Clinic'],
            'conditions' => $conditions,
            'order' => $this->getOrderFromRequest(),
        ];

        $this->set('specialistList', $this->paginate('User', $conditions));

        $this->set(
            'services',
            $this->Service->find('all', [
                'order' => ['title ASC'],
                'conditions' => ['title != ' => ''],
            ])
        );

        $this->set('cities', $this->Region->getCities());

        $this->set('top_services',
            $this->Service->find('all', [
                'order' => 'review_count DESC, Service.title',
                'limit' => 21,
                'contain' => ['Specialization'],
            ])
        );

        $this->page_title = $pageTitle;
        $this->set('h1', $h1);
        return $this->render('index');
    }

    public function clinicCatalogLogic(
        $regionAlias = 'all',
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $pageTitle = 'Список клиник';
        $h1 = 'Список клиник';
        $currentRegion = null;
        $currentService = null;
        $currentSpecialization = null;
        if ($regionAlias !== 'all' && $regionAlias) {
            $region = $this->Region->find('first', [
                'conditions' => [
                    'Region.alias' => $regionAlias,
                ],
            ]);
            if (empty($region)) {
                return $this->error_404();
            }
            $currentRegion = $region['Region'];
        }
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

            $whoPart = $currentService['specialization_id'] === '7' ? 'пластические хирурги' : 'косметологи';
            $who2Part = $currentService['specialization_id'] === '7' ? 'хирургов' : 'косметологов';
            $geoPart = $currentRegion !== null ? ' ' . $currentRegion['title_with_preposition'] : '';
            if ($currentRegion !== null && $currentRegion['title_with_preposition'] === '') {
                $geoPart = ' в ' . $currentRegion['title_genitive'];
            }
            $pageTitle = "Клиники по {$currentService['title_dative']}{$geoPart} . " .
                "Рейтинг клиник по {$currentService['title_dative']}{$geoPart}. Акции, отзывы, адреса.";
            $h1 = "Клиники по {$currentService['title_dative']}{$geoPart}";
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

        $this->set('currentRegion', $currentRegion);
        $this->set('currentSpecialization', $currentSpecialization);
        $this->set('currentService', $currentService);

        $conditions = ['User.is_specialist' => 2];
        $joins = [];
        if ($currentService !== null) {
            $specialists = $this->SpecialistService->find('list', [
                'fields' => 'user_id',
                'conditions' => [
                    'service_id' => $currentService['id'],
                ],
            ]);
            $conditions['id'] = $specialists;
        } else if ($currentSpecialization !== null) {
            $specialists = $this->SpecialistService->find('list', [
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
                    'Service.specialization_id' => $currentSpecialization['id'],
                ],
            ]);

            $conditions['id'] = $specialists;
        }
        if ($currentRegion !== null) {
            $conditions['User.region_id'] = $currentRegion['id'];
        }

        if (!empty($this->request->query('coast'))) {
            $coast = $this->request->query('coast');
            if ($coast === 'min') {
                $conditions['User.coast_avg <'] = 30000;
            }
            if ($coast === 'mid') {
                $conditions['User.coast_avg >'] = 30000;
                $conditions['User.coast_avg <'] = 100000;
            }
            if ($coast === 'max') {
                $conditions['User.coast_avg > '] = 100000;
            }
        }
        if (!empty($this->request->query('with_reviews'))) {
            $conditions['User.review_count >'] = 0;
        }

        $this->Paginator->settings = [
            'limit' => 10,
            'conditions' => $conditions,
            'order' => $this->getOrderFromRequest(),
        ];

        if ($currentService !== null) {
            $geoPart = isset($geoPart) ? $geoPart : '';
            $clinicCount = $this->User->find('count', ['conditions' => $conditions]);
            $this->page_description = "Лучшие клиники по {$currentService['title_dative']}{$geoPart}. На нашем сайте вы найдете - {$clinicCount} - адреса, схемы проезда, контакты. ";
        }

        $clinicUserList = $this->paginate('User', $conditions);
        $clinicTopSpecialistList = [];
        foreach ($clinicUserList as $clinicUser) {
            $topSpecialist = $this->SpecialistClinic->find(
                'first',
                [
                    'limit' => 1,
                    'fields' => '*',
                    'conditions' => ['SpecialistClinic.clinic_id' => $clinicUser['User']['id']],
                    'joins' => [
                        [
                            'table' => 'users',
                            'alias' => 'User',
                            'type' => 'LEFT',
                            'conditions' => [
                                'SpecialistClinic.specialist_id = User.id',
                            ],
                            'order' => 'rate',
                        ],
                    ],
                ]
            );
            $clinicTopSpecialistList[$clinicUser['User']['id']] = isset($topSpecialist['User']) ? $topSpecialist['User'] : null;
        }
        $this->set('clinicList', $clinicUserList);
        $this->set('clinicTopSpecialistList', $clinicTopSpecialistList);

        $this->set(
            'services',
            $this->Service->find('all', [
                'order' => ['title ASC'],
                'conditions' => ['title != ' => ''],
            ])
        );

        $this->set('cities', $this->Region->getCities());

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

    public function clinic()
    {
        $this->clinicCatalogLogic('all', null, null);
        return $this->render('clinic');
    }

    public function allClinic(
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $this->clinicCatalogLogic('all', $specializationAlias, $serviceAlias);
        return $this->render('clinic');
    }

//    function service($alias)
//    {
//        $service = $this->Service->find('first', [
//            'conditions' => ['Service.alias' => $alias], 'contain' => 'Specialization',
//        ]);
//
//        if (empty($service)) return $this->error_404();
//
//        $this->fastNav["/catalog/service/$alias/"] = $service['Service']['title'];
//
//        $this->page_title = "{$service['Specialization']['specialist_plural']}, специализация &mdash; {$service['Service']['title']}";
//
//        $specialist_ids = $this->SpecialistService->find('list', [
//            'fields' => 'user_id', 'conditions' => ['service_id' => $service['Service']['id']],
//        ]);
//        $region_ids = $this->User->find('list', ['fields' => 'region_id', 'conditions' => ['id' => $specialist_ids]]);
//        $this->set('regions', $this->Region->find('list', [
//            'conditions' => ['id' => $region_ids], 'fields' => 'alias, title',
//        ]));
//
//        $specialists = $this->SpecialistService->find('list', [
//            'fields' => 'user_id', 'conditions' => ['service_id' => $service['Service']['id']],
//        ]);
//        $this->setPaginate('specialists', $this->paginate('User', ['id' => $specialists, 'is_specialist' => 1]));
//        $this->set('service', $service);
//    }

//    function raiting($type)
//    {
//
//        $cond = ['review_count >' => 0];
//        if ($type == 'specialists') {
//            $cond['is_specialist'] = 1;
//        } else {
//            $cond['is_specialist'] = 2;
//        }
//        $this->Paginator->settings['User']['order'] = 'User.review_count DESC';
//
//        $this->set('specialists', $this->paginate('User', $cond));
//        $this->set('specialist_type', $cond['is_specialist']);
//    }

    public function regionClinic(
        $regionAlias = null,
        $specializationAlias = null,
        $serviceAlias = null
    )
    {
        $this->clinicCatalogLogic($regionAlias, $specializationAlias, $serviceAlias);
        return $this->render('clinic');
    }

    function cron()
    {
        $ids = $this->User->find('list', [
            'fields' => 'id, address',
            'conditions' => [
                'is_specialist <>' => 0,
                'coor' => '',
                'address <>' => '',
            ],
        ]);
        foreach ($ids as $id => $address) {
            echo $address = '' . $address;

            //идём в яндекс
            $request = file_get_contents('http://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . urlencode($address));
            $result = json_decode($request, true);
            if ($result['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'] > 0) {
                $coor = $result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
                $this->User->id = $id;
                $this->User->saveField('coor', $coor);
            }
        }
        exit();
    }

    private function getOrderFromRequest()
    {
        $order = $this->request->query('order');
        switch ($order) {
            case 'reviews':
                return 'User.review_count DESC';
            case 'rate':
                return 'User.rate DESC, User.review_count DESC';
            default:
                return 'User.review_count DESC';
        }
    }
}
