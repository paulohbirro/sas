@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('avaliacao.abas')

    <div class="tab-content">

        <div id="metodologia" class="tab-select">

            <div class="col-single">
                <div class="box">
                    <div class="box-content">
                        <h2>Metodologia</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média desta turma">Turma</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_metodologia, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores do Sebrae MG para esta solução">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($turma->solucao->notaMetodologia(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelecida para as metodologias">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_metodologia_meta, 1, '.', '') }}&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ ($turma->avaliacao->nota_metodologia*100/$turma->avaliacao->nota_metodologia_meta)-100 }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Avaliações</h2>
                        <h3>Participantes/Avaliações</h3>
                        <p>{{ $turma->participantes }}/{{ $turma->avaliacao->quantidade }}</p>
                        <h3>Tópicos avaliados:</h3>
                        <div class="basic-bar-10-row">
                            <div class="title">Material</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_metodologia_material, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-10-row">
                            <div class="title">Duração</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_metodologia_duracao, 1, '.', '') }}&nbsp;</div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2 class="titulo-comentarios">Comentários transcritos </h2>

                        <?php
                        $comentarios = $turma->avaliacao->comentarios->filter(function($item)
                        {
                            return strlen($item->comentario_transcrito) > 0 && $item->comentario_transcrito != '0' && strpos($item->comentario_tags, 'METODOLOGIA') !== false;
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