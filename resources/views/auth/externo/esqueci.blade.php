@extends('app')

@section('breadcrumb')
    ACESSAR SISTEMA
@endsection

@section('content')


    <form id="login-form" action="" class="form" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>

            Esqueceu sua senha? Informe os campos abaixo para recuperá-la:<br /><br />

            <div class="form-group">
                <h2>CPF</h2>
                <input class="form-control" name="cpf" value="{{ old('cpf') }}" autofocus />
            </div>
            <div class="form-group">
                <h2>Email</h2>
                <input class="form-control" name="email" type="text" value="{{ old('email') }}">
            </div>
            <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">Enviar</button>

            <div style="margin-top: 10px;">
                <a href="{{ action('ConsultorExternoController@getLogin') }}"><- Voltar</a>
            </div>

        </fieldset>
    </form>


@endsection

