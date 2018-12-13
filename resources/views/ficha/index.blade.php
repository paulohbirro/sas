@extends('app')

@section('breadcrumb')
    Fichas
@endsection

@section('content')

    <nav class="tab-nav">

        <ul>
            <li class="imprimir-fichas select">
                <a href="#">
                    Imprimir
                </a>
            </li>

            @if(!Sebrae::is('Expedição'))
                <li class="solucoes">
                    <a href="/fichas/impressas">
                        Impressas
                    </a>
                </li>

                <li class="enviar-fichas">
                    <a href="/fichas/envio">
                        Enviar
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="tab-content">
        <div id="fichas" class="tab-select" style="padding: 15px; min-height: 800px !important;">


            @if(isset($mensagem))
                <div style="padding: 20px; margin-bottom: 10px; background-color: #fff99d;">
                    {{ $mensagem }}
                </div>
            @endif
            <br />
            <br />

            <h2>Informe o código da turma:</h2>

            <form>
                <input name="codigo" type="text" value="{{ Input::get('codigo') }}" />

                <br /><br />

                <button type="submit" class="btn btn-primary select">Pesquisar</button>
            </form>

            @if(isset($turma))
                <br /><br /><hr style="height: 1px !important; background-color: #000 !important;;" /><br /><br />

                <h1>Turma {{ $turma->attributes()->id }} encontrada!</h1>

                <form target="_blank" action="{{ route('fichas.imprimir') }}">
                    <br />
                    <br />
                    <input name="codigo" type="hidden" value="{{ Input::get('codigo') }}" />
                    <button type="submit" class="btn btn-primary select">Imprimir ficha</button>

                </form>

                <br />
                <br />
                <br />
                <div class="col-right">
                    <div class="form-group">
                        <h3>Solução</h3>
                        <p>{{ $turma->solucao->nome }}</p>
                    </div>
                    <div class="form-group">
                        <h3>Consultor</h3>
                        <p>{{ $turma->consultor->nome }}</p>
                    </div>
                    <div class="form-group">
                        <h3>Participantes</h3>
                        <p>{{ $turma->{"qtd-particip"} }}</p>
                    </div>
                    <div class="form-group">
                        <h3>Data</h3>
                        <p>{{ $turma->{"data-ini"} }}</p>
                    </div>
                    <div class="form-group">
                        <h3>Local</h3>
                        <p>{{ $turma->{"local-realiz"} }}</p>
                    </div>
                    <div class="form-group">
                        <h3>Município</h3>
                        <p>{{ $turma->municipio->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Microregião</h3>
                        <p>{{ $turma->municipio->microregiao->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Regional</h3>
                        <p>{{ $turma->municipio->microregiao->regiao->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Técnico/Assistente</h3>
                        <p>{{ $turma->municipio->microregiao->tecnico->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Gestor da solução</h3>
                        <p>{{ $turma->solucao->gestor->nome }}</p>
                    </div>

                </div>

            @endif




        </div>
    </div>
@endsection