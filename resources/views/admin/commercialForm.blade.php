@extends('layouts.adminLayout')

@section('content')
<div class="container">
  <div>
    <div class="card mt-4">
      <div class="card-header">
        {{$title}}
      </div>
      <div class="card-body">
        <form action="/admin/commercials" method="post" enctype="multipart/form-data">
          @csrf

          @if ($commercial->id)
            <input type="hidden" name="id" value="{{$commercial->id}}">
          @endif
          <div class="form-group">
            <label for="model">Prénom</label>
            <input class="form-control" name="firstname" type="text" value="{{$commercial->model}}" required>
          </div>
          <div class="form-group">
            <label for="title">Nom</label>
            <input class="form-control" name="lastname" type="text" value="{{$commercial->title}}" required>
          </div>
          <div class="form-group">
            <label for="image">Avatar</label>
            <input class="form-control" name="image" type="file"/>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection