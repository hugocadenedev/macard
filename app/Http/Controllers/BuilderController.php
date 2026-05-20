<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuilderController extends Controller
{
  public function index(Request $request)
  {
    return view('admin.builder');
  }


  public function html(Request $request) {
    $html = file_get_contents("../public/offer_html/".$request->getHost().".offer.html");
    $css = file_get_contents("../public/offer_css/".$request->getHost().".offer.css");
    return response(["html" => $html, "css" => $css], 200);
  }

  public function store(Request $request) {
    $filename = storage_path("app/offer_html/".$request->getHost().".offer.html");

    if (file_exists($filename . ".old")) copy($filename . ".old", $filename . ".old2");
    copy($filename, $filename . ".old");
    $file = fopen($filename, 'w');
    fwrite($file, $request->input("data"));
    fclose($file);

    $css_path = storage_path("app/offer_css/".$request->getHost().".offer.css");

    if (file_exists($css_path . ".old")) copy($css_path . ".old", $css_path . ".old2");
    copy($css_path, $css_path . ".old");
    $file = fopen($css_path, 'w');
    fwrite($file, $request->input("css"));
    fclose($file);

    return response("ok", 200);
  }
}
