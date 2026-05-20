<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
  use SoftDeletes;

  protected $fillable = [ "constructor", "model", "image_url", "title", "description", "price", "available_amount", "active" ];

  public function getTitle() {
    
  }
}
