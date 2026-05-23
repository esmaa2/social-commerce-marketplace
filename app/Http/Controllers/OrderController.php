<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

class OrderController extends Controller
{
    private function getCartKey()
    {
        return auth()->check() ? "cart_" . auth()->id() : "cart_guest";
    }
    /**
     * Show all orders of the logged-in user
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show single order with its items
     */
    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
                      ->with('items')
                      ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Checkout → create order from session cart
     */
   private function getUserCart()
{
    return Cart::firstOrCreate(['user_id' => auth()->id()]);
}

public function showCheckoutPage()
{
    $cart = $this->getUserCart()->load('items.product');

    if ($cart->items->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    }

    $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
    $shipping = 10;
    $tax = $subtotal * 0.15;
    $total = $subtotal + $shipping + $tax;

    return view('cart.checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
}

public function checkout(Request $request)
{
    $cart = $this->getUserCart()->load('items.product');

    if ($cart->items->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty');
    }

    DB::beginTransaction();

    try {
        $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 10;
        $tax = $subtotal * 0.15;
        $totalAmount = $subtotal + $shipping + $tax;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending', // or 'paid' if you want
            'total_amount' => $totalAmount,
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'unit' => 'pcs',
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        DB::commit();

        // Redirect to payment page with order info
        return redirect()->route('payment', ['order' => $order->id]);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Checkout failed: ' . $e->getMessage());
    }
}



public function showPayment($orderId)
{
    $order = Order::with('items.product')->where('user_id', auth()->id())->findOrFail($orderId);

    return view('payment', compact('order'));
}


    /**
     * Order history for the logged-in user
     */
    public function history()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.history', compact('orders'));
    }
}
