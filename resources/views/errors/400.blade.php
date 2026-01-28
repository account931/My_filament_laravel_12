<?php
//my custom error page for 400
?>

@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '400')
@section('message')
    {{ $exception->getMessage() ?: __('Page not found.') }}
    <br>
    <small style="font-size: 0.7rem; color: #6c757d;">it is my custom 400  from /views/errors/400</small>
@endsection
