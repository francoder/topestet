<?php


class MaintenanceController extends AppController
{
  public $layout = "index_error";

  public $allow = "*";

  public $helpers = array("Display");

  public $uses = array(
    "Page", "Post", 'Comment', 'PostCategory', 'PostSpecialist', 'PostService', 'Service');

  public $paginate = array(
    "Post" => array(
      "limit"   => 10,
      "order"   => "Post.created desc",
      "fields"  => array(
        "id",
        "title",
        "description",
        "created",
        "alias",
        'PostCategory.*',
      ),
      'contain' => 'PostCategory',
    ),
    'Review'    => array(
      "order"   => "Review.is_adv DESC, Review.photo_count > 0 DESC, Review.edited DESC",
      'limit'   => 5,
      "contain" => array("User", "Region", "Photo", "Specialist", "Service",),
    ),
  );

  function beforeFilter()
  {
    parent::beforeFilter();

    parent::seoFilter();
  }

  public function index() {

    return $this->render('index');
  }
}