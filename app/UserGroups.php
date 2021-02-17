<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $fillable=['groupname','createdby'];
}
