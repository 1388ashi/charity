<div >
    @if (session('status'))
        <div class="alert alert-{{ session('status') }}">
            {{ session('message') }}
        </div>

        @php(session()->forget('status'))
    @endif
</div>
