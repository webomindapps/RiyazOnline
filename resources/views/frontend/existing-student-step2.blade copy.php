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
                <form action="{{ route('renewal.payment.initiate') }}" method="post" class="order-summary">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <h5>{{ $studentcourse->course->course_name }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $studentcourse->course->old_student_fees }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h5>Paying For</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">{{ $paying_for ?? 0 }} Months</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h5>Subtotal</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹{{ $subTotal ?? 0 }}</p>
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
                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" required />
                        <label for="terms">
                            I Agree to the
                            <a href="!#" data-bs-toggle="modal" data-bs-target="#termsModal">
                                Terms and Conditions
                            </a>
                        </label>
                    </div>
                    <input type="hidden" name="student_id" value="{{ $studentcourse->student_id }}" />
                    <input type="hidden" name="due" value="{{ $due }}" />
                    <input type="hidden" name="course_type" value="{{ $studentcourse->type }}" />
                    <input type="hidden" name="course_id" value="{{ $studentcourse->course_id }}" />
                    <input type="hidden" name="amount" id="amount" value="{{ $subTotal }}">
                    <input type="hidden" name="conv_fee" value="{{ $convfee }}" />
                    <input type="hidden" name="total" id="amount" value="{{ $total }}">
                    <input type="hidden" name="paying_for" id="amount" value="{{ $paying_for }}">
                    {{-- <input type="hidden" name="penalty" value="{{ $penalty }}" /> --}}
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
                                <p class="mb-1"><strong><a href="{{route('missing.class')}}">Missing a class</a></strong></p>
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
                            checkbox.disabled = false; // enable the checkbox if initially disabled
                        }
                    });
                }
            });
        </script>
    @endpush
</x-guest-layout>
