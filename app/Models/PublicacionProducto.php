<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicacionProducto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'PUBLISHED_PRODUCTS';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'priority',
        'isActive',
        'isPrincipal',
        'PRODUCTS_id',
        'USERS_id',
        'CATEGORY_PRODUCTS_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'PRODUCTS_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\CategoriaProducto', 'CATEGORY_PRODUCTS_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'USERS_id', 'id');
    }
}
