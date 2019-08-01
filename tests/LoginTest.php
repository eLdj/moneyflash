<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    // public function testSomething()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testIndex()
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('GET', '/api/employes');
    //     $rep=$client->getResponse();
    //     $this->assertSame(200,$client->getResponse()->getStatusCode());
    //     //$this->assertJsonStringEqualsJsonString($jsonstring,$rep->getContent());
    // }
    public function register()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=> 'admin' ,
             'PHP_AUTH_PW'=>'admin'
          ]);
        $crawler = $client->request('POST', '/api/register',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{"username":"admin3", "password":"admin"}');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
    // public function testAjoutKo()
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('POST', '/api/employe',[],[],
    //     ['CONTENT_TYPE'=>"application/json"],
    //     '{"matricule":"004","nom": "ndiaye","prenom": "","salaire": "iiii"}');
    //     $rep=$client->getResponse();
    //     var_dump($rep);
    //     $this->assertSame(200,$client->getResponse()->getStatusCode());
    // }
}
