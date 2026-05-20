@extends('layouts.app')

@section('app')
  <nav class="navbar navbar-expand-md">
    <div class="container-fluid">
      {{-- <a class="navbar-brand" href="{{ url('/') }}">
        ADMIN
      </a> --}}
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item mr-3">
            <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">Réservations</a>
          </li>
          <li class="nav-item mr-3">
            <a href="/admin/cars" class="nav-link {{ request()->is('admin/cars') ? 'active' : '' }}">Voitures</a>
          </li>
          <li class="nav-item mr-3">
            <a href="/admin/sites" class="nav-link {{ request()->is('admin/sites') ? 'active' : '' }}">Sites</a>
          </li>
          <li class="nav-item mr-3">
            <a href="/admin/commercials" class="nav-link {{ request()->is('admin/commercials') ? 'active' : '' }}">Commerciaux</a>
          </li>
          <li class="nav-item mr-3">
            <a href="/admin/page" class="nav-link {{ request()->is('admin/page') ? 'active' : '' }}">Page</a>
          </li>
          <li class="nav-item mr-3">
            <a href="/admin/builder" class="nav-link {{ request()->is('admin/builder') ? 'active' : '' }}">Builder</a>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li>
            <a class="nav-link" target="_blank" href="/offer">
              Voir la page offre
            </a>
          </li>
          <li>
            <a class="nav-link" target="_blank" href="/">
              Voir le site
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Se déconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  @yield('content')
@endsection