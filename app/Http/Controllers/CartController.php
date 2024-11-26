<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\CartIds;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function saveItemsToHistory(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'cartItems' => 'array',
            'cartItems.*.productId' => 'integer',
            'cartItems.*.productTitle' => 'string',
            'cartItems.*.description' => 'nullable|string',
            'cartItems.*.qty' => 'integer|min:1',
            'cartItems.*.price' => 'numeric|min:0',
            'cartItems.*.subTotal' => 'numeric|min:0',
            
            'cartInfo.amountPaid' => 'numeric|min:0',
            'cartInfo.customerName' => 'nullable',
            'cartInfo.paymentMethod' => 'nullable',
            'cartInfo.paymentStatus' => 'nullable',
            'cartInfo.cartTotal' => 'numeric|min:0'
        ]);

        // Generate a unique cart ID
        $cartId = rand(11111111, 99999999);

        // Save cart-level information
        CartIds::create([
            'cartId' => $cartId,
            'amountPaid' => $validatedData['cartInfo']['amountPaid'],
            'customerName' => $request->cartInfo['customerName'],
            'paymentMethod' => $request->cartInfo['paymentMethod'],
            'paymentStatus' => $request->cartInfo['paymentStatus'],
            'cartTotal' => $request->cartInfo['cartTotal']
        ]);

        // Save each cart item
        foreach ($request->cartItems as $item) {
            CartItems::create([
                'cartId' => $cartId,
                'itemId' => $item['itemId'],
                'productId' => $item['productId'],
                'productTitle' => $item['productTitle'],
                'description' => $item['description'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subTotal' => $item['subTotal']
            ]);
        }

        return response()->json(['message' => 'Cart items saved to history successfully', 'cartId' => $cartId], 200);
    }


    public function historyList(){
        $historyList = CartIds::orderBy('created_at', 'desc')->get();

        return response()->json(['historyList' => $historyList]);
    }

    public function historyCart($cartId){
        $cart = CartIds::where('cartId', $cartId)->first();

        $listItems = CartItems::where('cartId', $cartId)->get();

        return response()->json(['cart' => $cart, 'items' => $listItems]);
    }

    public function deleteInvoice($cartId){
        $cart = CartIds::where('cartId', $cartId)->first();

        $items = CartItems::where('cartId', $cartId)->get();

        foreach($items as $item){

            $item->delete();
        }

       $cart->delete();

        return response()->json(['status' => true]);
    }


}
