@extends('layouts.admin.admin_template')

@section('header')
    @parent
    <style>
        .filter-item {
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
        }
        .filter-item label {
            width: 150px;
        }
        .filter-container {
            display: flex; 
            flex-direction: row; 
            gap: 20px;
            flex-wrap: wrap;
        }
        .filter-section {
            display: flex; 
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        table > tbody > tr > td:nth-child(2) > div {
            align-items: center;
        }
    </style>
@stop

@section('content')

    <div class="col-md-12">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        @yield('title')
                    </h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <div id="mainContainer" class="page-content" style="margin-top: 5%; margin: 50px; direction: rtl">
                    <div class="row">
                        <div id="addToolbarContainer" class="flex gap10">
                            @yield('backBtn')
                            @section('addBtn')
                                <button onclick="document.location.href = @yield('createNew')" class="btn btn-success">افزودن مورد جدید</button>
                            @show
                            @yield('preBtn', '')
                        </div>
                        <div class="col-xs-12">
                            @yield('items')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop