<div class="row">
    <div class="col-12">
        @if(session('status'))
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
