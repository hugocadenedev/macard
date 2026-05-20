<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Car;
use App\Commercial;
use App\Page;
use App\Site;
use Illuminate\Http\Request;

class AdminController extends Controller
{

  public function index(Request $request) {
    $bookings = Booking::orderByDesc("created_at")->with([
      "bookingType",
      "slot" => function($q) {
        $q->withTrashed();
      }
    ])->filter($request)->searchInput($request)->paginate(20);
    $commercials = Commercial::all();
    $sites = Site::all();
    return view('admin.index', [
      "bookings" => $bookings,
      "commercials" => $commercials,
      "sites" => $sites
    ]);
  }
}
