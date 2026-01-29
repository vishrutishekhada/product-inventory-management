<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Products
        $totalProducts = Product::count();

        // Total Stock Value
        $stockValue = Product::sum(DB::raw('quantity * selling_price'));

        // Today's Sales
        $todaysSales = Sale::whereDate('sale_date', today())->sum('total_amount');

        // Low Stock Products
        $lowStockProducts = Product::lowStock()
            ->with('category')
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        // Recent Sales
        $recentSales = Sale::with('creator')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'stockValue',
            'todaysSales',
            'lowStockProducts',
            'recentSales'
        ));
    }
}
