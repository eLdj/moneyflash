<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.tjE3b0C' shared service.

return $this->privates['.service_locator.tjE3b0C'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'cmpt' => ['privates', '.errored..service_locator.tjE3b0C.App\\Entity\\Compte', NULL, 'Cannot autowire service ".service_locator.tjE3b0C": it references class "App\\Entity\\Compte" but no such service exists.'],
    'part' => ['privates', '.errored..service_locator.tjE3b0C.App\\Entity\\Partenaire', NULL, 'Cannot autowire service ".service_locator.tjE3b0C": it references class "App\\Entity\\Partenaire" but no such service exists.'],
    'validator' => ['services', 'validator', 'getValidatorService', false],
], [
    'cmpt' => 'App\\Entity\\Compte',
    'part' => 'App\\Entity\\Partenaire',
    'validator' => '?',
]);