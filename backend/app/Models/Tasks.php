<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    // Match these to your ERD exactly
    protected $fillable = ['users_id', 'title', 'description', 'status'];
}
