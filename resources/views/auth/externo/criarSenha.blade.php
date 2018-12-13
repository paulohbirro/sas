@extends('app')

@section('breadcrumb')
    ACESSAR SISTEMA
@endsection

@section('content')


    <form id="login-form" class="form" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>

            Seu primeiro acesso? Informe os campos para criar uma senha:<br /><br />

            <div class="form-group">
                <h2>CPF</h2>
                <input class="form-control" name="cpf" value="{{ old('cpf') }}" autofocus />
            </div>
            <div class="form-group">
                <h2>Email</h2>
                <input class="form-control" name="email" type="text" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <h2>Senha</h2>
                <input class="form-control" name="senha" type="password" value="">
            </div>
            <div class="form-group">
                <h2>Confirme a senha</h2>
                <input class="form-control" name="confirmacaoSenha" type="password" value="">
            </div>
            <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">CRIAR</button>

            <div style="margin-top: 10px;">
                <a href="{{ action('ConsultorExternoController@getLogin') }}"><- Voltar</a>
            </div>

        </fieldset>
    </form>


@endsection

