@extends('layouts.help-user.master')
@section('styles')
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
        .full-screen-logout{
            all: revert;
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
@endsection
@section('content')

    <div class="d-flex justify-content-around">
        <b style="font-size: 20px">فرم کمک همیاران</b>
    </div>
    <br>
    <div class="d-flex justify-content-center align-items-center">
        <div class="help-box card card-custom shadow-sm col-12 col-md-10 col-lg-8 p-4">
            <div class="card-body">
                @include('components.errors')

                <form id="storeHelp" action="{{ route('help-user.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" id="helpType" name="type" value="cash">
                    <input type="hidden" name="companion_id" value="{{ $code ? $companion->id : null }}">

                    <div class="d-flex justify-content-center filter-btn-form my-4">
                        <button type="button" id="btn-cash" class="active-btn btn-filter ml-3" onclick="setStepForm('cash')">کمک مالی</button>
                        <button type="button" id="btn-objects" class="btn-filter" onclick="setStepForm('objects')">اهدا تجهیزات</button>
                    </div>

                    <div id="cash">
                        <h4>کمک مالی:</h4>
                        <div class="row mb-3 p-3">
                            <div class="col-12 d-flex align-items-center">
                                <input type="range" class="form-control w-75" id="donationRange" min="1000000" max="1000000000" step="1000000"
                                    value="1000000" name="amount" oninput="updateDonationValue(this.value)">
                                <p class="mt-2 mr-2 mb-0">مبلغ انتخابی: <span id="donationValue">1,000,000</span> تومان</p>
                            </div>
                        </div>
                    </div>

                    <div id="objects" class="close">
                        <h4>اهدا تجهیزات:</h4>
                        @if(count($equipments) != 0)
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

                    <div class="text-center mt-4">
                        <button id="submitBtn" type="submit" class="btn btn-success px-4">
                            ثبت اطلاعات
                            <i class="fa fa-hand-o-up text-white mt-1 mr-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
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
@endsection
