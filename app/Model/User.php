<?
App::uses('Model', 'Model');

class User extends AppModel
{
    var $actsAs = ['Containable'];
    var $recursive = -1;
    public $virtualFields = [
        'age' => 'DATE_FORMAT(FROM_DAYS(TO_DAYS(now()) - TO_DAYS(%model%.`birthday`)), "%Y") + 0',
        'popular' => '%model%.response_count  + %model%.review_count',
        'has_request' => 'if(`%model%`.`specialist_request` != "", true, false)',
        'is_top' => 'IF(`%model%`.is_top_set OR (`%model%`.response_count >= %top_response_count% AND `%model%`.review_ex_count >= %top_exnote_count%), true, false)',
    ];
    public $validate = [
        'name' => [
            'non_empty' => [
                'allowEmpty' => false,
                'required' => true,
                'rule' => ['minLength', 1],
                'message' => 'Укажите ваше имя',
            ],
        ],
        'mail' => [
            'non_empty' => [
                'allowEmpty' => false,
                'required' => true,
                'rule' => ['minLength', 1],
                'message' => 'Укажите ваш e-mail',
            ],
            'uni' => [
                'rule' => 'isUnique',
                'on' => 'create',
                'message' => 'Указанные e-mail уже зарегистрирован',
            ],
            'valid' => [
                'rule' => 'email',
                'message' => 'Вы указали неверный e-mail',
            ],
        ],
        'password' => [
            'non_empty' => [
                'allowEmpty' => false,
                'required' => true,
                'rule' => '_psw_empty',
                'message' => 'Укажиет ваш пароль',
            ],
            'repeat' => [
                'allowEmpty' => false,
                'required' => true,
                'rule' => '_psw_repeat',
                'message' => 'Пароль и его повторение не совпадают',
            ],
        ],
        'avatar' => [
            'main' => [
                'allowEmpty' => true,
                'required' => false,
                'rule' => '_image',
                'message' => 'Неверный формат изображения',
            ],
        ],
        'social_id' => [
            'main' => [
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Неверный формат изображения',
            ],
        ],

    ];
    var $validate_admin = [
        'mail' => [
            'uni' => [
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'on' => 'create',
                'message' => 'Указанные e-mail уже зарегистрирован',
            ],
            'valid' => [
                'rule' => 'email',
                'allowEmpty' => true,
                'message' => 'Вы указали неверный e-mail',
            ],
        ],
    ];
    var $adminSchema = [
        'is_admin' => [
            'type' => 'list',
            'title' => 'Редактор',
            'title_short' => 'Ред.',
            'icons' => [
                0 => '',
                1 => '/img/admin/users.png',
                2 => '/img/admin/user.png',
            ],
            'values' => [
                1 => 'модератор',
                2 => 'админ',
            ],
        ],
        'is_specialist' => [
            'type' => 'list',
            'title' => 'Тип.аккаунта',
            'title_short' => 'Тип',
            'icons' => [
                0 => '',
                1 => '/img/admin/admin.png',
                2 => '/img/admin/users.png',
            ],
            'values' => [
                0 => 'Пользователь',
                1 => 'Специалист',
                2 => 'Клиника',
            ],
        ],
        'is_top_set' => [
            'type' => 'bool',
            'inlist' => false,
            'title' => 'Топ (в ручную)',
            'icons' => [
                0 => '',
                1 => '/img/admin/admin.png',
            ],
            'inlist' => false,
        ],
        'is_top' => [
            'type' => 'bool',
            'title' => 'Топ',
            'icons' => [
                0 => '',
                1 => '/img/admin/admin.png',
            ],
            'inform' => false,
        ],
        'is_adv' => [
            'type' => 'integer',
            'title' => 'Рекламный (сорт.)',
        ],
        'active' => [
            'type' => 'bool',
            'title' => 'Активирован',
            'title_short' => 'Акт.',
            'icons' => [
                0 => '/img/admin/off.png',
                1 => '/img/admin/on.png',
            ],
        ],
        'name' => [
            'type' => 'string',
            'title' => 'Имя',
            'edit_link' => true,
        ],
        'mail' => [
            'type' => 'string',
            'title' => 'E-mail',
            'edit_link' => true,
        ],
        'personal_mail' => [
            'type' => 'string',
            'title' => 'E-mail (персональный)',
            'edit_link' => true,
        ],
        'specialist_service_count' => [
            'type' => 'link',
            'template' => '/admin/self_list/SpecialistService/user_id:::id::/',
            'title' => 'Услуги',
            'inform' => false,
        ],
        'password' => [
            'type' => 'password',
            'title' => 'Пароль',
            'inlist' => false,
        ],
        'region_id' => [
            'title' => 'Город (регион)',
            'type' => 'list',
            'inlist' => false,
        ],
        "profession" => [
            'type' => 'string',
            'title' => 'Профессия',
            'inlist' => false,
        ],
        "address" => [
            'type' => 'string',
            'title' => 'Адрес',
            'inlist' => false,
        ],
        "coor" => [
            'type' => 'string',
            'title' => 'Координаты для Я.карт',
            'note' => 'Определяется каждый раз автоматически при сохранении записи',
            'inlist' => false,
        ],
        "phone" => [
            'type' => 'string',
            'title' => 'Телефон',
            'inlist' => false,
        ],
        "site" => [
            'type' => 'string',
            'title' => 'Сайт',
            'inlist' => false,
            'note' => 'Без указания http://. Например: www.kail.me',
        ],
        "description" => [
            'type' => 'text',
            'title' => 'Описание',
            'inlist' => false,
            'editor' => true,
        ],
        'avatar' => [
            'type' => 'image',
            'title' => 'Аватар',
            'inlist' => false,
        ],
        'service_id' => [
            'type' => 'habtm',
            'model' => 'Service',
            'title' => 'Оказываемые услуги',
            'fields' => [
                'price_min' => 'Стоимость мин.',
                'price_max' => 'Стоимость макс.',
                'rating_manual' => 'Адм.рейтинг',
                'comment' => 'Комментарий',
            ],
        ],
        'social_id' => [
            'type' => 'text',
            'title' => 'Социальны ID',
        ],
        'clinic_id' => [
            'type' => 'habtm',
            'model' => 'Clinic',
            'title' => 'Работа в клиниках',
        ],
        'parent_id' => [
            'type' => 'integer',
            'title' => 'Родительский аккаунт',
            'inlist' => false,
        ],
        'send_notification' => [
            'type' => 'bool',
            'title' => 'Слать уведомления о новых вопросах (комментариях)',
        ],
        'rate_manual' => [
            'type' => 'integer',
            'title' => 'Корректировка рейтинга',
        ],
        'created' => [
            'type' => 'datetime',
            'title' => 'Создан',
            'inform' => false,
        ],
    ];
    var $images = [
        'avatar' => [
            'main' => [
                'width' => 200,
                'height' => 200,
            ],
            'thumbnail' => [
                'width' => 100,
                'height' => 100,
            ],
            'mini' => [
                'width' => 64,
                'height' => 64,
            ],
            'profile' => [
                'width' => 32,
                'height' => 32,
            ],
        ],
    ];
    var $adminTitles = [
        'single' => 'пользователь',
        'plurial' => 'Пользователи',
        'genitive' => 'пользователя',
    ];
    public $order = 'User.created DESC';
    public $hasMany = [
        'SpecialistService' => [
            'dependent' => true,
        ],
        'Review' => [
            'foreignKey' => 'specialist_id',
            'dependent' => true,
        ],
        'Comment' => [
            'dependent' => true,
        ],
        'Photospec' => [
            'dependent' => true,
        ],
        'Response' => [
            'foreignKey' => 'specialist_id',
            'dependent' => true,
        ],
    ];
    public $hasAndBelongsToMany = [
        'Service' => [
            'with' => 'SpecialistService',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'service_id',
            'order' => 'Service.title',
            'fields' => 'id, title, alias, is_child, coast_avg',
            'unique' => true,
            'counterCache' => 'service_title_count',
        ],
        'Clinic' => [
            'with' => 'SpecialistClinic',
            'foreignKey' => 'specialist_id',
            'associationForeignKey' => 'clinic_id',
            'unique' => true,
            'className' => 'User',
            'fieldList' => 'name',
            'conditionsList' => [
                'is_specialist' => 2,
            ],
        ],
        'Post' => [
            'with' => 'PostSpecialist',
            'foreignKey' => 'specialist_id',
            'associationForeignKey' => 'post_id',
            'order' => 'Post.title',
            'fields' => 'id, title, alias, created, description',
            'unique' => true,
        ],
    ];
    public $belongsTo = [
        'Region' => [
            'conditionsList' => [
                'child_count' => 0,
            ],
        ],
        /*'Parent' => array(
          'className' => 'User',
          'foreignKey' => 'parent_id',
          'fieldList' => 'name'
        )*/
    ];
    public $filterField = "name";
    public $data_before = false;

