<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Package;

class Suborder extends Model
{
    use HasFactory;
    protected $fillable = ['*'];

    public function order()
    {
        return $this->belongsTo(Order::class,'suborder_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }
}
