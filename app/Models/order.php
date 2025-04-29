<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=['adminid','user_id','product_id','name','tracking_number','tracking_address','size','quantity','total_price','price','discount','discount_price','payment_method','status','pincode','shipping_fee','order_date','delivery_date','image'];
}
