@if(session()->has('success'))
    <script>
        $(document).ready(function () {
            $.growl.notice({
                title: "موفق شد!",
                message: "{{ session('success') }}"
            });
        });
    </script>
@elseif(session()->has('error'))
    <script>
        $(document).ready(function () {
            $.growl.error({
                title: "خطایی رخ داده!",
                message: "{{ session('error') }}"
            });
        });
    </script>
@elseif(session()->has('warning'))
    <script>
        $(document).ready(function () {
            $.growl.warning({
                title: "هشدار!",
                message: "{{ session('warning') }}"
            });
        });
    </script>
@elseif(session()->has('info'))
    <script>
        $(document).ready(function () {
            $.growl.warning({
                title: "هشدار!",
                message: "{{ session('warning') }}"
            });
        });
    </script>
@endif
