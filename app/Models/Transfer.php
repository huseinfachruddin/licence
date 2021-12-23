<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Account;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['*'];
        
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class,'account_id');
    }
    
}
