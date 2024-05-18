@extends('layout.main')

@section('title', 403)
@section('subtitle', __($exception->getMessage() ?: 'Forbidden'))
