<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'is_complete',
        'task_expiration',
    ];

    protected $casts = [
        'is_complete' => 'boolean'
    ];

    /*-----  Relationship  -----*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*-----  CRUD Controller  -----*/
    public function storeTaskList($req)
    {
        $user = $req->user();
        return TaskList::create([
            'user_id' => $user->id,
            'title' => $req->input('title'),
            'task_expiration' => $req->input('task_expiration')
        ]);
    }

    public function updateTaskList($req, $taskList)
    {
        $user = $req->user();
        $taskList->update([
            'user_id' => $user->id,
            'title' => $req->input('title'),
            'is_complete' => $req->is_complete ? $req->input('is_complete') : false,
            'task_expiration' => $req->input('task_expiration')
        ]);
    }

}
