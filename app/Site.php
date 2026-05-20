<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [ "name", "address", "address_name", "cp", "city", "active" ];
}
