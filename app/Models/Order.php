<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Suborder;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['*'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function suborder()
    {
        return $this->hasMany(Suborder::class,'order_id');
    }
}
