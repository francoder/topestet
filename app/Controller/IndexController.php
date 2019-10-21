<?php

class IndexController extends AppController
{
    public $layout = 'index';
    public $allow = '*';
    public $helpers = ['Display'];
    public $uses = ['Page', 'Feedback', 'Service', 'Review', 'Response', 'Post', 'Photo', 'Specialization'];

    function beforeFilter()
    {
        parent::beforeFilter();

        parent::seoFilter();
    }

    function index()
    {
        $this->set('top_services',
            $this->Service->find('all', [
                'order' => 'review_count DESC, Service.title',
                'limit' => 21,
                'contain' => ['Specialization'],
            ])
        );
        //$this->set("top_specialists", $this->User->find("all", array("order" => "response_count DESC", "limit" => 5, "conditions" => array("is_specialist" => 1))));

        $this->set('top_specialists', $this->User->getTopSpecialist());
        $this->set('last_publications', $this->Post->find('all', [
            'limit' => 5,
            'contain' => 'PostCategory',
            'conditions' => [
                'PostCategory.id in (4,3)'
            ],
            'order' => ['PostCategory.id' => 'DESC'],
        ]));

        $this->set('last_interest', $this->Post->find('all', [
            'contain' => [
                'PostCategory' => [
                    'conditions' => ['PostCategory.alias' => 'star'],
                ],
            ],
            'limit' => 5,
        ]));

        $this->set('last_problems', $this->Post->find('all', [
            'contain' => [
                'PostCategory' => [
                    'conditions' => ['PostCategory.alias' => 'int'],
                ],
            ],
            'limit' => 5,
        ]));

        $this->set('last_reviews', $this->Review->find('all',
            [
                'order' => 'Review.created desc',
                'conditions' => ['Review.specialist_id !=' => null],
                'limit' => 2,
                'contain' => [
                    'Region',
                    'User',
                    'Specialist',
                ],
            ]));

        $this->set('last_reponses', $this->Response->find('all', [
            'order' => 'Response.created desc',
            'limit' => 3,
            'contain' => ['Question' => 'Service', 'Specialist'],
        ]));
        /*
        $this->set('last_photos', $L = $this->Photo->find('all', array(
          'order'      => 'Photo.created DESC',
          'limit'      => 3,
          'contain'    => array('Review', 'Question'),
          'conditions' => array('is_adult' => 0),
        )));
        */
    }

    function document($alias)
    {
        $this->layout = 'inner';
        $page = $this->Page->findByAlias($alias);
        if (empty($page)) {
            return $this->error_404();
        }
        $this->fastNav["/page/{$page['Page']['alias']}/"] = $page['Page']['title_short'];
        $this->set('page', $page);
    }

    function feedback()
    {
        if ($this->request->is('post')) {

            $this->Feedback->set($this->data);

            if ($this->Feedback->validates()) {

                App::uses('CakeEmail', 'Network/Email');
                $email = new CakeEmail();

                if ($this->user) {
                    $mail_from = $this->user['mail'];
                } else {
                    $mail_from = $this->data['Feedback']['mail'];
                }

                $email->from($mail_from);
                $email->to($this->configs['mainmail']);
                $email->subject($this->data['Feedback']['subject'] . " - обратная связь с сайта {$_SERVER['SERVER_NAME']}");
                $email->emailFormat('html');
                $email->viewVars(['user' => $this->user, 'message' => $this->data['Feedback']]);
                $email->template('feedback');
                $email->send();
                $this->set('done', true);
            }
        }
    }

    function privacy() {
        $this->layout = 'fullWidthInner';
        $this->page_title = 'Политика конфиденциальности';
    }
}
