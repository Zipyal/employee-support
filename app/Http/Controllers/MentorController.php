<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    const VALIDATION_RULES = [
        'last_name' => 'required',
        'first_name' => 'required',
        'patronymic' => 'required',
        'phone' => 'required|regex:/^[0-9 -()+]+$/',
        'role' => 'required',
        'email' => 'required|email',
        'position' => 'required',
        'department' => 'required',
        'education' => 'required',
        'experience' => 'required|integer',
    ];

    public function index()
    {
        return view('mentors.index', [
            'mentors' => Mentor::query()->get()
        ]);
    }

    public function show(string $id)
    {
        return view('mentors.view', [
            'mentor' => Mentor::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('mentors.edit', [
            'mentor' => new Mentor(),
            'roles' => Mentor::ROLES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);


        Mentor::query()->create($validated);

        return redirect('/mentors');
    }

    public function edit(string $id)
    {
        return view('mentors.edit', [
            'mentor' => Mentor::query()->findOrFail($id),
            'roles' => Mentor::ROLES,
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Mentor $mentor */
        $mentor = Mentor::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $mentor->update($validated);
        return redirect('/mentors');
    }

    public function delete($id)
    {
        /** @var Mentor $mentor */
        $mentor = Mentor::query()->findOrFail($id);
        $mentor->delete();
        return redirect('/mentors');
    }
}


