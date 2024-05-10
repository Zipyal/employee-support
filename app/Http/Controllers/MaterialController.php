<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'category' => 'required',
        'text' => 'required',
        'mentor_uuid' => 'required|exists:employees,uuid',
    ];

    public function index(Request $request)
    {
        $materials = Material::query()->get();

        return view('material.index', [
            'materials' => $materials,
        ]);
    }


    public function show(string $id)
    {
        return view('material.view', [
            'material' => Material::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('material.edit', [
            'material' => new Material(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);


        Material::query()->create($validated);

        return redirect()->route('material');
    }

    public function edit(string $id)
    {
        return view('material.edit', [
            'material' => Material::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $material->update($validated);
        return redirect()->route('material');
    }

    public function delete($id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $material->delete();
        return redirect()->route('material');
    }
}


