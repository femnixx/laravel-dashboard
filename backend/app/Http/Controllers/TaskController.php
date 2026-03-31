<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 2. Process via your private check method
        $task = $this->check($id, $validated['title'], $validated['description']);

        if (!$task) {
            return response()->json(['message' => 'Task not found or unauthorized'], 404);
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    /**
     * Find, Verify Owner, and Update
     */
    private function check(string $id, string $title, string $description) 
    {
        // We use the 'users_id' column from your ERD to ensure ownership
        $task = Task::where('id', $id)
                    ->where('users_id', Auth::id()) 
                    ->first();

        if ($task) {
            $task->update([
                'title' => $title,
                'description' => $description,
            ]);
            return $task;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)
                    ->where('users_id', Auth::id())
                    ->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found or unauthorized'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}