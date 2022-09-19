<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'PRODUCTS';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'colors',
        'sizes',
        'description',
        'CATEGORY_PRODUCTS_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\CategoriaProducto', 'CATEGORY_PRODUCTS_id', 'id');
    }

    public function publicaciones()
    {
        return $this->hasMany('App\Models\PublicacionProducto', 'PRODUCTS_id', 'id');
    }

    public function precios()
    {
        return $this->hasMany('App\Models\ProductoPrice', 'PRODUCTS_id', 'id');
    }

    public function imagenes()
    {
        return $this->hasMany('App\Models\ProductoImage', 'PRODUCTS_id', 'id');
    }

    public function colores()
    {
        return $this->hasMany('App\Models\ProductoColor', 'PRODUCTS_id', 'id');
    }
}
