<?php

namespace App\models;

use App\models\BaseModel;

class ProductModel extends BaseModel
{
    protected static string $table = 'products';
    protected static array $fillable = [
        'name',
        'sku',
        'category',
        'price',
        'quantity',
        'supplier',
        'description'
    ];
}