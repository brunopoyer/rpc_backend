<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function list()
    {
        $tags = Tag::with('tasks')->get();

        return response()->json([
            'success' => true,
            'data' => $tags
        ], 200);
    }

    public function get($id)
    {
        $tag = Tag::with('tasks')->find($id);

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag não encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tag
        ], 200);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:tags|max:255',
            'color' => 'required|regex:/^#[a-f0-9]{6}$/i'
        ]);

        $tag = new Tag();
        $tag->fill($validatedData)->save();

        return response()->json([
            'success' => true,
            'message' => 'Tag criada com sucesso',
            'data' => $tag
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:tags,name,' . $id . '|max:255',
            'color' => 'required|regex:/^#[a-f0-9]{6}$/i'
        ]);

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag não encontrada'
            ], 404);
        }

        $updated = $tag->fill($validatedData)->save();

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Tag atualizada com sucesso'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag não pode ser atualizada'
            ], 500);
        }
    }

    public function delete($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag não encontrada'
            ], 404);
        }

        if ($tag->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag deletada com sucesso'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag não pode ser deletada'
            ], 500);
        }
    }
}
