<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Licence;
use Illuminate\Database\Eloquent\SoftDeletes;


class Domain extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['*'];

    public function licence()
    {
        return $this->belongsTo(Licence::class,'licence_id');
    }
    
    
    

}
