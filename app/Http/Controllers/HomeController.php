<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Car;
use App\Mail\AlertMail;
use App\Mail\ConfirmationMail;
use App\Page;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

  public function index(Request $request)
  {
    $page = Page::first();
    $cars = Car::all();
    $sites = Site::where("active", 1)->get();
    return view('home', [
      "cars" => $cars,
      "page" => $page,
      "sites" => $sites
    ]);
  }

  public function bookings(Request $request) {
    $page = Page::first();
    $booking = Booking::create($request->all());
    $booking->load("slot.site");
    $page = Page::first();
    $mailMSO = "m.rodolphe@groupemso.fr";
    // try {
      Mail::to($booking->email)->send(new ConfirmationMail($booking, $page));
    // } catch (\Throwable $th) {
      // throw $th;
    // }
    // try {
      Mail::to($mailMSO)->send(new AlertMail($booking));
    // } catch (\Throwable $th) {
      // throw $th;
    // }
    return view('confirm', [
      "booking" => $booking,
      "page" => $page
    ]);
  }
}
