@extends('app')

@section('breadcrumb')
    Fichas
@endsection

@section('content')

    @if(isset($mensagem))
        <div class="div message-box alert">
            <li>{{ $mensagem }}</li>
        </div>
    @endif

    <nav class="tab-nav">

        <ul>
            <li class="imprimir-fichas">
                <a href="/fichas">
                    Imprimir
                </a>
            </li>

            <li class="solucoes">
                <a href="/fichas/impressas">
                    Impressas
                </a>
            </li>

            <li class="enviar-fichas select">
                <a href="#">
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
                        <th><a href="#"></a></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turmas as $turma)

                        <?php
                        $status = $turma->status;
                        $img = "scan-gray.png";
                        $bkg = " gray";

                        $diff = \Carbon\Carbon::now()->diffInDays($turma->inicio, false);

                        if ($status == "IMPRESSO")
                        {
                            if ($diff > 14) {
                                $img = "malote-blue.png";
                                $bkg = " blue";
                            } else if ($diff > 7) {
                                $img = "malote-yellow.png";
                                $bkg = " yellow";
                            } else {
                                $img = "malote-red.png";
                                $bkg = " red";
                            }
                        }
                        ?>

                        <tr class="{{ (in_array($status, ['ENVIADO', 'SUSPENSO'])?'enviar-fichas':'digitalizar-fichas').$bkg  }}">
                            <td>
                                @if($status == 'IMPRESSO')
                                    <a href="{{ route('fichas.envio.formulario', ['codigoTurma' => $turma->codigo]) }}">{{ Utils::highlighting($turma->codigo, Input::get('like')) }}</a>
                                @else
                                    {{ Utils::highlighting($turma->codigo, Input::get('like')) }}
                                @endif
                            </td>
                            <td>{{ $turma->inicio->format('d/m/Y') }}</td>
                            <td>{{ $turma->solucao->nome }}</td>
                            <td>{{ $turma->municipio->nome }}</td>

                            <td style="text-align: center;">
                                @if($status == 'ENVIADO')
                                    <img title="Aguardando digitalização" class="imprimir-fichas" src="/sas/img/<?php echo $img ?>" style="position:relative; top:5px;" />
                                @elseif($status == 'SUSPENSO')
                                    Suspensa
                                @else
                                    <img title="{{ $status == "ENVIADO" ? 'Aguardando digitalização' : '' }}" class="imprimir-fichas"  src="/sas/img/{{ $img }}" style="position:relative; top:5px;" />
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma turma com fichas impressas para ser listada</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <?php echo $turmas->appends(Input::query())->render() ?>

            </div>

            <div class="col-right space">

                <form id="formFilter" method="get">


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