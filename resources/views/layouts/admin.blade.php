<!-- START HEADER-->
@include('admin.section.header')
<!-- END HEADER-->
<!-- START SIDEBAR-->
{{-- @include('admin.section.left-sidebar') --}}
<x-admin-sidebar></x-admin-sidebar>
<!-- END SIDEBAR-->
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    @yield('content')
    <!-- END PAGE CONTENT-->
    @include('admin.section.copy-right')
</div>
@include('admin.section.footer')
