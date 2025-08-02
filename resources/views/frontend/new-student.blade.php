<x-guest-layout>
    <!-- Hero Section -->
    <section class="hero-section" style="height: 35vh;">
        <div class="container">
        </div>
    </section>

    <!-- Enhanced Form Section -->
    <section class="form-section">
        <div class="auth-container">
            <!-- Login Form -->
            <div class="form-container login-form animated">
                <h1 class="auth-title">{{ $course->course_name }}</h1>
                {{-- <p class="auth-description">Explore the Soul of Indian Classical Music</p> --}}
                <form action="{{ route('new.registration', $course->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control" placeholder="First Name" name="f_name"
                                    autocomplete="off" value="{{ old('f_name') }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control" placeholder="Last Name" name="l_name"
                                    autocomplete="off" value="{{ old('l_name') }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Email ID -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control" placeholder="Email ID" required
                                    name="email" autocomplete="off" value="{{ old('email') }}" />
                            </div>
                            @if ($errors->has('email'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Age -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-birthday-cake input-icon"></i>
                                <i class="fas fa-chevron-down select-icon"></i>
                                <select class="form-control" required name="age">
                                    <option value="" style="color:red;">Select Age</option>
                                    @for ($i = 3; $i <= 18; $i++)
                                        <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                    <option {{ old('age') == 'Adult' ? 'selected' : '' }} value="Adult">Adult</option>
                                </select>
                            </div>
                            @if ($errors->has('age'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('age') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Country -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-globe input-icon"></i>
                                <i class="fas fa-chevron-down select-icon"></i>
                                <select class="form-control" required name="country_id" id="country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('country_id'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Country -->
                            <div class="form-group animated delay-1">
                                <i class="fa-solid fa-earth-americas input-icon"></i>
                                <i class="fas fa-chevron-down select-icon"></i>
                                <select class="form-control" required name="state_id" id="state">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            @if ($errors->has('state_id'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('state_id') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <!-- Country -->
                            <div class="form-group animated delay-1">
                                <i class="fa-solid fa-location-dot input-icon"></i>
                                <input type="text" placeholder="Enter City" class="form-control" name="city" value="{{ old('city') }}" required />
                            </div>
                            @if ($errors->has('city'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('city') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Mobile Number -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="10" name="phone" class="form-control" placeholder="Mobile Number"
                                    pattern="[0-9]{10}" value="{{ old('phone') }}" required />
                            </div>
                            @if ($errors->has('phone'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- Alternative Mobile Number -->
                            <div class="form-group animated delay-1">
                                <i class="fas fa-phone-alt input-icon"></i>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="10" name="contact_no2" class="form-control"
                                    placeholder="Alternative Mobile Number" pattern="[0-9]{10}"
                                    value="{{ old('contact_no2') }}" />
                            </div>
                            @if ($errors->has('contact_no2'))
                                <span style="font-size: 10px; color:red;">{{ $errors->first('contact_no2') }}</span>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth animated delay-2">
                        Continue to Payment
                    </button>
                </form>
            </div>

            <!-- Welcome Panel -->
            <div class="welcome-panel animated delay-1">

            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('#mySelect').on('change', function() {
                $(this).find('option').each(function() {
                    if ($.trim($(this).val()) == '') {
                        $(this).prop('disabled', true);
                    }
                });
            });
            $('#country').on('change', function() {
                var country_id = $(this).val();
                if (country_id) {
                    $.ajax({
                        url: "{{ url('/') }}/get-states/" + country_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#state').empty().append(
                                '<option selected value="">Select State</option>');
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty().append('<option selected value="">Select State</option>');
                }
            });
        </script>
    @endpush
</x-guest-layout>
