<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\Domain;

class Licence extends Model
{
    use HasFactory;
    protected $fillable = ['*'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function domain()
    {
        return $this->hasMany(Domain::class,'licence_id');
    }
    
}
