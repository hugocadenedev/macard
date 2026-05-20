
<form action="/admin/cars" method="post" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col">
      <img class="img-fluid mb-4" src="{{$car->image_url ?? 'https://user-images.githubusercontent.com/194400/49531010-48dad180-f8b1-11e8-8d89-1e61320e1d82.png'}}" alt="">
      <input class="form-control" name="image" type="file"/>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="model">Modèle</label>
        <input class="form-control" name="model" type="text" value="{{$car->model}}">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" rows="6" name="description" >{{$car->description}}</textarea>
      </div>
      @if ($car->id)
        <input type="hidden" name="id" value="{{$car->id}}">
      @endif
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Enregistrer</button>
      </div>
    </div>
  </div>
</form>