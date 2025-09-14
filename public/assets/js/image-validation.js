function imageValidation() {
var fileInput =
    document.getElementById('image');

var filePath = fileInput.value;

var allowedExtensions =
    /(\.jpg|\.jpeg|\.png|\.gif)$/i;

if (!allowedExtensions.exec(filePath)) {
    swal({
        title: 'فرمت تصویر معتبر نیست!',
        text: 'فایل انتخاب شده باید فرمت تصویری داشته باشد.',
        icon: 'warning',
        dangerMode: true
    })

    fileInput.value = '';
    document.getElementById('imagePreview').innerHTML = '';
    return false;
} else {
    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(
                'imagePreview').innerHTML =
                '<img width="50%" height="50%" src="' + e.target.result +
                '"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
}
}


