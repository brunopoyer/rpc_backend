<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_list_tasks()
    {
        $tasks = Task::factory()->count(5)->create();

        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_can_show_task()
    {
        $task = Task::factory()->create();

        $response = $this->get('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date,
                'completed_at' => $task->completed_at,
                'tags' => $task->tags->toArray(),
            ]
        ]);
    }

    public function test_can_create_task()
    {
        $tag = Tag::factory()->count(2)->create()->pluck('id')->map(function ($id) {
            return collect(['id' => $id]);
        })->toArray();
        $taskData = [
            'name' => 'Test task',
            'description' => 'Test task description',
            'due_date' => '2021-01-01',
            'status' => 'todo',
            'tags' => $tag,
        ];

        $response = $this->post('/api/tasks', $taskData);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Tarefa criada com sucesso',
            'data' => [
                'name' => $taskData['name'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'due_date' => '01/01/2021',
            ]
        ]);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        $tags = Tag::count();
        if ($tags < 2) {
            Tag::factory()->count(2 - $tags)->create();
        }

        $taskData = [
            'name' => 'Updated task name',
            'description' => 'Updated task description',
            'due_date' => '2021-01-01',
            'status' => 'todo',
            'completed_at' => '2021-01-01'
        ];

        $response = $this->put('/api/tasks/' . $task->id, $taskData);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => $taskData['name'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'due_date' => '01/01/2021',
            ]
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Tarefa deletada com sucesso'
        ]);
    }
}
