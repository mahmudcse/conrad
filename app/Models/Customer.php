<?php

namespace App\Models;

use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function order(){
        return $this->hasMany(Order::class);
    }

}
