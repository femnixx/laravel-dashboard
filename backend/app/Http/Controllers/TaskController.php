<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Tasks;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->user()->tasks()->with('user');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->latest()->paginate(15);

        return TaskResource::collection($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, TaskService $taskService)
    {
        try {
            $task = $taskService->createTask($request->user(), $request->validated());
            return new TaskResource($task);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tasks $task)
    {
        //Check again
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status'      => 'sometimes|required|string', // Matches TEXT type in your diagram
        ]);

        try {
            $task->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Task updated successfully',
                'data'    => new TaskResource($task)
            ], 200);

            } catch (Throwable $e) {
            return response()->json([
                'error' => 'Update failed'], 500
                );
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'Sucessfully Delete Task',
        ]);
    }
}