@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid">
<div class="mt-5">
  <div class="align-items-end d-flex justify-content-between">
    <div class="row-flex">
      <h2 class="mb-0">Réservations</h2>
      <form action="" method="get" id="search-form">
        <div class="mx-3 row-flex position-relative">
          <input style="border-radius: 0.25rem 0 0 0.25rem;" class="form-control" autofocus type="text" name="search" required>
          <div>
            <button style="border-radius: 0 0.25rem 0.25rem 0;" class="btn btn-primary px-2">
              <i class="fas fa-search"></i>
            </button>
          </div>
          @if (request()->has('search') && request()->input('search') != "" )
            <i onclick="document.getElementById('search-form').submit()" class="clear-search far fa-times"></i>
          @endif
        </div>
      </form>
    </div>
    {{ $bookings->links() }}
  </div>
</div>
  <div class="card mt-4">
    <div class="card-body pt-0">
      <table class="table">
        <thead>
          <th>Créé le</th>
          <th>Type</th>
          <th>Site</th>
          <th>Prospect</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Créneau</th>
          <th>Voiture</th>
          <th>Commercial</th>
          <th></th>
        </thead>
        <thead>
          <th>
            <form action="/admin" method="get" class="mr-3">
              <input onChange="this.form.submit()" type="date" name="slot_start" class="form-control" value="{{request()->input('slot_start')}}">
            </form>
          </th>
          <th></th>
          <th>
            <form action="/admin" method="get">
              <select onChange="this.form.submit()" name="site_id" class="form-control">
                <option value="">Tous</option>
                @foreach ($sites as $site)
                  <option
                    @if (request()->input('site_id') == strval($site->id))
                      selected
                    @endif
                    value="{{$site->id}}"
                  >{{$site->name}}</option>
                @endforeach
              </select>
            </form>
          </th>
          <th></th>
          <th></th>
          <th></th>
          <th>
            <form action="/admin" method="get" class="mr-3">
              <input onChange="this.form.submit()" type="date" name="slot_start" class="form-control" value="{{request()->input('slot_start')}}">
            </form>
          </th>
          <th></th>
          <th>
            <form action="/admin" method="get">
              <select onChange="this.form.submit()" name="commercial_id" class="form-control">
                <option value="">Tous</option>
                @foreach ($commercials as $c)
                  <option
                    @if (request()->input('commercial_id') == strval($c->id))
                      selected
                    @endif
                    value="{{$c->id}}"
                  >{{$c->getTitle()}}</option>
                @endforeach
              </select>
            </form>
          </th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($bookings as $booking)
            <tr>
              <td>{{$booking->created_at->format('d M y')}}</td>
              <td>{{$booking->bookingType ? $booking->bookingType->label : ""}}</td>
              <td>{{($booking->slot && $booking->slot->site) ? $booking->slot->site->name : ""}}</td>
              <td>{{$booking->firstname}} {{$booking->lastname}}</td>
              <td>{{$booking->email}}</td>
              <td>{{$booking->phone}}</td>
              <td>{{$booking->getSlot()}}</td>
              <td>{{$booking->slot && $booking->slot->car && $booking->slot->car->model ? $booking->slot->car->model : ""}}</td>
              <td>
                <select data-booking_id="{{$booking->id}}" class="form-control commercial-select" type="text">
                  <option value="">Aucun</option>
                  @foreach ($commercials as $c)
                    <option @if ($booking->commercial_id === $c->id)
                      selected
                    @endif value="{{$c->id}}">{{$c->getTitle()}}</option>
                  @endforeach
                </select>
              </td>
              <td style="width: 40px; text-align: center;">
                <button
                  type="button"
                  class="text-danger btn btn-link px-0"
                  data-toggle="modal"
                  data-target="#deleteModal"
                  data-booking-id="{{$booking->id}}"
                  data-booking-name="{{$booking->firstname}} {{$booking->lastname}}"
                >
                  &times;
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Modal double confirmation suppression réservation --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Supprimer la réservation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      {{-- Étape 1 --}}
      <div id="delete-step-1">
        <div class="modal-body">
          <p>Êtes-vous sûr de vouloir supprimer la réservation de <strong id="delete-booking-name"></strong> ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-warning" id="btn-step-2">Continuer</button>
        </div>
      </div>

      {{-- Étape 2 --}}
      <div id="delete-step-2" style="display:none;">
        <div class="modal-body">
          <div class="alert alert-danger mb-0">
            <strong>Attention !</strong> Cette action est irréversible. La réservation sera définitivement supprimée.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btn-back-step-1">Retour</button>
          <form id="delete-booking-form" method="post" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#deleteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var bookingId = button.data('booking-id');
      var bookingName = button.data('booking-name');

      // Réinitialise à l'étape 1
      $('#delete-step-1').show();
      $('#delete-step-2').hide();

      // Remplit les données
      $('#delete-booking-name').text(bookingName);
      $('#delete-booking-form').attr('action', '/api/bookings/' + bookingId);
    });

    $('#btn-step-2').on('click', function () {
      $('#delete-step-1').hide();
      $('#delete-step-2').show();
    });

    $('#btn-back-step-1').on('click', function () {
      $('#delete-step-2').hide();
      $('#delete-step-1').show();
    });
  });
</script>

@endsection
