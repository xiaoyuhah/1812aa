<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $table = 'coupon';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
