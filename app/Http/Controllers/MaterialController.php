<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'category' => 'required',
        'text' => 'required',
        'author_id' => 'nullable|exists:employees,uuid',
        'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ];

    protected string $imagesDir = 'img/upload/materials';

    public function index()
    {
        $materials = Material::query()->where('published', '=', true);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        if (!$currentUser->canAny([Permission::MATERIAL_SEE_ALL, Permission::MATERIAL_SEE_PUBLISHED])) {
            if ($currentUser->can(Permission::MATERIAL_SEE_OWN)) {
                $materials->where('author_uuid', '=', $currentUser->uuid);
            } else {
                abort(403);
            }
        }

        return view('material.index', [
            'materials' => $materials->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function show(string $id)
    {
        $material = Material::query()->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        if (!$currentUser->can(Permission::MATERIAL_SEE_ALL)) {
            if (!$currentUser->canAny([Permission::MATERIAL_SEE_PUBLISHED, Permission::MATERIAL_SEE_OWN])) {
                abort(403);
            }

            if (
                !$currentUser->can(Permission::MATERIAL_SEE_PUBLISHED)
                && $currentUser->can(Permission::MATERIAL_SEE_OWN)
                && $material->author_uuid !== $currentUser->uuid
            ) {
                abort(403);
            }

            if (
                $currentUser->can(Permission::MATERIAL_SEE_PUBLISHED)
                && !$currentUser->can(Permission::MATERIAL_SEE_OWN)
                && !$material->published
            ) {
                abort(403);
            }

            if (
                $currentUser->can(Permission::MATERIAL_SEE_PUBLISHED)
                && $currentUser->can(Permission::MATERIAL_SEE_OWN)
                && !$material->published
                && $material->author_uuid !== $currentUser->uuid
            ) {
                abort(403);
            }
        }

        return view('material.view', [
            'material' => $material
        ]);
    }

    public function admin()
    {
        $materials = Material::query()->get();

        return view('material.admin', [
            'materials' => $materials,
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

        /** @var Material $material */
        $material = Material::query()->create($validated);

        $currentUser = auth()->user();
        Material::withoutTimestamps(function () use (&$material, $currentUser) {
            $material->author_uuid = $currentUser->uuid;
            $material->save();
        });

        $this->uploadImages($request, Material::class, $material->uuid);

        if ($request->get('stay-here')) {
            return redirect()->route('material-edit', ['id' => $material->uuid]);
        } else {
            return redirect()->route('material-manage');
        }
    }

    public function edit(string $id)
    {
        return view('material.edit', [
            'material' => Material::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $material->update($validated);

        $this->uploadImages($request, Material::class, $material->uuid);

        if ($request->get('stay-here')) {
            return redirect()->back();
        } else {
            return redirect()->route('material-manage');
        }
    }

    public function delete($id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $material->delete();

        if (in_array(url()->previous(), [route('material-manage'), route('material')])) {
            return redirect()->back();
        }

        return redirect()->route('material-manage');
    }

    public function publish(Request $request, $id)
    {
        /** @var Material $material */
        $material = Material::query()->findOrFail($id);
        $published = filter_var($request->get('published') ?? false, FILTER_VALIDATE_BOOL);

        if ($material->published !== $published) {
            $material->update(['published' => $published]);
        }

        $responseData = [
            'uuid' => $material->uuid,
            'published' => $material->published,
            'updated_at' => $material->updated_at->format('Y-m-d H:i:s'),
        ];

        return response()->json($responseData);
    }
}


