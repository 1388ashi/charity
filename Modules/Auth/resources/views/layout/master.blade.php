<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

    <!-- Title -->
    <title>ورود به پنل مدیریت</title>

    <!--Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand/favicon.ico') }}" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- Style css -->
    <link href="{{ asset('assets/css-rtl/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css-rtl/dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{ asset('assets/css-rtl/animated.css') }}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ asset('assets/css-rtl/icons.css') }}" rel="stylesheet" />

    <!-- Select2 css -->
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/css-rtl/custom.css') }}" rel="stylesheet" />
</head>
<body style="overflow: hidden; height: 100%; font-family: 'IRANSans-web'">

<!-- Page opened -->
    @yield('content')
<!-- Page closed -->

<!-- Jquery js-->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap4 js-->
<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Select2 js -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<!-- P-scroll js-->
<script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script>

<!-- Custom js-->
<script src="{{ asset('assets/js/custom.js') }}"></script>


</body>
</html>
