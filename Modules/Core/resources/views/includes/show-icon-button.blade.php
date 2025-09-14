<a
  target="_blank"
  href="{{route($route, $model)}}"
  class="btn btn-sm btn-primary btn-icon text-white"
  data-toggle="tooltip"
  data-original-title="نمایش">
  {{ isset($title) ? $title : null }}
  <i class="fa fa-eye {{ isset($title) ? 'mr-1' : null }}"></i>
</a>
