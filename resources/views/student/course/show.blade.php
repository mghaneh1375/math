@extends('layouts.template')

@section('meta_tags')
    @foreach($seo_tags as $seo_tag)
        <meta name="{{ $seo_tag->key }}" content="{{ $seo_tag->value }}" />
    @endforeach
    @foreach($item['seo_tags'] as $seo_tag)
        <meta name="{{ $seo_tag['key'] }}" content="{{ $seo_tag['value'] }}" />
    @endforeach
@stop

@section('content')
@stop
