@if(Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {!! Session::get('success') !!}
</div>
@endif

@if(session('send'))
<div class="alert alert-success">{{session('send')}}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif

{{-- <script>
    setTimeout(function(){
        $('.alert').slideUp('slow');
    }, 7000);
</script> --}}