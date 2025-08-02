<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .payments {
            font-family: Arial, Helvetica, sans-serif;
        }

        h2 {
            margin-bottom: 0;
        }

        .payment-options {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 600;
        }

        .btn-design {
            height: 60px;
            width: auto;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid grey;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    @php
        if ($type == 'new') {
            $callback = route('payment.confirm', $student->id);
        } else {
            $callback = route('renewal.payment.confirm', $student->id);
        }
    @endphp
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_ZZUeN8wD4JZhW5",
            "amount": "{{ $student->grand_total }}",
            "currency": "INR",
            "name": "Riyaaz Online",
            // "description": "Riyaaz Online Course Fee",
            "description": "Marriage Smile Subscription Fee",
            "image": "{{ asset('frontend/ifo.png') }}",
            "order_id": "{{ $order->id }}",
            "callback_url": "{{ $callback }}",
            "theme": {
                "color": "#3399cc"
            },
            "prefill": {
                "name": "{{ $student->f_name . ' ' . $student->l_name }}",
                "email": "{{ $student->email }}",
                "contact": "{{ $student->phone }}"
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = "{{ url('/') }}";
                }
            }
        };
        var rzp1 = new Razorpay(options);
        window.onload = function() {
            rzp1.open();
            redirectAfterDelay();
            // e.preventDefault();
        };
        rzp1.on('payment.failed', function(response) {
            console.log(response);
            const data = {
                razorpay_payment_id: response.error.metadata.payment_id
            };

            // Send a POST request to your server
        });
    </script>
</body>

</html>
