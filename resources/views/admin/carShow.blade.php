@extends('layouts.adminLayout')

@section('content')
<script>
  let sites = {!! json_encode($sites) !!}
  let car = {!! json_encode($car) !!}
  let slots = {!! json_encode($slots) !!}
</script>
<div class="container-fluid">
  <div class="mt-5">
    <div class="card mt-4">
      <div class="card-header">
        <div class="row-between">
          <h2>{{$car->model}}</h2>
        </div>
      </div>
      <div class="card-body">
        <x-carForm :car="$car" ></x-carForm>
      </div>
    </div>
    <div class="card my-4">
      <div class="card-body">
        <div id="slot-form" ></div>
      </div>
    </div>
  </div>
</div>
@endsection