<?php

namespace App\Http\Controllers;

use App\BookingType;
use Illuminate\Http\Request;

class BookingTypeController extends Controller
{
    public function index() {

        $models = BookingType::all();
        return response($models, 200);
    }
}
