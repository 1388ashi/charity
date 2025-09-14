<button
  onclick="confirmDelete('delete-{{ $model->id }}')"
  class="btn btn-sm btn-icon btn-danger text-white"
  data-toggle="tooltip"
  data-original-title="حذف"
  style="margin-inline: 1px"
  {{ isset($disabled) && $disabled ? 'disabled' : null }}>
  {{ isset($title) ? $title : null}}
  <i class="fa fa-trash-o {{ isset($title) ? 'mr-1' : null }}"></i>
</button>
<form
  action="{{ route($route, $model) }}"
  method="POST"
  id="delete-{{ $model->id }}"
  style="display: none">
  @csrf
  @method('DELETE')
</form>
