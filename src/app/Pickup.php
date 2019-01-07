<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pickup extends Model
{
    use SoftDeletes;

    protected $table 		= 'pick_up';

    protected $dates 		= ['deleted_at'];
}
