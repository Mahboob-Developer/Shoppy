<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class create_category extends Model
{
    use HasFactory;
    protected $table="create_categories";
    protected $fillable = (['name', 'size','image']);
}
