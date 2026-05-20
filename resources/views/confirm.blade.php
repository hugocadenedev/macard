@extends('layouts.app')

@section('app')
  <div class="home-body" style="background-color: {{$page->background_color ?? 'white'}}">
    <div style="background-image: url({{ $page->banner_url }})" class="banner">
    </div>
    <div class="bg-body">
      <div class="header text-center">
        <div class="container d-flex h-100">
          <div class="m-auto" style="color: {{$page->text_color ?? 'white'}}">
            <h1 class="title mb-3">
              Votre réservation a été enregistrée
            </h1>
            <h1 class="text-center mb-3">
              <i class="fas fa-check-circle text-success"></i>
            </h1>
            <h5 class="presentation w-75 m-auto pb-5">
              Vous allez recevoir un email de confirmation sur votre adresse email {{$booking->email}}.
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection