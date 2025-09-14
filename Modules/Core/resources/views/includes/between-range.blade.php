@push('range-style')
<style>
    .wrapper{
        height: 0px;
    }
    .price-input{
        width: 100%;
        display: flex;
        /*margin: 30px 0 35px;*/
        justify-content: center;
    }
    .price-input .field{
        display: flex;
        width: 2px;
        /*height: 45px;*/
        align-items: center;
        justify-content: center;
    }
    .field input{
        width: 100%;
        /*height: 100%;*/
        outline: none;
        font-size: 19px;
        margin-left: 12px;
        border-radius: 5px;
        text-align: center;
        border: 1px solid #999;
        -moz-appearance: textfield;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    .price-input .separator{
        width: 80px;
        display: flex;
        font-size: 19px;
        align-items: center;
        justify-content: center;
    }
    .slider{
        height: 5px;
        position: relative;
        background: #ddd;
        border-radius: 5px;
    }
    .slider .progress{{$id}}{
        height: 100%;
        left: 0%;
        right: 0%;
        position: absolute;
        border-radius: 5px;
        background: #17A2B8;
    }
    .range-input{
        position: relative;
    }

    .range-min::-webkit-slider-thumb{
        position: relative;
    }
    .min-span{
        position: absolute;
        left: 0px;
        top: 0;

    }
    .min-mark-container{
        position: absolute;
        content: "";
        background-color: red;
        height: 35px;
        top: -52px;
        left: 0px;
        width: 35px;
        transform: translateX(-50%) rotate(45deg);
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .range-input input{
        position: absolute;
        direction: ltr;
        width: 100%;
        height: 5px;
        top: -5px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    input[type="range"]::-webkit-slider-thumb{
        height: 17px;
        width: 17px;
        border-radius: 50%;
        background: #ffffff;
        pointer-events: auto;
        -webkit-appearance: none;
        box-shadow: 0 0 6px rgba(0,0,0,0.5);
    }
    input[type="range"]::-moz-range-thumb{
        height: 17px;
        width: 17px;
        border: none;
        border-radius: 50%;
        background: #17A2B8;
        pointer-events: auto;
        -moz-appearance: none;
        box-shadow: 0 0 6px rgba(0,0,0,0.05);
    }

</style>
@endpush
<div class="wrapper" style="width: 100%">
    <div class="price-input">
        <div class="field">
            <span class="span{{$id}}">{{$max}}</span>
            <input type="number" hidden class="input-min priceInput{{$id}}" name="{{$name}}_lower" value="0">
        </div>
        <div class="separator">-</div>
        <div class="field">
            <span class="span{{$id}}">0</span>
            <input type="number" hidden class="input-max priceInput{{$id}}" name="{{$name}}_higher" value="{{$max}}">
        </div>
    </div>
    <div class="slider">
        <div class="progress{{$id}}"></div>
    </div>
    <div class="range-input">
        <input type="range" class="range-min range{{$id}}" min="0" max="{{$max}}" value="0" step="1">
        <input type="range" class="range-max range{{$id}}" min="0" max="{{$max}}" value="{{$max}}" step="1">
    </div>
</div>

@push('range-script')

<script>

    const rangeInput{{$id}} = document.querySelectorAll(".range-input .range{{$id}}"),
        priceInput{{$id}} = document.querySelectorAll(".price-input .priceInput{{$id}}"),
        span{{$id}} = document.querySelectorAll(".span{{$id}}"),
        range{{$id}} = document.querySelector(".slider .progress{{$id}}");
    let priceGap{{$id}} = 1;
    rangeInput{{$id}}.forEach(input =>{
        input.addEventListener("input", e =>{
            let minVal = parseInt(rangeInput{{$id}}[0].value),
                maxVal = parseInt(rangeInput{{$id}}[1].value);

            if((maxVal - minVal) < priceGap{{$id}}) {
                if (e.target.className === "range-min") {
                    rangeInput{{$id}}[0].value = maxVal - priceGap{{$id}}
                } else {
                    rangeInput{{$id}}[1].value = minVal + priceGap{{$id}};
                }
            }else {
                priceInput{{$id}}[0].value = minVal;
                priceInput{{$id}}[1].value = maxVal;
                span{{$id}}[1].innerHTML = minVal;
                span{{$id}}[0].innerHTML = maxVal;
                range{{$id}}.style.left = ((minVal / rangeInput{{$id}}[0].max) * 100) + "%";
                range{{$id}}.style.right = 100 - (maxVal / rangeInput{{$id}}[1].max) * 100 + "%";
            }


        });
    });
</script>
@endpush
