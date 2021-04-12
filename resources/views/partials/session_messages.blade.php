@if (session('success-message'))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <span class="fa fa-check-circle"></span>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                </button>
                {!! session('success-message') !!}
            </div>
        </div>
    </div>
@endif

@if (session('error-message'))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <span class="fa fa-check-circle"></span>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                </button>
                {!! session('error-message') !!}
            </div>
        </div>
    </div>
@endif

@if (session('warning-message') && is_array(session('warning-message')))
    @foreach (session('warning-message') as $warningMessage)
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <span class="fa fa-check-circle"></span>
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                    </button>
                    {!! $warningMessage !!}
                </div>
            </div>
        </div>
    @endforeach
@endif