<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Select Your Course | Riyaaz Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
</head>

<body>
    <!-- Responsive Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <div class="container-fluid p-0">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('frontend/logo.png') }}" alt="Riyaaz Online" class="img-fluid" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <img src="{{ asset('frontend/logo.png') }}" alt="Riyaaz Online"
                                class="img-fluid mobile-logo" />
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="d-flex flex-column flex-lg-row ms-lg-auto">
                                <a href="https://www.riyaazonline.com/"
                                    class="btn nav-btn me-lg-2 mb-2 mb-lg-0">Home</a>
                                <a href="{{ url('/') }}" class="btn nav-btn me-lg-2 mb-2 mb-lg-0">
                                    New Students
                                </a>
                                <a href="{{ route('existing.student') }}" class="btn nav-btn me-lg-2 mb-2 mb-lg-0">Existing Students</a>
                                <a href="{{ route('exam.registration') }}" class="btn nav-btn me-lg-2 mb-2 mb-lg-0">Exam Registration</a>
                                <a href="{{ route('missing.class') }}" class="btn nav-btn me-lg-2 mb-2 mb-lg-0">Missing Class Terms</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    {{ $slot }}
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
                        Thank you for updating your details successfully ! Welcome Aboard ! <br>Please check your mail
                        for further details......!</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Close mobile menu when clicking a nav item
        document.querySelectorAll(".nav-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const offcanvas = bootstrap.Offcanvas.getInstance(
                    document.getElementById("offcanvasNavbar")
                );
                offcanvas.hide();
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute("href")).scrollIntoView({
                    behavior: "smooth",
                });
            });
        });
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
    {{-- @if (Session::has('renewed'))
        <script>
            $(document).ready(function() {
                $('#renew').modal('show');
                setTimeout(
                    function() {
                        $('#renew').modal('hide');
                    }, 8000);
            });
        </script>
    @endif --}}
</body>

</html>
