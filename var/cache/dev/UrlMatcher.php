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
        '/api/list' => [[['_route' => 'list', '_controller' => 'App\\Controller\\ListController::index'], null, null, null, false, false, null]],
        '/api/listparts' => [[['_route' => 'parts', '_controller' => 'App\\Controller\\ListController::listPart'], null, ['GET' => 0], null, false, false, null]],
        '/api/inscrit' => [[['_route' => 'app_inscrit_create', '_controller' => 'App\\Controller\\SecurityController::inscrit'], null, ['POST' => 0], null, false, false, null]],
        '/api/adduser' => [[['_route' => 'app_user_create', '_controller' => 'App\\Controller\\SecurityController::AddUser'], null, ['POST' => 0], null, false, false, null]],
        '/api/login_check' => [
            [['_route' => 'login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'api_login_check'], null, null, null, false, false, null],
        ],
        '/api/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, ['GET' => 0], null, false, false, null]],
        '/api/envoi' => [[['_route' => 'envoi', '_controller' => 'App\\Controller\\TransfertController::envoie'], null, ['POST' => 0], null, false, false, null]],
        '/api/findcode' => [[['_route' => 'findcode', '_controller' => 'App\\Controller\\TransfertController::findCode'], null, ['POST' => 0], null, false, false, null]],
        '/api/retrait' => [[['_route' => 'retrait', '_controller' => 'App\\Controller\\TransfertController::retrait'], null, ['POST' => 0], null, false, false, null]],
        '/api/attcmpt' => [[['_route' => 'attcompt', '_controller' => 'App\\Controller\\TransfertController::attcmpt'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api(?'
                    .'|/(?'
                        .'|depot/([^/]++)(*:67)'
                        .'|list(?'
                            .'|users(?'
                                .'|(?:/([^/]++))?(*:103)'
                                .'|(*:111)'
                            .')'
                            .'|part(?:/([^/]++))?(*:138)'
                        .')'
                        .'|part(?'
                            .'|update/([^/]++)(*:169)'
                            .'|block/([^/]++)(*:191)'
                        .')'
                        .'|modif_user/([^/]++)(*:219)'
                        .'|comptes/([^/]++)(*:243)'
                        .'|userblock/([^/]++)(*:269)'
                    .')'
                    .'|(?:/(index)(?:\\.([^/]++))?)?(*:306)'
                    .'|/(?'
                        .'|docs(?:\\.([^/]++))?(*:337)'
                        .'|contexts/(.+)(?:\\.([^/]++))?(*:373)'
                    .')'
                .')'
                .'|/compte/([^/]++)(?'
                    .'|(*:402)'
                    .'|/edit(*:415)'
                    .'|(*:423)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        67 => [[['_route' => 'depot', '_controller' => 'App\\Controller\\AdminController::depot'], ['id'], ['PUT' => 0], null, false, true, null]],
        103 => [[['_route' => 'user', 'id' => null, '_controller' => 'App\\Controller\\ListController::listUser'], ['id'], ['GET' => 0], null, false, true, null]],
        111 => [[['_route' => 'users', '_controller' => 'App\\Controller\\ListController::listUser'], [], ['GET' => 0], null, false, false, null]],
        138 => [[['_route' => 'part', 'id' => null, '_controller' => 'App\\Controller\\ListController::listPart'], ['id'], ['GET' => 0], null, false, true, null]],
        169 => [[['_route' => 'partupdate', '_controller' => 'App\\Controller\\SecurityController::partUpdate'], ['id'], ['PUT' => 0], null, false, true, null]],
        191 => [[['_route' => 'partblock', '_controller' => 'App\\Controller\\SecurityController::partblock'], ['id'], ['GET' => 0], null, false, true, null]],
        219 => [[['_route' => 'modif_user', '_controller' => 'App\\Controller\\SecurityController::updateUser'], ['id'], ['PUT' => 0], null, false, true, null]],
        243 => [[['_route' => 'new_compte', '_controller' => 'App\\Controller\\SecurityController::addCompte'], ['id'], ['POST' => 0], null, false, true, null]],
        269 => [[['_route' => 'userblock', '_controller' => 'App\\Controller\\SecurityController::userblock'], ['id'], ['GET' => 0], null, false, true, null]],
        306 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        337 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        373 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null]],
        402 => [[['_route' => 'compte_show', '_controller' => 'App\\Controller\\CompteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        415 => [[['_route' => 'compte_edit', '_controller' => 'App\\Controller\\CompteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        423 => [
            [['_route' => 'compte_delete', '_controller' => 'App\\Controller\\CompteController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
