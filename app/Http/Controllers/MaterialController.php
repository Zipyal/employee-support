<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MaterialController extends Controller
{
    public function index()
    {
        return view('materials.index', [
            'materials' => Material::query()->get()
        ]);
    }

    public function show(string $id)
    {
        return view('materials.view', [
            'material' => Material::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('materials.edit', [
            'material' => new Material()
        ]);
    }

    public function create(Request $request)
    {
        /** @var Material $material */
        $material = new Material();
        $material->Тема = $request->request->get('Тема');
        $material->Категория = $request->request->get('Категория');
        $material->ID_Наставника = $request->request->get('ID_Наставника');
        $material->save();

        return redirect('/materials');
    }

    public function edit(string $id)
    {
        return view('materials.edit', [
            'material' => Material::query()->findOrFail($id)
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $material->Тема = $request->request->get('Тема');
        $material->Категория = $request->request->get('Категория');
        $material->save();

        return redirect('/materials');
    }

    public function delete($id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $material->delete();
        return redirect('/materials');
    }
}


