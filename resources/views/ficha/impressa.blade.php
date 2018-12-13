@extends('app')

@section('breadcrumb')
    Fichas
@endsection

@section('content')

    <nav class="tab-nav">

        <ul>
            <li class="imprimir-fichas">
                <a href="/fichas">
                    Imprimir
                </a>
            </li>

            <li class="solucoes select">
                <a href="#">
                    Impressas
                </a>
            </li>

            <li class="enviar-fichas">
                <a href="/fichas/envio">
                    Enviar
                </a>
            </li>
        </ul>
    </nav>

    <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">

            <div class="col-left">
                <table class="table table-hover">
                    <thead>
                    <tr class="orderBy">
                        <th><a href="{{Order::url('codigo')}}">Turma</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('inicio')}}">Data</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('solucao.nome')}}">Solução</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('municipio.nome')}}">Municipio</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('vagas')}}">Vagas</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('participantes')}}">Participantes</a><i class="caret"></i></th>
                        <th><a href="#"></a></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turmas as $turma)
                        <tr>
                            <td>{{ Utils::highlighting($turma->codigo, Input::get('like')) }}</td>
                            <td>{{ $turma->inicio->format('d/m/Y') }}</td>
                            <td>{{ $turma->solucao->nome }}</td>
                            <td>{{ $turma->municipio->nome }}</td>
                            <td>{{ $turma->vagas }}</td>
                            <td>{{ $turma->participantes }}</td>
                            <td>
                                <a href="{{ route('fichas.imprimir', ['codigo' => $turma->codigo]) }}" onclick="" target="_blank" title="Imprimir fichas de avaliação">
                                    <img class="imprimir-fichas" src="/sas/img/print-gray.png" style="position:relative; top:5px;" />
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Nenhuma turma com fichas impressas para ser listada</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <?php echo $turmas->appends(Input::query())->render() ?>

            </div>

            <div class="col-right space">

                <form id="formFilter" method="get"">


                    <div class="form-group">
                        <h2>Palavra-chave:</h2>
                        <input type="text" class="form-control input-sm textbox" name="like" value="{{ Input::get('like') }}" />
                    </div>

                    @if(!Sebrae::in(['Gerente de Regional', 'Técnico de Microregião']) )
                        @include('filtros.regiao')
                    @endif

                    @if(!Sebrae::is('Técnico de Microregião') )
                        @include('filtros.microRegiao')
                    @endif

                    @include('filtros.municipio')

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary select">Filtrar</button>
                    </div>

                </form>

            </div>

            <div style="clear: both; "></div>

        </div>
    </div>
@endsection