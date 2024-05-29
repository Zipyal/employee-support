@php
    use App\Models\User;
    /** @var \App\Models\Employee[]|\Illuminate\Database\Eloquent\Collection $employees */
@endphp
@extends('layout.main')
@section('title')
    Сотрудники
@endsection
{{--@section('buttons')
    @if(in_array(auth()?->user()?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR]))
        <a class="btn btn-sm btn-outline-success" href="{{ route('employee-add') }}"><i class="fas fa-plus"></i></a>
    @endif
@endsection--}}
@section('content')
    <div class="container">
        @if($employees->isNotEmpty())
            <div class="row">
                @foreach($employees as $item)
                    <div class="col-12 col-md-4 mb-5">
                        <div class="card shadow-sm mb-5">
                            <div class="row g-0" style="min-height: 160px">
                                <div class="col-md-3 align-self-end">
                                    <a href="{{ route('employee-show', ['id' => $item->uuid]) }}">
                                        <img src="{{ asset($item->image_filepath ?? '/img/no_avatar.png') }}" class="img-fluid rounded-start">
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body mb-0 pb-0">
                                        <table class="table table-hover table-borderless table-responsive table-sm small lh-1 mb-0">
                                            <tr class="row">
                                                <th class="col-5 text-end py-1">Должность:</th>
                                                <td class="col-7 text-start py-1">{{ $item->lastContract()?->position }}</td>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-5 text-end py-1">Отдел:</th>
                                                <td class="col-7 text-start py-1">{{ $item->lastContract()?->department }}</td>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-5 text-end py-1">Опыт работы:</th>
                                                <td class="col-7 text-start py-1">{{ $item->experience }}</td>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-5 text-end py-1">Телефон:</th>
                                                <td class="col-7 text-start py-1">{{ $item->phone }}</td>
                                            </tr>
                                            <tr class="row">
                                                <th class="col-5 text-end py-1">E-mail:</th>
                                                <td class="col-7 text-start py-1">{{ $item->email }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h5 class="card-title"><a class="hover-underline" href="{{ route('employee-show', ['id' => $item->uuid]) }}">{{ $item->fullName }}</a></h5>
                                <div class="card-subtitle">
                                    @if($item->user?->roles)
                                        @foreach($item->user?->roles as $role)
                                            <span class="badge rounded-pill text-bg-secondary fw-normal">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-danger small">{{ !$item->user ? 'без учётной записи' : 'без роли' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-muted">У вас в подчинении нет сотрудников.</div>
        @endif
    </div>
@endsection
