<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
        'is_featured'
    ];

    //Casting atribut ke tipe data yang sesuai
    //Agar Laravel otomatis mengubah string dari DB menjadi tipe data yang benar
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}
