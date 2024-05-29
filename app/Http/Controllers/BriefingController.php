<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\BriefingEmployee;
use App\Models\User;
use Illuminate\Http\Request;

class BriefingController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'text' => 'required',
        'author_id' => 'nullable|exists:employees,uuid',
        'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ];

    protected string $imagesDir = 'img/upload/briefings';

    public function index()
    {
        $briefings = Briefing::query()->where('published', '=', true)->orderBy('created_at', 'desc')->get();

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

    public function admin()
    {
        $briefings = Briefing::query()->orderBy('created_at', 'desc')->get();

        return view('briefing.admin', [
            'briefings' => $briefings,
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

        /** @var Briefing $briefing */
        $briefing = Briefing::query()->create($validated);

        $currentUser = auth()->user();
        Briefing::withoutTimestamps(function () use (&$briefing, $currentUser) {
            $briefing->author_uuid = $currentUser->uuid;
            $briefing->save();
        });

        $this->uploadImages($request, Briefing::class, $briefing->uuid);

        if ($request->get('stay-here')) {
            return redirect()->route('briefing-edit', ['id' => $briefing->uuid]);
        } else {
            return redirect()->route('briefing-manage');
        }
    }

    public function edit(string $id)
    {
        return view('briefing.edit', [
            'briefing' => Briefing::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        /** @var Briefing $briefing */
        $briefing = Briefing::query()->findOrFail($id);
        $briefing->update($validated);

        $this->uploadImages($request, Briefing::class, $briefing->uuid);

        if ($request->get('stay-here')) {
            return redirect()->back();
        } else {
            return redirect()->route('briefing-manage');
        }
    }

    public function delete($id)
    {
        /** @var Briefing $briefing */
        $briefing = Briefing::query()->findOrFail($id);
        $briefing->delete();

        if (in_array(url()->previous(), [route('briefing-manage'), route('briefing')])) {
            return redirect()->back();
        }

        return redirect()->route('briefing-manage');
    }

    public function publish(Request $request, $id)
    {
        /** @var Briefing $briefing */
        $briefing = Briefing::query()->findOrFail($id);
        $published = filter_var($request->get('published') ?? false, FILTER_VALIDATE_BOOL);

        if ($briefing->published !== $published) {
            $briefing->update(['published' => $published]);
        }

        $responseData = [
            'uuid' => $briefing->uuid,
            'published' => $briefing->published,
            'updated_at' => $briefing->updated_at->format('Y-m-d H:i:s'),
        ];

        return response()->json($responseData);
    }

    public function read(Request $request, $id)
    {
        /** @var Briefing $briefing */
        $briefing = Briefing::query()->where('published', '=', true)->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        if (!$briefing->isReadByEmployee($currentEmployee->uuid)) {
            BriefingEmployee::query()->create([
                'briefing_uuid' => $briefing->uuid,
                'employee_uuid' => $currentEmployee->uuid,
            ]);
        }

        $currentEmployee->load('briefingsRead'); // обязательно подгружаем связь снова!

        if ($currentEmployee->isAllPublishedBriefingsRead()) {
            session()->forget('warning');
            session()->flash('success', 'Отлично! Вы прочитали все опубликованные инструктажи.<br> Доступ к системе получен.');
        }

        return redirect()->route('briefing');
    }
}


