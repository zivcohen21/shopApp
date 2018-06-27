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
            'title' => 'Argentina Jersey',
            'price' => 200,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-argentina-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496578-story-large-ab0ce78b-4f1b-4e9e-8dfc-caa965ef8817.jpg',
            'amount' => 100
        ]);

        DB::table('products')->insert([
            'title' => 'Belgium Jersey',
            'price' => 150,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-belgium-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496572-story-large-9c9f4214-bf4e-4cd0-bfb6-d00116e8d3cf.jpg',
            'amount' => 80
        ]);

        DB::table('products')->insert([
            'title' => 'Brazil Jersey',
            'price' => 170,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-brazil-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496576-story-small-218ca4ae-18f2-46b5-b546-1e9cf607753a.jpg',
            'amount' => 95
        ]);

    }
}
