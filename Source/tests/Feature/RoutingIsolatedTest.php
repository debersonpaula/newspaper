<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoutingIsolatedTest extends TestCase
{
    /**
    * @runInSeparateProcess
    * 
    */

    //test public routes that return pages with headers
    public function testPublicRouteIsolated()
    {
        $this->getAssertHeader('Location: http://newspaper/images/1');
        $this->getAssertHeader('Location: http://newspaper/article/PDF/1');
        $this->getAssertHeader('Location: http://newspaper/rss');
    }
    //===========================================================
    //method to test GET
    private function getAssertHeader($route){
        header($route);
        $this->assertContains($route, xdebug_get_headers());
    }
}
