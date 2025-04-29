<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class create_offers extends Model
{
    use HasFactory;
    protected $table="create_offers";
    protected $fillable=(['name','category','discount','starting_date','ending_date','image']);
}
