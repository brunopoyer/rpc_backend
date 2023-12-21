<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    //
    public function list()
    {
        $tasks = Task::with('tags', 'user')->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ], 200);
    }

    public function get($id)
    {
        $task = Task::with('tags', 'user')->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarefa não encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $task
        ], 200);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'due_date' => 'required|date_format:d/m/Y',
        ]);

        $task = Task::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'user_id' => $validatedData['user_id'],
            'due_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $validatedData['due_date'])->format('Y-m-d'),
            'status' => StatusEnum::Todo
        ]);

        $task->tags()->sync(collect($validatedData['tags'])->map(function ($tag) {
            return $tag["id"];
        }));

        return response()->json([
            'success' => true,
            'message' => 'Tarefa criada com sucesso',
            'data' => $task
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarefa não encontrada'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'max:255',
            'description' => 'string',
            'user_id' => 'exists:users,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'due_date' => 'date_format:d/m/Y',
            'status' => [
                Rule::enum(StatusEnum::class),
            ],
        ]);

        // send only updated fields
        $task->fill($validatedData)->save();

        if (isset($validatedData['tags'])) {
            $task->tags()->detach();
            $task->tags()->sync(collect($validatedData['tags'])->map(function ($tag) {
                return $tag["id"];
            }));
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarefa atualizada com sucesso',
            'data' => $task
        ], 200);
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarefa não encontrada'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tarefa deletada com sucesso',
        ], 200);
    }


}
