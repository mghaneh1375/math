@extends('layouts.template')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('asset/css/course.css') }}" />
@show

@section('meta_tags')
    @foreach($seo_tags as $seo_tag)
        <meta name="{{ $seo_tag->key }}" content="{{ $seo_tag->value }}" />
    @endforeach
    @foreach($item['seo_tags'] as $seo_tag)
        <meta name="{{ $seo_tag['key'] }}" content="{{ $seo_tag['value'] }}" />
    @endforeach
@stop

@section('content')
    <div class="course-detail-container">
        <div class="d-flex f-row">
            <div class="course-detail-content col-md-9 col-xs-12">
                <h2>{{ $item['title'] }}</h2>
                <div class="d-flex f-row g-10">
                    <img width="400px" src="{{ $item['img'] }}" />
                    <div>
                        {!! $item['description'] !!}
                    </div>
                </div>
            </div>
            <div class="course-detail-info col-md-3 col-xs-12">
                <h2 class="titr">اطلاعات کلی دوره</h2>
                <div style="height: -webkit-fill-available;" class="d-flex f-col justify-content-space-between">
                    <div class="d-flex f-col">
                        <div class="d-flex justify-content-space-between"><p>تعداد جلسات</p><p>{{ sizeof($item['sessions']) }}</p></div>
                        <div class="d-flex justify-content-space-between"><p>مدت دوره</p><p>{{ $item['duration'] }}</p></div>
                        @if(isset($item['attaches_count']))
                            <div class="d-flex justify-content-space-between"><p>تعداد فایل‌های ضمیمه</p><p>{{ $item['attaches_count'] }}</p></div>
                        @elseif(isset($item['attaches']))
                            <div class="d-flex justify-content-space-between"><p>تعداد فایل‌های ضمیمه</p><p>{{ sizeof($item['attaches']) }}</p></div>
                        @endif
                        <div class="d-flex f-row g-10">
                            {{ implode(' - ', array_map(function($e) {return "#" . $e; }, $item['tags'])) }} 
                        </div>
                    </div>
                
                    @if(!$is_owner)
                        <div class="d-flex f-row justify-content-end">
                            @if(Auth::check())
                                <form method="post" action="{{ route('course.buy', ['course' => $item['id']]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">خرید دوره</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">ورود به سایت برای خرید دوره</a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <h2 class="titr">جلسات دوره</h2>
        <div class="chapters">
            <?php $chapters = []; $i = 0; ?>
            @foreach($item['sessions'] as $session)
                @if(!in_array($session['chapter'], $chapters))
                    @if($i > 0)
                        </div>
                    @endif
                    <div class="chapter" onclick="toggleHiddenClass('{{$i}}')">
                        <p>{{ $session['chapter'] }}</p>
                        <div class="d-flex f-row g-10 align-items-center">
                            <p>{{ "تعداد جلسات این فصل: " . count(array_filter($item['sessions'], fn($x) => $x['chapter'] === $session['chapter'])) }}</p>
                            <span id="icon_{{$i}}" class="icons glyphicon glyphicon-chevron-down"></span>
                        </div>
                    </div>
                    <div class="sessions hidden" id="session_{{$i}}">
                        <div onclick="window.location.href = '{{route('session.show', ['session' => $session['id']])}}'" class="session">
                            <p>{{ $session['title'] }}</p>
                            <div class="d-flex f-row g-10">
                                <p>{{ $session['duration'] }}</p>
                                @if(isset($session['attaches']) && count($session['attaches']) > 0)
                                    <p>{{ "تعداد فایل‌های ضمیمه این جلسه" . count($session['attaches_count']) }}</p>
                                @endif
                            </div>
                        </div>
                        <?php array_push($chapters, $session['chapter']) ?>
                @else
                    <div class="session">
                        <p>{{ $session['title'] }}</p>
                        <div class="d-flex f-row g-10">
                            <p>{{ $session['duration'] }}</p>
                            @if(
                                (isset($session['attaches_count']) && $session['attaches_count'] > 0) ||
                                (isset($session['attaches']) && count($session['attaches']) > 0)
                            )
                                <span> - </span>
                                <p>{{ "تعداد فایل‌های ضمیمه این جلسه: " . (isset($session['attaches']) ? count($session['attaches']) : $session['attaches_count']) }}</p>
                            @endif
                        </div>
                    </div>
                @endif
                <?php $i++; ?>
                @if(sizeOf($item['sessions']) == $i)
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <script>
        function toggleHiddenClass(i) {
            if($(`#session_${i}`).hasClass('hidden')) {
                $(".sessions").addClass('hidden');
                $(`#session_${i}`).removeClass('hidden');
                $('.icons').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(`#icon_${i}`).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            }
            else {
                $(`#session_${i}`).addClass('hidden');
                $(`#icon_${i}`).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            }
        }
    </script>
@stop