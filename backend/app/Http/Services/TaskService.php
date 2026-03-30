<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function createTask(User $user, array $taskData)
    {
        return DB::transaction(function () use ($user, $taskData) {
            $user = User::lockForUpdate()->find($user->id);
            return $user->tasks()->create($taskData);
        });
    }
}
