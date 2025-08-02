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
        <div class="final-card row g-0">
            <div class="col-md-12 left-side">
                <form action="{{ route('payment.initiate') }}" method="post" class="order-summary">
                    @csrf
                    <input type="hidden" name="temp_id" value="{{ $order->id }}">
                    <input type="hidden" name="payment_status" value="1">
                    <div class="row">
                        <div class="col-8">
                            <h5>1 x {{ $course->course_name }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $course->new_student_fees }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h5>Total</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $course->new_student_fees }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h5>Convenience Fees</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $order->convenience_fees }}</p>
                        </div>
                    </div>
                    <div class="row total">
                        <div class="col-8">
                            <h4>Grand Total</h4>
                        </div>
                        <div class="col-4 text-end">
                            <h4>₹ {{ $order->grand_total }}</h4>
                        </div>
                    </div>

                    <div class="terms-checkbox">
                        <div class="check-layer">
                            <input type="checkbox" id="terms" required
                                oninvalid="this.setCustomValidity('Please go through the Terms and Conditions')" />
                        </div>
                        <label>
                            I Agree to the <a href="!#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms
                                and Conditions</a>
                        </label>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ url()->previous() }}" class="act-btn cancel">Cancel</a>
                        <button type="submit" class="act-btn next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="termsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="termsContent">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="artist-info">
                                <p class="mb-1"><strong>Payments and Refunds</strong></p>
                                <p class="text-justify">All payments are to be made online using Razorpay gateway. We
                                    follow a strict No Refund policy. If a student makes fee payment twice by mistake
                                    ,the amount is refunded via the same source or adjusted against the next payment
                                    cycle. Any Convenience Fee paid in the process cannot be refunded/ reversed</p>
                                <p class="mb-1"><strong>Convenience fees</strong></p>
                                <p class="text-justify">For online payments, a nominal convenience fee is charged by the
                                    payment gateway for processing credit card/debit card/net-banking/e-wallet payments.
                                </p>
                                <p class="mb-1"><strong>Due Date of Monthly fee Payment</strong></p>
                                <p class="text-justify">All students are required to pay the monthly fees on or before
                                    the due date every month. Students’ first date of joining the class is considered as
                                    the Due Date for the Monthly Fee payment.</p>
                                <p class="mb-1"><strong>Class Cycle</strong></p>
                                <p class="text-justify">There are 4 sets of classes conducted in a month during the
                                    regular 4 weeks. In case a month has 5 weeks, there are no regular classes conducted
                                    during the 5th week</p>
                                <p class="mb-1"><strong><a href="{{ route('missing.class') }}">Missing a
                                            class</a></strong></p>
                                <p class="mb-1"><strong>Class Recordings</strong></p>
                                <p class="text-justify">Riyaaz Online aims at preserving the tradition of learning with
                                    the Guru, hence all classes are live classes and not pre recorded sessions. Being
                                    attentive and participative in the class is of utmost importance. Whenever the Guru
                                    decides that a particular recording is necessary for the student’s learning, he will
                                    guide appropriately.</p>
                                <p class="mb-1"><strong>Pictures &amp; Recordings</strong></p>
                                <p class="text-justify">Riyaaz Online would take still pictures and audio-visual
                                    recordings of students from time to time, related to music and matter taught in
                                    class, and will reserve the right to use the same on website, social media and
                                    print.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalBody = document.getElementById('termsContent');
                const checkbox = document.getElementById('terms');

                if (modalBody && checkbox) {
                    modalBody.addEventListener('scroll', function() {
                        const scrollBottom = modalBody.scrollTop + modalBody.clientHeight;
                        const scrollHeight = modalBody.scrollHeight;

                        if (scrollBottom >= scrollHeight - 10) { // 10px margin for tolerance
                            checkbox.checked = true;
                            checkbox.setCustomValidity('');
                        }
                    });
                }
            });
        </script>
    @endpush
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
