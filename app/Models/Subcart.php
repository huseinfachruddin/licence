<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Package;
class Subcart extends Model
{
    use HasFactory;
    protected $fillable = ['*'];

    public function cart()
    {
        return $this->belongsTo(Cart::class,'subcart_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }
}
