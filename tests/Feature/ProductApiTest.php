<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
        /** @test */
    public function it_can_show_list_of_products()
    {
        $this->json('get', '/api/products')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

    /** @test */
    public function it_can_show_new_arrivals_products()
    {
        $this->json('get', '/api/p/new-arrivals-products')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => []
        ]);
    }

     /** @test */
     public function it_can_show_new_arrivals_filtered_products()
     {
         $this->json('get', '/api/p/new-arrivals-filtered')
         ->assertStatus(200)
         ->assertJsonStructure([
             'data' => []
         ]);
     }

     /** @test */
     public function it_can_show_top_products()
     {
         $this->json('get', '/api/p/top-products')
         ->assertStatus(200)
         ->assertJsonStructure([
             'data' => []
         ]);
     }

       /** @test */
       public function it_can_show_top_filtered_products()
       {
           $this->json('get', '/api/p/top-products-filtered')
           ->assertStatus(200)
           ->assertJsonStructure([
               'data' => []
           ]);
       }
}
