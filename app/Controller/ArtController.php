<?php

class ArtController extends AppController 
{
    public $layout = "inner";
    
    public $allow = "*";
    
    public $helpers = array("Display");
    
    public $uses = array("Page", "Post", 'Comment', 'PostCategory', 'PostSpecialist', 'PostService', 'Service');

    public $paginate = array(
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
        )
    );
    
    function beforeFilter()
    {
        parent::beforeFilter();

        $this->fastNav['/art/'] = "Медиа";

        parent::seoFilter();
    }
    
    function index()
    {
        $this->redirect('/article/', 301);
    }
    
    function full($alias)
    {
        $this->redirect('/article/' . $alias .  '/', 301);
    }
    
    function category($alias){
        $this->redirect('/article/?category=' . $alias, 301);
    }
}
