@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('avaliacao.abas')

    <div class="tab-content">

        <div id="nps" class="tab-select">
            <div class="col-single">

                <div class="box">
                    <div class="box-content">
                        <h2>Nível de Satisfação </h2>

                        <div class="nps-bar-row">
                            <div class="title" title="Nota desta turma">Turma</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nps, 1, '.', '')  }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas ministradas pelo consultor para esta solução">Consultor</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-consultor"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-consultor"></div>
                            </div>
                            <div class="value nps">{{ number_format($turma->consultor->nps(), 1, '.', '')  }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas ministradas pelos consultores do Sebrae MG para esta solução">Sebrae MG</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value nps">{{ number_format($turma->solucao->nps(), 1, '.', '')  }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title" title="Meta estabelecida para as turmas">Meta</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value nps">{{ number_format($turma->avaliacao->nps_meta, 1, '.', '')  }}&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ ($turma->avaliacao->nps*100/$turma->avaliacao->nps_meta)-100 }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Avaliações</h2>
                        <h3>Participantes/Avaliações</h3>
                        <p>{{ $turma->participantes }}/{{ $turma->avaliacao->quantidade }}</p>
                        <h3>Número de avaliações por faixa</h3>
                        <div class="basic-bar-10-row tracks">
                            <div class="title">Detratores</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ $turma->avaliacao->detratores }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-10-row tracks">
                            <div class="title">Neutros</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ $turma->avaliacao->passivos }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-10-row tracks">
                            <div class="title">Promotores</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ $turma->avaliacao->promotores }}&nbsp;</div>
                        </div>

                        <input type="hidden" class="faixa-maior-numero" value="{{ max([$turma->avaliacao->detratores, $turma->avaliacao->passivos, $turma->avaliacao->promotores]) }}" />

                        <span class="break-bar-graph"></span>
                        <h1>NPS = {{ $turma->avaliacao->nps }}%</h1>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2 class="titulo-comentarios">Comentários transcritos </h2>

                        <?php
                            $comentarios = $turma->avaliacao->comentarios->filter(function($item)
                            {
                                return strlen($item->comentario_transcrito) > 0 && $item->comentario_transcrito != '0' && strpos($item->comentario_tags, 'NPS') !== false;
                            });
                        ?>

                        @foreach($comentarios as $comentario)
                            <p class="comentario-transcrito">{{$comentario->comentario_transcrito}}</p>
                        @endforeach

                        <a href="/avaliacao/ver/{{ $turma->codigo }}/comentarios">+ Outros comentários</a>
                    </div>
                </div>

            </div>
            <div style="clear: both;"></div>

        </div>

    </div>


@endsection