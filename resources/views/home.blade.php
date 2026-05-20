@extends('layouts.app')

<script>
  let cars = {!! json_encode($cars) !!}
  let sites = {!! json_encode($sites) !!}
  let page = {!! json_encode($page) !!}
  let token = "{{csrf_token()}}"
</script>

@section('app')
  <div class="home-body" style="font-family: '{{$page->font}}', sans-serif">
    <div style="background-image: url({{ $page->banner_url }})" class="banner">
    </div>
    @if ($page->is_active)
      <div class="bg-body" style="background-color: {{$page->background_color ?? 'white'}}">
        <div class="header text-center">
          <div class="container d-flex">
            <div class="m-auto" style="color: {{$page->text_color ?? 'white'}}">
              <h1 class="title mb-5">
                {{$page->title}}
              </h1>
              <h5 class="presentation m-auto pb-5">
                {{$page->description}}
              </h5>
            </div>
          </div>
        </div>
        <div id="Booker"></div>
      </div>
      <div class="footer text-white">
        <div class="container">
          <div class="row-between h-100">
            <span>© 2021 Groupe MSO</span>
            <span>Propulsé par <b>Urioz</b></span>
          </div>
        </div>
      </div>
    @else
      <h3 style="color: {{$page->text_color}}" class="text-center mt-5 ">AUCUN EVENEMENT DISPONIBLE</h3>
    @endif
  </div>
@endsection
