<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- FontAwesome 5 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="icon" href="{{ asset('frontend/favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- sidebar --}}
    <x-admin.side-bar />

    <!-- Content Area -->
    <div id="content" class="content">
        {{-- header --}}
        <x-admin.top-header />

        <main>
            {{ $slot }}
        </main>

    </div>

    <div class="modal fade" id="studentDetailModal" tabindex="-1" aria-labelledby="studentDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="student-detail-body">
                Loading student details...
            </div>
        </div>
    </div>
    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    @stack('scripts')
    <script>
        $(document).ready(function() {
            $('.view-student-detail').on('click', function() {
                var studentId = $(this).data('id');

                // Show the modal first
                $('#studentDetailModal').modal('show');
                // For example:
                $.ajax({
                    url: '{{url("/")}}/admin/student/' + studentId + '/details', // Adjust this route
                    type: 'GET',
                    success: function(data) {
                        $('#student-detail-body').html(data.html);
                    },
                    error: function() {
                        $('#student-detail-body').html('<p>Error loading student details.</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>
