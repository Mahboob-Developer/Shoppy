<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addtocart extends Model
{
    use HasFactory;
    protected $table="addtocarts";
    protected $fillable=['productid','userid'];
}
