<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transfer;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['*'];

    public function transfer()
    {
        return $this->hasMany(Transfer::class,'account_id');
    }

}
