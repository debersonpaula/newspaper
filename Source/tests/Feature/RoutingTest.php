<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class RoutingTest extends TestCase
{

    /**
     * Routing Tester for general requests
     *
     * @return void
     */

    public function testRoute()
    {
        //test public routes that return simple pages
        $this->getAssertStatus('/','welcome');
        $this->getAssertStatus('/article/1','viewArticle');
        $this->getAssertStatus('/activate/test');
        //test authenticated routes that return simple pages
        $this->getAssertStatusAuth('/home');
        $this->getAssertStatusAuth('/addpost');
        $this->getAssertMethod('post','/article','/home',['artTitle' => 'Test', 'artText' => 'Test', '_token' => csrf_token()]);
        $this->getAssertMethod('delete','/article','/home',['id' => 1, '_token' => csrf_token()]);
    }
    //===========================================================
    //method to test GET
    private function getAssertStatus($route,$view = false){
        $this->get($route)->assertStatus(200);
        if ($view) $this->get($route)->assertViewIs($view);
    }
    //method to test GET with authentication
    private function getAssertStatusAuth($route){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get($route);
        $response->assertStatus(200);
    }
    //method to test method with authentication and redirect
    private function getAssertMethod($method,$route,$redirectTo,$data)
    {
        $user =  factory(User::class)->create();
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->call($method, $route, $data)
            ->assertStatus(302);
        $response->assertRedirect($redirectTo);
    }
}
