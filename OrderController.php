<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{


    /**
     * List all orders for the authenticated customer.
     *
     * @return \Illuminate\View\View
     */
    public function listOrders()
    {
        $orders = auth()->user()->orders()->forCustomer()->latest()->get();
        NotificationHelper::deleteAllOrderNoti(auth()->id());
        return view('customer.orders', compact('orders'));
    }

    /**
     * Place a new order.
     *
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        $transBegin = false;
        try {
            $cart = auth()->user()->cart;
            DB::beginTransaction();
            $transBegin = true;
            $order = Order::fillFromCart($cart);
            $order->delivery_info = json_encode($request->toArray());
            $order->save();
            $total = 0;
            foreach ($cart->items as $item) {
                $subtotal = $item->menu->price * $item->quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal
                ]);
                $total += $subtotal;
            }
            $order->total_amount = $total;
            $order->save();
            $cart->items()->delete();
            $cart->restaurant_id = null;
            $cart->status = 0;
            $cart->save();
            $notifiation = Notification::create([
                'user_id' => $order->restaurant->owner_id,
                'message' => 'You Have new order.',
                'is_read' => false,
                'goto_url' => route('owner.orders'),
                'related' => Order::class,
                'reference_id' => $order->id
            ]);
            DB::commit();
            $transBegin = false;
            return back()->with(['success' => 'The order placed successfully']);
        } catch (\Throwable $e) {
            if ($transBegin)
                DB::rollBack();
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * List all orders for the authenticated customer.
     *
     */
    public function orderChangeStatus(Request $request)
    {

        $order = Order::find($request->id);
        $sid = $request->sid;
        $status = "error";
        $message = "Process Failed";
        $prev_status = $order->status;
        if ($sid == 1 && $order->update(['is_favorite' => !$order->is_favorite])) {
            $status = "success";
            $message = 'Order '.($order->is_favorite?'added to':'removed from').' favorites';
        } elseif ($sid == 2 && $order->update(['status' => 'canceled'])) {
            $status = "success";
            $message = 'Order canceled';
            $order->update(['hide_from_customer' => true]);

        } elseif ($sid == 3 && $order->update(['status' => 'canceled'])) {
            $status = "success";
            $message = 'Order canceled';
        }
        NotificationHelper::deleteOrderNoti($order->restaurant->owner_id, $order->id);

        if ($sid==2&&array_key_exists( $prev_status,['pending' => 1, 'preparing' => 1, 'delivering' => 1])) {
            $notification = Notification::create([
                'message' => $message,
                'user_id' => $order->restaurant->owner_id,
                'reference_id' => $order->id,
                'related' => Order::class,
                'goto_url' => route('owner.orders')
            ]);
        }
        NotificationHelper::deleteOrderNoti($order->customer_id, $order->id);
        return response()->json(['status' => $status, 'message' => $message]);
    }

    /**
     * List all orders for a specific restaurant.
     *
     * @return \Illuminate\View\View
     */
    public function listRestaurantOrders()
    {
        $restaurant = auth()->user()->restaurant;
        $orders = $restaurant->orders()->forOwner()->latest()->get();

        return view('owner.orders', compact('orders', 'restaurant'));
    }

    /**
     * List all orders for a specific restaurant.
     *
     */
    public function restaurantOrder($id)
    {
        $order = Order::find($id);
        $view = view('owner.view_order', compact('order'))->render();
        return response()->json(['modal' => $view]);
    }

    /**
     * List all orders for a specific restaurant.
     *
     */
    public function restaurantOrderConfirm(Request $request)
    {

        $order = Order::find($request->id);
        $status = "error";
        $message = "Process Failed";
        if ($request->pid == 1) {
            if ($order->update(['status' => 'preparing'])) {
                $status = "success";
                $message = 'Order preparing';
            }
        } elseif ($request->pid == 2) {
            if ($order->update(['status' => 'rejected'])) {
                $status = "success";
                $message = 'Order rejected';
                $order->update(['hide_from_owner' => true]);

            }
        }
        NotificationHelper::deleteOrderNoti($order->customer_id, $order->id);
        $notification = Notification::create([
            'message' => $message,
            'user_id' => $order->customer_id,
            'reference_id' => $order->id,
            'related' => Order::class,
            'goto_url' => route('customer.orders')
        ]);
        NotificationHelper::deleteOrderNoti($order->restaurant->owner_id, $order->id);
        return response()->json(['status' => $status, 'message' => $message]);
    }

    public function restaurantOrderChangeStatus(Request $request)
    {

        $order = Order::find($request->id);
        $sid = $request->sid;
        $status = "error";
        $message = "Process Failed";
        if ($sid == 1 && $order->update(['status' => 'preparing'])) {
            $status = "success";
            $message = 'Order preparing';
        } elseif ($sid == 2 && $order->update(['status' => 'delivering'])) {
            $status = "success";
            $message = 'Order delivering';
            if($order->delivery) {
                NotificationHelper::deleteOrderNoti($order->delivery->agent->user_id, $order->id);
                $notification = Notification::create([
                    'message' => $message,
                    'user_id' => $order->delivery->agent->user_id,
                    'reference_id' => $order->id,
                    'related' => Order::class,
                    'goto_url' => route('agent.orders')
                ]);
            }
        } elseif ($sid == 3 && $order->update(['status' => 'rejected'])) {
            $status = "success";
            $message = 'Order rejected';
        }elseif ($sid == 4 && $order->update(['status' => $order->status=='delivering'?'preparing':'canceled'])) {
            $status = "success";
            $message = 'Order Canceled';
            if($order->delivery) {
                NotificationHelper::deleteOrderNoti($order->delivery->agent->user_id, $order->id);
                $notification = Notification::create([
                    'message' => $message,
                    'user_id' => $order->delivery->agent->user_id,
                    'reference_id' => $order->id,
                    'related' => Order::class,
                    'goto_url' => route('agent.orders')
                ]);
            }

        }elseif ($sid == 5 && str_contains("canceled rejected",$order->status)) {
            $status = "success";
            $message = 'Order Removed';
        }
        if($sid!=5) {
            NotificationHelper::deleteOrderNoti($order->customer_id, $order->id);
            $notification = Notification::create([
                'message' => $message,
                'user_id' => $order->customer_id,
                'reference_id' => $order->id,
                'related' => Order::class,
                'goto_url' => route('customer.orders')
            ]);
        }
        NotificationHelper::deleteOrderNoti($order->restaurant->owner_id, $order->id);
        return response()->json(['status' => $status, 'message' => $message]);
    }

    /**
     * Show order details.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        return view('order.details', compact('order'));
    }
}
