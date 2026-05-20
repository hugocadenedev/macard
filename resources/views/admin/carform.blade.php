@extends('layouts.adminLayout')

@section('content')
<div class="container">
  <div>
    <div class="card mt-4">
      <div class="card-header">
        {{$title}}
      </div>
      <div class="card-body">
        <x-carForm :car="$car" ></x-carForm>
      </div>
    </div>
  </div>
</div>
@endsection