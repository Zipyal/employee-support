<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    const VALIDATION_RULES = [
        'category' => 'required',
        'subject' => 'required',
    ];

    public function index(Request $request)
    {
        return view('test.index', [
            'tests' => Test::query()->get(),
        ]);
    }


    public function show(string $id)
    {
        return view('test.view', [
            'test' => Test::query()->findOrFail($id)
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
        return redirect()->route('test');
    }
}

