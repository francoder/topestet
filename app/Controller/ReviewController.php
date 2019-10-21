<?php

class ReviewController extends AppController
{
    public $layout = 'index';
    public $allow = ['index', 'view'];
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

    public function index($id = null)
    {
        return $this->redirect('/reviews/' . $id, 301);
    }

    public function view($id = null)
    {
        return $this->redirect('/reviews/' . $id, 301);
    }
}


