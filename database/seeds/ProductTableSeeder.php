<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        error_log("ProductTableSeeder");
        DB::table('products')->delete();
        /*
                Product::create(array(
                    'title' => 'product1',
                    'price' => 20,
                    'img' => '',
                    'amount' => 10
                ));*/
        DB::table('products')->insert([
            'title' => 'product1',
            'price' => 20,
            'img' => '',
            'amount' => 10
        ]);

        DB::table('products')->insert([
            'title' => 'product2',
            'price' => 40,
            'img' => '',
            'amount' => 10
        ]);
    }
}
