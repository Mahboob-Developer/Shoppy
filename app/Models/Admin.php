<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Admin extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $table = 'admins';
    protected $fillable = [
        'fullname',
        'mobile',
        'email',
        'gender',
        'brand',
        'pincode',
        'address',
        'password',
        'status',
        'image',
    ];
}
