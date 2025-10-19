<h2 class="titr">لیست دوره‌ها</h2>
<div class="courses-container">
    @foreach ($courses as $item)
        <x-course-card :course="$item" />
    @endforeach
</div>