<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaProducto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'CATEGORY_PRODUCTS';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'parent_category_id',
        'urlImg'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\CategoriaProducto', 'parent_category_id', 'id');
    }

    public function productos()
    {
        return $this->hasMany('App\Models\Producto', 'CATEGORY_PRODUCTS_id', 'id');
    }

    public function publicaciones()
    {
        return $this->hasMany('App\Models\PublicacionProducto', 'CATEGORY_PRODUCTS_id', 'id');
    }

    public function categorias()
    {
        return $this->hasMany('App\Models\CategoriaProducto', 'parent_category_id', 'id');
    }
}
