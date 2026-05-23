<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    private function getUserCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    // Show cart page
    public function index()
    {
        $cart = $this->getUserCart()->load('items.product');

        $subtotal = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 10;
        $tax = $subtotal * 0.15;
        $total = $subtotal + $shipping + $tax;

        return view('cart.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    // Add product
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getUserCart();

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} added to cart!");
    }

    // Update quantity
    public function update(Request $request, $productId)
    {
        $quantity = (int) $request->input('quantity');
        $cart = $this->getUserCart();
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->update(['quantity' => $quantity]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    // Remove product
    public function remove($productId)
    {
        $cart = $this->getUserCart();
        $cart->items()->where('product_id', $productId)->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }


    public function toggle(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $cart = $this->getUserCart();

    $cartItem = $cart->items()->where('product_id', $productId)->first();

    if ($cartItem) {
        // Product exists → remove it
        $cartItem->delete();
        return response()->json([
            'status' => 'removed',
            'message' => "{$product->name} removed from cart!"
        ]);
    } else {
        // Product does not exist → add it
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        return response()->json([
            'status' => 'added',
            'message' => "{$product->name} added to cart!"
        ]);
    }
}

}
