<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\Material;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // /** @var User $currentUser */
        // $currentUser = auth()->user();
        // if (!$currentUser->can(Permission::FEED_SEE)) {
        //     if ($currentUser->hasExactRoles(Role::ROLE_INTERN)) {
        //         return redirect()->route('briefing')->withErrors(
        //             ['Для дальнейшего пользования системой вам необходимо прочитать все опубликованные инструктажи!']
        //         );
        //     } else {
        //         abort(403);
        //     }
        // }

        $materials = Material::query()->where('published', '=', true)->orderBy('created_at', 'desc')->get();

        return view('home', [
            'materials' => $materials,
        ]);
    }
}


