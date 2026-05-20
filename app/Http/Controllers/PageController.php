<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

  public function index() {
    $page = Page::first();
    return view('admin.page', [
      "page" => $page,
    ]);
  }

  public function store(Request $request) {

    if ($request->hasFile("banner")) {
      $path = Storage::disk('uploads')->putFile("page", $request->file("banner"));
      $request->merge(["banner_url" => "/" . $path]);
    }
    Page::first()->update($request->all());

    return redirect("/admin/page");
  }
}
