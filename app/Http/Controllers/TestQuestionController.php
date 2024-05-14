<?php

namespace App\Http\Controllers;

use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    const VALIDATION_RULES = [
        'text' => 'required',
        'test_uuid' => 'required',
    ];

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);
        $testId = $validated['test_uuid'];
        TestQuestion::query()->create($validated);

        return redirect()->route('test-edit', ['id' => $testId]);
    }

    public function update(Request $request, string $id)
    {
        /** @var TestQuestion $comment */
        $comment = TestQuestion::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $testId = $validated['test_uuid'];
        $comment->update($validated);

        return redirect()->route('test-edit', ['id' => $testId]);
    }

    public function delete(string $id)
    {
        /** @var TestQuestion $comment */
        $comment = TestQuestion::query()->findOrFail($id);
        $testId = $comment->test_uuid;
        $comment->delete();

        return redirect()->route('test-edit', ['id' => $testId]);
    }
}


