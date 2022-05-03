<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Modules\Dashboard\Service\DashboardService;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Transaction;
use Modules\Product\Entities\Product;
use Modules\User\Entities\Vendor;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        if (auth()->user()->hasRole('vendor')) {
            return $this->vendorDashboard();
        }
        return $this->adminDashboard();
    }

    protected function adminDashboard()
    {
        $title = 'Dashboard';
        $totalSales = $this->dashboardService->getTotalSales();
        $salesFromOnlinePayment = $this->dashboardService->getSalesFromOnlinePayment();
        $salesFromCOD = $this->dashboardService->getSalesFromCOD();
        $totalActiveVendors = Vendor::whereHas('user', function($q){
            $q->where('vendor_type', 'approved');
        })->count();
        $totalNewVendors = Vendor::whereHas('user', function($q){
            $q->where('vendor_type', 'new');
        })->count();

        $totalCustomers = User::whereHas('roles', function($q){
            $q->where('name', 'customer');
        })->count();
        $receivableFromVendors = Transaction::where('is_cod', true)->whereNull('settled_at')->sum('commission');
        $payableToVendors = Transaction::onlyOnlinePayments()
        ->whereIn('id', function($query) {
            $query->select(\DB::raw('MAX(id) FROM transactions where (is_cod = 0 OR is_cod is null) GROUP BY vendor_id'));
            // $query->select(\DB::raw('MAX(id) FROM transactions GROUP BY vendor_id'));
        })
        ->sum('running_balance');

        $totalActiveProductsCount = Product::active()->count();

        return view('dashboard::admin.dashboard', [
            'title' => $title,
            'totalSales' => $totalSales,
            'salesFromOnlinePayment' => $salesFromOnlinePayment,
            'salesFromCOD' => $salesFromCOD,
            'payableToVendors' => $payableToVendors,
            'receivableFromVendors' => $receivableFromVendors,
            'totalActiveProductsCount' => $totalActiveProductsCount,
            'totalActiveVendors' => $totalActiveVendors,
            'totalNewVendors' => $totalNewVendors,
            'totalCustomers' => $totalCustomers
        ]);
    }

    protected function vendorDashboard()
    {
        $title = 'Dashboard';
        $vendor = auth()->user()->vendor;
        $totalSales = $this->dashboardService->getTotalSales();
        $salesFromOnlinePayment = $this->dashboardService->getSalesFromOnlinePayment();
        $salesFromCOD = $this->dashboardService->getSalesFromCOD();

        $payableToAdmin = Transaction::where('vendor_id', $vendor->id)->where('is_cod', true)->whereNull('settled_at')->sum('commission');
        $receivableFromAdmin =  $this->dashboardService->getReceivableFromAdmin($vendor->id);

        $totalActiveProductsCount = Product::where('vendor_id', $vendor->id)->active()->count();

        return view('dashboard::vendor.dashboard', [
            'title' => $title,
            'totalSales' => $totalSales,
            'salesFromOnlinePayment' => $salesFromOnlinePayment,
            'salesFromCOD' => $salesFromCOD,
            'payableToAdmin' => $payableToAdmin,
            'receivableFromAdmin' => $receivableFromAdmin,
            'totalActiveProductsCount' => $totalActiveProductsCount,
        ]);
    }
}
