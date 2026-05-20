<?php

namespace App\Http\Controllers;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
  public function index() {
    $bookings = Booking::select(DB::raw('count(*) as amount, start_at, car_id'))
                        ->whereDate("start_at", ">", Carbon::now())
                        ->groupBy(["start_at", "car_id"])
                        ->get();

    return response($bookings, 200);
  }

  public function update(Request $request, $id) {
    $booking = Booking::find($id);
    $booking->update($request->all());
    return response($booking, 200);
  }

  public function destroy($id) {
    Booking::destroy($id);

    return redirect("/admin");
  }
}
