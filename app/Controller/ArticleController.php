<?php

class ArticleController extends AppController
{
    public $layout = 'index';
    public $allow = '*';
    public $helpers = ['Display'];
    public $uses = [
        'Post', 'PostCategory',
    ];
    public $paginate = [
        'Post' => [
            'limit' => 10,
            'order' => 'Post.created desc',
            'fields' => [
                'id',
                'title',
                'description',
                'created',
                'alias',
                'PostCategory.*',
            ],
            'contain' => 'PostCategory',
        ],
    ];

    function beforeFilter()
    {
        parent::beforeFilter();

        parent::seoFilter();
    }

    public function index()
    {
        $h1 = 'Все статьи и медиа-материалы TopEstet';
        $currentCategory = null;
        $conditions = null;

        /* Сохранение коммента, почему оно здесь? */
        $this->saveComment();

        $categoryAlias = $this->request->query('category');
        if ($categoryAlias !== null) {
            $category = $this->PostCategory->find('first', [
                'conditions' => [
                    'alias' => $categoryAlias,
                ],
            ]);

            if (empty($category)) {
                return $this->error_404();
            }
            $currentCategory = $category['PostCategory'];
            $conditions['post_category_id'] = $currentCategory['id'];
            $h1 = 'Статьи и медиа метариалы на тему "' . $currentCategory['title'] . '"';
        }

        $this->set('postList', $this->paginate('Post', $conditions));

        if ($currentCategory === null) {
            /* Блок "Популярные статьи" */
            $popularPosts = $this->Post->find('all', [
                'contain' => ['PostCategory'],
                'limit' => 3,
                'conditions' => ['Post.id in (41,17,26)'],
            ]);
            $this->set('popularPosts', $popularPosts);
        }

        // Уставновка заголовков и seo
        $this->set('h1', $h1);
        $this->page_title = 'Статьи';
        $postCategoryList = $this->PostCategory->find('all', []);
        $this->set('postCategoryList', $postCategoryList);
        $this->set('currentCategory', $currentCategory);
    }

    public function view($slug = null)
    {
        $post = $this->Post->find('first', [
            'conditions' => ['Post.alias' => $slug],
            'contain' => ['PostCategory', 'Opinion' => 'Specialist'],
        ]);
        if (empty($post)) {
            return $this->error_404();
        }

        /* Блок "Другие полезные статьи по теме" */
        $this->set('useFullArticlesSlider', $this->Post->find(
            'all',
            [
                'contain' => [
                    'PostCategory' => [
                        'conditions' => [
                            'PostCategory.alias ' => $post['PostCategory']['alias'],
                        ],
                    ],
                ],
                'limit' => 7,
                'order' => ['Post.comment_count' => 'DESC'],
            ]
        ));

        $this->page_title = $post['Post']['page_title'];
        $this->page_description = $post['Post']['description'];
        $this->set('post', $post);
    }

    private function saveComment()
    {
        if ($this->request->is('post') && $this->user) {
            $data = $this->data;
            if (empty($data['Comment']['parent_id'])) {
                unset($data['Comment']['parent_id']);
            }
            $data['Comment']['user_id'] = $this->user['id'];
            if ($this->Comment->save($data)) {
                $this->set('done', true);
                $this->data = [];
            }
        }
    }
}
