<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'PRODUCTS_PRICES';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'amount',
        'productos_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
