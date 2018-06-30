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
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-brazil-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496576-story-large-218ca4ae-18f2-46b5-b546-1e9cf607753a.jpg',
            'amount' => 95
        ]);




        DB::table('products')->insert([
            'title' => 'Colombia Jersey',
            'price' => 150,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-colombia-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496574-story-large-2ceca6e0-8c8d-43d1-9492-b15995da56c6.jpg',
            'amount' => 100
        ]);

        DB::table('products')->insert([
            'title' => 'Croatia Jersey',
            'price' => 150,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-croatia-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496596-story-large-0278a0e9-9441-4bde-aa96-7db32b035018.jpg',
            'amount' => 80
        ]);

        DB::table('products')->insert([
            'title' => 'England Jersey',
            'price' => 150,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-england-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496600-story-large-8937eaf8-732b-4e8c-9ef8-d9205652a9b5.jpg',
            'amount' => 80
        ]);

        DB::table('products')->insert([
            'title' => 'France Jersey',
            'price' => 200,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-france-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496608-story-large-00bd6ce8-d5a6-4090-9776-f25592aa3392.jpg',
            'amount' => 90
        ]);

        DB::table('products')->insert([
            'title' => 'Germany Jersey',
            'price' => 188,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-germany-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496620-story-large-4289b4b0-bb02-4ada-981a-c3f017583401.jpg',
            'amount' => 80
        ]);

        DB::table('products')->insert([
            'title' => 'Iceland Jersey',
            'price' => 100,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-iceland-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496618-story-large-947a8ea1-a26f-4c76-afab-b9f9e5948361.jpg',
            'amount' => 50
        ]);

        DB::table('products')->insert([
            'title' => 'Nigeria Jersey',
            'price' => 100,
            'img' => 'https://foto.gettyimages.com/photos/on-display-the-nigeria-shirt-for-the-fifa-world-cup-2018-in-russia-picture-id962496646-story-large-56c54cad-21d0-4233-a22f-b1865f60b774.jpg',
            'amount' => 70
        ]);

    }
}
