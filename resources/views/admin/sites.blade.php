@extends('layouts.adminLayout')

@section('content')

<div class="container">
<div class="mt-5">
  <div class="row-between mb-4">
    <h2>Sites</h2>
    <div>
      <a href="/admin/sites/create" class="btn btn-primary">Ajouter</a>
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-body pt-0">
      <div class="collapse show" id="collapseExample">
        <table class="table">
          <thead>
            <th>Nom</th>
            <th>Nom de l'adresse</th>
            <th>Adresse</th>
            <th></th>
            <th></th>
            <th></th>
          </thead>
          <tbody>
            @foreach ($sites as $site)
              <tr>
                <td>
                  {{$site->name}}
                </td>
                <td>
                  {{$site->address_name}}
                </td>
                <td>
                  <div>
                    <div>
                      {{$site->address}}
                    </div>
                    <div>
                      {{$site->cp}} {{$site->city}}
                    </div>
                  </div>
                </td>
                <td>
                  {{$site->active ? "Actif" : "Inactif"}}
                </td>
                <td style="width: 150px;">
                  <a class="btn btn-link" href="/admin/sites/{{$site->id}}/edit">Modifier</a>
                </td>
                <td>
                  <form method="post" action="/admin/sites/{{$site->id}}">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Etes vous sur de vouloir supprimer ce site ? \nLes créneaux et réservations associés seront supprimé également.')" class="btn btn-link text-danger" type="submit">
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