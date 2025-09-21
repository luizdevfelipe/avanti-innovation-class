<?php

namespace App\Tests;

use App\Tests\BaseTestCase;
use App\Core\Router;

class RouterTest extends BaseTestCase
{
    private $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    public function test_defining_get_route_with_controller (): void
    {
        $class = new class() {
            function createView() {
                return 'createView called';
            }
        };

        $this->router->get('/produto/create', [$class, 'createView']);

        $this->assertEquals(
            'createView called',
            $this->router->dispatch('/produto/create', 'GET')
        );
    }
}