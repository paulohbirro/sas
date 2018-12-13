@extends('app')

@section('breadcrumb')
    ACESSAR SISTEMA
@endsection

@section('content')


    <form id="login-form" class="form" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="chave" value="{{ $chave }}">
        <fieldset>

            Informe os campos para criar uma nova senha:<br /><br />

            <div class="form-group">
                <h2>Senha</h2>
                <input class="form-control" name="senha" type="password" value="">
            </div>
            <div class="form-group">
                <h2>Confirme a senha</h2>
                <input class="form-control" name="confirmacaoSenha" type="password" value="">
            </div>

            <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">Salvar</button>


        </fieldset>
    </form>


@endsection

