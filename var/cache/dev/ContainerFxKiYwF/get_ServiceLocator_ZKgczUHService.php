<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.ZKgczUH' shared service.

return $this->privates['.service_locator.ZKgczUH'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'exp' => ['privates', 'App\\Repository\\TransactionRepository', 'getTransactionRepositoryService.php', true],
    'manager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
    'serializer' => ['services', 'serializer', 'getSerializerService', false],
    'validator' => ['services', 'validator', 'getValidatorService', false],
], [
    'exp' => 'App\\Repository\\TransactionRepository',
    'manager' => '?',
    'serializer' => '?',
    'validator' => '?',
]);