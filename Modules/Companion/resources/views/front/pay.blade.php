<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>کمک همیار</title>

    <link rel="icon" href="{{asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/animated.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css-rtl/sidemenu.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css-rtl/icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min-rtl.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/notify/css/jquery.growl.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="{{asset('assets/PersianDateTimePicker-bs4/src/jquery.md.bootstrap.datetimepicker.style.css')}}"/>


    <link href="{{ asset('assets/css-rtl/style-rtl.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css-rtl/custom.css') }}" rel="stylesheet"/>

    <style>
        #growls-default {
            right: 80%;
        }

        body {
            background: rgb(255, 255, 255) !important;
        }
        .container{
            margin-top: 2rem !important;
        }
        button {
            all: unset;
        }
        .filter-btn-form button {
            padding: 6px 50px;
            border-radius: 8px;
            background: rgba(128, 128, 128, 0.5);
        }
        
        .close {
            display: none;
        }

        .filter-btn-form .active-btn {
            background-color: rgb(24 200 24);
            color: white;
        }

        .footer-btn button{
            background-color: #038521 !important;
            color: white;
        }
        .footer-btn .footer-btn-arrow button{
            background-color: rgb(48 66 6 / 50%) !important;
            color: white;
        }
        #submitBtn:disabled {
            background: #ccc;   
            color: #e4dede;
            cursor: not-allowed;
            opacity: 0.3;
        }
        .card-custom {
            background-color: #f8f9fa;
            border-radius: 12px;      
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); 
            padding: 30px;            
            transition: all 0.3s ease-in-out;
        }

        .card-custom:hover {
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }
 
        @media (max-width: 576px) { 
            .filter-btn-form button {
                padding: 6px 10px;  
                font-size: 12px;   
                margin-left: 5px !important;
            }
        }
    </style>
</head>

<body>

    <div id="global-loader">
        <img src="{{ asset('assets/images/svgs/loader.svg') }}" alt="loader">
    </div>

    <div class="container pt-5">
        <div class="d-flex justify-content-around">
            <b style="font-size: 20px">فرم کمک همیاران</b>
            <img class="" src="{{asset('assets/images/brand/favicon.png')}}" height="45px">
        </div>
        <br>
        <div class="card card-custom">
            <div class="card-body">
                @include('components.errors')
                <form id="storeHelp" action="{{route('front.companions.pay')}}" method="POST">
                    @csrf
                    <input type="hidden" id="helpType" name="help_type" value="cash">
                    <input type="hidden" name="companion_id" value="{{$companion->id}}">
                    <div class="row">
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="name" class="control-label">نام و نام خانوادگی</label>
                                <span class="text-danger">&starf;</span>
                                <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control" id="name"
                                        placeholder="نام و نام خانوادگی خود را اینجا وارد کنید..." required autofocus>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="national_code" class="control-label">کد ملی</label>
                                <span class="text-danger">&starf;</span>
                                <input type="text" name="national_code" value="{{ old('national_code') }}"
                                        class="form-control" id="national_code"
                                        placeholder="کد ملی خود را اینجا وارد کنید..." required autofocus>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="form-group">
                                <label for="mobile" class="control-label">شماره موبایل</label>
                                <span class="text-danger">&starf;</span>
                                <input type="text" name="mobile" value="{{ old('mobile') }}"
                                        class="form-control" id="mobile"
                                        placeholder="شماره موبایل خود را اینجا وارد کنید..." required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center filter-btn-form my-5">
                        <button type="button" id="btn-cash" class="active-btn btn-filter ml-5" onclick="setStepForm('cash')">کمک مالی</button>
                        <button type="button" id="btn-objects" class="btn-filter" onclick="setStepForm('objects')">اهدا تجهیزات</button>
                    </div>
                    <div id="cash">
                        <h4>کمک مالی:</h4>
                        <div class="row mb-3 p-3">
                            <div class="col-12  d-flex">
                                <input type="range" class="form-control w-80" id="donationRange" min="1000000" max="100000000" step="1000000" 
                                    value="1000000" name="amount" oninput="updateDonationValue(this.value)">
                                <p class="mt-2 mr-1 mb-0">مبلغ انتخابی: <span id="donationValue">1,000,000</span> تومان</p>
                            </div>
                        </div>
                    </div>
                    <div id="objects" class="close">
                        <h4>اهدا تجهیزات:</h4>

                        @if (count($equipments) != 0 )
                            <div class="row mb-3 p-3">
                                @foreach($equipments as $equipment)
                                    <div class="col-6 col-md-3 mb-3">
                                        <div class="card border border-black shadow-sm p-2 text-center">
                                            <h6 class="mb-2">{{ $equipment->name }}</h6>

                                            <div class="d-flex justify-content-center align-items-center">
                                                <button type="button"
                                                        class="btn btn-outline-danger btn-sm btn-icon mx-1 qty-btn"
                                                        data-id="{{ $equipment->id }}"
                                                        data-action="decrease">-</button>

                                                <span id="qty-display-{{ $equipment->id }}" class="mx-2">0</span>

                                                <button type="button"
                                                        class="btn btn-outline-success btn-sm btn-icon mx-1 qty-btn"
                                                        data-id="{{ $equipment->id }}"
                                                        data-action="increase">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="selectedEquipments"></div>
                    </div>
                </form>
                <hr>
                <div class="d-flex justify-content-between align-items-center filter-btn-form w-100 footer-btn">
                    <button id="submitBtn" type="submit" class="btn btn-success">ثبت اطلاعات
                        <i class="fa fa-hand-o-up text-white mt-1 mr-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}"></script>
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/plugins/chart.min/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/index1.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/PersianDateTimePicker-bs4/src/jquery.md.bootstrap.datetimepicker.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @include('components.notifications')
    <script src="{{ asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        let ActiveStepIndex = "cash"; 

        function setStepForm(index) {
            let btns = document.querySelectorAll(".btn-filter");
            btns.forEach(btn => btn.classList.remove("active-btn"));

            document.getElementById(`btn-${index}`).classList.add("active-btn");

            document.getElementById(ActiveStepIndex).classList.add("close");
            
            ActiveStepIndex = index;
            document.getElementById(ActiveStepIndex).classList.remove("close");
            document.getElementById("helpType").value = index;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const qtyButtons = document.querySelectorAll(".qty-btn");
            const container = document.getElementById("selectedEquipments");
            
            let equipments = {};
            
            qtyButtons.forEach(btn => {
                btn.addEventListener("click", function () {
                    const id = this.dataset.id;
                    const action = this.dataset.action;

                    const display = document.getElementById(`qty-display-${id}`);
                    let currentValue = parseInt(display.innerText);

                    if (action === "increase") {
                        currentValue++;
                    } else if (action === "decrease" && currentValue > 0) {
                        currentValue--;
                    }

                    display.innerText = currentValue;

                    if (currentValue > 0) {
                        equipments[id] = currentValue;
                    } else {
                        delete equipments[id];
                    }
                    container.innerHTML = "";
                    let index = 0;
                    for (const [eqId, qty] of Object.entries(equipments)) {
                        container.innerHTML += `
                            <input type="hidden" name="equipments[${index}][id]" value="${eqId}">
                            <input type="hidden" name="equipments[${index}][quantity]" value="${qty}">
                        `;
                        index++;
                    }
                });
            });
        });

        document.getElementById("submitBtn").addEventListener("click", function () {
            document.getElementById("storeHelp").submit();
        });
        function updateDonationValue(value) {
            document.getElementById("donationValue").innerText = Number(value).toLocaleString("fa-IR");
        }
    </script>
</body>

</html>
