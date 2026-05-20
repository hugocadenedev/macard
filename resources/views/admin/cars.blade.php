@extends('layouts.adminLayout')

@section('content')

<div class="container">
<div class="mt-5">
  <div class="row-between mb-4">
    <h2>Voiture disponible</h2>
    <div>
      <a href="/admin/cars/create" class="btn btn-primary">Ajouter</a>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-body pt-0">
      <div class="collapse show" id="collapseExample">
        <table class="table">
          <thead>
            <th>Description</th>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            @foreach ($cars as $car)
              <tr>
                <td>
                  <div class="row-flex">
                    <div class="w-25">
                      <img class="img-fluid" src="{{$car->image_url}}" alt="">
                    </div>
                    <div class="w-100">
                      <div class="mb-2">
                        <b>{{$car->model}}</b>
                      </div>
                      <div>
                        {{$car->description}}
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <a class="btn btn-link" href="/admin/cars/{{$car->id}}">Gérer</a>
                </td>
                <td>
                  <form method="post" action="/admin/cars/{{$car->id}}">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Etes vous sur de vouloir supprimer ce véhicule ?')" class="btn btn-link text-danger" type="submit">
                      <i class="fas fa-times"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
@endsection