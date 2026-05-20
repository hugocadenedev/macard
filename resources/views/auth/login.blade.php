@extends('layouts.app')

@section('app')
  <div class="d-flex bg-login" style="min-height: 100vh">
    <div class="card m-auto">
      <div class="card-header text-center">
        <h3>Connexion</h3>
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="form-group">
            <label for="email" class="col-form-label text-md-right">Adresse Email</label>

              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          <div class="form-group">
            <label for="password" class="col-form-label text-md-right">Mot de passe</label>

              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>

          {{-- <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
                </label>
              </div>
          </div> --}}

          <div class="form-group mb-0 pt-3 text-center">
              <button type="submit" class="btn btn-primary">
                Se connecter
              </button>

              @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('Forgot Your Password?') }}
                </a>
              @endif
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
