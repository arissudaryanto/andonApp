
<div class="container-fluid">
    @if (Session::has('errors'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="list-unstyled">
            @foreach (Session::get('errors')->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{Session::get('warning')}}
        </div>
    @endif


    @if (Session::has('info'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{Session::get('info')}}
        </div>
    @endif


    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{Session::get('success')}}
        </div>
    @endif
</div>
