<div class="modal fade" id="{{ $id }}" style="display: none;" aria-hidden="true" class="{{ isset($class) ? $class : '' }}">
    <div class="modal-dialog modal-{{ $size }}" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <p class="modal-title font-weight-bold">{{ $title }}</p>
                <button aria-label="Close" class="close" data-dismiss="modal"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>