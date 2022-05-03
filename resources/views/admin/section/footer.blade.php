</div>
<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<!-- END PAGA BACKDROPS-->

<!-- CORE PLUGINS-->
<script src="{{asset('/assets/admin/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/metisMenu/dist/metisMenu.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- PAGE LEVEL PLUGINS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- CORE SCRIPTS-->
<script src="{{asset('/assets/admin/js/app.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/admin/js/BsMultiSelect.bs4.min.js') }}" type="text/javascript"></script>
<!-- PAGE LEVEL SCRIPTS-->

<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<script>
   
    $(document).ready(function() {
        // $.ajaxSetup({
        //     beforeSend: function(xhr) {
        //         xhr.setRequestHeader('Authorization', 'Bearer {{ auth()->user()->api_token }}');
        //     }
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer {{ auth()->user()->api_token }}'
            }
        });

        $('form.js-disable-on-submit').submit(function(e) {
            $(this).find('button[type="submit"]').prop('disabled', true);
            // $('form button').attr('disabled', true);
        });
        
        $('[data-toggle="tooltip"]').tooltip();

        // Url driven nav-tabs
        $(function() {
                $('.js-enable-tab-url a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            history.pushState({}, '', e.target.hash);
            });
        
            var hash = document.location.hash;
            var prefix = "tab_";
            if (hash) {
                $('.nav-tabs a[href="'+hash.replace(prefix,"")+'"]').tab('show');
            }
        });

    });
    
    // for image preview
    function handleUploadPreview() {
        console.log('handleUploadPreview');
        document.getElementById(event.target.dataset.previewElId).src = URL.createObjectURL(event.target.files[0]);
    }

</script>
@stack('push_scripts')
@yield('scripts')

</body>

</html>
