<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CartController extends Controller
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
                'item'  => []
            ];
           /* $cartsItems = Cart::all();
            //error_log($cartsItems);
            foreach($cartsItems as $cartsItem)
            {
                $productId = $cartsItem->productid;
                error_log($productId);
                $product = DB::table('products')->select('id', 'title', 'price')->where('id', $productId)->get();

                $amount = $cartsItem->amount;

                $response['item'][] = [
                    'id' => $product[0]->id,
                    'title' => $product[0]->title,
                    'price' => $product[0]->price,
                    'amount' => $amount
                ];

            }*/

            $items = DB::table('products')->join('carts', 'carts.productid', '=', 'products.id')->select('products.id', 'products.title', 'products.price', 'carts.amount')->get();
            $response['item'] =  $items;
            /*foreach($items as $item)
            {
                error_log($response['item']);
                $response['item'][] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'price' => $item->price,
                    'amount' => $item->amount
                ];

            }*/

            



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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
