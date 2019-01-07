<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupDetail extends Model
{
    use SoftDeletes;

    protected $table 		= 'pick_up_detail';

    protected $dates 		= ['deleted_at'];
}
