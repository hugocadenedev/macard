@extends('layouts.adminLayout')

@section('content')
<div class="container">
  <div class="mt-5">
    <div class="row-between mb-4">
      <h2>Personnalisation de la page</h2>
      <form action="/admin/page" method="post">
        @csrf
        @if ($page->is_active)
          <button name="is_active" value="0" class="btn btn-warning">Mode maintenance</button>
        @else
          <button name="is_active" value="1" class="btn btn-success">Activer le site</button>
        @endif
      </form>
    </div>
    @if ($page->is_active)
      <div class="card mt-4">
        <div class="card-body">
          <form action="/admin/page" method="post" enctype="multipart/form-data">
            @csrf
            <img src="{{$page->banner_url}}" class="img-fluid" alt="">
            <div class="form-group">
              <label for="banner">Bannière</label>
              <input class="form-control" name="banner" type="file"/>
            </div>
            <div class="form-group">
              <label for="title">Titre</label>
              <textarea class="form-control" name="title" type="text">{{$page->title}}</textarea>
            </div>
            <div class="form-group">
              <label for="description">Texte de présentation</label>
              <textarea rows="6" class="form-control" name="description" >{{$page->description}}</textarea>
            </div>
            <div class="form-group">
              <label for="banner">Couleur de fond</label>
              <input class="form-control" name="background_color" type="color" value="{{$page->background_color}}"/>
            </div>
            <div class="form-group">
              <label for="banner">Couleur du texte</label>
              <input class="form-control" name="text_color" type="color" value="{{$page->text_color}}"/>
            </div>
            <div class="form-group">
              <label for="banner">Typographie</label>
              <select class="form-control" name="font">
                <option selected="{{$page->font == 'CITROEN'}}" value="CITROEN">CITROEN</option>
                <option selected="{{$page->font == 'DS'}}" value="DS">DS</option>
                <option selected="{{$page->font == 'FORD'}}" value="FORD">FORD</option>
                <option selected="{{$page->font == 'KIA'}}" value="KIA">KIA</option>
                <option selected="{{$page->font == 'MAZDA'}}" value="MAZDA">MAZDA</option>
                <option selected="{{$page->font == 'PEUGEOT'}}" value="PEUGEOT">PEUGEOT</option>
                <option selected="{{$page->font == 'OPEL'}}" value="OPEL">OPEL</option>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    @else
      <div class="text-center">Site désactivé</div>
    @endif
  </div>
</div>
@endsection