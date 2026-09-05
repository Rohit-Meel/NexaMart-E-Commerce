<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Orders list
     */
    public function index()
    {
        $orders = Order::with('customer')
            ->withCount('orderItems')
            ->latest('id')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Order details
     */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'address',
            'orderItems.product',
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => [
                'required',
                'in:pending,confirmed,processing,shipped,delivered,cancelled'
            ],
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => [
                'required',
                'in:pending,paid,failed,refunded'
            ],
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Payment status updated successfully.');
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}