@extends('layouts.admin.create')

@section('title')
{{ 'افزودن کد تخفیف' }}
@stop


@section('form')
    
    <form id="myForm" action="{{ route('offer.store') }}" method="post">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="value">نوع تخفیف</label>
                <select id="value">
                    <option>انتخاب کنید</option>
                    <option value="PERCENT">درصدی</option>
                    <option value="VALUE">مقداری</option>
                </select>
            </div>
            
            <div>
                <label for="value">مقدار تخفیف</label>
                <input type="number" name="value" id="value" required />
            </div>

            <div>
                <label for="grade_id">(اختیاری)پایه تحصیلی برای اعمال تخفیف</label>
                <select id="grade_id">
                    <option>انتخاب کنید</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endif
                </select>
            </div>
            
            <div>
                <label for="lesson_id">(اختیاری)درس  برای اعمال تخفیف</label>
                <select id="lesson_id">
                    <option>انتخاب کنید</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                    @endif
                </select>
            </div>

            <div>
                <label for="course_id">(اختیاری)دوره برای اعمال تخفیف</label>
                <select id="course_id">
                    <option>انتخاب کنید</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endif
                </select>
            </div>

        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('offer.index') }}'" class="btn btn-danger">بازگشت</span>
            <input type="submit" class="btn btn-success" value="ذخیره" />
        </div>

    </form>

@stop