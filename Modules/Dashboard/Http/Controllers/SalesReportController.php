<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;
use Modules\User\Entities\Vendor;
use Modules\Order\Entities\VendorOrder;
use Carbon;
use Auth;
use Modules\Order\Entities\Package;

class SalesReportController extends Controller
{

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function daily_report()
    {
        $months_day = $this->dates_of_month();
        $dailySales = [];
        // $sales = [];
        foreach ($months_day['date'] as $date) {
            $daily = $this->order->whereDate('created_at', $date)->sum('amount');

            array_push($dailySales, $daily);
        }
        $sales = array_sum($dailySales);
        $vendors = Vendor::where('status', 1)->get();
        // dd($dailySales,$sales);
        return view('dashboard::salesreport.daily', compact(
            'dailySales',
            'months_day',
            'vendors',
            'sales'
        ));
    }

    public function salesSearchByDates(Request $request)
    {
        $months_day = [];
        $amount = [];
        if ($request->vendor == '')
            $details = $this->order->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        else
            $details = VendorOrder::where('user_id', $request->vendor)->orWhereBetween('created_at', [$request->start_date, $request->end_date])->get();


        foreach ($details as $detail) {
            $months_day[] = $detail->created_at->format('Y-m-d');
            if ($request->vendor != '')
                $orderlist = OrderList::where('order_id', $detail->order_id)->where('user_id', $detail->user_id)->sum('amount');
            else
                $orderlist  = $detail->amount;
            $amount[] = [$detail->created_at->format('Y-m-d') => $orderlist];
        }
        $finalamount = array();

        array_walk_recursive($amount, function ($item, $key) use (&$finalamount) {
            $finalamount[$key] = isset($finalamount[$key]) ?  $item + $finalamount[$key] : $item;
        });
        $amt = [];
        foreach ($finalamount as $value) {
            $amt[] = $value;
        }
        $total_sales = array_sum($amt);
        $months_day = array_values(array_unique($months_day));
        // dd($months_day);
        return response()->json([
            'status' => 'successful',
            'details' => $details,
            'months_day' => $months_day, 'sales' => $amt, 'total_sales' => $total_sales
        ]);
    }

    // public function getVendorReport(Request $request, $id)
    // {
    //     $user = User::where('id', $id)->first();
    //     $orders = Package::with(['order', 'vendorShop'])
    //         ->where('vendor_user_id', $user->id)
    //         ->latest()
    //         ->paginate(5);
    //     $months_day = [];
    //     $amount = [];
    //     $details = Package::where('vendor_user_id', $user->id)->get();
    //     $total_sales = Package::where('vendor_user_id', $user->id)->sum('total_price');
    //     foreach ($details as $detail) {
    //         $months_day[] = $detail->created_at->format('Y-m-d');
    //         $amount[] = [$detail->created_at->format('Y-m-d') => $detail->total_price];
    //     }
    //     $finalamount = array();

    //     array_walk_recursive($amount, function ($item, $key) use (&$finalamount) {
    //         $finalamount[$key] = isset($finalamount[$key]) ?  $item + $finalamount[$key] : $item;
    //     });
    //     $amt = [];
    //     foreach ($finalamount as $value) {
    //         $amt[] = $value;
    //     }
    //     $months_day = array_values(array_unique($months_day));
    //     return view('dashboard::salesreport.sales-info', compact(
    //         'orders',
    //         'details',
    //         'months_day',
    //         'amt',
    //         'total_sales'
    //     ));
    // }

