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
{{ 'افزودن دوره جدید' }}
@stop


@section('form')
    
    <form id="myForm" action="{{ isset($item) ? route('course.update', ['course' => $item->id]) : route('course.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="title">عنوان</label>
                <input value="{{ old('title', isset($item) ? $item->title : '') }}" type="text" name="title" id="title" required />
            </div>
            
            <div>
                <label for="img_file">{{ isset($item) ? 'تصویر دوره (اختیاری)' : 'تصویر دوره' }}</label>
                <input accept=".jpg,.jpeg,.png" type="file" name="img_file" id="img_file" {{ isset($item) ? '' : 'required' }} />
            </div>

            @if(isset($item))
                <p>تصویر فعلی</p>
                <img src='{{ Storage::url($item->img) }}' width="300px" />
            @endif

            <div>
                <label for="price">قیمت</label>
                <input value="{{ old('price', isset($item) ? $item->price : '') }}" type="number" name="price" id="price" required />
            </div>

            <div>
                <label for="duration">مدت دوره به ثانیه</label>
                <input value="{{ old('duration', isset($item) ? $item->duration : '') }}" type="number" name="duration" id="duration" required />
            </div>

            <div>
                <label for="priority">اولویت نمایش</label>
                <input value="{{ old('priority', isset($item) ? $item->priority : '') }}" type="number" name="priority" id="priority" required />
            </div>

            <div>
                <label for="visibility">وضعیت نمایش</label>
                <select name="visibility" id="visibility">
                    <option {{ isset($item) && $item->visibility ? 'selected' : '' }} value="1">نمایش</option>
                    <option {{ isset($item) && !$item->visibility ? 'selected' : '' }} value="0">مخفی</option>
                </select>
            </div>

            <p style="margin-top: 20px">توضیحات</p>
            <div class="editor">
                <div id="toolbar-container"></div>
                @if(old('description') != null && old('description') != '')
                    <div id="desc">{!! old('description') !!}</div>
                @elseif (isset($item) && $item->description != null && $item->description != '')
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