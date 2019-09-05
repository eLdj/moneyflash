<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_twig_error_test' => [['code', '_format'], ['_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], []],
    'depot' => [[], ['_controller' => 'App\\Controller\\AdminController::depot'], [], [['text', '/api/depot']], [], []],
    'findnum' => [[], ['_controller' => 'App\\Controller\\AdminController::findNum'], [], [['text', '/api/findnum']], [], []],
    'compte_index' => [[], ['_controller' => 'App\\Controller\\CompteController::index'], [], [['text', '/compte/']], [], []],
    'compte_new' => [[], ['_controller' => 'App\\Controller\\CompteController::new'], [], [['text', '/compte/new']], [], []],
    'compte_show' => [['id'], ['_controller' => 'App\\Controller\\CompteController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/compte']], [], []],
    'compte_edit' => [['id'], ['_controller' => 'App\\Controller\\CompteController::edit'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/compte']], [], []],
    'compte_delete' => [['id'], ['_controller' => 'App\\Controller\\CompteController::delete'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/compte']], [], []],
    'list' => [[], ['_controller' => 'App\\Controller\\ListController::index'], [], [['text', '/api/list']], [], []],
    'user' => [['id'], ['id' => null, '_controller' => 'App\\Controller\\ListController::listUser'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/listusers']], [], []],
    'users' => [[], ['_controller' => 'App\\Controller\\ListController::listUser'], [], [['text', '/api/listusers']], [], []],
    'part' => [['id'], ['id' => null, '_controller' => 'App\\Controller\\ListController::listPart'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/listpart']], [], []],
    'parts' => [[], ['_controller' => 'App\\Controller\\ListController::listPart'], [], [['text', '/api/listparts']], [], []],
    'app_inscrit_create' => [[], ['_controller' => 'App\\Controller\\SecurityController::inscrit'], [], [['text', '/api/inscrit']], [], []],
    'partupdate' => [['id'], ['_controller' => 'App\\Controller\\SecurityController::partUpdate'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/partupdate']], [], []],
    'app_user_create' => [[], ['_controller' => 'App\\Controller\\SecurityController::AddUser'], [], [['text', '/api/adduser']], [], []],
    'modif_user' => [['id'], ['_controller' => 'App\\Controller\\SecurityController::updateUser'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/modif_user']], [], []],
    'new_compte' => [['id'], ['_controller' => 'App\\Controller\\SecurityController::addCompte'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/comptes']], [], []],
    'userblock' => [['id'], ['_controller' => 'App\\Controller\\SecurityController::userblock'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/userblock']], [], []],
    'partblock' => [['id'], ['_controller' => 'App\\Controller\\SecurityController::partblock'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/partblock']], [], []],
    'login' => [[], ['_controller' => 'App\\Controller\\SecurityController::login'], [], [['text', '/api/login_check']], [], []],
    'app_logout' => [[], ['_controller' => 'App\\Controller\\SecurityController::logout'], [], [['text', '/api/logout']], [], []],
    'envoi' => [[], ['_controller' => 'App\\Controller\\TransfertController::envoie'], [], [['text', '/api/envoi']], [], []],
    'findcode' => [[], ['_controller' => 'App\\Controller\\TransfertController::findCode'], [], [['text', '/api/findcode']], [], []],
    'retrait' => [[], ['_controller' => 'App\\Controller\\TransfertController::retrait'], [], [['text', '/api/retrait']], [], []],
    'attcompt' => [[], ['_controller' => 'App\\Controller\\TransfertController::attcmpt'], [], [['text', '/api/attcmpt']], [], []],
    'api_entrypoint' => [['index', '_format'], ['_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index' => 'index'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', 'index', 'index', true], ['text', '/api']], [], []],
    'api_doc' => [['_format'], ['_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], [], [['variable', '.', '[^/]++', '_format', true], ['text', '/api/docs']], [], []],
    'api_jsonld_context' => [['shortName', '_format'], ['_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName' => '.+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '.+', 'shortName', true], ['text', '/api/contexts']], [], []],
    'api_login_check' => [[], [], [], [['text', '/api/login_check']], [], []],
];
