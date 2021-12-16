<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Licence;
use App\Models\Package;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['*'];

    public function licence()
    {
        return $this->hasMany(Licence::class,'product_id');
    }
    public function package()
    {
        return $this->hasMany(Package::class,'product_id');
    }

}
