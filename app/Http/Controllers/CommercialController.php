<?php

namespace App\Http\Controllers;

use App\Commercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommercialController extends Controller
{
  public function index() {
    $commercials = Commercial::all();
    return view('admin.commercials', [
      "commercials" => $commercials,
    ]);
  }

  public function create() {
    return view("admin.commercialForm", [
      "commercial" => new Commercial(),
      "title" => "Nouveau commercial"
    ]);
  }

  public function edit(Request $request, $id) {
    $commercial = Commercial::find($id);
    return view("admin.commercialForm", [
      "commercial" => $commercial,
      "title" => "Edition de " . $commercial->getTitle()
    ]);
  }

  public function update(Request $request, $id) {
    $commercial = Commercial::find($id);
    $commercial->update($request->all());
    return response($commercial, 200);
  }

  public function store(Request $request) {

    if ($request->hasFile("image")) {
      $path = Storage::disk('uploads')->putFile("commercials", $request->file("image"));
      $request->merge(["avatar" => "/" . $path]);
    }
    if ($request->has("id")) Commercial::find($request->id)->update($request->all());
    else Commercial::create($request->all());

    return redirect("/admin/commercials");
  }

  public function destroy($id) {
    Commercial::destroy($id);

    return redirect("/admin/commercials");
  }
}
