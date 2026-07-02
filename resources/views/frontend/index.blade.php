<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
             <div class="hero-content">
                <h1 class="hero-title text-center">Choose Your Learning Format</h1>
                <p class="plans-subtitle">
                    Every format below welcomes</br> <span>both children and adult learners, with separate batches</span></br>grouped by age, level and schedule for a comfortable learning experience.
                </p>
            </div>
        </div>
    </section>

    <!-- Plan Cards -->
    <main class="plan-container" id="planCards">
        <div class="container-fluid px-lg-5">
            <div class="outer-card">
                <div class="row mt-3 g-3">
                    <!-- Guru-Shishya Premium -->
                    @foreach ($courses as $course)
                    @php
                    $planBadge = '';
                    $planFormat = '';
                    $monthlyFeeContent="";
                    switch ($course->id) {
                        case '5':
                            $planBadge = 'Personal Mentorship &middot; One-to-One';
                            $planFormat = '
                            <p class="plan-format">Limited Enrolment</p>
                                <div class="plan-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i>1/week</span>
                                    <span><i class="fa-regular fa-clock"></i>60 min</span>
                                    <span><i class="fa-solid fa-book-open"></i>4/month</span>
                                </div>';
                            $monthlyFeeContent = "Monthly Fee <small class='text-muted'>/student</small>";
                            break;
                        case '6':
                            $planBadge = 'Small Group Mentorship';
                            $planFormat = '
                            <p class="plan-format">Up to 2 Students per batch</p>
                                <div class="plan-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i>1/week</span>
                                    <span><i class="fa-regular fa-clock"></i>60 min</span>
                                    <span><i class="fa-solid fa-book-open"></i>4/month</span>
                                </div>';
                            $monthlyFeeContent = "Monthly Fee <small class='text-muted'>/student</small>";
                            break;
                        case '7':
                            $planBadge = 'Group Learning Program';
                            $planFormat = '
                            <p class="plan-format">Up to 6 Students per batch</p>
                                <div class="plan-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i>2/week</span>
                                    <span><i class="fa-regular fa-clock"></i>60 min</span>
                                    <span><i class="fa-solid fa-book-open"></i>8/month</span>
                                </div>';
                            $monthlyFeeContent = "Monthly Fee <small class='text-muted'>/student</small>";
                            break;
                        case '8':
                            $planBadge = 'Optional Add-on';
                            $planFormat = '
                            <p class="plan-format">Practice Support &middot; One-to-One</p>
                                <div class="plan-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i>On request</span>
                                    <span><i class="fa-regular fa-clock"></i>60 min Per session</span>
                                </div>';
                            $monthlyFeeContent = "Fee per Session";
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    @endphp
                    <div class="col-lg-3 col-md-6">
                        <div class="plan-card {{ $course->id == 8 ? 'addon' : '' }}">
                            <div class="plan-header">
                                <h3 class="plan-name">{{ $course->course_name }}</h3>
                                <span class="plan-badge">{!! $planBadge !!}</span>
                            </div>
                            <div class="plan-body">
                                {!! $planFormat !!}
                                <table class="table table-sm table-borderless mb-3 text-start align-middle">
                                    <tbody>
                                        <tr>
                                            <td>{!! $monthlyFeeContent !!}</td>
                                            <td class="text-end fw-semibold">₹{{ number_format($course->old_student_fees) }}</td>
                                        </tr>
                                        @php
                                            $registration_fee = $course->new_student_fees - $course->old_student_fees;
                                        @endphp
                                        @if ($registration_fee > 0)
                                            <tr>
                                                <td>Registration Fee (One-time)</td>
                                                <td class="text-end fw-semibold">₹{{ number_format($registration_fee) }}</td>
                                            </tr>
                                            <tr class="border-top">
                                                <td class="fw-semibold">Total Enrollment Fee</td>
                                                <td class="text-end fw-bold text-danger fs-5">₹{{ number_format($course->new_student_fees) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <p class="plan-desc">
                                    {{ $course->description }}
                                </p>
                                <a href="{{ route('new.registration', $course->id) }}">
                                    <button class="select-btn">Select Course</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </main>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        @import url("https://fonts.googleapis.com/css2?family=Lobster&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap");

        @font-face {
            font-family: "CustomFont";
            src: url("../fonts/blenda-script/blendascript.otf") format("opentype");
        }

        .outer-card {
            padding: 0px 20px;
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

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg,
                    rgba(192, 57, 43, 0.9),
                    rgba(241, 196, 15, 0.8)),
                url("./images/banner-image.webp");
            background-size: cover;
            background-position: 50% 20%;
            color: #fff;
            padding: 40px 0 180px 0;
            position: relative;
            overflow: hidden;
            min-height: 380px;
            height: auto !important;
            display: flex;
            align-items: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-family: "Lobster", cursive;
            font-size: 3.2rem;
            font-weight: 400;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .plans-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.95);
            max-width: 720px;
            margin: 0 auto 30px;
            font-size: 0.98rem;
            line-height: 1.6;
        }

        .plans-subtitle span {
            display: inline-block;
            color: #b61111;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(255,255,255,0.22), rgba(255,255,255,0.12));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.35), 0 3px 10px rgba(0,0,0,0.12);
            border: 1px solid rgba(255,255,255,0.25);
        }

        /* Plans */
        .plan-container {
            margin-top: -180px;
            position: relative;
            z-index: 10;
            padding-bottom: 60px;
        }

        .plan-card {
            background: #fff;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .plan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, .15);
        }

        .plan-card.addon {
            border: 2px dashed var(--secondary);
        }

        .plan-card.addon .plan-header {
            background: linear-gradient(135deg, var(--dark), #4a6076);
        }

        .plan-header {
            background: linear-gradient(135deg, var(#e72427), var(#f35b5d));
            color: #fff;
            text-align: center;
            padding: 18px 20px;
        }

        .plan-name {
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
        }

        .plan-badge {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .25);
            color: #fff;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .plan-body {
            background: #fff5f5;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .plan-format {
            text-align: center;
            font-size: .85rem;
            color: #888;
            font-style: italic;
            margin-bottom: 6px;
        }

        .plan-meta {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 10px;
            padding: 0 10px;
            font-size: .82rem;
            font-weight: 600;
            color: var(--primary);
        }

        .plan-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .plan-desc {
            flex: 1;
            text-align: center;
            color: #555;
            font-size: .92rem;
            line-height: 1.45;
            margin-bottom: 14px;
        }

        .plan-body .table {
            width: 100%;
            margin-bottom: 12px;
            font-size: .9rem;
        }

        .plan-body .table td {
            padding: 6px 4px;
            vertical-align: middle;
        }

        .plan-body .table td:first-child {
            width: 100%;
            white-space: normal;
            word-break: break-word;
        }

        .plan-body .table td:last-child {
            white-space: nowrap;
            text-align: right;
        }

        .plan-body .table tr.border-top td:last-child {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
        }

        .select-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 600;
            letter-spacing: .5px;
            transition: .3s;
        }

        .select-btn:hover {
            transform: translateY(-3px);
            opacity: .9;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .2);
        }

        /* Desktop */
        @media (min-width:992px) {
            .plan-body {
                min-height: 310px;
            }
        }

        /* Tablet */
        @media (max-width:768px) {
            .hero-section {
                padding: 60px 0 120px;
                min-height: auto;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .plan-container {
                margin-top: -80px;
                padding: 30px 15px;
            }

            .plan-card {
                margin-bottom: 20px;
            }
        }

        /* Mobile */
        @media (max-width:480px) {
            .hero-section {
                padding: 40px 0 30px;
            }

            .plan-container {
                margin-top: 20px;
                padding: 20px 10px;
            }
        }
    </style>
</x-guest-layout>
