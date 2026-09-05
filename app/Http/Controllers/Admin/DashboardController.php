<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalVendors = Vendor::count();
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalBrands',
            'totalVendors',
            'totalProducts',
            'totalCustomers',
            'totalOrders'
        ));
    }
}