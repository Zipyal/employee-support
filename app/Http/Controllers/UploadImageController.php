<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\Material;
use App\Models\Permission;
use App\Models\Task;
use App\Models\UploadImage;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UploadImageController extends Controller
{
    public function delete(string $id)
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        /** @var UploadImage $image */
        $image = UploadImage::query()->findOrFail($id);

        /** @var Briefing|Material|Task $model */
        $model = $image->imageable;
        $modelClass = $image->getMorphClass();

        if (
            (Briefing::class === $modelClass && !$currentUser->canAny([Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN]))
            || (Material::class === $modelClass && !$currentUser->canAny([Permission::MATERIAL_EDIT]))
            || (Task::class === $modelClass && !$currentUser->canAny([Permission::TASK_EDIT, Permission::TASK_EDIT_OWN]))
        ) {
            abort(403);
        }

        if (
            (Briefing::class === $modelClass && !$currentUser->can(Permission::BRIEFING_EDIT) && $currentUser->can(Permission::BRIEFING_EDIT_OWN))
            || (Task::class === $modelClass && !$currentUser->can(Permission::TASK_EDIT) && $currentUser->can(Permission::TASK_EDIT_OWN))
        ) {
            if ($model->author_uuid !== $currentUser->uuid) {
                abort(403);
            }
        }

        try {
            File::delete($image->image_filepath);
            $image->delete();
        } catch (\Throwable $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return response()->noContent();
    }
}
