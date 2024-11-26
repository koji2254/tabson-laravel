<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    public function allProducts(){

        $products = Products::all();
    
        return response()->json(['products' => $products], 201);
    }

    public function singleProduct($id){

        $product = Products::where('productId', $id)->first();

        if ($product) {
            $product->productImage = asset('storage/' . $product->productImage); // Adjust path if stored differently
        }

        return response()->json(['product' => $product], 200);

        
    }
    
    public function addProduct(Request $request){

        $request->validate([
            'productTitle' => 'required|string|max:255',
            'productCategory' => 'string|max:255',
            'price' => 'required|numeric|min:0',
            'packetPrice' => 'numeric|min:0',
            'cartonPrice' => 'numeric|min:0',
            'quantity' => 'integer|min:0',
            'expiryDate' => 'date|after:today',
            'productImage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Optional image validation
        ]);

         // If there's an image, handle the file upload
        if ($request->hasFile('productImage')) {
            $imagePath = $request->file('productImage')->store('product_images', 'public');
        } else {
            $imagePath = null;  // Or set a default image path if necessary
        }


            // Create the product in the database
        $product = Products::create([
            'productId' => rand(1000000, 9999999), // Random 7-digit product ID
            'productTitle' => $request->input('productTitle'),
            'productCategory' => $request->input('productCategory'),
            'price' => $request->input('price'),
            'packetPrice' => $request->input('packetPrice'),
            'cartonPrice' => $request->input('cartonPrice'),
            'quantity' => $request->input('quantity'),
            'expiryDate' => $request->input('expiryDate'),
            'productImage' => $imagePath,  // Store the image path if there is an image
        ]);

        // Save the product
        $product->save();

        // Return a response
        return response()->json([
            'message' => 'Product added successfully!',
            'product' => $product
        ], 201);
        
    }



    public function editProduct(Request $request) {
 
        $id = $request->productId;

        $product = Products::where('productId', $id)->first();
    
        if ($product === null) {
            return response()->json([
                'product' => 'No product found'
            ], 404);
        }
        
        // Validate the incoming request
        $productInfo = $request->validate([
            'productTitle' => 'string|max:255',
            'productCategory' => 'string|max:255',
            'price' => 'numeric|min:0',
            'packetPrice' => 'numeric|min:0',
            'cartonPrice' => 'numeric|min:0',
            'quantity' => 'integer|min:0',
            'expiryDate' => 'date|after:today',
            'productImage' => '',
        ]);

        // Handle image update if a new image is uploaded
        if ($request->hasFile('productImage')) {
            // Delete the old image if it exists
            if ($product->productImage) {
                Storage::disk('public')->delete($product->productImage);
            }

            // Store the new image and update the image path
            $productInfo['productImage'] = $request->file('productImage')->store('product_images', 'public');
        } else {
            // Keep the old image path if no new image is uploaded
            $productInfo['productImage'] = $product->productImage;
        }

        // Perform the update and check the result
        $updateResult = $product->update($productInfo);

        if ($updateResult) {
            // Reload the product data after update
            $product->refresh();

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed to update product',
                'status' => false
            ], 500);
        }

    }
    
    
    public function deleteProduct($id){
        $product = Products::where('productId', $id)->first();

        if(!$product) {
            return response()->json([ 
                'message' => 'No Product found',
                'product' => '',
                'status' => false
            ], 404); 
        }

        $product->delete(); // Save the product with deleted information
    
        return response()->json(['message' => 'Product deleted successfully', 'status' => true], 200);

    }


}
