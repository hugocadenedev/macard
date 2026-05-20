<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  protected $fillable = [ "banner_url", "title", "description", "background_color", "text_color", "is_active", "font", "email_site" ];
}
