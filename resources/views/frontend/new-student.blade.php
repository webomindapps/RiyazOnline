<x-guest-layout>
    <div class="row">
        <div class="col-lg-9 mx-auto mt-5 ">
            <div class="r-form">
                <h2 class="f-title">{{ $course->course_name }}</h2>
                <form action="{{ route('new.registration', $course->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="text" name="name" autocomplete="off" class="input"
                                    value="{{ old('name') }}">
                                <label class="user-label">Name *</label>
                                <span>(Please fill your complete name as per your ID proof)</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="email" oninput="this.value=this.value.toLowerCase()" name="email"
                                    autocomplete="off" class="input" value="{{ old('email') }}">
                                <label class="user-label">Email *</label>
                                @if ($errors->has('email'))
                                    <span style="font-size: 10px; color:red;">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <select name="age" id="">
                                    <option value="" style="color:red;">Select Age</option>
                                    <option {{ old('age') == 'Adult' ? 'selected' : '' }} value="Adult">Adult</option>
                                    @for ($i = 3; $i <= 18; $i++)
                                        <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @if ($errors->has('age'))
                                    <span style="font-size: 10px; color:red;">{{ $errors->first('age') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <select name="country_id" id="">
                                    <option value="" style="color:red;">Country</option>
                                    @foreach ($countries as $country)
                                        <option {{ $country->id == 1 ? 'selected' : '' }} value="{{ $country->id }}">
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span style="font-size: 10px; color:red;">{{ $errors->first('age') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="10" name="phone" autocomplete="off" class="input"
                                    value="{{ old('phone') }}">
                                <label class="user-label">Mobile No *</label>
                                @if ($errors->has('phone'))
                                    <span style="font-size: 10px; color:red;">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    maxlength="10" name="contact_no2" autocomplete="off" class="input"
                                    value="{{ old('contact_no2') }}">
                                <label class="user-label">Alternate Mobile No *</label>
                                @if ($errors->has('contact_no2'))
                                    <span
                                        style="font-size: 10px; color:red;">{{ $errors->first('contact_no2') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 text-center mt-lg-4">
                            <a href="{{ url()->previous() }}" class="act-btn"
                                style="text-decoration: none;color:white">Back</a>
                            <button type="submit" class="act-btn">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
