@extends('layouts.admin.create')

@section('header')
    @parent
    <script>
        var UploadURL = '{{ route('upload_img') }}';
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{ asset('admin-panel/js/ckeditor.js?v=2.2') }}"></script>
@stop

@section('title')
افزودن جلسه جدید در دوره{{ $course->title }}
@stop


@section('form')
    
    <form id="myForm" action="{{ isset($item) ? route('session.update', ['session' => $item->id]) : route('course.session.store', ['course' => $course->id]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="title">عنوان</label>
                <input value="{{ isset($item) ? $item->title : ''}}" type="text" name="title" id="title" required />
            </div>

            <div>
                <label for="chapter">فصل</label>
                <input value="{{ isset($item) ? $item->chapter : ''}}" type="text" name="chapter" id="chapter" required />
            </div>

            <div>
                <label for="link">لینک جلسه (اختیاری)</label>
                <input value="{{ isset($item) ? $item->link : null}}" type="text" name="link" id="link" required />
            </div>

            <div>
                <label for="duration">مدت دوره به ثانیه</label>
                <input value="{{ isset($item) ? $item->duration : ''}}" type="number" name="duration" id="duration" required />
            </div>

            <div>
                <label for="visibility">وضعیت نمایش</label>
                <select name="visibility" id="visibility">
                    <option {{ isset($item) && $item->visibility ? 'selected' : '' }} value="1">نمایش</option>
                    <option {{ isset($item) && !$item->visibility ? 'selected' : '' }} value="0">مخفی</option>
                </select>
            </div>

            <p style="margin-top: 20px">توضیحات اختیاری</p>
            <div class="editor">
                <div id="toolbar-container"></div>
                @if (isset($item) && $item->description != null && $item->description != '')
                    <div id="desc">{!! $item->description !!}</div>
                @else
                    <div id="desc"></div>
                @endif
            </div>
        </div>

        <input type="hidden" id="description" name="description" />
        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('course.index') }}'" class="btn btn-danger">بازگشت</span>
            <span id="saveBtn" class="btn btn-success">ذخیره</span>
        </div>

    </form>

    <script src="{{ asset('admin-panel/js/initCKs.js?v=2.4') }}"></script>
    <script>
        $(document).ready(function() {
            initCK('{{ csrf_token() }}');
            $("#saveBtn").on('click', function() {
                $("#description").val($("#desc").html());
                $("#myForm").submit();
            });
        });
    </script>
@stop