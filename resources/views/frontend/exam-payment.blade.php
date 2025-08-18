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

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #e9ecef;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .warning {
            color: #dc3545;
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }

        .info {
            color: #6c757d;
            font-size: 15px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Processing Your Payment</h2>
        <div class="spinner"></div>
        <div class="warning">Do not refresh or press the back button</div>
        <div class="info">Please wait while we complete your transaction...</div>
    </div>
    @php
        $callback = route('exam.payment.confirm', $student->id);
    @endphp
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "",
            "amount": "{{ $total }}",
            "currency": "INR",
            "name": "Riyaaz Online",
            "description": "Riyaaz Online Exam Fee",
            "image": "{{ asset('frontend/ifo.png') }}",
            "order_id": "{{ $order->id }}",
            "callback_url": "{{ $callback }}",
            "theme": {
                "color": "#3399cc"
            },
            "prefill": {
                "name": "{{ $student->name }}",
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
