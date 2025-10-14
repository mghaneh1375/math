@extends('layouts.admin.list')

@section('title')
دوره {{ $course->title }} -> جلسه -> {{ $session->title }} -> مدیریت فایل‌های ضمیمه 
@stop

@section('backBtn')
    <a href="{{ route('course.session.index', ['course' => $course->id]) }}" class="btn btn-danger">بازگشت</a>
@stop

@section('createNew')
'{{ route('session.session_attach.create', ['session' => $session->id]) }}'
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
                    <th>لینک</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($items as $item)
                    <tr id="item_{{ $item->id }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            <div class="flex flex-col gap10">
                                <div class="flex gap10">
                                    <button
                                        onclick="removeModal('item', {{ $item->id }}, '{{ route('session_attach.destroy', ['session_attach' => $item->id]) }}')"
                                        data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span></button>
                                    <a
                                        href="{{ route('session_attach.edit', ['session_attach' => $item->id]) }}"
                                        data-toggle='tooltip' title="ویرایش" class="btn btn-primary"><span
                                            class="glyphicon glyphicon-edit"></span></a>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item['title'] }}</td>
                        <td><a target="_blank" href="{{ Storage::url($item['file']) }}">مشاهده فایل</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </center>

@stop