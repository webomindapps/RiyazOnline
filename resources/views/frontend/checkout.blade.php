<x-guest-layout>
    <form action="{{ route('payment.confirm') }}" method="post">
        @csrf
        <input type="hidden" name="temp_id" value="{{ $order->id }}">
        <input type="hidden" name="payment_status" value="1">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5 ">
                <div class="order-summary">
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>1 x {{ $course->course_name }}</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ $course->new_student_fees }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>Total</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹
                                    {{ $course->new_student_fees - ($course->new_student_fees * 2.5) / 100 }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="gst">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h5>Convenience Fees</h5>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <p class="fw-semibold">₹ {{ ($course->new_student_fees * 2.5) / 100 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="total">
                        <div class="row">
                            <div class="col-lg-8 col-8">
                                <h4>Grand Total</h4>
                            </div>
                            <div class="col-lg-4 col-4 text-end">
                                <h4>₹ {{ $course->new_student_fees }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <p>
                            <input type="checkbox" required> I Agree
                            <a href="" target="_blank" style="color:#0004ff;text-decoration: underline;">
                                Terms and Conditions
                            </a>
                        </p>
                    </div>
                    <div class="col-lg-12 mt-lg-4">
                        <a href="{{ url()->previous() }}" class="act-btn" style="text-decoration: none;">Cancel</a>
                        <button class="act-btn">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
