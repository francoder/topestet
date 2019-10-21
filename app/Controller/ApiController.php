<?php

class ApiController extends AppController
{
    public $layout = "index";
    public $allow = "*";
    public $helpers = ["Display"];
    public $components = [
        'Paginator' => [
            /*"Review"    => array(
                "limit"   => 10,
                "order"   => "Review.is_adv DESC, Review.photo_count > 0 DESC, Review.edited DESC",
                "contain" => array("User", "Region", "Photo")
            ),
            "Comment"   => array(
                "limit"     => 10,
                "order"     => "Comment.created ASC",
                "contain"   => array("User"),
                "Comment.parent_id" => null
            ),
            "Photo"     => array(
                "limit" => 9,
                "order" => "Photo.created DESC, Photo.id DESC"
            ),

            */
            "Photospec" => [
                "limit" => 10,
                "order" => "Photospec.created DESC",
                "contain" => "User",
            ]/*,
	        "Post" => array(
	            "limit" => 10,
	            "order" => "Post.created desc",
	            "fields" => array(
	                "id", 
	                "title", 
	                "description", 
	                "created", 
	                "alias",
	                'PostCategory.*'
	            ),
	            'contain' => 'PostCategory'
	        )*/
        ],
    ];
    public $uses = [
        "Service",
        "Specialization",
        "Review",
        "Region",
        "SpecialistService",
        "Thank",
        "Comment",
        "Photo",
        "Photospec",
        "Rate",
        "ReviewAdd",
        "Question",
        'PostService',
        'Post',
    ];
    public $paginate = [
        'Comment' => [
            "contain" => ["User"],
            'order' => 'Comment.created ASC',
            'limit' => 10,
        ],
        'Review' => [
            "order" => "Review.is_adv DESC, Review.photo_count > 0 DESC, Review.edited DESC",
            "contain" => ["User", "Region", "Photo"],
        ],
        "Photospec" => [
            "limit" => 10,
            "order" => "Photospec.created DESC",
            "contain" => "User",
        ],
    ];

    public function get_services()
    {

        /*$specs = $this->Specialization->find('all', array(
          'conditions' => array('title LIKE ' => '%'. $this->request->query('value') . '%' ),
          'order' => 'title'
        ) );

        foreach ($specs as $item) {

          $response[] = array('title' => $item['Specialization']['title'], 'id' => $item['Specialization']['id']);
        }*/
        $services = $this->Service->find('all',
            [
                'conditions' => [
                    'Service.title LIKE ' => '%' . $this->request->query('value') . '%',
                    'Service.title !=' => ''
                ],
                'order' => 'Service.title',
                'contain' => ['Specialization'],
            ]);
        $response = [];

        //Debugger::dump($services);

        foreach ($services as $item) {
            $response[] = [
                'title' => $item['Service']['title'], 'id' => $item['Service']['id'],
                'alias' => $item['Service']['alias'],
                'specialization_alias' => $item['Specialization']['alias'],
            ];
        }

        if ($this->request->is('ajax')) {
            echo json_encode($response);
            exit();
        }

        echo json_encode(['message' => 'ok']);
        exit();
    }
}

