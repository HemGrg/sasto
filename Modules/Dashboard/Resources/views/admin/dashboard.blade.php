@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($totalSales) }}</h3>
                    <p>Total Sales</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-bag text-aqua"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-bar-chart text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number">{{ formatted_price($totalSales) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($salesFromOnlinePayment) }}</h3>
                    <p>Sales from Online Payment</p>
                </div>
                <div class="icon">
                <i class="fa-brands fa-google-wallet text-green"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa-brands fa-google-wallet"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from Online Payment</span>
                    <span class="info-box-number">{{ formatted_price($salesFromOnlinePayment) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($salesFromCOD) }}</h3>
                    <p>Sales from COD</p>
                </div>
                <div class="icon">
                <i class="fa-solid fa-money-bill text-gold"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-warning text-white"><i class="fa-solid fa-money-bill"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales from COD</span>
                    <span class="info-box-number">{{ formatted_price($salesFromCOD) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($receivableFromVendors) }}</h3>
                    <p>Receivable Amount From Vendors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-credit-card text-red"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Receivable Amount From Vendors</span>
                    <span class="info-box-number">{{ formatted_price($receivableFromVendors) }}</span>
                </div>
            </div>
        </div>


        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ formatted_price($payableToVendors) }}</h3>
                    <p>Payable Amount To Vendors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-credit-card text-gold"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Payable Amount To Vendors</span>
                    <span class="info-box-number">{{ formatted_price($payableToVendors) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <!-- <div class="small-box">
                <div class="inner">
                    <h3>{{ $totalActiveProductsCount }}</h3>
                    <p><a href="{{route('product.index')}}" class="text-dark">Active Products</a></p>
                </div>
                <span class="info-box-icon bg-green text-white"><i class="fa fa-truck"></i></span>
                <div class="icon">
                    <i class="fa fa-cubes text-aqua"></i>
                </div>
            </div> -->
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa fa-cubes text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><a href="{{route('product.index')}}" class="text-dark">Active Products</a></span>
                    <span class="info-box-number">{{ $totalActiveProductsCount }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-green text-white"><i class="fa fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><a href="{{route('vendor.getApprovedVendors')}}" class="text-dark">Active Vendors</a></span>
                    <span class="info-box-number">{{ $totalActiveVendors }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-info-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><a href="{{route('vendor.getNewVendors')}}" class="text-dark">Vendor Requests</a></span>
                    <span class="info-box-number">{{ $totalNewVendors }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><a href="{{route('user.getAllCustomers')}}" class="text-dark">Customers</a></span>
                    <span class="info-box-number">{{ $totalCustomers }}</span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <x-charts.sales-chart-tile></x-charts.sales-chart-tile>
        </div>
        <div class="col-md-4">
            <x-charts.payment-type-pie-chart-tile></x-charts.payment-type-pie-chart-tile>
        </div>
    </div>

    <div class="my-4"></div>

    <x-dashboard.latest-orders-tile></x-dashboard.latest-orders-tile>
</div>
@endsection

@section('scripts')

@endsection