<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">--}}
    <title>سفارش</title>
    <style>
        @font-face {
            font-family: iransans-bold;
            src: url(../assets/font/IRANSans-Bold.woff);
        }

        @font-face {
            font-family: iransans;
            src: url(../assets/font/IRANSansWeb.ttf);
        }

        * {
            font-family: iransans, sans-serif;
        }

        .iranssans-bold {
            font-size: iransans-bold;
        }

        .poem {
            color: #787878;
            font-size: 12px;
            display: flex;
            width: 60%;
            justify-content: space-between;
            margin: auto;
        }
             /*! CSS Used from: https://unpkg.com/tailwindcss@%5E2/dist/tailwind.min.css */
         *,::after,::before{box-sizing:border-box;}
        html{-moz-tab-size:4;tab-size:4;}
        html{line-height:1.15;-webkit-text-size-adjust:100%;}
        body{margin:0;}
        body{font-family:system-ui,-apple-system,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji';}
        ::-moz-focus-inner{border-style:none;padding:0;}
        :-moz-focusring{outline:1px dotted ButtonText;}
        h1,p{margin:0;}
        html{font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";line-height:1.5;}
        body{font-family:inherit;line-height:inherit;}
        *,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:currentColor;}
        img{border-style:solid;}
        h1{font-size:inherit;font-weight:inherit;}
        a{color:inherit;text-decoration:inherit;}
        img{display:block;vertical-align:middle;}
        img{max-width:100%;height:auto;}
        *,::after,::before{--tw-border-opacity:1;border-color:rgba(229,231,235,var(--tw-border-opacity));}
        .container{width:100%;}
        @media (min-width:640px){
            .container{max-width:640px;}
        }
        @media (min-width:768px){
            .container{max-width:768px;}
        }
        @media (min-width:1024px){
            .container{max-width:1024px;}
        }
        @media (min-width:1280px){
            .container{max-width:1280px;}
        }
        @media (min-width:1536px){
            .container{max-width:1536px;}
        }
        .absolute{position:absolute;}
        .relative{position:relative;}
        .inset-y-0{top:0;bottom:0;}
        .left-0{left:0;}
        .col-span-2{grid-column:span 2/span 2;}
        .mx-auto{margin-left:auto;margin-right:auto;}
        .mt-12{margin-top:3rem;}
        .mt-28{margin-top:7rem;}
        .mt-2\.5{margin-top:.625rem;}
        .grid{display:grid;}
        .h-24{height:6rem;}
        .grid-flow-col{grid-auto-flow:column;}
        .grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr));}
        .grid-rows-1{grid-template-rows:repeat(1,minmax(0,1fr));}
        .grid-rows-2{grid-template-rows:repeat(2,minmax(0,1fr));}
        .gap-2\.5{gap:.625rem;}
        .rounded-t-2xl{border-top-left-radius:1rem;border-top-right-radius:1rem;}
        .rounded-b-2xl{border-bottom-right-radius:1rem;border-bottom-left-radius:1rem;}
        .border-r-2{border-right-width:2px;}
        .border-gray-300{--tw-border-opacity:1;border-color:rgba(209,213,219,var(--tw-border-opacity));}
        .bg-white{--tw-bg-opacity:1;background-color:rgba(255,255,255,var(--tw-bg-opacity));}
        .bg-gray-100{--tw-bg-opacity:1;background-color:rgba(243,244,246,var(--tw-bg-opacity));}
        .hover\:bg-green-200:hover{--tw-bg-opacity:1;background-color:rgba(167,243,208,var(--tw-bg-opacity));}
        .p-5{padding:1.25rem;}
        .p-1\.5{padding:.375rem;}
        .p-2\.5{padding:.625rem;}
        .px-5{padding-left:1.25rem;padding-right:1.25rem;}
        .px-10{padding-left:2.5rem;padding-right:2.5rem;}
        .pt-2{padding-top:.5rem;}
        .pr-2\.5{padding-right:.625rem;}
        .text-center{text-align:center;}
        .text-xs{font-size:.75rem;line-height:1rem;}
        .text-sm{font-size:.875rem;line-height:1.25rem;}
        .font-bold{font-weight:700;}
        .text-green-500{--tw-text-opacity:1;color:rgba(16,185,129,var(--tw-text-opacity));}
        .text-green-600{--tw-text-opacity:1;color:rgba(5,150,105,var(--tw-text-opacity));}
        .text-red-600{--tw-text-opacity:1;color: rgb(217, 30, 50,var(--tw-text-opacity));}
        .hover\:text-green-700:hover{--tw-text-opacity:1;color:rgba(4,120,87,var(--tw-text-opacity));}
        .opacity-0{opacity:0;}
        *,::after,::before{--tw-shadow:0 0 #0000;}
        .shadow-md{--tw-shadow:0 4px 6px -1px rgba(0, 0, 0, 0.1),0 2px 4px -1px rgba(0, 0, 0, 0.06);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}
        *,::after,::before{--tw-ring-inset:var(--tw-empty, );--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgba(59, 130, 246, 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;}
        @media (min-width:640px){
            .sm\:max-h-24{max-height:6rem;}
            .sm\:grid-rows-1{grid-template-rows:repeat(1,minmax(0,1fr));}
            .sm\:rounded-t-2xl{border-top-left-radius:1rem;border-top-right-radius:1rem;}
            .sm\:bg-gray-100{--tw-bg-opacity:1;background-color:rgba(243,244,246,var(--tw-bg-opacity));}
            .sm\:text-sm{font-size:.875rem;line-height:1.25rem;}
            .sm\:opacity-100{opacity:1;}
        }
        @media (min-width:768px){
            .md\:h-40{height:10rem;}
            .md\:max-h-24{max-height:6rem;}
            .md\:max-w-4xl{max-width:56rem;}
            .md\:grid-rows-1{grid-template-rows:repeat(1,minmax(0,1fr));}
            .md\:text-2xl{font-size:1.5rem;line-height:2rem;}
        }
        @media (min-width:1024px){
            .lg\:grid-rows-1{grid-template-rows:repeat(1,minmax(0,1fr));}
        }
        /*! CSS Used from: Embedded */
        *{font-family:iransans, sans-serif;}
        .iranssans-bold{font-size:iransans-bold;}
        .poem{color:#787878;font-size:12px;display:flex;width:60%;justify-content:space-between;margin:auto;}
        /*! CSS Used fontfaces */
        @font-face{font-family:iransans;src:url(https://api.atlasmode.ir/assets/font/IRANSansWeb.ttf);}

        .back-to-web {
            background: #933228;
            color: white;
            top: 0;
            transform: translateY(-7px);
            height: 30px;
            line-height: 30px;
        }

        .bold {
            font-weight: bold;
        }

    </style>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KZC9MDV');
    </script>
    <!-- End Google Tag Manager -->
</head>
<body dir="rtl" class="bg-gray-100">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZC9MDV"
                  height="0" width="0" style="display:none;visibility:hidden">
    </iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="container mx-auto">
        <div class="bg-white md:max-w-4xl mt-12 mt-28 mx-auto mx-w-md p-5 px-10 shadow-md">
            <div class="relative">
                <span class="opacity-0 sm:rounded-t-2xl sm:text-sm sm:opacity-100 sm:bg-gray-100 p-1.5">نتیجه پرداخت</span>
                @if(@isset($invoice))
                    <a href="{{env('APP_URL_FRONT', 'https://luxury-surprise.ir')}}/callback?payable_id={{$invoice->payable_id}}&success={{$invoice->status == 'success' ? 1 : 0 }}&type={{$type ?? 'order'}}"
                @else
                    <a href="{{env('APP_URL_FRONT', 'https://luxury-surprise.ir')}}"
                       @endif
                   class="back-to-web hover:bg-green-200 hover:text-green-700 absolute inset-y-0 left-0 px-5 rounded-t-2xl text-green-500 text-sm">
                    بازگشت به وبسایت
                </a>
            </div>
            @yield('content')
        </div>
    </div>
</body>
@yield('style')
</html>
