<?php

namespace App\Http\Controllers;

use App\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotsController extends Controller
{
  public function store(Request $request) {
    $slot = Slot::create($request->all());
    $slot->load("commercial");
    return response($slot, 200);
  }

  public function index(Request $request) {
    $slots = Slot::where("site_id", $request->site_id)
                ->where("car_id", $request->car_id)
                ->whereDate("start", ">=", Carbon::now())
                ->orderBy("start")
                ->get()->append("available");
    return response($slots, 200);
  }

  public function destroy($id) {
    Slot::destroy($id);

    return response(true, 200);
  }
}
