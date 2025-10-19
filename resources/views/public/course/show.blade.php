@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/course.css') }}" />
@show

@section('content')
    <div class="course-detail-container">
        <div class="d-flex f-row">
            <div class="course-detail-content col-md-9 col-xs-12">
                <h2>{{ $item['title'] }}</h2>
                <div class="d-flex f-row g-10">
                    <img width="400px" src="{{ $item['img'] }}" />
                    {!! $item['description'] !!}
                </div>
            </div>
            <div class="course-detail-info col-md-3 col-xs-12">
                <h2 class="titr">اطلاعات کلی دوره</h2>
                <div class="d-flex justify-content-space-between"><p>تعداد جلسات</p><p>{{ sizeof($item['sessions']) }}</p></div>
                <div class="d-flex justify-content-space-between"><p>مدت دوره</p><p>{{ $item['duration'] }}</p></div>
                <div class="d-flex justify-content-space-between"><p>تعداد فایل‌های ضمیمه</p><p>{{ $item['attaches_count'] }}</p></div>
                <div class="d-flex f-row g-10">
                    {{ implode(' - ', array_map(function($e) {return "#" . $e; }, $item['tags'])) }} 
                </div>
                <div class="d-flex f-row justify-content-end">
                    <button class="btn btn-primary">خرید دوره</button>
                </div>
            </div>
        </div>
        <h2 class="titr">جلسات دوره</h2>
        <?php $chapters = []; ?>
        @foreach($item['sessions'] as $session)
            @if(!in_array($session['chapter'], $chapters))
                <p class="chapter">{{ $session['chapter'] }}</p>
                <div class="ahidden session">
                    <p>{{ $session['title'] }}</p>
                </div>
                <?php array_push($chapters, $session['chapter']) ?>
            @else
                <div class="ahidden session">
                    <p>{{ $session['title'] }}</p>
                    <p>{{ $session['duration'] }}</p>
                </div>
            @endif
        @endforeach
    </div>
@stop