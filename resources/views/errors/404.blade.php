@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    {{ $exception->getMessage() ?: __('Page not found.') }}
    <br>
    <small style="font-size: 0.7rem; color: #6c757d;">it is my custom 404  from /views/errors/404</small>
@endsection
