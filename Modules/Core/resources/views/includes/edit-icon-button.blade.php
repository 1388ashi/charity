<a
  href="{{route($route, $model)}}"
  class="btn btn-sm btn-icon btn-warning text-white"
  data-toggle="tooltip"
  style="margin-inline: 1px"
  data-original-title="ویرایش">
  {{ isset($title) ? $title : null }}
  <i class="fa fa-pencil {{ isset($title) ? 'mr-1' : null }}"></i>
</a>
