@extends('layouts.admin.admin_template')

@section('header')
    @parent

    <script src={{ asset('admin-panel/js/calendar.js') }}></script>
    <script src={{ asset('admin-panel/js/calendar-setup.js') }}></script>
    <script src={{ asset('admin-panel/js/calendar-fa.js') }}></script>
    <script src={{ asset('admin-panel/js/jalali.js') }}></script>
    <link rel="stylesheet" href={{ asset('admin-panel/css/calendar-green.css') }}>

    <style>
        #myForm>div:not(.editor)>div:not(.editor) {
            width: calc(100% - 20px);
        }

        #myForm>div:not(.editor)>div:not(.editor) {
            display: flex;
        }

        #myForm>div>div>label {
            width: 150px;
        }

        #myForm>div>div>textarea,
        #myForm>div>div>input,
        #myForm>div>div>select {
            width: calc(100% - 170px);
        }
        .calendar table td,
        .calendar table th {
            min-width: unset !important;
        }
        #myForm>div>div>label {
            width: 180px;
        }
        #myForm>div>div>textarea, #myForm>div>div>input, #myForm>div>div>select {
            width: calc(100% - 200px);
        }
        .result {
            position: relative;
            width: 200px;
            max-height: 300px;
            overflow: hidden;
            border-left: 1px solid;
            border-right: 1px solid;
        }

        .result .item {
            border-bottom: 1px solid black;
            padding: 4px;
            color: black;
            cursor: pointer;
        }
    </style>

@section('moreHeader')
@show

@stop

@section('content')

<div class="col-md-12">
    <div class="sparkline8-list shadow-reset mg-tb-30">
        <div class="sparkline8-hd">
            <div class="main-sparkline8-hd">
                <h1>@yield('title')</h1>
            </div>
        </div>

        <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

            <div id="mainContainer" class="page-content" style="margin-top: 5%; direction: rtl">

                <div class="row">

                    <div class="col-xs-12" style="padding: 0">

                        <div style="margin-top: 10px;">

                            <center id="errs">

                                @if (isset($errors))
                                    @if (is_string($errors))
                                        <p> {{ $errors }} </p>
                                    @elseif ($errors->any())
                                        {!! implode('<br />', $errors->all(':message')) !!}
                                    @endif
                                @endif

                            </center>

                            @yield('form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
