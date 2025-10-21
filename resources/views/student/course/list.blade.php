@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/course.css') }}" />
@show

@section('content')
    @include('public.course.list')
@stop