<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Design;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Date Range Filtering
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        // --- KPIs ---
        $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])->get();
        $totalRevenue = $invoices->sum('total_amount');
        $totalOrders = $invoices->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $newCustomers = User::where('role', 'customer')->whereBetween('created_at', [$startDate, $endDate])->count();

        // --- Sales Over Time Chart ---
        $salesOverTime = Invoice::select(
                DB::raw('DATE(invoice_date) as date'),
                DB::raw('sum(total_amount) as total')
            )
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $salesChartData = [
            'labels' => $salesOverTime->pluck('date')->map(function($date) { return Carbon::parse($date)->format('M d'); }),
            'data' => $salesOverTime->pluck('total'),
        ];

        // --- Order Status Breakdown Chart ---
        $orderStatusCounts = Design::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $orderStatusChartData = [
            'labels' => $orderStatusCounts->keys(),
            'data' => $orderStatusCounts->values(),
        ];

        // --- Top Selling Products Table ---
        $topProducts = Design::whereNotNull('product_id')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('product_name', DB::raw('count(*) as orders_count'), DB::raw('sum(total_price) as revenue'))
            ->groupBy('product_name')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();
            
        // --- Top Spending Customers Table ---
        $topCustomers = User::where('role', 'customer')
            ->withSum(['invoices' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            }], 'total_amount')
            ->orderBy('invoices_sum_total_amount', 'desc')
            ->limit(10)
            ->get();


        return view('admin.reports.index', compact(
            'totalRevenue', 'totalOrders', 'avgOrderValue', 'newCustomers',
            'salesChartData', 'orderStatusChartData',
            'topProducts', 'topCustomers',
            'startDate', 'endDate'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])->get();
        $totalRevenue = $invoices->sum('total_amount');
        $totalOrders = $invoices->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $newCustomers = User::where('role', 'customer')->whereBetween('created_at', [$startDate, $endDate])->count();

        $orderStatusCounts = Design::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $orderStatusChartData = [
            'labels' => $orderStatusCounts->keys(),
            'data' => $orderStatusCounts->values(),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'avgOrderValue' => $avgOrderValue,
            'newCustomers' => $newCustomers,
            'orderStatusChartData' => $orderStatusChartData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        return $pdf->download('business_report_'.now()->format('Ymd_His').'.pdf');
    }
}
