<?php

namespace App\Http\Middleware;

use App\Models\Briefing;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class BriefingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();
        if ($currentUser instanceof User && !$currentUser->hasRole(Role::ROLE_ADMIN) && $currentUser->employee instanceof Employee) {

            $briefingsPublishedCount = Briefing::published()->count();

            if (!$currentUser->employee->isAllPublishedBriefingsRead()) {
                session()->flash('warning', 'Для дальнейшего пользования системой вам необходимо прочитать все опубликованные <a href="' . route('briefing') . '">инструктажи</a>!<br><br> Прочитано: ' . $currentUser->employee->briefingsRead->count() . ' из ' . $briefingsPublishedCount);

                if (!Route::is('briefing*', 'profile')) {
                    return redirect()->route('briefing');
                }
            }
        }

        return $next($request);
    }
}
