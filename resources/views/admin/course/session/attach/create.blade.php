@extends('layouts.admin.create')

@section('title')
افزودن فایل ضمیمه جدید به جلسه {{ $session->title }} در دوره {{ $course->title }}
@stop


@section('form')
    
    <form id="myForm" action="{{ isset($item) ? route('session_attach.update', ['session_attach' => $item->id]) : route('session.session_attach.store', ['session' => $session->id]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="title">عنوان</label>
                <input value="{{ isset($item) ? $item->title : '' }}" type="text" name="title" id="title" required />
            </div>

            <div>
                <label for="file">فایل ضمیمه</label>
                <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png,.pptx,.mp4,.mp3,.mov,.aov" {{ isset($item) ? '' : 'required' }} />
            </div>
            
            @if(isset($item))
                <div>
                    <a target="_blank" href='{{ Storage::url($item->file) }}'>مشاهده فایل فعلی</a>
                </div>
            @endif
            
        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('session.session_attach.index', ['session' => $session->id]) }}'" class="btn btn-danger">بازگشت</span>
            <input type="submit" class="btn btn-success" value="ذخیره" />
        </div>

    </form>

@stop