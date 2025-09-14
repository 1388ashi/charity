<div class="table-responsive">
    <table
        class="table table-striped table-bordered text-nowrap text-center {{ $class ?? ''}}"
        @isset($id) id="{{ $id }}" @endisset
    >
        <thead class="border-top">
        {{$tableTh}}
        </thead>
        <tbody @isset($idTbody) id="{{ $idTbody }}" @endisset>
        {{ $tableTd }}
        </tbody>
    </table>
    @isset($extraData)
    {{ $extraData }}
    @endisset
</div>
