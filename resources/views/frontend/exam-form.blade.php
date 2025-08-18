<x-guest-layout>
    <style>
        .gradient-button {
            background: linear-gradient(45deg, red, rgb(255, 234, 0));
            background-size: 400% 400%;
            animation: gradientAnimation 3s ease infinite;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="hero-section existin">
        <div class="container">
            <div class="hero-content">
                {{-- <h1 class="hero-title">Select the course of your choice</h1> --}}
            </div>
        </div>
    </section>

    <!-- Enhanced Form Section -->
    <section class="form-section">
        <div class="auth-container">
            <!-- Login Form -->
            <div class="form-container login-form animated">
                <div class="d-flex justify-content-between">
                    <h1 class="auth-title">Exam Registration</h1>
                </div>
                <form action="{{ route('exam.registration') }}" method="POST">
                    @csrf
                    <div class="form-group animated delay-1 mb-3">
                        <i class="fas fa-id-card input-icon"></i>
                        <input id="roll_no" type="text" name="roll_no" class="form-control"
                            placeholder="Roll number" required />
                    </div>
                    <div class="form-group animated delay-1 mb-3">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Please enter your registered email ID" required />
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-auth animated delay-2 w-100">
                                <i class="fas fa-arrow-right me-2"></i> Next
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Welcome Panel -->
            <div class="welcome-panel animated delay-1">
                <img src="" alt="" />
            </div>
        </div>
    </section>
</x-guest-layout>
