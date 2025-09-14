@if ($data->lastPage() > 1)
    <ul class="d-flex justify-content-center pagination text-center ">
        <li class="{{ ($data->currentPage() == 1) ? 'page-item disabled' : 'page-item'}}">
            <a class="page-link"
               href="{{request('keyword') ? $data->previousPageUrl().'&keyword='.request('keyword') : $data->previousPageUrl()}}">صفحه
                قبلی</a>
        </li>
        @for ($i = 1; $i <= $data->lastPage(); $i++)
            <li class=" {{ ($data->currentPage() == $i) ? ' active ' : '' }}">
                <a class="page-link {{$data->currentPage() == $i ? 'bg-primary text-white ' : 'bg-light'}} "
                   href="{{request('keyword') ? $data->url($i).'&keyword='.request('keyword') : $data->url($i)}}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($data->currentPage() == $data->lastPage()) ? 'page-item disabled' : 'page-item' }}">
            <a class="page-link"
               href="{{request('keyword') ? $data->url($data->currentPage()+1).'&keyword='.request('keyword') : $data->url($data->currentPage()+1)}}">صفحه
                بعدی</a>
        </li>
    </ul>
@endif
