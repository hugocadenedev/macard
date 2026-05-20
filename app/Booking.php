<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Booking extends Model
{

  use SoftDeletes;

  protected $fillable = [ "firstname", "lastname", "email", "phone", "start_at", "end_at", "slot_id", "active", "commercial_id", "booking_type_id" ];

  protected $dates = ['start_at', 'end_at', 'created_at'];

  // protected $casts = [
  //   'start_at' => 'datetime',
  // ];

  public function slot()
  {
    return $this->belongsTo('App\Slot');
  }
  public function bookingType()
  {
    return $this->belongsTo('App\BookingType');
  }

  public function scopeFilter($query, $request) {
    if ($request->has("commercial_id") && $request->input("commercial_id") != "") return $query->where("commercial_id", $request->input("commercial_id"));
    if ($request->has("created_at"))    return $query->whereDate("created_at", $request->input("created_at"));
    if ($request->has("slot_start"))    return $query->whereHas('slot', function($q) use($request) {
      $q->whereDate("start", $request->input("slot_start"));
    });
    if ($request->has("site_id") && $request->input("site_id") != "")    return $query->whereHas('slot', function($q) use($request) {
      $q->where("site_id", $request->input("site_id"));
    });
  }

  public function scopeSearchInput($query, $request) {
    if (!$request->has("search")) return $query;
    $keyword = explode(" ", $request->search);
    foreach ($keyword as $word) {
      $query = $query->orWhere("firstname", "like", '%' . $word . '%')
                ->orWhere("lastname", "like", '%' . $word . '%')
                ->orWhere("email", "like", '%' . $word . '%');
    }
    return $query;
  }

  public function getSlot() {
    return $this->slot->start->setTimezone("Europe/Paris")->format('d M à H\hi');
  }
}
