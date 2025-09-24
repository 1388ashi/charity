<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>پنل همیار</title>

    <!--Favicon -->
    <link rel="icon" href="{{asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Style css -->
    <link href="{{ asset('assets/css-rtl/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/dark.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/animated.css') }}" rel="stylesheet"/>

    <!--Sidemenu css -->
    <link href="{{ asset('assets/css-rtl/sidemenu.css') }}" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet"/>

    <!---Icons css-->
    <link href="{{ asset('assets/css-rtl/icons.css') }}" rel="stylesheet"/>

    <!---Sidebar css-->
    <link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet"/>

    <!-- Select2 css -->
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

    <!--- INTERNAL jvectormap css-->
    <link href="{{ asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet"/>

    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min-rtl.css') }}" rel="stylesheet"/>

    <!-- INTERNAL Time picker css -->
    <link href="{{ asset('assets/plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet"/>

    <!-- INTERNAL jQuery-countdowntimer css -->
    <link href="{{ asset('assets/plugins/jQuery-countdowntimer/jQuery.countdownTimer.css') }}" rel="stylesheet"/>

    <!-- Sweet-alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <!-- Notifications css -->
    <link href="{{ asset('assets/plugins/notify/css/jquery.growl.css') }}" rel="stylesheet">

    <!-- Summernote css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">

    <!-- PersianDateTimePicker css -->
    <link rel="stylesheet"
        href="{{asset('assets\PersianDateTimePicker-bs4/src/jquery.md.bootstrap.datetimepicker.style.css')}}"/>


    <link href="{{ asset('assets/css-rtl/style-rtl.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css-rtl/custom.css') }}" rel="stylesheet"/>

    <style>
        #growls-default {
            right: 80%;
        }
        label,.card-title {
            font-weight: bold;
        }
        .text-bold{
            font-weight: bold;
        }
        .test {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        .page-header{
            margin:0 !important;
        }
        .inactive {
            opacity: 0.5;
        }

        .hidden {
            display: none;
            float: left;
        }

        .add {
            display: flex;
            float: left;
        }
    </style>

    @yield('styles')
</head>

<body>

    <div id="global-loader">
        <img src="{{asset('assets/images/svgs/loader.svg')}}" alt="loader">
    </div>

    <div class="page">
        <div class="page-main">
            @include('layouts.companion.navbar')
            @include('layouts.companion.menu')

            <div class="main-content" style="padding: 20px;">

                    @yield('content')

            </div>
        </div>

    @include('layouts.companion.footer')
    </div>


<!-- Back to top -->
<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

<!-- Jquery js-->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/image-validation.js')}}"></script>

<!--Moment js-->
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Bootstrap4 js-->
<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!--Othercharts js-->
<script src="{{asset('assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

<!--Sidemenu js-->
<script src="{{asset('assets/plugins/sidemenu/sidemenu.js')}}"></script>

<!-- P-scroll js-->
<script src="{{asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<script src="{{asset('assets/plugins/p-scrollbar/p-scroll1.js')}}"></script>

<!--Sidebar js-->
<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>

<!-- Select2 js -->
<script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>

<!-- INTERNAL Peitychart js-->
<script src="{{asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

<!-- INTERNAL Apexchart js-->
<script src="{{asset('assets/plugins/apexchart/apexcharts.js')}}"></script>

<!-- INTERNAL Vertical-scroll js-->
<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}"></script>
<script src="{{asset('assets/plugins/vertical-scroll/vertical-scroll.js')}}"></script>

<!-- INTERNAL  Datepicker js -->
<script src="{{asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>

<!-- INTERNAL Chart js -->
<script src="{{asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/chart/utils.js')}}"></script>

<!-- INTERNAL Timepicker js -->
<script src="{{asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
<script src="{{asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

<!-- INTERNAL Chartjs rounded-barchart -->
<script src="{{asset('assets/plugins/chart.min/chart.min.js')}}"></script>
<script src="{{asset('assets/plugins/chart.min/rounded-barchart.js')}}"></script>

<!-- INTERNAL jQuery-countdowntimer js -->
<script src="{{asset('assets/plugins/jQuery-countdowntimer/jQuery.countdownTimer.js')}}"></script>

<!-- INTERNAL Index js-->
<script src="{{asset('assets/js/index1.js')}}"></script>

<!-- Sweet-alert js  -->
<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

<!-- Notifications js -->

<!-- Summernote js  -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<!-- PersianDateTimePicker js -->
<script src="{{asset('assets\PersianDateTimePicker-bs4/src/jquery.md.bootstrap.datetimepicker.js')}}"
type="text/javascript"></script>
<script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

<!-- Custom js-->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- Main js -->
{{--{{\Illuminate\Support\Facades\Session::flush()}}--}}
@yield("scripts")
@stack('vue')


@include('components.notifications')
<style>
    .tdnowrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }


    .text-bold{
        font-weight: bold !important;
    }
    p{
        font-size: 16px;
    }
    .p__title{
        margin: 0 0 50px 0 ;
    }
    .rtl{
        direction: rtl !important;
        text-align: right !important;
    }
    .ltr{
        direction: ltr;
        text-align: left;
    }
    </style>

<script src="{{ asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
