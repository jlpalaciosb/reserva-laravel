@extends('layouts.guest')

@section('content')
    <div>
        <h1 class="mt-3 mb-3">
            Restablecer contraseña
        </h1>
        <p>¿Olvidaste tu contraseña? No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace de restablecimiento de contraseña que le permitirá elegir una nueva!</p>
        <div>
            @if (session('status'))
                <p class="text-success">
                    {{ session('status') }}
                </p>
            @endif
            @if ($errors->any())
                <ul class="text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="row form-group">
                <div class="col-12 col-lg-4">
                    <label for="email">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input id="email" type="email" name="email" class="form-control"
                    value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div>
                <button class="btn btn-primary mr-3" type="submit">
                    <i class="fas fa-envelope"></i> Enviar
                </button>
            </div>
        </form>
    </div>
@endsection
