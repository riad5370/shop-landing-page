<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingDetails;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(){
        $orders = Order::orderBy('created_at', 'DESC')->get();
        $pendingOrders = Order::where('status', 1)->count();
        $processingOrders = Order::where('status', 2)->count();
        $deliveryOrders = Order::where('status', 6)->count();
        return view('admin.order.order',[
            'orders'=>$orders,
            'pendingOrders'=>$pendingOrders,
            'deliveryOrders'=>$deliveryOrders,
            'processingOrders'=>$processingOrders,
        ]);
    }

    public function orderStatus(Request $request){
        $after_explode = explode(',', $request->status);
        Order::where('order_id',$after_explode[0])->update([
            'status'=>$after_explode[1],
        ]);
        return back();
    }
    public function ordersDetails($id){
        $order_info = Order::find($id);
        $customerInfo = BillingDetails::where('order_id',$order_info->order_id)->first();
        $order_product = OrderProduct::where('order_id',$order_info->order_id)->get();
        return view('admin.order.order_details',[
            'order_info'=>$order_info,
            'customerInfo'=>$customerInfo,
            'order_product'=>$order_product,
        ]);
    }

    public function orderDelete($id){
        // Find the order by ID
    $order = Order::find($id);

    // Check if the order exists
    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    // Find the billing details related to the order
    $billingDetails = BillingDetails::where('order_id', $order->order_id)->first();

    // Find all order products related to the order
    $orderProducts = OrderProduct::where('order_id', $order->order_id)->get();

    // Delete each order product
    foreach ($orderProducts as $orderProduct) {
        $orderProduct->delete();
    }

    // Delete the billing details if they exist
    if ($billingDetails) {
        $billingDetails->delete();
    }
    // Delete the order
    $order->delete();
    return back()->with('success', 'Order and its related data deleted successfully.');
    }
}
