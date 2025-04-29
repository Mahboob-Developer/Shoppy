<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;  // Add Authenticatable trait

    // Specify the table name if it differs from Laravel's default pluralization
    protected $table = 'users';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'fullname',
        'mobile',
        'email',
        'gender',
        'pincode',
        'address',
        'password',
    ];

    // Optional: Add any additional methods or relationships specific to your User model
}
