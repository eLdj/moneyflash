<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/part' => [[['_route' => 'app_part_create', '_controller' => 'App\\Controller\\AdminController::createPart'], null, ['POST' => 0], null, false, false, null]],
        '/compte' => [[['_route' => 'compte_index', '_controller' => 'App\\Controller\\CompteController::index'], null, ['GET' => 0], null, true, false, null]],
        '/compte/new' => [[['_route' => 'compte_new', '_controller' => 'App\\Controller\\CompteController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/api/register' => [[['_route' => 'register', '_controller' => 'App\\Controller\\SecurityController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/login_check' => [
            [['_route' => 'login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'api_login_check'], null, null, null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api(?'
                    .'|/(?'
                        .'|partenaires/([^/]++)(*:73)'
                        .'|compte/([^/]++)(*:95)'
                        .'|statut/([^/]++)(*:117)'
                    .')'
                    .'|(?:/(index)(?:\\.([^/]++))?)?(*:154)'
                    .'|/(?'
                        .'|docs(?:\\.([^/]++))?(*:185)'
                        .'|contexts/(.+)(?:\\.([^/]++))?(*:221)'
                    .')'
                .')'
                .'|/compte/([^/]++)(?'
                    .'|(*:250)'
                    .'|/edit(*:263)'
                    .'|(*:271)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        73 => [[['_route' => 'app_user_create', '_controller' => 'App\\Controller\\AdminController::addUser'], ['id'], ['POST' => 0], null, false, true, null]],
        95 => [[['_route' => 'depot', '_controller' => 'App\\Controller\\AdminController::depot'], ['id'], ['PUT' => 0], null, false, true, null]],
        117 => [[['_route' => 'app_part_modif', '_controller' => 'App\\Controller\\AdminController::editpart'], ['id'], ['PUT' => 0], null, false, true, null]],
        154 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        185 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        221 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null]],
        250 => [[['_route' => 'compte_show', '_controller' => 'App\\Controller\\CompteController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        263 => [[['_route' => 'compte_edit', '_controller' => 'App\\Controller\\CompteController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        271 => [
            [['_route' => 'compte_delete', '_controller' => 'App\\Controller\\CompteController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
