@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('avaliacao.abas')

    <div class="tab-content">

        <div id="consultor" class="tab-select">

            <div class="col-single">
                <div class="box">
                    <div class="box-content">
                        <h2>Consultor </h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do consultor para esta turma">Turma</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do consultor para esta solução">Consultor</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-consultor"></div>
                            </div>
                            <div class="value">{{ number_format($turma->consultor->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores do Sebrae MG para está solução">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($turma->solucao->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelicida para os consultores">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor_meta, 1, '.', '') }}&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ ($turma->avaliacao->nota_consultor*100/$turma->avaliacao->nota_consultor_meta )-100 }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Avaliações</h2>
                        <h3>Participantes/Avaliações</h3>
                        <p>{{ $turma->participantes }}/{{ $turma->avaliacao->quantidade }}</p>
                        <h3>Tópicos avaliados:</h3>
                        <div class="basic-bar-row">
                            <div class="title">Domínio</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor_dominio, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Clareza</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor_clareza, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Recursos</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor_recursos, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Exemplos</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_consultor_exemplos, 1, '.', '') }}&nbsp;</div>
                        </div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2 class="titulo-comentarios">Comentários transcritos </h2>

                        <?php
                        $comentarios = $turma->avaliacao->comentarios->filter(function($item)
                        {
                            return strlen($item->comentario_transcrito) > 0 && $item->comentario_transcrito != '0' && strpos($item->comentario_tags, 'CONSULTOR') !== false;
                        });
                        ?>

                        @foreach($comentarios as $comentario)
                            <p class="comentario-transcrito">{{$comentario->comentario_transcrito}}</p>
                        @endforeach

                        <a href="/avaliacoes/ver/{{ $turma->codigo }}/comentarios">+ Outros comentários</a>
                    </div>
                </div>

            </div>

            <div style="clear: both;"></div>

        </div>

    </div>


@endsection