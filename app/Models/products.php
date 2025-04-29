<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=([
        'adminid','name','category','brand','size','quantity','stock','price','description','mainimage','sideone','sidetwo','sidethree'
    ]); 
}
