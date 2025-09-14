@if (isset($isLight) && !is_null($isLight))
    @php($type .= '-light')
@endif
@if (!isset($fontSize))
  @php($fontSize = 14)  
@endif
<span class="badge badge-{{ $type }}" style="font-size: {{ $fontSize }}">{{ $text }}</span>