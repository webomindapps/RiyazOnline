<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-section" style="height: 35vh;">
        <div class="container">
            <div class="hero-content">
            </div>
        </div>
    </section>

    <!-- Payment Summary Section -->
    <section class="final-step-card-section">
        <div class="final-card row g-0" style="width: 45%">
            <div class="col-md-12 left-side">
                <form action="{{ route('exam.payment.initiate') }}" method="post" class="order-summary">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="exam_fee" value="{{ $exam_fee }}">
                    <input type="hidden" name="conv_fee" value="{{ $convfee }}">
                    <input type="hidden" name="total" value="{{ $total }}">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <h5>Exam Fee</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $exam_fee }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h5>Convenience Fees</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $convfee }}</p>
                        </div>
                    </div>
                    <div class="row total">
                        <div class="col-8">
                            <h4>Grand Total</h4>
                        </div>
                        <div class="col-4 text-end">
                            <h4>₹ {{ $total }}</h4>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ url()->previous() }}" class="act-btn cancel">Cancel</a>
                        <button type="submit" class="act-btn next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <style>
        .check-layer {
            position: relative;
            padding: 0 2px 0 2px;
        }

        .check-layer:before {
            content: ' ';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: transparent;
        }
    </style>
</x-guest-layout>
