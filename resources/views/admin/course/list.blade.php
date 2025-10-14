@extends('layouts.admin.list')

@section('title')
مدیریت دوره‌ها
@stop

@section('createNew')
'{{ route('course.create') }}'
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
                    <th>تعداد خریداران</th>
                    <th>تعداد جلسات</th>
                    <th>تعداد فایل‌های ضمیمه</th>
                    <th>امتیاز</th>
                    <th>اولویت</th>
                    <th>وضعیت نمایش</th>
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
                                        onclick="removeModal('item', {{ $item['id'] }}, '{{ route('course.destroy', ['course' => $item['id']]) }}')"
                                        data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span></button>
                                    <a href="{{ route('course.session.index', ['course' => $item['id']]) }}" class="btn btn-info">جلسات</a>
                                    <a href="{{ route('course.free_session.index', ['course' => $item['id']]) }}" class="btn btn-primary">جلسات رایگان دوره</a>
                                    <a href="{{ route('course.attach.index', ['course' => $item['id']]) }}" class="btn btn-warning">فایل‌های ضمیمه</a>
                                    <a href="{{ route('course.tag.index', ['course' => $item['id']]) }}" class="btn btn-default">تگ‌ها</a>
                                    <a href="{{ route('course.seo_tag.index', ['course' => $item['id']]) }}" class="btn btn-success">تگ‌های سئو</a>
                                </div>
                            </div>
                        </td>

                        <td>{{ $item['title'] }}</td>
                        <td>{{ $item['buyers_count'] }}</td>
                        <td>{{ $item['sessions_count'] }}</td>
                        <td>{{ $item['attaches_count'] }}</td>
                        <td>{{ $item['rate'] }}</td>
                        <td>{{ $item['priority'] }}</td>
                        <td>{{ $item['visibility'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td>{{ $item['updated_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </center>

@stop