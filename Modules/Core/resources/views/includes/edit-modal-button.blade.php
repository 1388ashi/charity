<button
  class="btn btn-sm btn-icon btn-warning text-white"
  data-target= {{ $target }}
  data-toggle="modal"
  type="button"
  data-original-title="ویرایش">
  {{ isset($title) ? $title : null }}
  <i class="fa fa-pencil {{ isset($title) ? 'mr-1' : null }}"></i>
</button>
