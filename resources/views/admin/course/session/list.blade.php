@extends('layouts.admin.list')

@section('title')
مدیریت جلسات دوره‌ {{ $course->title }}
@stop

@section('backBtn')
    <a href="{{ route('course.index', ['course' => $course->id]) }}" class="btn btn-danger">بازگشت</a>
@stop

@section('createNew')
'{{ route('course.session.create', ['course' => $course->id]) }}'
@stop


@section('items')

    <center style="margin-top: 20px">
        <video class="hidden" controls id="preview_file"></video>
        <table id="table" data-toggle="table" data-search="true" data-show-columns="true" data-key-events="true"
            data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true"
            data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عملیات</th>
                    <th>عنوان</th>
                    <th>فصل</th>
                    <th>مدت زمان</th>
                    <th>تعداد فایل‌های ضمیمه</th>
                    <th>وضعیت نمایش</th>
                    <th>آیا نیاز با چانک شدن دارد؟</th>
                    <th>زمان چانک شدن</th>
                    <th>وضعیت چانک شدن</th>
                    <th>وضعیت انتقال به ftp</th>
                    <th>زمان انتقال به سرور ftp</th>
                    <th>زمان ایجاد</th>
                    <th>زمان ویرایش</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($items as $item)
                    <tr id="item_{{ $item['id'] }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            <div class="flex flex-col gap10">
                                <div class="flex gap10" style="width: 300px; flex-wrap: wrap">
                                    <button
                                        onclick="removeModal('item', {{ $item['id'] }}, '{{ route('session.destroy', ['session' => $item['id']]) }}')"
                                        data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span></button>
                                    
                                    <a href="{{ route('session.session_attach.index', ['session' => $item['id']]) }}" class="btn btn-warning">فایل‌های ضمیمه</a>
                                    <a href="{{ route('session.session_seo_tag.index', ['session' => $item['id']]) }}" class="btn btn-success">تگ‌های سئو</a>
                                    <a href="{{ route('session.file.index', ['session' => $item['id']]) }}" class="btn btn-primary">بارگذاری فایل جلسه</a>
                                    <button onclick="$('#table').addClass('hidden');  $('#preview_file').removeClass('hidden').attr('src', '{{ $item['preview_link'] }}')[0].load()" class="btn btn-primary">مشاهده فایل بارگذاری شده</button>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['chapter'] }}</td>
                        <td>{{ $item['duration'] }}</td>
                        <td>{{ $item['attaches_count'] }}</td>
                        <td>{{ $item['visibility'] ? 'نمایش' : 'مخفی' }}</td>
                        <td>{{ $item['need_chunking'] }}</td>
                        <td>{{ $item['chunked_at'] }}</td>
                        <td>{{ $item['processing_status'] }}</td>
                        <td>{{ $item['transfer_status'] }}</td>
                        <td>{{ $item['transferred_at'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td>{{ $item['updated_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </center>

@stop