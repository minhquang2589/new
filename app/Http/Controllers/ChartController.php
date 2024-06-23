<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Payment;
use App\Models\Customers;
use Illuminate\Support\Facades\Redirect;
use App\Models\color;
use App\Models\Product;
use App\Models\ordernumber;
use App\Models\size;
use App\Models\Discounts;
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use App\Models\Vouchers;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ChartController extends Controller
{
    //
    public function getMonthlySales()
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        $totalSales = Orders::whereRaw('MONTH(STR_TO_DATE(order_date, "%d/%m/%Y %H:%i:%s")) = ?', [$currentMonth])
            ->whereRaw('YEAR(STR_TO_DATE(order_date, "%d/%m/%Y %H:%i:%s")) = ?', [$currentYear])
            ->sum('total_amount');

        $monthlySales = Orders::select(
            DB::raw('DATE_FORMAT(STR_TO_DATE(order_date, "%d/%m/%Y %H:%i:%s"), "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total_amount')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyOrderCounts = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(STR_TO_DATE(order_date, "%d/%m/%Y %H:%i:%s"), "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topSellingProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.product_id',
                'products.name',
                'products.class',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->groupBy(
                'order_items.product_id',
                'products.name',
                'products.class',
            )
            ->orderByDesc(
                'total_quantity'
            )
            ->take(10)
            ->get();
        $totalOrdersToday = $this->getTodaySales();
        $topUsers = $this->getTopCustomer();
        $getOrderStatus = $this->getOrderStatus();


        return response()->json([
            'monthlySales' => $monthlySales,
            'totalSales' => $totalSales,
            'monthlyOrderCounts' => $monthlyOrderCounts,
            'topSellingProducts' => $topSellingProducts,
            'totalOrdersToday' => $totalOrdersToday,
            'topUsers' => $topUsers,
            'getOrderStatus' => $getOrderStatus,
            'success' => true,
        ]);
    }

    protected function getTopSellingProducts()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalOrders = DB::table('orders')
            ->whereYear('order_date', $currentYear)
            ->whereMonth('order_date', $currentMonth)
            ->count();
        $uniqueCustomers = DB::table('orders')
            ->whereYear('order_date', $currentYear)
            ->whereMonth('order_date', $currentMonth)
            ->distinct('customer_id')
            ->count('customer_id');
        return  $averageOrdersPerCustomer = $uniqueCustomers > 0 ? $totalOrders / $uniqueCustomers : 0;
    }
    //
    protected function getTodaySales()
    {
        $today = Carbon::now()->format('d/m/Y');
        $totalOrdersToday = DB::table('orders')
            ->where('order_date', $today)
            ->count();
        $totalRevenueToday = DB::table('orders')
            ->where('order_date', $today)
            ->sum('total_amount');
        $data = [
            'totalOrdersToday' => $totalOrdersToday,
            'totalRevenueToday' => $totalRevenueToday,

        ];
        return $data;
    }
    protected function getTopCustomer()
    {
        $topUsers = DB::table('orders')
            ->select('customers.id', 'customers.name', 'customers.email', DB::raw('COUNT(*) as total_orders'))
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->groupBy('customers.id', 'customers.name', 'customers.email')
            ->orderByDesc('total_orders')
            ->take(10)
            ->get();
        return $topUsers;
    }
    ///
    protected function getOrderStatus()
    {
        $orderStatusCounts = Orders::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return $orderStatusCounts;
    }
}
