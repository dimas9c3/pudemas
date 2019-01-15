<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryDetail extends Model
{
    use SoftDeletes;

    protected $table 			= 'delivery_detail';
    protected $dates 			= ['deleted_at'];
}
