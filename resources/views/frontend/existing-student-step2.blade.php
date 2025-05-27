<x-guest-layout>
    <form action="{{ route('renewal.payment.confirm') }}" method="POST" class="form-horizontal" id="contact1"
        style="padding: 4%;">
        @csrf
        <input type="hidden" name="amount" id="amount" value="{{ $total }}">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5 ">
                <div class="order-summary">
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>1 x {{ $studentcourse->course->course_name }}</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ $studentcourse->course->old_student_fees }}</p>
                            </div>
                        </div>
                    </div>
                    @if ($studentcourse->student->penalty_congestion != 1 && $penalty != 0)
                        <div class="gst">
                            <div class="row">
                                <div class="col-lg-8 col-8">
                                    <h5>Penalty</h5>
                                </div>
                                <div class="col-lg-4 col-4 text-end">
                                    <p class="fw-semibold">₹ {{ $penalty }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>Course Fees</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ $subTotal }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>Convenience Fees</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ $convfee }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>Grand Total</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ $total }}</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="student_id" value="{{ $studentcourse->student_id }}" />
                    <input type="hidden" name="billing_name" value="{{ $studentcourse->student?->name }}">
                    <input type="hidden" name="billing_email" value="{{ $studentcourse->student?->email }}">
                    <input type="hidden" name="billing_tel" value="{{ $studentcourse->student?->phone }}">
                    <input type="hidden" name="due" value="{{ $due }}" />
                    <input type="hidden" name="course_type" value="{{ $studentcourse->type }}" />
                    <input type="hidden" name="course_id" value="{{ $studentcourse->course_id }}" />
                    <input type="hidden" name="conv_fee" value="{{ $convfee }}" />
                    <input type="hidden" name="penalty" value="{{ $penalty }}" />
                    <div class="col-lg-12 mt-lg-4">
                        <button class="act-btn">Cancel</button>
                        <button class="act-btn" type="submit">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
