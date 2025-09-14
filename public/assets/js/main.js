//SweetAlert confirmation
function confirmDelete(formId) {
    swal({
            title: 'آیا مطمئن هستید؟',
            text: 'بعد از حذف این آیتم دیگر قابل بازیابی نخواهد بود!',
            icon: 'warning',
            buttons: ["انصراف", "حذف کن"],
            dangerMode: true
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById(formId).submit();
                swal('آیتم با موفقیت حذف شد.', {
                    icon: 'success',
                });
            }
        });
}

$(document).ready(function () {
    $('.ckeditor').each(function (e) {
        CKEDITOR.replace(this.id);
    });
    //Prevent multiple submit
    $('form.save').submit(function(){
        $(this).find(':submit').attr('disabled','disabled');
    });
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    //Comma format
    $('input.comma').on('keyup', function(event) {
        if(event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    // Select2 by showing the search
    $('.select2-show-search').select2({
        minimumResultsForSearch: ''
    });

});
