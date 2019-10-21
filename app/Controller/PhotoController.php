<?php

class PhotoController extends AppController
{
    public $layout = 'inner';
    public $allow = '*';
    public $helpers = ['Display'];
    public $uses = ['Service', 'Review'];

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->fastNav['/photo/'] = 'Фото до и после';

        parent::seoFilter();
    }

    function index()
    {
        $this->layout = 'fullWidthInner';

        $conditions = [
            'is_child' => 0,
        ];

        if ($this->request->param('category') !== null) {

        }

        $this->set('services', $this->Service->find('all', [
            'order' => 'title',
            'fields' => ['id', 'specialization_id', 'alias', 'title', 'Photo.count'],
            'joins' => [
                '
                    LEFT JOIN (
                        SELECT service_id, count(*) as count FROM `photospecs` GROUP BY service_id
                    ) as `Photo` ON Service.id = Photo.service_id
                ',
            ],
            'conditions' => $conditions,
        ]));
    }
}
