<?php

class ProfileController extends AppController
{
    public $layout = "index";
    public $allow = "*";
    public $helpers = ["Display"];
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
        "Post",
        "Comment",
    ];
    public $paginate = [
        "Review" => [
            "limit" => 10,
            "order" => "Review.created DESC",
            'contain' => ['Service', 'User', 'Specialist', 'Clinic', 'Photo'],
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

    function index($id = null)
    {
        $userProfile = $this->User->find('first', [
            'conditions' => ['id' => $id],
        ]);

        if (empty($userProfile)) {
            return $this->error_404();
        }

        $userReviews = $this->Paginator->paginate('Review',
            [
                'Review.user_id' => $id,
            ]);

        $userComments = $this->Comment->find('all', [
            'conditions' => ['Comment.user_id' => $id],
            'contain' => ['User'],
        ]);

        $this->page_description = "Профиль пользователя {$userProfile['User']['name']} на портале Topestet";

        $this->set('profile', $userProfile);

        $this->set('reviews', $userReviews);

        $this->set('comments', $userComments);
    }
}
