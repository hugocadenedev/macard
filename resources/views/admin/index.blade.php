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
              <td>
                <form style="width: 40px; text-align: center;" method="post" action="/api/bookings/{{$booking->id}}">
                  @csrf
                  @method('DELETE')
                  <button onclick="return confirm('Etes vous sur de vouloir supprimer cette réservation ?')" type="submit" class="text-danger btn btn-link px-0">
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
@endsection
