<?php

namespace Tests\Feature;

use App\Models\Data;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Test extends TestCase
{

    /**
     * Test saving data via API.
     *
     * @return void
     */
    public function testSaveData()
    {
        $token = "fb807a7431356776eaea88963a3b6577";

        // Make the request to save data
        $data = [
            'foo' => 'bar',
            'baz' => [1, 2, 3],
            '0' => ['1'=>0]
        ];

        $response = $this->postJson('/api/save-data', ['data' => $data], [
            'Authorization' => $token
        ]);

        // Check the response status and format
        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'time',
            'memory'
        ]);
    }
}
