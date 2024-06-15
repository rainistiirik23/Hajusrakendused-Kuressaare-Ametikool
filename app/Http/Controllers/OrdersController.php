<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('Store/Order-Checkout', ['orders' => $request->session()->get('orders')]);
    }
    public function OrderPayment(Request $request)
    {
        $orderModel = new Order();
        $orderItems = $request->orderItems;
        $orderSum = 0;

        for ($i = 0; $i < count($orderItems); $i++) {
            $orderSum += $orderItems[$i]['price'];
        }

        $order = Order::create([
            'first_name' => $request['paymentInfo']['firstName'],
            'last_name' => $request['paymentInfo']['lastName'],
            'email' => $request['paymentInfo']['email'],
            'phone' => $request['paymentInfo']['phone'],
            'order_sum' => $orderSum,
        ]);

        for ($i = 0; $i < count($orderItems); $i++) {
            OrderItem::create([
                'name' => $orderItems[$i]['name'],
                'image' => $orderItems[$i]['name'],
                'price' => $orderItems[$i]['price'],
                'amount' => $orderItems[$i]['userSelectedStock'],
                'order_id' => $order->id,
            ]);
        }
        $request->session()->flush();
        return redirect()->back();
    }
    public function orderSession(Request $request)
    {

        if (!$request->session()->exists('orders')) {
            $request->session()->put('orders', [$request->all()]);
            return redirect()->back();
        }
        $sessionData = $request->session()->get('orders');
        $duplicateValueArrayKey = null;
        for ($i = 0; $i < count($sessionData); $i++) {
            if ($sessionData[$i]['name'] === $request->input('name')) {
                $duplicateValueArrayKey = $i;
                break;
            }
        }

        if ($duplicateValueArrayKey or $duplicateValueArrayKey === 0) {
            $sessionData[$duplicateValueArrayKey]['userSelectedStock']++;
            $request->session()->put('orders', $sessionData);
            return redirect()->back();
        }
        array_push($sessionData, $request->all());
        $request->session()->put('orders', $sessionData);
        return redirect()->back();
    }
    public function removeCartItem(Request $request)
    {

        $sessionData = $request->session()->get('orders');
        for ($i = 0; $i < count($sessionData); $i++) {

            if ($sessionData[$i]['name'] === $request->input('orderItemName')) {
                if ($i === 0) {
                    array_shift($sessionData);
                    break;
                }
                array_splice($sessionData, $i, $i);
                break;
            }
        }

        $request->session()->put('orders', $sessionData);
        return redirect()->back();
    }
    public function changeUserStock(Request $request)
    {
        $request->input('orderIndex');
        $sessionData = $request->session()->get('orders');
        /*   dd($sessionData[$request->input('orderIndex')]['userSelectedStock']); */
        $sessionData[$request->input('orderIndex')]['userSelectedStock'] = intval($request->input('userSelectedStockValue'));
        $request->session()->put('orders', $sessionData);
        return redirect()->back();
    }
}
