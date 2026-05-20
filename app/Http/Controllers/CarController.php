<?php

namespace App\Http\Controllers;

use App\Car;
use App\Commercial;
use App\Site;
use App\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{

  public function index() {

    $cars = Car::all();
    return view('admin.cars', [
      "cars" => $cars,
    ]);
  }

  public function show(Request $request, $id) {
    $car = Car::find($id);
    $sites = Site::all();
    $slots = $sites->isEmpty() ? [] : Slot::with("commercial")->where("site_id", $sites[0]->id)->where("car_id", $id)->get();

    return view("admin.carShow", [
      "car" => $car,
      "slots" => $slots,
      "sites" => $sites,
    ]);
  }

  public function create() {

    return view("admin.carform", [
      "car" => new Car(),
      "title" => "Nouvelle voiture"
    ]);
  }

  public function edit(Request $request, $id) {

    $car = Car::find($id);

    return view("admin.carform", [
      "car" => $car,
      "title" => "Edition de " . $car->model
    ]);
  }

  public function update(Request $request, $id) {
    $car = Car::find($id);
    $car->update($request->all());
    return response($car, 200);
  }

  public function store(Request $request) {

    if ($request->hasFile("image")) {
      $path = Storage::disk('uploads')->putFile("cars", $request->file("image"));
      $request->merge(["image_url" => "/" . $path]);
    }
    if ($request->has("id")) Car::find($request->id)->update($request->all());
    else Car::create($request->all());

    return redirect("/admin/cars");
  }

  public function destroy($id) {
    Car::destroy($id);

    return redirect("/admin/cars");
  }

}
