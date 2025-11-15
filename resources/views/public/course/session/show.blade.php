@extends('layouts.template')

@section('header')
    @parent
@show

{{-- @section('meta_tags')
    @foreach($seo_tags as $seo_tag)
        <meta name="{{ $seo_tag->key }}" content="{{ $seo_tag->value }}" />
    @endforeach
    @foreach($item['seo_tags'] as $seo_tag)
        <meta name="{{ $seo_tag['key'] }}" content="{{ $seo_tag['value'] }}" />
    @endforeach
@stop --}}

@section('content')
    <center><h1>{{ $session['title'] }}</h1></center>
    <video style="width: calc(100% - 50px)" controls src="{{ $session['preview_link'] }}"></video>
    @if(isset($session['attaches']) && count($session['attaches']) > 0)
        @foreach ($session['attaches'] as $itr)
            <a download href="{{$itr['file']}}">{{ $itr['title'] }}</a>
        @endforeach
    @endif
@stop