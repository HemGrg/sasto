<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Site Metas -->
    <title>Blog</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{asset('front-assets/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{asset('front-assets/images/apple-touch-icon.png')}}">
    
    <!-- Design fonts -->
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet"> 

    <!-- Bootstrap core CSS -->
    <link href="{{asset('front-assets/css/bootstrap.css')}}" rel="stylesheet">

    <!-- FontAwesome Icons core CSS -->
    <link href="{{asset('front-assets/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('front-assets/css/style.css')}}" rel="stylesheet">

    <!-- Responsive styles for this template -->
    <link href="{{asset('front-assets/css/responsive.css')}}" rel="stylesheet">

    <!-- Colors for this template -->
    <link href="{{asset('front-assets/css/colors.css')}}" rel="stylesheet">

    <!-- Version Garden CSS for this template -->
    <link href="{{asset('front-assets/css/version/garden.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
     
     @include('blog.layouts.header')
     @yield('content')
     @include('blog.layouts.footer')
 <!-- Core JavaScript
    ================================================== -->
    <script src="{{asset('front-assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('front-assets/js/tether.min.js')}}"></script>
    <script src="{{asset('front-assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front-assets/js/custom.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
 
