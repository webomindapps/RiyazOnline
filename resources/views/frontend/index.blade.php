<x-guest-layout>
    <div class="row">
        <div class="col-lg-9 mx-auto mt-5 ">
            <div class="course-card">
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-lg-11 col-md-11 col-sm-10 col-10 mx-auto py-3 border-bottom">
                            <div class="row ">
                                <div class="col-lg-7 col-md-7">
                                    <h4>{{ $course->course_name }}</h4>
                                    <p class="desc">{{ $course->description }}</p>
                                </div>
                                <div class="col-lg-5 col-md-5 text-end">
                                    <h6 class="price">₹ {{ $course->new_student_fees }}</h6>
                                    <a href="{{ route('new.registration', $course->id) }}">
                                        <button class="select-btn">
                                            Select
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
