<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from thememinister.com/crm/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Jun 2019 11:09:03 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog Admin Pannel</title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{asset('admin-assets/dist/img/ico/favicon.png')}}" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="{{asset('admin-assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap rtl -->
    <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
    <!-- Pe-icon-7-stroke -->
    <link href="{{asset('admin-assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css" />
    <!-- style css -->
    <link href="{{asset('admin-assets/dist/css/stylecrm.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style rtl -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            @include('admindashboard::admin.layouts._partials.messages.info')
            <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Login</h3>
                                <small><strong>Please enter your credentials to login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="app">
                            <login-component></login-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{mix('js/app.js')}}"></script>
    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="{{asset('admin-assets/plugins/jQuery/jquery-1.12.4.min.js')}}" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="{{asset('admin-assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
</body>

<!-- Mirrored from thememinister.com/crm/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Jun 2019 11:09:03 GMT -->

</html>