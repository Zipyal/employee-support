<?php

namespace App\Http\Controllers;

use App\Models\TestAnswerVariant;
use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestAnswerVariantController extends Controller
{
    const VALIDATION_RULES = [
        'text' => 'required',
        'is_correct' => 'nullable|boolean',
        'test_question_uuid' => 'required',
    ];

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);
        $answer = TestAnswerVariant::query()->create($validated);
        $testUuid = $answer->question?->test_uuid;

        if (null !== $testUuid) {
            return redirect()->route('test-edit', ['id' => $testUuid]);
        }
        return redirect()->route('test');
    }

    public function update(Request $request, string $id)
    {
        /** @var TestAnswerVariant $answer */
        $answer = TestAnswerVariant::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $validated['is_correct'] = $validated['is_correct'] ?? "0";
        $testUuid = $answer->question?->test_uuid;
        $answer->update($validated);

        if (null !== $testUuid) {
            return redirect()->route('test-edit', ['id' => $testUuid]);
        }
        return redirect()->route('test');
    }

    public function delete(string $id)
    {
        /** @var TestAnswerVariant $answer */
        $answer = TestAnswerVariant::query()->findOrFail($id);
        $testUuid = $answer->question?->test_uuid;
        $answer->delete();

        if (null !== $testUuid) {
            return redirect()->route('test-edit', ['id' => $testUuid]);
        }
        return redirect()->route('test');
    }
}


