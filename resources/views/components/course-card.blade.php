<div class="course-card">
    <p class="course-title">{{ $course['title'] }}</p>
    <img src="{{ $course['img'] }}" width="200px" height="200px" />
    <div class="course-info">
        <p>تعداد جلسات: {{ $course['sessions_count'] }}</p>
        <p>مدت جلسه: {{ $course['duration'] }}</p>
        <p>فیمت دوره: {{ $course['price'] }}</p>
        <p>توضیحات:</p>
        <div class="course-desc">{!! $course['description'] !!}</div>
    </div>
    <div class="course-action">
        <a href="{{ route('course.show', ['course' => $course['id']]) }}" class="btn btn-success">مشاهده بیشتر</a>
    </div>
</div>