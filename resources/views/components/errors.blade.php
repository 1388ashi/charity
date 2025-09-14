@if($errors->any())
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="alert alert-danger">
                <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>خطاهای زیر رخ داده است:</strong>
                <hr class="message-inner-separator">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    </div>
@endif
