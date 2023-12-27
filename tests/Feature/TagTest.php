<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_tags(): void
    {
        $tasks = Tag::factory()->count(5)->create();

        $response = $this->get('/api/tags');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_can_show_task()
    {
        $tag = Tag::factory()->create();

        $response = $this->get('/api/tags/' . $tag->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'color' => $tag->color,
            ]
        ]);
    }

    public function test_can_create_task()
    {
        $tagData = [
            'name' => 'Test task',
            'color' => '#000000',
        ];

        $response = $this->post('/api/tags', $tagData);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Tag criada com sucesso',
            'data' => [
                'name' => $tagData['name'],
                'color' => $tagData['color'],
            ]
        ]);
    }

    public function test_can_update_task()
    {
        $tag = Tag::factory()->create();
        $tagData = [
            'name' => 'Updated tag name',
            'color' => '#FF00FF',
        ];

        $response = $this->put('/api/tags/' . $tag->id, $tagData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => "Tag atualizada com sucesso"
        ]);
    }

    public function test_can_delete_task()
    {
        $tag = Tag::factory()->create();

        $response = $this->delete('/api/tags/' . $tag->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Tag deletada com sucesso'
        ]);
    }
}
