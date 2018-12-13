@extends('app')

@section('breadcrumb')
    ACESSAR SISTEMA
@endsection

@section('content')


    <form id="login-form" class="form" action="{{ action('Auth\AuthController@postLogin') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <fieldset>
            <div class="form-group">
                <h2>CPF</h2>
                <input class="form-control" name="username" value="{{ old('cpf') }}" autofocus />
            </div>
            <div class="form-group">
                <h2>Senha</h2>
                <input class="form-control" name="password" type="password" value="">
            </div>
            <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">ACESSAR</button>
            <br />

            <div style="margin-top: 10px; margin-left: -20px;">
                <a href="{{ action('ConsultorExternoController@getEsqueci') }}" class="space">Esqueceu sua senha?</a><br /><br />
                <a href="{{ action('ConsultorExternoController@getCriarSenha') }}" class="space">Primeiro acesso? Clique aqui</a><br /><br /><br /><br />
                <a href="/auth/login" class="space"><- Voltar</a>
            </div>

        </fieldset>
    </form>

@endsection

