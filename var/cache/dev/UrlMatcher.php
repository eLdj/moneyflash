<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/compte' => [[['_route' => 'compte_index', '_controller' => 'App\\Controller\\CompteController::index'], null, ['GET' => 0], null, true, false, null]],
        '/compte/new' => [[['_route' => 'compte_new', '_controller' => 'App\\Controller\\CompteController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/api/inscrit' => [[['_route' => 'app_inscrit_create', '_controller' => 'App\\Controller\\SecurityController::inscrit'], null, ['POST' => 0], null, false, false, null]],
        '/api/adduser' => [[['_route' => 'app_user_create', '_controller' => 'App\\Controller\\SecurityController::AddUser'], null, ['POST' => 0], null, false, false, null]],
        '/api/login_check' => [
            [['_route' => 'login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'api_login_check'], null, null, null, false, false, null],
        ],
        '/api/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, ['GET' => 0], null, false, false, null]],
        '/api/envoi' => [[['_route' => 'envoi', '_controller' => 'App\\Controller\\TransfertController::envoie'], null, ['POST' => 0], null, false, false, null]],
        '/api/attcmpt' => [[['_route' => 'attcompt', '_controller' => 'App\\Controller\\TransfertController::attcmpt'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api(?'
                    .'|/(?'
                        .'|depot/([^/]++)(*:67)'
                        .'|part(?'
                            .'|update/([^/]++)(*:96)'
                            .'|block/([^/]++)(*:117)'
                        .')'
                        .'|modif_user/([^/]++)(*:145)'
                        .'|comptes/([^/]++)(*:169)'
                        .'|userblock/([^/]++)(*:195)'
                        .'|retrait/([^/]++)(*:219)'
                    .')'
                    .'|(?:/(index)(?:\\.([^/]++))?)?(*:256)'
                    .'|/(?'
                        .'|docs(?:\\.([^/]++))?(*:287)'
                        .'|contexts/(.+)(?:\\.([^/]++))?(*:323)'
                    .')'
                .')'
                .'|/compte/([^/]++)(?'
                    .'|(*:352)'
                    .'|/edit(*:365)'
                    .'|(*:373)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        67 => [[['_route' => 'depot', '_controller' => 'App\\Controller\\AdminController::depot'], ['id'], ['PUT' => 0], null, false, true, null]],
        96 => [[['_route' => 'partupdate', '_controller' => 'App\\Controller\\SecurityController::partUpdate'], ['id'], ['PUT' => 0], null, false, true, null]],
        117 => [[['_route' => 'partblock', '_controller' => 'App\\Controller\\SecurityController::partblock'], ['id'], ['GET' => 0], null, false, true, null]],
        145 => [[['_route' => 'modif_user', '_controller' => 'App\\Controller\\SecurityController::updateUser'], ['id'], ['PUT' => 0], null, false, true, null]],
        169 => [[['_route' => 'new_compte', '_controller' => 'App\\Controller\\SecurityController::addCompte'], ['id'], ['POST' => 0], null, false, true, null]],
        195 => [[['_route' => 'userblock', '_controller' => 'App\\Controller\\SecurityController::userblock'], ['id'], ['GET' => 0], null, false, true, null]],
        219 => [[['_route' => 'retrait', '_controller' => 'App\\Controller\\TransfertController::retrait'], ['codesearch'], ['GET' => 0], null, false, true, null]],
        256 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        287 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        323 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null]],
        352 => [[['_route' => 'compte_show', '_controller' => 'App\\Controller\\CompteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        365 => [[['_route' => 'compte_edit', '_controller' => 'App\\Controller\\CompteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        373 => [
            [['_route' => 'compte_delete', '_controller' => 'App\\Controller\\CompteController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
