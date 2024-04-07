<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskListRequest;
use App\Http\Resources\TaskListResource;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskListController extends Controller
{

    public function index(Request $req)
    {
        $user = $req->user();
        $tasks = TaskList::query()
            ->where('user_id', $user->id)
            ->where('task_expiration' , '>=' , now())
            ->orderByDesc('created_at')
            ->paginate(10);
        return $this->successResponse(200, [
            'taskLists' => TaskListResource::collection($tasks->load('user')),
            'links' => TaskListResource::collection($tasks)->response()->getData()->links,
            'meta' => TaskListResource::collection($tasks)->response()->getData()->meta,
        ], 'sho all list');
    }


    public function store(TaskListRequest $req)
    {
        $task = (new TaskList())->storeTaskList($req);
        return $this->successResponse(201, new TaskListResource($task), 'task create successfully');
    }

    public function show(TaskList $taskList)
    {
        return $this->successResponse(200, new TaskListResource($taskList), 'show task list');
    }


    public function update(TaskListRequest $req, TaskList $taskList)
    {
        (new TaskList())->updateTaskList($req, $taskList);
        return $this->successResponse(200, new TaskListResource($taskList), 'task updated successfully');
    }

    public function destroy(TaskList $taskList)
    {
        $taskList->delete();
        return $this->successResponse(200 , "task $taskList->title deleted successfully" , "deleted");
    }
}
