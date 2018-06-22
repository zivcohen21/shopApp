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

            $items = DB::table('products')->
            join('carts', 'carts.productid', '=', 'products.id')->
            select('products.id', 'products.title', 'products.price', 'carts.amount', 'products.amount as maxAmount')->get();
            $response['item'] =  $items;

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
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        try {

            $statusCode = 200;
            $response = [
                'item' => []
            ];
            error_log($request);
            $newAmount = $request->amount;
            $productId = $request->id;
            error_log($newAmount);
            DB::table('carts')->where('productid', '=', $productId)->update(['amount'=> $newAmount]);
        }
        catch (Exception $e){
            $statusCode = 400;
        }
        finally{
            return Response::create($response, $statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        try {
            $statusCode = 200;
            $response = [
                'item' => $productId
            ];
            error_log($productId);
            $amount = DB::table('carts')->where('productid', '=', $productId)->select('amount')->get();
            $amount = $amount[0]->amount;
            DB::table('carts')->where('productid', '=', $productId)->delete();
            DB::table('products')->where('id', $productId)->increment('amount', $amount, ['isincart' => false]);


        }
        catch (Exception $e){
            $statusCode = 400;
        }
        finally{
            return Response::create($response, $statusCode);
        }
    }
}
