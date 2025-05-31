<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" dir="ltr" xml:lang="en-gb" lang="en-gb" />

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register Now | Riyaz Online</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" rel="stylesheet"
        crossorigin>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="icon" href="{{ asset('frontend/favicon.ico') }}" type="image/x-icon">
</head>

<body class="bg-banner">
    <section>
        <div class="container">
            <div class="row">
                <header class="bg-white shadow">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="logo-sec">
                                    <a href="https://www.riyaazonline.com/">
                                        <img src="{{ asset('frontend/logo.png') }}" class="img-fluid bg-white p-1"
                                            style="height: 50px;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="menu-bar">
                                    <ul>
                                        <li>
                                            <a href="https://www.riyaazonline.com/">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/') }}">New Students</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('existing.student') }}">Existing Students</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            {{ $slot }}
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: 3px solid #ff4404;">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Riyaz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('frontend/logo.png') }}" alt="logo">
                    <p class="mt-3" style="line-height: 25px;font-size: 20px;font-family: Open Sans, sans-serif;">
                        Thank You for
                        registering in Riyaz....! <br> Check your Mail for further details.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- complate registration Modal -->
    <div class="modal fade" id="completeReg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: 3px solid #ff4404;">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Riyaz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('frontend/logo.png') }}" alt="logo">
                    <p class="mt-3" style="line-height: 25px;font-size: 20px;font-family: Open Sans, sans-serif;">
                        Thank you for updating your details successfully ! Welcome Aboard ! <br>Please check your mail for further details......!</p>
                </div>
            </div>
        </div>
    </div>
    <!-- renew Modal -->
    <div class="modal fade" id="renew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: 3px solid #ff4404;">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Riyaz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('frontend/logo.png') }}" alt="logo">
                    <p class="mt-3" style="line-height: 25px;font-size: 20px;font-family: Open Sans, sans-serif;">
                        Your monthly/quarterly fees payment is successful....! <br> Check your Mail for further details.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @stack('scripts')
    @if (Session::has('registered'))
        <script>
            $(document).ready(function() {
                $('#myModal').modal('show');
                setTimeout(
                    function() {
                        $('#myModal').modal('hide');
                    }, 4000);
            });
        </script>
    @endif
    @if (Session::has('complete'))
        <script>
            $(document).ready(function() {
                $('#completeReg').modal('show');
                setTimeout(
                    function() {
                        $('#myModal').modal('hide');
                    }, 8000);
            });
        </script>
    @endif
    @if (Session::has('renewed'))
        <script>
            $(document).ready(function() {
                $('#renew').modal('show');
                setTimeout(
                    function() {
                        $('#renew').modal('hide');
                    }, 8000);
            });
        </script>
    @endif
</body>

</html>
