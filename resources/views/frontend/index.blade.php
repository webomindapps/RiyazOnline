<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Select Your Course</h1>
            </div>
        </div>
    </section>

    <!-- Plan Cards -->
    <main class="plan-container" id="planCards">
        <div class="container">
            <div class="row g-2">
                @foreach ($courses->chunk(2) as $chunk)
                    <div class="col-lg-6 ">
                        <div class="outer-card">
                            <h2 class="text-center main-card-title">{{ $loop->iteration === 1 ? 'For Adults' : 'For Kids' }}</h2>
                            <div class="row mt-3">
                                @foreach ($chunk as $course)
                                    <!-- course -->
                                    <div class="col-md-6">
                                        <div class="plan-card">
                                            <div class="plan-header">
                                                <h3 class="plan-name">{{ $course->course_name }}</h3>
                                            </div>
                                            <div class="plan-body">
                                                <div class="plan-price">₹ {{ $course->new_student_fees }}
                                                    <span>/-</span>
                                                    <p style="font-size:13px;" class="float-brak">( Includes a one-time registration fee of ₹1,000/- )</p>
                                                </div>
                                                <p class="plan-desc">
                                                    {{ $course->description }}
                                                </p>
                                                <a href="{{ route('new.registration', $course->id) }}">
                                                    <button class="select-btn">Select Plan</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
    <style>
        /* .plan-body {
            padding: 20px !important;
        }
        .float-brak{
            position: relative;
        }
        .float-brak::before {
            content: "(";
            position: absolute;
            left: -8px;
        }
        .float-brak::after {
            content: ")";
            position: absolute;
            right: -8px;
        } */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        @import url("https://fonts.googleapis.com/css2?family=Lobster&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap");

        @font-face {
            font-family: "CustomFont";
            src: url("../fonts/blenda-script/blendascript.otf") format("opentype");
        }

        .outer-card {
            padding: 40px 20px;
            padding-bottom: 20px;
            border-radius: 20px;
            background-color: white;
        }

        .main-card-title {
            font-family: "Lobster", cursive;
            /* font-family: 'Lobster Two', cursive; */
            font-weight: 400;

            font-size: 44px;
            color: #E72427;

            text-transform: capitalize;
            margin-bottom: 20px;
        }
    </style>
</x-guest-layout>