    function beforeSave($data = [])
    {
        if ($this->auth && $this->auth['is_admin'] == 2 && !empty($this->data['User']['id'])) {
            $this->data_before = $this->findById($this->data['User']['id']);
        }

        return parent::beforeSave();
    }

    function afterSave($created, $data = [])
    {
        parent::afterSave($created);
        if ($this->auth && $this->auth['is_admin'] == 2 && !empty($this->data_before) && isset($this->data['User']['is_specialist']) && $this->data['User']['is_specialist'] == 1 && $this->data_before['User']['is_specialist'] == 0 && !empty($this->data['User']['mail'])) {
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from('no-reply@' . str_replace("www.", "", $_SERVER['SERVER_NAME']));
            $email->to($this->data['User']['mail']);
            //$email->to("kail.sazerland@gmail.com");
            $email->subject("Вы назначены специалистом сайта {$_SERVER['SERVER_NAME']}");
            $email->emailFormat("html");
            $email->viewVars(["user" => $this->data]);
            $email->template('specialist');
            $email->send();
        }
        if (isset($this->data['User']['address']) && $this->data['User']['is_specialist'] != 0) {
            $address = 'Россия, ' . $this->data['User']['address'];

            //идём в яндекс
            $request = file_get_contents('http://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . urlencode($address));
            $result = json_decode($request, true);
            if ($result['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'] > 0) {
                $coor = $result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
                $this->saveField('coor', $coor);
            }
        }
    }

    function _psw_empty($data)
    {
        if ($data['password'] == sha1(Configure::read("Security.salt"))) {
            return false;
        } else {
            return true;
        }
    }

    function _psw_repeat($data)
    {
        return $this->data['User']['password'] == $this->data['User']['password_repeat'];
    }

    function _is_captcha($data)
    {
        return $data['captcha'] == $_SESSION['random_string'];
    }

    function _image($data)
    {
        if (!empty($data['avatar']['tmp_name'])) {
            if (!empty($data['avatar']['tmp_name'])) {
                if (in_array(mime_content_type($data['avatar']['tmp_name']), [
                    "image/jpeg", "image/gif", "image/png",
                ])) {
                    return true;
                }
            }

            return false;
        } else {
            return true;
        }
    }

    function getFilters($service_id, $conditions = [])
    {
        $conditions["service_id"] = $service_id;
        $user_ids = array_unique($this->Review->find("list",
            ["fields" => "user_id", "conditions" => $conditions]));
        $user_ages = array_unique($this->find("list",
            ["fields" => "age", "conditions" => ["id" => $user_ids, "age <>" => ""], "order" => "age"]));
        $filters = [
            'rate' => [
                "title" => "Рейтинг",
                'values' => [
                    1 => 'Неудовлетрворен',
                    2 => 'Сомневаюсь',
                    3 => 'Удовлетворен',
                ],
            ],
        ];
        $templ_ages = [25, 35, 45, 55];
        $filters['age']['title'] = "Возраст";
        foreach ($user_ages as $age) {
            if ($age < min($templ_ages)) {
                $filters['age']['values']["0-" . (min($templ_ages) - 1)] = "До " . (min($templ_ages) - 1);
            } else if ($age > max($templ_ages)) {
                $filters['age']['values'][max($templ_ages) . "-150"] = max($templ_ages) . " и старше";
            } else {
                foreach ($templ_ages as $i => $temp_age) {
                    if ($i == 0 || $i == (count($templ_ages) - 1)) {
                        continue;
                    }
                    if ($age < $temp_age && $age >= $templ_ages[$i - 1]) {
                        $filters['age']['values'][$templ_ages[$i - 1] . "-" . ($templ_ages[$i] - 1)] = $templ_ages[$i - 1] . " &mdash; " . ($templ_ages[$i] - 1);
                    }
                }
            }
        }
        $filters['sex'] = [
            'title' => 'Пол',
            'values' => [
                1 => 'Мужской',
                2 => 'Женский',
            ],
        ];
        $filters['order'] = [
            'title' => 'Упорядочить по',
            'values' => [
                'comment_count' => 'Количеству комментариев',
                'thank_all_count' => 'Рейтингу',
                'updated' => 'Дате обновления',
            ],
        ];

        return $filters;
    }

    function getListWithServ($service_id = null)
    {
        $conditions = [];
        if (!is_null($service_id)) {
            $conditions = ["service_id" => $service_id];
        }
        $ids = $this->SpecialistService->find("list", ["fields" => "user_id", "conditions" => $conditions]);
        $result = $this->find("list",
            ["conditions" => ["id" => $ids, "is_specialist" => 1], "order" => "name", "fields" => "id, name"]);

        return $result;
    }

    function getTopSpecialist($limit = 10)
    {
        // получаем платных специалистов
        $adsUsers = $this->find('all',
            [
                'conditions' => [
                    'is_specialist' => 1,
                    'is_top_set' => 1,
                ],
                'order' => [
                    'rate DESC',
                ],
                'contain' => [
                    'Review',
                ],
            ]
        );
        $needUsersByReviewCount = $limit - count($adsUsers);

        $userByRate = $this->find('all',
            [
                'fields' => [
                    'User.*',
                    'count(*) AS reviews_count'
                ],
                'conditions' => [
                    'is_specialist' => 1,
                    'is_top_set' => 0,
                ],
                'order' => [
                    'reviews_count DESC',
                    'rate DESC',
                ],
                'joins' => [
                    [
                        'table' => 'reviews',
                        'alias' => 'Reviews',
                        'type' => 'Right',
                        'conditions' => [
                            'User.id = Reviews.specialist_id',
                        ],
                    ],
                ],
                'group' => ['User.id'],
                'contain' => ['Review'],
                'limit' => $needUsersByReviewCount,
            ]
        );

        return array_merge($adsUsers, $userByRate);
    }
}

