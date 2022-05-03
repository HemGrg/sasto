<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="icon" href="{{ asset('/images/favicon.png') }}" type="image/gif" />
    <title> @yield('page_title') | {{ config('app.name') }}</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- <link href="{{asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/brands.min.css" integrity="sha512-OivR4OdSsE1onDm/i3J3Hpsm5GmOVvr9r49K3jJ0dnsxVzZgaOJ5MfxEAxCyGrzWozL9uJGKz6un3A7L+redIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/regular.min.css" integrity="sha512-YoxvmIzlVlt4nYJ6QwBqDzFc+2aXL7yQwkAuscf2ZAg7daNQxlgQHV+LLRHnRXFWPHRvXhJuBBjQqHAqRFkcVw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/solid.min.css" integrity="sha512-qzgHTQ60z8RJitD5a28/c47in6WlHGuyRvMusdnuWWBB6fZ0DWG/KyfchGSBlLVeqAz+1LzNq+gGZkCSHnSd3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="{{asset('/assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" /> -->
    <link href="{{asset('/assets/admin/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('/assets/admin/css/main.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/assets/admin/css/BsMultiSelect.bs4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/assets/admin/css/style.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <!-- PAGE LEVEL STYLES-->
    @yield('styles')
    @stack('styles')
    <style>
        .title-label {
            font-size: 0.9rem;
            color: gray;
            margin-bottom: 0;
        }

        /*==========
            * Dropzone
            ===========*/

        .dropzone {
            border: 2px dashed #5370e9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #333;
            font-weight: 600;
        }

        @media screen AND (min-width: 600px) {
            .dropzone {
                min-height: 300px;
            }
        }

        #productImages .img-wrap {
            display: block;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        #productImages .img-wrap img {
            overflow: hidden;
            width: 100%;
            aspect-ratio: 900 / 900;
        }

        #productImages .img-wrap .del-image-btn {
            background-color: transparent;
            border: 0px;
            outline: none;
            border-radius: 50%;
            line-height: 1;
            color: #f55252;
            transition: background-color 150ms ease-in;
        }

        #productImages .img-wrap .del-image-btn:hover {
            background-color: whitesmoke;
        }

        #no-image {
            text-align: center;
            background-color: #fff;
            padding: 20px;
        }

        #no-image .image-icon {
            font-size: 72px;
            color: #a5a5a5;
        }

        #no-image .text {
            font-style: italic;
        }

        /* Left sidebar */
        /* Scrollable content in sidebar only in large screens */
        @media screen AND (min-width: 600px) {
            .page-sidebar {
                position: fixed;
                height: calc(100vh - 56px);
                min-height: calc(100vh - 56px);
            }

            #sidebar-collapse {
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            #sidebar-collapse .side-menu {
                flex-grow: 1;
                overflow-y: auto;
                padding-bottom: 100px;
                scrollbar
            }

            .side-menu::-webkit-scrollbar {
                width: 10px;
            }

            .side-menu::-webkit-scrollbar-thumb {
                background-color: transparent;
                border-radius: 4px;
            }

            .side-menu:hover::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.4);
            }

            .side-menu::-webkit-scrollbar-thumb:hover {
                background: #778af1;
            }
        }
    </style>

    <script src="{{asset('/assets/admin/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">

        <header class="header">
            <div class="page-brand">
                <!-- <a class="link" href="#"> -->
                <span class="brand">
                    @if(auth()->user()->hasAnyRole('admin|super_admin'))
                    {{ auth()->user()->name }}
                    @else
                    {{ auth()->user()->vendor->shop_name }}
                    @endif
                </span>
                <span class="brand-mini text-nowrap">
                    @if(auth()->user()->hasAnyRole('admin|super_admin'))
                    {{ auth()->user()->name }}
                    @else
                    {{ auth()->user()->vendor->shop_name }}
                    @endif
                </span>
                <!-- </a> -->
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <h4>
                    @if(auth()->user()->hasRole('vendor'))
                    <span class="d-md-inline d-none">
                        <strong>Welcome,</strong>
                        <strong> {{ auth()->user()->vendor->shop_name }} </strong>
                    </span>
                    <!-- <button class="btn btn-primary btn-sm" onclick="location.href=' {{ config('constants.customer_app_url') . '/suppliers/' . auth()->user()->vendor->id }}'">View Store</button> -->
                    @endif
                </h4>
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    @if(auth()->user()->hasRole('vendor'))
                    <li class="nav-item">
                        <x-vendor-support class="btn btn-secondary btn-sm border-0"></x-vendor-support>
                    </li>
                    @endif
                    <li class="nav-item">
                        <x-notification-bell></x-notification-bell>
                    </li>
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="{{asset('/assets/admin/images/admin-avatar.png')}}" />
                            <span>{{ is_alternative_login() ? alt_usr()->name : Auth::user()->name }}</span><i class="fa fa-angle-down m-l-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @if(!is_alternative_login())
                            <li>
                                <a class="dropdown-item" href="{{ route('change.password') }}">
                                    <i class="fa fa-cog"></i>Change Password
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            @endif
                            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>