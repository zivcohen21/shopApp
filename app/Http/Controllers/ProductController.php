<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $statusCode = 200;
            $response = [
                'product'  => []
            ];

            $products = Product::all();

            foreach($products as $product){

                $response['product'][] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'img' => $product->img,
                    'amount' => $product->amount
                ];
            }
            //error_log($products);

        } catch (Exception $e){
            $statusCode = 400;
        }finally{
            return Response::create($response, $statusCode);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $statusCode = 200;
            $response = [
                'product' => null
            ];

            $productId = $request['productId'];
            $amountToBuy = $request['amountToBuy'];
            $curAmount = DB::table('products')->where('id', $productId)->value('amount');
            $curAmount -= $amountToBuy;
            $product = null;
            DB::table('products')->where('id', $productId)->update(['amount' => $curAmount]);
            $product = DB::table('products')->where('id', $productId)->get();
            $response['product'] = $product;
            error_log($amountToBuy);
            DB::table('carts')->insert(['productId' => $productId, 'amount' => $amountToBuy, 'userId' => 7]);
        }
        catch (Exception $e){
            $statusCode = 400;
        }finally{
            return  Response::create($response, $statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
