<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Briefing;
use Illuminate\Http\Request;

class BriefingController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'text' => 'required',
    ];

    public function index(Request $request)
    {
        $briefings = Briefing::query()->get();

        return view('briefing.index', [
            'briefings' => $briefings,
        ]);
    }


    public function show(string $id)
    {
        return view('briefing.view', [
            'briefing' => Briefing::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('briefing.edit', [
            'briefing' => new Briefing(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);


        Briefing::query()->create($validated);

        return redirect()->route('briefing');
    }

    public function edit(string $id)
    {
        return view('briefing.edit', [
            'briefing' => Briefing::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Briefing $briefing */
        $briefing = Briefing::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $briefing->update($validated);
        return redirect()->route('briefing');
    }

    public function delete($id)
    {
        /** @var Briefing $briefing */
        $briefing = Briefing::query()->findOrFail($id);
        $briefing->delete();
        return redirect()->route('briefing');
    }
}


