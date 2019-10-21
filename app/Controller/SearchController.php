<?php

class SearchController extends AppController
{
    public $layout = 'index';
    public $allow = '*';
    public $helpers = ['Display'];
    public $components = ['RequestHandler'];
    public $uses = [
        'Region',
        'Service',
        'User',
        'SpecialistService',
        'Review',
        'SpecialistClinic',
        'Clinic',
        'Response',
    ];
    public $paginate = [
        'User' => [
            'recursive' => -1,
            'group' => 'User.id',
            'limit' => 10,
            'order' => 'User.rate DESC',
            'contain' => [
                'Region',
                'Clinic',
                'Review',
            ],
        ],

    ];

    function beforeFilter()
    {
        parent::beforeFilter();

        parent::seoFilter();
    }

    function index()
    {
        $this->redirect('/catalog/', 301);
    }

    function clinics()
    {
        $this->redirect('/catalog/clinic/', 301);
    }

    function reviews($specializationAlias = null, $serviceAlias = null)
    {
        $this->redirect('/reviews/', 301);
    }

    function forum($specializationAlias = null, $serviceAlias = null)
    {
        $this->redirect('/forum/', 301);
    }

    function profile($specialist_id, $preload = false)
    {

    }

    function responses($specialist_id)
    {

    }

    function lastReviews()
    {
        $this->set('last_reviews', $this->Review->find('all',
            [
                'order' => 'Review.edited desc',
                'limit' => 3,
                'contain' => ['Region', 'User', 'Specialist'],
                'conditions' => ['Review.specialist_id !=' => null],
            ]
        ));
    }
}
