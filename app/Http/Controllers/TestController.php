<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Material;
use App\Models\Test;
use App\Models\TestAnswerVariant;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    const VALIDATION_RULES = [
        'category' => 'required',
        'subject' => 'required',
    ];

    public function index(Request $request)
    {
        $tests = Test::query();

        $employees = Employee::query()->get()->pluck('fullName', 'uuid')->toArray();
        if (in_array(auth()->user()?->role, [User::ROLE_ADMIN, User::ROLE_MENTOR])) {
            $employeeUuid = $request->get('employee');
            if (strlen($employeeUuid) && in_array($employeeUuid, array_keys($employees))) {
                $tests = $tests->whereHas('tasks', function($query) use ($employeeUuid) {
                    return $query->where('employee_uuid', '=', $employeeUuid);
                });
            }
        } else {
            $tests = $tests->whereHas('tasks', function($query) {
                return $query->where('employee_uuid', '=', auth()->user()?->employee?->uuid);
            });
        }

        return view('test.index', [
            'tests' => $tests->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function show(string $id)
    {
        /** @var Test $test */
        $test = Test::query()
            ->with('questions')
            ->with('questions.answerVariants')
            ->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();

        $testResult = $test->resultByUser($currentUser);
        if ($testResult instanceof TestResult) {
            session()->flash('info',
                'Данный тест пройден вами.<br> Вы набрали <span class="badge text-bg-primary">'
                . round($testResult->score)
                . ' баллов</span> из '. TestResult::MAX_SCORE .'.<br> Ниже показаны ваши ответы.'
            );
        }

        return view('test.view', [
            'test' => $test,
            'result' => $testResult,
        ]);
    }

    public function solve(Request $request, string $id)
    {
        /** @var Test $test */
        $test = Test::query()
            ->with('questions')
            ->with('questions.answerVariants')
            ->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();

        if ($request->isMethod('get')) {

            /** @var TestResult $lastResult */
            $lastResult = TestResult::query()
                ->where('test_uuid', '=', $test->uuid)
                ->where('user_uuid', '=', $currentUser->uuid)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastResult?->is_closed) {
                // session()->flash('warning', 'Данный тест пройден вами. Показаны ваши ответы.');
                return redirect()->route('test-show', ['id' => $test->uuid]);
                // return view('test.view', [
                //     'test' => $test,
                //     'result' => $lastResult,
                // ]);
            }

            return view('test.solve', [
                'test' => $test,
            ]);
        }

        $answers = [];

        foreach ($request->get('questions') as $questionId => $data) {
            /** @var TestQuestion $question */
            $question = TestQuestion::query()->findOrFail($questionId);
            $answers[$questionId] = [
                'question_id' => $questionId,
                'question_text' => $question->text,
                'answers' => [],
            ];

            foreach ($data as $variantId) {
                /** @var TestAnswerVariant $variant */
                $variant = TestAnswerVariant::query()->findOrFail($variantId);
                $answers[$questionId]['answers'][$variantId] = [
                    'answer_id' => $variantId,
                    'answer_text' => $variant->text,
                ];
            }
        }

        try {
            $testResult = new TestResult();
            $testResult['test_uuid'] = $test->uuid;
            $testResult['user_uuid'] = $currentUser->uuid;
            $testResult['score'] = $testResult->calcScore($answers);
            $testResult['answers'] = $answers;
            $testResult->save();

        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        session()->flash('success', 'Ваши ответы приняты!');
        return redirect()->back();
    }

    public function admin()
    {
        $tests = Test::query()->get();

        return view('test.admin', [
            'tests' => $tests,
        ]);
    }

    public function add()
    {
        return view('test.edit', [
            'test' => new Test(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        Test::query()->create($validated);

        return redirect()->route('test');
    }

    public function edit(string $id)
    {
        return view('test.edit', [
            'test' => Test::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Test $test */
        $test = Test::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $test->update($validated);
        return redirect()->route('test');
    }

    public function delete($id)
    {
        /** @var Test $test */
        $test = Test::query()->findOrFail($id);
        $test->delete();

        if (in_array(url()->previous(), [route('test-manage'), route('test')])) {
            return redirect()->back();
        }

        return redirect()->route('test-manage');
    }
}


