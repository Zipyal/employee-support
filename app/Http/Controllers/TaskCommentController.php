<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    const VALIDATION_RULES = [
        'task_id' => 'required',
        'text' => 'required',
        'author_uuid' => 'nullable',
    ];

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);
        $taskId = $validated['task_id'];
        TaskComment::query()->create($validated);

        return redirect()->route('task-show', ['id' => $taskId]);
    }

    public function update(Request $request, string $id)
    {
        /** @var TaskComment $comment */
        $comment = TaskComment::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $taskId = $validated['task_id'];
        $comment->update($validated);

        return redirect()->route('task-show', ['id' => $taskId]);
    }

    public function delete(string $id)
    {
        /** @var TaskComment $comment */
        $comment = TaskComment::query()->findOrFail($id);
        $taskId = $comment->task_id;
        $comment->delete();

        return redirect()->route('task-show', ['id' => $taskId]);
    }
}


