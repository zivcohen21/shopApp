<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $listOfProduct = [];
    protected $table = 'carts';
}
