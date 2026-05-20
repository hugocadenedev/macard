@extends('layouts.app')

@section('app')
  <link href="{{ asset('offer_css/'.Request::getHost().'.offer.css') }}" rel="stylesheet">
  {!! file_get_contents("../public/offer_html/".Request::getHost().".offer.html") !!}
@endsection