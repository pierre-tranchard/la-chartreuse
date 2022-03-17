<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    protected static KernelBrowser $client;
    protected static array $connections = [];


    protected function setUp(): void
    {
        self::$client = self::createClient();
        self::$connections['default'] = self::getContainer()->get('doctrine.dbal.default_connection');

        foreach (self::$connections as $connection) {
            $connection->beginTransaction();
        }
        self::$connections['default']->executeQuery('INSERT INTO `user`(username, first_name, last_name, email, birth_date, created_at, salt, password) VALUES("test_user", "foo", "bar", "foo@bar.com", "1988-02-18", "2021-03-17", "'.uniqid().'", "'.uniqid().'");');

        parent::setUp();
    }


    public function testIGetOneUser(): void
    {
        self::$client->request('GET', '/v1/users/1');
        self::assertEquals(200, self::$client->getResponse()->getStatusCode());
        self::$client->request('GET', '/v1/users/2');
        self::assertEquals(404, self::$client->getResponse()->getStatusCode());
    }

    protected function tearDown(): void
    {
        foreach (self::$connections as $connection) {
            if ($connection->isTransactionActive()) {
                $connection->rollBack();
            }
        }

        self::$connections['default']->executeQuery('ALTER TABLE `user` AUTO_INCREMENT = 1');

        parent::tearDown();
    }

}
