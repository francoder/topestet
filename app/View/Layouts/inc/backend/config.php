<?php
/**
 * backend/config.php
 *
 * Author: pixelcave
 *
 * Codebase - Backend papges configuration file
 *
 */

// **************************************************************************************************
// BACKEND INCLUDED VIEWS
// **************************************************************************************************

//: Useful for adding different sidebars/headers per page or per section
$cb->inc_side_overlay = resource_path('backend/views/inc_side_overlay.php');
$cb->inc_sidebar = resource_path('backend/views/inc_sidebar.php');
$cb->inc_header = resource_path('backend/views/inc_header.php');
$cb->inc_footer = resource_path('backend/views/inc_footer.php');

// **************************************************************************************************
// BACKEND MAIN MENU
// **************************************************************************************************

// You can use the following array to create your main menu
//$cb->main_nav = [
//    [
//        'name' => '<span class="sidebar-mini-hide">Dashboard</span>',
//        'icon' => 'si si-cup',
//        'url' => '',
//    ],
//    [
//        'name' => '<span class="sidebar-mini-visible">ОБМ</span><span class="sidebar-mini-hidden">База</span>',
//        'type' => 'heading',
//    ],
//    [
//        'name' => '<span class="sidebar-mini-hide">Обменники</span>',
//        'icon' => 'si si-layers',
//        'sub' => [
//            [
//                'name' => 'Добавить обменник',
//                'url' => '',
//            ],
//            [
//                'name' => 'Список',
//                'url' => '',
//            ],
//        ],
//    ],
//];
$navData = [];
foreach ($menu as $parentMenu) {
    $parentMenuTitle = reset($parentMenu);
    $parentMenuUrl = key($parentMenu);
    $sub = isset($parentMenu['sub']) ? $parentMenu['sub'] : [];
    $also = isset($parentMenu['also']) ? $parentMenu['also'] : [];

    $templateNavElement = [
        'name' => '<span class="sidebar-mini-hide">' . $parentMenuTitle . '</span>',
        //'icon' => 'si si-layers',
        'url' => $parentMenuUrl,
    ];

    foreach ($sub as $url => $title) {
        $templateNavElement['sub'][] = [
            'name' => $title,
            'url' => $url,
        ];
    }
    $navData[] = $templateNavElement;
}
$cb->main_nav = $navData;
?>
