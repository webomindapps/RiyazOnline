{{-- <p class="">"{{ $content }}"</p> --}}
<p>Dear Student,</p>

<p>We are pleased to share your details below:</p>

<ul>
    <li><strong>Roll Number:</strong> {{ $roll }}</li>
    <li><strong>Email Address:</strong> {{ $email }}</li>
</ul>

<p>To proceed, kindly complete the required form using the link below:</p>

<p><a href="{{ $link }}">{{ $link }}</a></p>

<p>Please find the attached guide for the payment process.</p>

<p>Thank you,<br>
    Riyaaz Online</p>
