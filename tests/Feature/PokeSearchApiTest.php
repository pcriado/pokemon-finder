<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokeSearchApiTest extends TestCase
{
    /**
     * A basic test of pokemon search
     *
     * @return void
     */
    public function test_basic_search()
    {
        $response = $this->get('/api/v1/pokesearch?keyword=charm');        
        $response->assertStatus(200)
            ->assertJson([['name' => 'charmander']]);
    }
}
