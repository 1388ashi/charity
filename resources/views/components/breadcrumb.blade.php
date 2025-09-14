<ol class="breadcrumb align-items-center pr-0">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fe fe-home ml-1"></i> داشبورد
        </a>
    </li>
    @foreach ($items as $item)
        @if (!isset($item['route_link']) || is_null($item['route_link']))
            <li class="breadcrumb-item active">
                {{ $item['title'] }}
            </li>
        @else
            <li class="breadcrumb-item">
                @php
                    $param = isset($item['parameter']) ? $item['parameter'] : null;
                @endphp
                <a href="{{ route($item['route_link'], $param) }}">{{ $item['title'] }}</a>
            </li>
        @endif
    @endforeach
</ol>
