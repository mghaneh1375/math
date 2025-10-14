@extends('layouts.admin.list')

@section('title')
دوره {{ $course->title }} -> مدیریت جلسات رایگان 
@stop

@section('backBtn')
    <a href="{{ route('course.index') }}" class="btn btn-danger">بازگشت</a>
@stop

@section('createNew')
'{{ route('course.free_session.create', ['course' => $course->id]) }}'
@stop


@section('items')

    <center style="margin-top: 20px">

        <table id="table" data-toggle="table" data-search="true" data-show-columns="true" data-key-events="true"
            data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true"
            data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عملیات</th>
                    <th>عنوان</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($items as $item)
                    <tr id="item_{{ $item['id'] }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            <div class="flex flex-col gap10">
                                <div class="flex gap10">
                                    <button
                                        onclick="removeModal('item', {{ $item['id'] }}, '{{ route('free_session.destroy', ['course' => $course->id, 'session' => $item['id']]) }}')"
                                        data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span></button>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item['title'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </center>

@stop