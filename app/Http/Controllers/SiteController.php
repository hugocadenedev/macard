<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
  public function index() {
    $sites = Site::all();
    return view('admin.sites', [
      "sites" => $sites,
    ]);
  }

  public function create() {
    return view("admin.siteForm", [
      "site" => new Site(),
      "title" => "Nouveau site"
    ]);
  }

  public function edit(Request $request, $id) {
    $site = Site::find($id);
    return view("admin.siteForm", [
      "site" => $site,
      "title" => "Edition de " . $site->name
    ]);
  }

  public function update(Request $request, $id) {
    $site = Site::find($id);
    $site->update($request->all());
    return response($site, 200);
  }

  public function store(Request $request) {

    if ($request->hasFile("image")) {
      $path = Storage::disk('uploads')->putFile("sites", $request->file("image"));
      $request->merge(["avatar" => "/" . $path]);
    }
    if ($request->has("id")) Site::find($request->id)->update($request->all());
    else Site::create($request->all());

    return redirect("/admin/sites");
  }

  public function destroy($id) {
    Site::destroy($id);

    return redirect("/admin/sites");
  }
}