    public function getOrderInfo()
    {
        abort_if(is_alternative_login() && !alt_usr_has_permission('sales_report'), 403);
        $vendor = auth()->user()->hasRole('vendor') ? auth()->user()->vendor : 0;

        $orders = Order::with(['vendor'])
            ->when(auth()->user()->hasRole('vendor'), function ($query) use ($vendor) {
                return $query->where('vendor_id', $vendor->id);
            })
            ->latest()
            ->paginate(5);

        $months_day = [];
        $amount = [];
            $details = Order::when(auth()->user()->hasRole('vendor'), function ($query) use ($vendor) {
                return $query->where('vendor_id', $vendor->id);
            })->get();

            $total_sales = Order::when(auth()->user()->hasRole('vendor'), function ($query) use ($vendor) {
                return $query->where('vendor_id', $vendor->id);
            })->sum('total_price');
            
            foreach ($details as $detail) {
                $months_day[] = $detail->created_at->format('Y-m-d');
                $amount[] = [$detail->created_at->format('Y-m-d') => $detail->total_price];
            }

        $finalamount = array();

        array_walk_recursive($amount, function ($item, $key) use (&$finalamount) {
            $finalamount[$key] = isset($finalamount[$key]) ?  $item + $finalamount[$key] : $item;
        });

        $amt = [];
        foreach ($finalamount as $value) {
            $amt[] = $value;
        }
        $months_day = array_values(array_unique($months_day));

        return view('dashboard::salesreport.sales-info', compact(
            'orders',
            'details',
            'months_day',
            'amt',
            'total_sales'
        ));
    }

    

    public function weekly_report()
    {
        $weekly_sales_total = [];
        $sales = 0;
        $week_days = $this->dates_of_week();
        foreach ($week_days['date'] as $date) {
            //weekly sales
            $sales = $this->order->whereDate('created_at', $date)->sum('amount');
            array_push($weekly_sales_total, $sales);

            $weeklysales = $this->order->whereDate('created_at', $date)->sum('amount');
            $sales += $weeklysales;
        }
        return view('admin.salesreport.weekly', compact(
            'week_days',
            'sales',
            'weekly_sales_total'
        ));
    }

    public function monthly_report()
    {
        $monthlySales = $this->getMonthlySalesData();
        return view('admin.salesreport.monthly', compact(
            'monthlySales'
        ));
    }

    public function getAllMonths()
    {

        $month_array = [];
        $year = date('Y');
        $billing_dates = $this->order->orderBy('created_at', 'asc')->whereYear('created_at', $year)->pluck('created_at');

        $billing_dates = json_decode($billing_dates);

        if (!empty($billing_dates)) {

            foreach ($billing_dates as $unformatedDate) {

                $date = Carbon\Carbon::parse($unformatedDate);
                $month_name = $date->format('M');
                $month_no = $date->format('m');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    public function getMonthlySalesCount($month)
    {
        $year = date('Y');
        $monthlyBillingCount = $this->order->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount');
        return $monthlyBillingCount;
    }

    public function getMonthlySalesData()
    {
        $monthly_post_data = [];
        $monthly_post_count_array = [];
        $month_array = $this->getAllMonths();
        $month_name_array = [];
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthly_post_count = $this->getMonthlySalesCount($month_no);
                array_push($monthly_post_count_array, $monthly_post_count);
                array_push($month_name_array, $month_name);
            }
        }
        return $monthly_post_count_array = ['months' => $month_name_array, 'total_amount' => $monthly_post_count_array];
    }

    public function dates_of_week()
    {
        $date = Carbon\Carbon::today();
        $num = date('N');
        // parse about any English textual datetime description into a Unix timestamp
        $ts = strtotime($date);
        // find the year (ISO-8601 year number) and the current week
        $year = date('o', $ts);
        $week = date('W', $ts);
        // print week for the current date
        $day_name = [];
        $day_date = [];
        for ($i = 0; $i <= $num; $i++) {
            // timestamp from ISO week date format
            $ts = strtotime($year . 'W' . $week . $i);
            $day = date("l", $ts);
            $daydate = date("Y-m-d ", $ts);
            array_push($day_name, $day);
            array_push($day_date, $daydate);
        }
        return $data = ['day' => $day_name, 'date' => $day_date];
    }

    public function dates_of_month()
    {
        $date = Carbon\Carbon::today();
        $num = date('m');
        $month = date('m');
        $year = date('Y');

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime($date);
        $day_name = [];
        $day_date = [];
        for ($i = $start_time; $i <= $end_time; $i += 86400) {
            $day = date('l', $i);
            $daydate = date('Y-m-d', $i);
            array_push($day_name, $day);
            array_push($day_date, $daydate);
        }
        return $data = ['day' => $day_name, 'date' => $day_date];
    }

    public function index()
    {
        return view('dashboard::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
