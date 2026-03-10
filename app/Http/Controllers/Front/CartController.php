<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{


    public function index()
    {
        $items = Cart::getContent();

        if($items->isEmpty()){
            return redirect()->route('home.index');
        }

        return view('front-end.cart.list', compact('items'));
    }

    // Add an item to the cart
public function add(string $id)
{
    // get product with images
    $product = Products::where('id', $id)->with('Images')->first();

    if(!$product){
        return redirect()->back()->with('error','Product not found');
    }

    $image = $product->Images->first();
    $image_url = $image ? $image->image : 'default.png';

    $cartItem = Cart::get($id);

    if ($cartItem) {
        // If item exists, update the quantity (+1)
        Cart::update($id, [
            'quantity' => [
                'relative' => true,
                'value' => 1,
            ],
        ]);
    } else {

        // Add item to the cart
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
                'image' => $image_url,
            ],
        ]);
    }

    // return $cartItem;

    return redirect()->route('cart.list')->with('success', 'Item added to cart!');
}

    // Update the quantity of an item in the cart
    public function update(Request $request){
        $id = $request->id;
        $action = $request->action;

        // Get the product and current cart item
        $product = Products::find($id);
        $cartItem = Cart::get($id);

        if (!$product || !$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart!',
            ]);
        }

        // Calculate new quantity
        $newQuantity = $cartItem->quantity;

        if ($action === 'increase') {
            $newQuantity += 1;
        } elseif ($action === 'decrease') {
            if ($newQuantity > 1) {
                $newQuantity -= 1;
            }
        }

        // Check if new quantity exceeds stock
        if ($newQuantity > $product->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity exceeds available stock!',
            ]);
        }

        // Update quantity in cart
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $newQuantity,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully!',
            'newQuantity' => $newQuantity,
        ]);
    }



    // Remove an item from the cart
    public function remove($id)
    {
        // Remove the item from the cart
        Cart::remove($id);

        // Redirect back with success message
        return redirect()->route('cart.list')->with('success', 'Item removed from cart!');
    }

    // Clear the entire cart
    public function clear()
    {
        // Clear all items from the cart
        Cart::clear();

        // Redirect back with success message
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

}
