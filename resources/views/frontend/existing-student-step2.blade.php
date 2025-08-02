<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-section existin">
        <div class="container">
            <div class="hero-content">
            </div>
        </div>
    </section>

    <!-- Payment Summary Section -->
    <section class="final-step-card-section">
        <form action="{{ route('renewal.payment.initiate') }}" method="post" class="final-card row g-0">
            @csrf
            <div class="col-md-7 p-4" style="border-right: 1px solid #ddd;">
                <div class="form-group animated delay-1 mb-2">
                    <i class="fas fa-id-card input-icon"></i>
                    <input id="roll_no" type="text" name="roll_no" class="form-control" placeholder="Roll number"
                        readonly value="{{ $student->id }}" />
                </div>
                <div class="form-group animated delay-1 mb-2 my_hide">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ $student->name }}" readonly />
                </div>
                <div class="form-group animated delay-1 mb-2 my_hide">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" class="form-control" name="mobile" id="mobile"
                        value="{{ $student->phone }}" readonly />
                </div>
                <div class="form-group animated delay-1 mb-2">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" class="form-control" id="email" name="email" autofocus="off"
                        placeholder="Please enter your registered email ID" value="{{ $student->email }}" readonly />
                </div>
                <input class="input" id="course_id" type="hidden" name="course_id">
                <div class="form-group animated delay-1 mb-2 my_hide">
                    <i class="fa-solid fa-music input-icon"></i>
                    <input id="course" type="text" name="course" class="form-control" autofocus="off"
                        value="{{ $studentcourse->course?->course_name }}" readonly />
                </div>
                <div class="form-group animated delay-1 mb-2 my_hide">
                    <i class="fa-solid fa-money-bill-1-wave input-icon"></i>
                    <i class="fas fa-chevron-down select-icon"></i>
                    <select class="form-control" name="paying_for" id="payment_type" required>
                        @if ($student->payment_type == 0)
                            <option value="1" selected>Monthly</option>
                            <option value="3">Quaterly</option>
                            <option value="6">Half Yearly</option>
                        @else
                            @if ($student->payment_type == 1)
                                <option value="3" selected>Quaterly</option>
                            @else
                                <option value="6" selected>Half Yearly</option>
                            @endif
                        @endif
                    </select>
                </div>
                @if ($errors->has('paying_for'))
                    <span style="font-size: 10px; color:red;">{{ $errors->first('paying_for') }}</span>
                @endif
            </div>
            <div class="col-md-5 left-side">
                <div class="order-summary">
                    <div class="row g-3">
                        <div class="col-8">
                            <h5>{{ $studentcourse->course?->course_name }}</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ {{ $studentcourse->course?->old_student_fees }}</p>
                        </div>
                        <div class="col-8">
                            <h5>Paying For</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold for_month">{{ $paying_for ?? 0 }} Month</p>
                        </div>
                        <div class="col-8">
                            <h5>Subtotal</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ <span class="amount">{{ $subTotal ?? 0 }}</span> </p>
                        </div>
                        <div class="col-8">
                            <h5>Convenience Fees</h5>
                        </div>
                        <div class="col-4 text-end">
                            <p class="fw-semibold">₹ <span class="conv_fee">{{ $convfee }}</span></p>
                        </div>
                    </div>
                    <div class="row total">
                        <div class="col-8">
                            <h4>Grand Total</h4>
                        </div>
                        <div class="col-4 text-end">
                            <h4>₹ <span class="all_total">{{ $total }}</span></h4>
                        </div>
                    </div>
                    <div class="terms-checkbox">
                        <div class="check-layer">
                            <input type="checkbox" id="terms" required
                                oninvalid="this.setCustomValidity('Please go through the Terms and Conditions')" />
                        </div>
                        <label>
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
                    <input type="hidden" name="conv_fee" value="{{ $convfee }}" id="conv" />
                    <input type="hidden" name="total" id="total" value="{{ $total }}">
                    {{-- <input type="hidden" name="penalty" value="{{ $penalty }}" /> --}}
                    <div class="action-buttons">
                        <a href="{{ url()->previous() }}" class="act-btn cancel w-50">Cancel</a>
                        <button type="submit" class="act-btn next w-50">Next</button>
                    </div>
                </div>
            </div>
        </form>
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
                                <p class="text-justify">For online payments, a nominal convenience fee is charged by
                                    the
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
                            checkbox.setCustomValidity('')
                        }
                    });
                }
            });
            $('#payment_type').on('change', function() {
                var paymentType = parseInt($(this).val());
                var amount = parseFloat("{{ $subTotal }}");
                var convFee = parseFloat("{{ $convfee }}");
                sub_tot = amount * paymentType;
                tot_conv = convFee * paymentType;
                var total = sub_tot + tot_conv;
                $('.amount').text(sub_tot);
                $('.conv_fee').text(tot_conv);
                $('.all_total').text(total);
                $('.for_month').text(paymentType + ' Month' + (paymentType > 1 ? 's' : ''));
                $('#amount').val(sub_tot);
                $('#conv').val(tot_conv);
                $('#total').val(total);
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
