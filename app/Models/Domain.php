<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Licence;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function licence()
    {
        return $this->belongsTo(Licence::class,'licence_id');
    }
    
    
    

}
