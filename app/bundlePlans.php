<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bundlePlans extends Model
{
    protected $fillable = ['plantitle','planname','cost','desc','mode'];
}
