@extends('app')

@section('breadcrumb')
    Ficha
@endsection

@section('content')


    <hgroup style="width: 100%; margin-bottom: 20px;">
        <h1 class="turma">Turma: {{ $turma->codigo }} - {{ $turma->solucao->nome }}</h1>
        <h2><a class="close" href="/fichas/envio" title="Fechar"></a></h2>
    </hgroup>

    <div class="tab-content" style="border-top-left-radius: 4px;margin-top: 0;">

        <div id="form-dialog">
            <div class="col-left">
                <form class="" method="POST" action="{{ route('fichas.envio.enviar') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="turma_id" value="{{ $turma->id }}">

                    <div class="form-group">

                        <p><input class="checkbox-inline" type="radio" name="opcao" value="ENVIADO" /> CONFIRMAR ENVIO DAS FICHAS DE AVALIAÇÃO POR MALOTE</p>
                        <p><input class="checkbox-inline" type="radio" name="opcao" value="SUSPENSO" /> SUSPENDER ENVIO DAS FICHAS DE AVALIAÇÃO</p>

                    </div>
                    <div class="form-group">
                        <textarea class="pad" style="margin-left: 26px;" name="descricao" placeholder="Descrição"></textarea>
                    </div>
                    <button type="submit" class="btn-form">Enviar</button>
                </form>
            </div>

            <div class="col-right space">

                <div class="form-group">
                    <h3>Consultor(a)</h3>
                    <p>{{ $turma->consultor->nome }}</p>
                </div>
                <div class="form-group">
                    <h3>Participantes</h3>
                    <p>{{ $turma->participantes }}</p>
                </div>
                <div class="form-group">
                    <h3>Data</h3>
                    <p>{{ $turma->inicio->format('d/m/Y') }}</p>
                </div>
                <div class="form-group">
                    <h3>Local</h3>
                    <p>{{ $turma->local_execucao }}</p>
                </div>
                <div class="form-group">
                    <h3>Município</h3>
                    <p>{{ $turma->municipio->nome }}</p>
                </div>

            </div>

            <div style="clear: both;"></div>
        </div>

    </div>

@endsection