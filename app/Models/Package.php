<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['*'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
