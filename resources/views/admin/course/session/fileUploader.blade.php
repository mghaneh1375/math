@extends('layouts.admin.list')

@section('title')
مدیریت فایل جلسه {{ $session->title }} در دوره {{ $course->title }}
@stop

@section('backBtn')
    <a href="{{ route('course.index', ['course' => $course->id]) }}" class="btn btn-danger">بازگشت</a>
@stop

@section('items')
    <input id="fileInput" type="file" />
    <button id="uploadBtn">بارگذاری فایل</button>
    <div>
        <progress id="progressBar" value="0" max="100"></progress>
    </div>

    <script>
        $("#uploadBtn").on('click', async () => {
            
            const fileInput = document.getElementById('fileInput');
            
            if (!fileInput.files.length) {
                alert('لطفا یک فایل انتخاب کنید');
                return;
            }

            const file = fileInput.files[0];
            const chunkSize = 500 * 1024; // 200KB برای هر چانک
            const totalChunks = Math.ceil(file.size / chunkSize);
            const fileName = file.name;

            for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
                const start = chunkIndex * chunkSize;
                const end = Math.min(file.size, start + chunkSize);
                const chunk = file.slice(start, end);

                const formData = new FormData();
                formData.append('file', chunk);
                formData.append('chunkIndex', chunkIndex);
                formData.append('totalChunks', totalChunks);
                formData.append('fileName', fileName);
                
                const percent = (chunkIndex / totalChunks) * 100;
                document.getElementById('progressBar').value = percent;

                try {
                    const response = await fetch('{{route('session.file.store', ['session' => $session])}}', {
                        method: 'POST',
                        body: formData,
                    });

                    const result = await response.json();
                    console.log(result.message);
                } catch (error) {
                    console.error(`خطا در آپلود چانک ${chunkIndex}:`, error);
                    return;
                }
            }
        });
    </script>
@stop
