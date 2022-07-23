@extends('layouts.guest')


@if (session('status'))
    @section('content')
        <div>
            <h1 class="mt-3 mb-3">
                Restablecer contraseña
            </h1>
        </div>
        <p class="text-success">
            {{ session('status') }}
        </p>
        <a href="/">Iniciar sesión con la nueva contraseña.</a>
    @endsection
@else
    @section('content')
        <div>
            <h1 class="mt-3 mb-3">
                Restablecer contraseña
            </h1>
            <div>
                @if ($errors->any())
                    <ul class="text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="row form-group">
                    <div class="col-12 col-lg-4">
                        <label for="email">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input id="email" type="email" name="email" class="form-control"
                        value="{{ old('email', $request->email) }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="row form-group">
                    <div class="col-12 col-lg-4">
                        <label for="password">
                            Nueva contraseña <span class="text-danger">*</span>
                        </label>
                        <input id="password" type="password" name="password"
                        class="form-control" required autofocus>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="row form-group">
                    <div class="col-12 col-lg-4">
                        <label for="password_confirmation">
                            Confirmar contraseña <span class="text-danger">*</span>
                        </label>
                        <input id="password_confirmation" type="password"
                        name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div>
                    <button class="btn btn-primary mr-3" type="submit">
                        <i class="fas fa-save"></i> Restablecer contraseña
                    </button>
                </div>
            </form>
        </div>
    @endsection
@endif
