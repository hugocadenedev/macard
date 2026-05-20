<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
  protected $fillable = [ "firstname", "lastname", "avatar" ];

  public function getTitle() {
    return $this->firstname . " " . $this->lastname;
  }
}
