@extends('layouts.adminLayout')

@section('content')

<div class="container">
<div class="mt-5">
  <div class="row-between mb-4">
    <h2>Commerciaux</h2>
    <div>
      <a href="/admin/commercials/create" class="btn btn-primary">Ajouter</a>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-body pt-0">
      <div class="collapse show" id="collapseExample">
        <table class="table">
          <thead>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            @foreach ($commercials as $commercial)
              <tr>
                <td>
                  <img style="max-height: 100px" class="img-fluid" src="{{$commercial->avatar}}" alt="">
                </td>
                <td>
                  <div>
                    {{$commercial->getTitle()}}
                  </div>
                </td>
                <td>
                  <a class="btn btn-link" href="/admin/commercials/{{$commercial->id}}/edit">Modifier</a>
                </td>
                <td>
                  <form method="post" action="/admin/commercials/{{$commercial->id}}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-link text-danger" type="submit">Supprimer</button>
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