<form method="post" action="" enctype="multipart/form-data">
    @csrf
    <textarea class="ckeditor form-control" id="ckEditor"
              {{$required ? 'required' : ''}}
              name="{{$name}}">{{(str_contains(Request::path(), 'edit') ? $model->$name : old($name))}}</textarea>
</form>

<script src="{{asset('/assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
    var options = {
        filebrowserImageBrowseUrl: '/admin/FileManager?type=Images',
        filebrowserImageUploadUrl: '/admin/FileManager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/admin/FileManager?type=Files',
        filebrowserUploadUrl: '/admin/FileManager/upload?type=Files&_token='
    };
    CKEDITOR.replace('ckEditor', options);
</script>
