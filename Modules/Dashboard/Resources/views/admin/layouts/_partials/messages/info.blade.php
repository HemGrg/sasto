@if(session('message'))
<div class="alert alert-info alert-dismissible" id="successMessage">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{session('message')}}
</div>
@endif
@if(session('error'))

<div class="alert alert-danger alert-dismissible" id="errorMessage">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{session('error')}}
</div>
@endif


@if(Session::has('flash_message_error'))
<div class="alert alert-sm alert-danger alert-block" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span area-hidden="true">&times;</span>
    </button>
    <strong>{!! session('flash_message_error') !!}</strong>
</div>
@endif

@if(Session::has('flash_message_success'))
<div class="alert alert-sm alert-success alert-block" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!! session('flash_message_success') !!}</strong>
</div>
@endif


@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
@push('scripts')
<script>
    $(document).ready(function() {
        $("#errorMessage").delay(2000).slideUp(500);
        $("#successMessage").delay(2000).slideUp(500);
        $('.alert').delay(2000).slideUp(500);
    });
</script>
@endpush