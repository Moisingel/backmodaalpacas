<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'PRODUCTS_IMAGES';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'PRODUCTS_id',
        'url',
        'order',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
