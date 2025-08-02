<p>Dear {{ $studentcourse->student?->name }}</p>
<p>Greetings from RiyaazOnline music classes. Kindly note, that your fees due date is on {{ date('d-m-Y', strtotime($studentcourse->due_date)) }} .Kindly
    make
    the payment on or before the due date to continue your lessons smoothly. Please ignore if already paid. Thank you.
</p>
<p><a href="https://surl.li/cuctcx">Click</a></p>
<p>Regards,<br>
    RiyaazOnline Team</p>
