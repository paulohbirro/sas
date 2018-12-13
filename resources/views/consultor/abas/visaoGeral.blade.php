@extends('app')

@section('breadcrumb')
    Consultores
@endsection

@section('content')

    @include('consultor.abas')

    <div class="tab-content">


        <div id="consultor" class="tab-select">

            <div class="col-single">
                <div class="box">
                    <div class="box-content">
                        <h2>Consultor </h2>

                        <div class="colored-bar-row">
                            <div class="title" title="Média do consultor para esta solução">Consultor(a)</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-consultores"></div>
                            </div>
                            <div class="value">{{ number_format($consultor->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores do Sebrae MG">Consultores</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($consultorGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelicida para os consultores">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format( (($consultor->notaConsultor() * 100 / 8) - 100), 1, '.', '') }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Avaliações</h2>
                        <h3>Turmas/Avaliações</h3>
                        <p>{{ $consultor->turmas->count() }}/{{ $consultor->avaliacoes->sum('quantidade') }}</p>
                        <h3>Tópicos avaliados:</h3>
                        <div class="basic-bar-row">
                            <div class="title">Domínio</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($consultor->mediaDominio(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Clareza</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($consultor->mediaClareza(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Recursos</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($consultor->mediaRecursos(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-row">
                            <div class="title">Exemplos</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($consultor->mediaExemplos(), 1, '.', '') }}&nbsp;</div>
                        </div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2 class="titulo-comentarios">Comentários transcritos </h2>

                        @foreach(array() as $comentario)
                            <p class="comentario-transcrito">-</p>
                        @endforeach

                        <a href="/consultores/ver/{{ $consultor->codigo }}/comentarios">+ Outros comentários</a>
                    </div>
                </div>

            </div>

            <div style="clear: both;"></div>

        </div>


    </div>




@endsection