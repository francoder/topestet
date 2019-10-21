<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', ['controller' => 'index', 'action' => 'index']);
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/page/*', ['controller' => 'index', 'action' => 'document']);
Router::connect('/feedback/', ['controller' => 'index', 'action' => 'feedback']);
Router::connect('/feedback', ['controller' => 'index', 'action' => 'feedback']);
Router::connect('/privacy', ['controller' => 'index', 'action' => 'privacy']);

Router::connect('/service/all_reviews/', ['controller' => 'service', 'action' => 'all_reviews']);
Router::connect('/service/add_review/', ['controller' => 'service', 'action' => 'add_review']);
Router::connect('/service/:alias',
    ['controller' => 'service', 'action' => 'index'],
    ['alias' => '[0-9a-zA-Z_-]+', 'id' => '[0-9]+']
);

Router::connect('/service/photo/:alias/:id', ['controller' => 'service', 'action' => 'photos'],
    ['alias' => '[0-9a-zA-Z_-]+', 'id' => '[0-9]+']);

Router::connect('/service/photo/:alias/:id/*', ['controller' => 'service', 'action' => 'photos'],
    ['alias' => '[0-9a-zA-Z_-]+', 'id' => '[0-9]+']);

Router::connect('/service/photo/:alias', ['controller' => 'service', 'action' => 'photos'],
    ['alias' => '[0-9a-zA-Z_-]+']);

Router::connect('/service/photo/:alias/*', ['controller' => 'service', 'action' => 'photos'],
    ['alias' => '[0-9a-zA-Z_-]+']);


Router::connect('/catalog/clinic/all/*', ['controller' => 'catalog', 'action' => 'allClinic', 'type' => 'clinics']);
Router::connect('/catalog/clinic/region/*', [
    'controller' => 'catalog', 'action' => 'regionClinic', 'type' => 'clinics',
]);
Router::connect('/catalog/clinic/*', ['controller' => 'catalog', 'action' => 'clinic']);

Router::connect('/clinic/:action/*', ['controller' => 'clinic', 'type' => 'clinic']);
Router::connect('/clinics/:action/*', ['controller' => 'clinic', 'type' => 'clinic']);

Router::connect('/search/:procedure:id/:alias', ['controller' => 'search', 'action' => 'index'],
    [
        'alias' => '[0-9a-zA-Z_-]+',
        'id' => '[0-9]+',
        'procedure' => '[0-9a-zA-Z_-]+',
    ]
);

Router::connect('/review/:id/', ['controller' => 'review', 'action' => 'view'],
    [
        'pass' => ['id'],
        'id' => '[0-9]+',
    ]
);
Router::redirect('/doctors/', ['controller' => 'catalog', 'action' => 'index']);
Router::connect('/reviews/:id/', ['controller' => 'reviews', 'action' => 'view'],
    [
        'pass' => ['id'],
        'id' => '[0-9]+',
    ]
);

Router::connect('/doctors/*', ['controller' => 'specialist', 'action' => 'profile']);

//Router::connect('/article/index/*', ['controller' => 'article', 'action' => 'index']);
Router::connect('/article/:slug/', ['controller' => 'article', 'action' => 'view'],
    [
        'slug' => '[\s0-9a-zA-Z_-]+',
        'pass' => ['id', 'slug'],
        'id' => '[0-9]+',
    ]
);

Router::connect('/profile/:id/', ['controller' => 'profile', 'action' => 'index'],
    [
        'slug' => '[\s0-9a-zA-Z_-]+',
        'pass' => ['id', 'slug'],
        'id' => '[0-9]+',
    ]
);

//Router::connect('/api/get_services', array( 'controller' => 'api','action' => 'get_services'));
/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
