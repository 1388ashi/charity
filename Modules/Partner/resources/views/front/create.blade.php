<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ثبت نام درخواست</title>

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
            <b style="font-size: 20px">فرم ثبت نام درخواست کمک ازدواج</b>
            <img class="" src="{{asset('assets/images/brand/favicon.png')}}" height="45px">
        </div>
        <hr>
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-center filter-btn-form mb-5">
                    <button id="btn-step1" class="active-btn btn-filter ml-5" onclick="setStepForm(1)">اطلاعات متقاضی</button>
                    <button id="btn-step2" class="ml-5 btn-filter" onclick="setStepForm(2)">اطلاعات همسر</button>
                    <button id="btn-step3" class="btn-filter" onclick="setStepForm(3)">اطلاعات ازدواج</button>
                </div>
                @include('components.errors')
                <form id="createPartner" action="{{route('front.partners.store')}}" method="POST">
                    @csrf
                    <div id="step1">
                        <h3 class="mb-5">اطلاعات متقاضی:</h3>
                        <div class="row">
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">نام و نام خانوادگی</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[0][name]" value="{{ old('partners.0.name') }}"
                                        class="form-control" id="name"
                                        placeholder="نام کامل خود را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="gender" class="control-label">جنسیت</label>
                                    <span class="text-danger">&starf;</span>
                                    <select name="partners[0][gender]" class="form-control select2" required>
                                        <option value="">-- جنسیت خود را انتخاب کنید --</option>
                                        <option value="male" {{old('partners.0.gender') == 'male' ? 'selected' : ''}}>آقا</option>
                                        <option value="female" {{old('partners.0.gender') == 'female' ? 'selected' : ''}}>خانم</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="birth_date" class="control-label">تاریخ تولد</label>
                                    <span class="text-danger">&starf;</span>
                                    <input class="form-control fc-datepicker" id="birth_date_show" type="text"
                                        autocomplete="off" placeholder="تاریخ تولد" />
                                    <input name="partners[0][birth_date]" id="birth_date_hide" type="hidden"
                                        value="{{ old('partners.0.birth_date') }}" />
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="national_code" class="control-label">کد ملی</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[0][national_code]" value="{{ old('partners.0.national_code') }}"
                                        class="form-control" id="national_code" placeholder="کد ملی خود را اینجا وارد کنید..." required>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="phone" class="control-label">شماره همراه</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[0][phone]" value="{{ old('partners.0.phone') }}"
                                        class="form-control" id="phone" placeholder="شماره همراه خود را اینجا وارد کنید..." required>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="job" class="control-label">شغل</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[0][job]" value="{{ old('partners.0.job') }}"
                                        class="form-control" id="job" placeholder="شغل خود را اینجا وارد کنید..." required>
                                </div>
                            </div>
                             <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">استان</label>
                                    <span class="text-danger">&starf;</span>
                                    <select id="provinceSelect" name="province_id" class="form-control select2" required>
                                        <option value="" disabled selected>-- استان را انتخاب کنید --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">شهر</label>
                                    <span class="text-danger">&starf;</span>
                                    <select id="citySelect" name="city_id" class="form-control select2" required>
                                        <option value="" disabled selected>-- شهر را انتخاب کنید --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="education" class="control-label">تحصیلات</label>
                                    <span class="text-danger">&starf;</span>
                                    <select name="partners[0][education]" class="form-control select2" required>
                                        <option value="">-- تحصیلات خود را انتخاب کنید --</option>
                                        @foreach ($educations as $key => $value)
                                            <option value="{{ $key }}" {{ old('partners.0.education') == $key ? 'selected' : '' }}>
                                                {{ config('partner.educations.' . $key) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="form-group">
                                    <label for="address" class="control-label">آدرس</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[0][address]" value="{{ old('partners.0.address') }}"
                                            class="form-control" id="address"
                                            placeholder="آدرس کامل خود را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step2" class="close">
                        <h3 class="mb-5">اطلاعات همسر:</h3>

                        <div class="row">
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">نام و نام خانوادگی</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[1][name]" value="{{ old('partners.1.name') }}"
                                            class="form-control" id="name"
                                            placeholder="نام کامل همسر را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="gender" class="control-label">جنسیت</label>
                                    <span class="text-danger">&starf;</span>
                                    <select name="partners[1][gender]" class="form-control select2" required>
                                        <option value="">-- جنسیت همسر را انتخاب کنید --</option>
                                        <option value="male" {{old('partners.0.gender') == 'male' ? 'selected' : ''}}>آقا</option>
                                        <option value="female" {{old('partners.1.gender') == 'female' ? 'selected' : ''}}>خانم</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="birth_date" class="control-label">تاریخ تولد</label>
                                    <span class="text-danger">&starf;</span>
                                    <input class="form-control fc-datepicker" id="birth_date_partner_show" type="text"
                                        autocomplete="off" placeholder="تاریخ تولد" />
                                    <input name="partners[1][birth_date]" id="birth_date_partner_hide" type="hidden"
                                        value="{{ old('partners.1.birth_date') }}" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="national_code" class="control-label">کد ملی</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[1][national_code]" value="{{ old('partners.1.national_code') }}"
                                            class="form-control" id="national_code" placeholder="کد ملی همسر را اینجا وارد کنید..." required>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="phone" class="control-label">شماره همراه</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[1][phone]" value="{{ old('partners.1.phone') }}"
                                            class="form-control" id="phone" placeholder="شماره همراه همسر را اینجا وارد کنید..." required>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="job" class="control-label">شغل</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[1][job]" value="{{ old('partners.1.job') }}"
                                            class="form-control" id="job" placeholder="شغل همسر را اینجا وارد کنید..." required>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="education" class="control-label">تحصیلات</label>
                                    <span class="text-danger">&starf;</span>
                                    <select name="partners[1][education]" class="form-control select2" required>
                                        <option value="">-- تحصیلات همسر را انتخاب کنید --</option>
                                        @foreach ($educations as $key => $value)
                                            <option value="{{ $key }}" {{ old('partners.1.education') == $key ? 'selected' : '' }}>
                                                {{ config('partner.educations.' . $key) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="form-group">
                                    <label for="address" class="control-label">آدرس</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="text" name="partners[1][address]" value="{{ old('partners.1.address') }}"
                                            class="form-control" id="address"
                                            placeholder="آدرس کامل همسر را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step3" class="close">

                        <h3 class="mb-5">اطلاعات پایانی:</h3>
                            
                        <div class="row">
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="marriage_certificate_no" class="control-label">شماره عقدنامه</label>
                                    <span class="text-danger">&starf;</span>
                                    <input type="number" name="marriage_certificate_no" value="{{ old('marriage_certificate_no') }}"
                                            class="form-control" id="marriage_certificate_no"
                                            placeholder="شماره عقدنامه را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="marriage_date" class="control-label">تاریخ عقد</label>
                                    <span class="text-danger">&starf;</span>
                                    <input class="form-control fc-datepicker" id="marriage_date_show" type="text"
                                        autocomplete="off" placeholder="تاریخ عقد" />
                                    <input name="marriage_date" id="marriage_date_hide" type="hidden"
                                        value="{{ old('marriage_date') }}" />
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="form-group">
                                    <label for="marriage_location" class="control-label">مکان ازدواج</label>
                                    <input type="text" name="marriage_location" value="{{ old('marriage_location') }}"
                                    class="form-control" id="marriage_location"
                                    placeholder="مکان ازدواج را اینجا وارد کنید..." autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-8 form-group">
                                <label for="notes" class="control-label">یادداشت</label>
                                <textarea name="notes" id="notes" class="form-control">{{old('notes')}}</textarea>
                            </div>
                        </div>
                        @if (count($equipments) != 0 )
                            <hr>
                            <h4>تجهیزات مورد نیاز:</h4>
                            <div class="row mb-3 p-4 ">
                                @foreach($equipments as $equipment)
                                    <div class="col-6 col-md-2 mb-2 d-flex ">
                                        <button type="button"
                                                class="btn btn-outline-primary w-100 equipment-btn btn-sm"
                                                data-id="{{ $equipment->id }}">
                                            {{ $equipment->name }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="selectedEquipments"></div>
                    </div>
                </form>
                <hr>
                <div class="d-flex justify-content-between align-items-center filter-btn-form w-100 footer-btn">
                    <button id="submitBtn" title="برای زدن این دکمه باید تا مرحله‌ی سوم فرم را پر کنید" disabled type="submit" class="btn btn-primary">ارسال فرم
                        <i class="fa fa-hand-o-up text-white mt-1 mr-1"></i>
                    </button>
                    <div class="d-flex align-items-center footer-btn-arrow">
                        <button onclick="changeStepForm('prev')" class="btn ml-3"><i class="text-white fa fa-arrow-right ml-1 mt-1"></i>قبلی</button>
                        <button onclick="changeStepForm('next')" class="btn ">بعدی<i class="text-white fa fa-arrow-left mt-1 mr-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <a target="_blank" href="https://trustseal.enamad.ir/?id=670150&Code=tz2EC3pRVD2SxwvIEK3K0tOZc3MhRid6"><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=670150&Code=tz2EC3pRVD2SxwvIEK3K0tOZc3MhRid6' alt='' style='cursor:pointer' code='tz2EC3pRVD2SxwvIEK3K0tOZc3MhRid6'></a>
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
    @include('core::includes.date-input-script', [
        'dateInputId' => 'birth_date_hide',
        'textInputId' => 'birth_date_show',
    ])
    @include('core::includes.date-input-script', [
        'dateInputId' => 'birth_date_partner_hide',
        'textInputId' => 'birth_date_partner_show',
    ])
    @include('core::includes.date-input-script', [
        'dateInputId' => 'marriage_date_hide',
        'textInputId' => 'marriage_date_show',
    ])
    @include('components.notifications')
    <script src="{{ asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
         $(document).ready(function() {
            $('#provinceSelect').select2({
                placeholder: "-- انتخاب استان --",
                allowClear: true
            });
            $('#citySelect').select2({
                placeholder: "-- انتخاب شهر --",
                allowClear: true
            });
        });
        let activeStep = "step1"
        let btnActiveStep = "btn-step1"
        let ActiveStepIndex = 1
        

        function setStepForm(index) {

            let btn= document.querySelectorAll(".btn-filter")
            for(let i=0 ; i<btn.length;i++){
                btn[i].classList.remove("active-btn")
            }
            for(let i=0 ; i<index;i++){
                btn[i].classList.add("active-btn")
            }
             if (index == 3) {
                toggleSubmitBtn(true);
            }else{
                toggleSubmitBtn(false);
            }
            console.log(index,'index');
            document.getElementById(`step${ActiveStepIndex}`).classList.add("close")
            ActiveStepIndex = index
           
            document.getElementById(`step${ActiveStepIndex}`).classList.remove("close")
        }

        function changeStepForm(type) {
            let newIndex = ActiveStepIndex
                type == "next" ? ++newIndex : --newIndex
            if (newIndex > 0 && newIndex < 4) {
                setStepForm(newIndex)
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".equipment-btn");
            const container = document.getElementById("selectedEquipments");

            buttons.forEach(btn => {
                btn.addEventListener("click", function () {
                    const id = this.dataset.id;

                    const existingInput = container.querySelector(`input[value="${id}"]`);

                    if (existingInput) {
                        existingInput.remove();
                        this.classList.remove("btn-success");
                        this.classList.add("btn-outline-primary");
                    } else {
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "equipments[]";
                        input.value = id;
                        container.appendChild(input);

                        this.classList.remove("btn-outline-primary");
                        this.classList.add("btn-success");
                    }
                });
            });
        });

        $('#provinceSelect').on('change', function() {
            var provinceId = $(this).val();
            if(provinceId) {
                $.ajax({
                    url: '/cities/' + provinceId,
                    type: 'GET',
                    success: function(data) {
                        var citySelect = $('#citySelect');
                        citySelect.empty();
                        citySelect.append('<option value="" disabled selected>-- شهر را انتخاب کنید --</option>');
                        $.each(data, function(key, city) {
                            citySelect.append('<option value="'+city.id+'">'+city.name+'</option>');
                        });
                        citySelect.trigger('change'); 
                    }
                });
            }
        });
        document.getElementById("submitBtn").addEventListener("click", function () {
            document.getElementById("createPartner").submit();
        });
        const submitBtn = document.getElementById('submitBtn');

        function toggleSubmitBtn(isEnabled) {
            if (isEnabled) {
                submitBtn.disabled = false;
                submitBtn.removeAttribute("title"); 
            } else {
                submitBtn.disabled = true;
                submitBtn.setAttribute("title", "برای زدن این دکمه باید تا مرحله‌ی سوم فرم را پر کنید");
            }
        }
    </script>
</body>

</html>
