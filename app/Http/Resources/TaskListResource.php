<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskListResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'user_id' => $this->user->name,
                'title' => $this->title,
                'is_complete' => $this->is_complete,
                'task_expiration' => $this->task_expiration,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
