@extends('app')

@section('breadcrumb')
    ACESSAR SISTEMA
@endsection

@section('content')

        <form id="login-form" class="form" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <fieldset>
                <div class="form-group">
                    <h2>Usuário</h2>
                    <input class="form-control" name="username" value="{{ old('username') }}" autofocus />
                </div>
                <div class="form-group">
                    <h2>Senha</h2>
                    <input class="form-control" name="password" type="password" value="">
                </div>
                <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">ACESSAR</button>
                <a href="{{ action('ConsultorExternoController@getLogin') }}" class="space">Consultor externo?</a>
            </fieldset>
        </form>
@endsection

