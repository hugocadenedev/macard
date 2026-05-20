@extends('layouts.adminLayout')

@section('content')
<div class="container">
  <div>
    <form action="/admin/sites" method="post" enctype="multipart/form-data">
      <div class="card mt-4">
        <div class="card-header">
          <div class="row-between">
            {{$title}}
              @csrf
              @if ($site->id)
                @if ($site->active)
                  <button name="active" value="0" class="btn btn-warning">Désactiver</button>
                @else
                  <button name="active" value="1" class="btn btn-success">Activer</button>
                @endif
              @endif
          </div>
        </div>
        <div class="card-body">
          @csrf

          @if ($site->id)
            <input type="hidden" name="id" value="{{$site->id}}">
          @endif
          <div class="form-group">
            <label for="model">Nom du site</label>
            <input class="form-control" name="name" type="text" value="{{$site->name}}" required>
          </div>
          <div class="form-group">
            <label for="title">Nom de l'adresse</label>
            <input class="form-control" name="address_name" type="text" value="{{$site->address_name}}">
          </div>
          <div class="form-group">
            <label for="title">Adresse</label>
            <input class="form-control" name="address" type="text" value="{{$site->address}}" required>
          </div>
          <div class="form-group">
            <label for="title">Code postal</label>
            <input class="form-control" name="cp" type="text" value="{{$site->cp}}" required>
          </div>
          <div class="form-group">
            <label for="title">Ville</label>
            <input class="form-control" name="city" type="text" value="{{$site->city}}" required>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection