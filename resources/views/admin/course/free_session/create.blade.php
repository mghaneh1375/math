@extends('layouts.admin.create')

@section('title')
دوره {{ $course->title }} -> مدیریت جلسات رایگان
@stop


@section('form')
    
    <form id="myForm" action="{{ route('course.free_session.store', ['course' => $course->id]) }}" method="post">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="session_id">جلسه مدنظر</label>
                <select name="session_id" id="session_id" required>
                    <option>انتخاب کنید</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">{{ $session->title }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('course.index') }}'" class="btn btn-danger">بازگشت</span>
            <input type="submit" class="btn btn-success" value="ذخیره" />
        </div>

    </form>

@stop