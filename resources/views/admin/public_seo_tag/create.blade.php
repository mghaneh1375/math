@extends('layouts.admin.create')

@section('title')
{{ 'افزودن تگ جدید' }}
@stop


@section('form')
    
    <form id="myForm" action="{{ route('public_seo_tags.store') }}" method="post">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="key">کلید</label>
                <input type="text" name="key" id="key" required />
            </div>

            <div>
                <label for="value">مقدار</label>
                <input type="text" name="value" id="value" required />
            </div>
            
        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('public_seo_tags.index') }}'" class="btn btn-danger">بازگشت</span>
            <input type="submit" class="btn btn-success" value="ذخیره" />
        </div>

    </form>

@stop