@extends('app')

@section('breadcrumb')
    Regiões
@endsection

@section('content')

    @include('regiao.abas')


    <div class="tab-content">
        <div id="visao" class="tab-select">

            <div class="col-left">
                <div class="box">
                    <div class="box-content">
                        <h2>NPS das Soluções (%)</h2>
                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas realizadas na regional">Regional</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-regional"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-regional"></div>
                            </div>
                            <div class="value">{{ number_format($regiao->nps(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas realizadas pelo Sebare MG, a partir das soluções aplicadas na regional">Sebrae MG</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value nps">{{ number_format($npsGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="nps-bar-row">
                            <div class="title" title="Meta estabelecida para NPS">Meta</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value nps">80.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format( (($regiao->nps()*100/80)-100), 1, '.', '') }}%</div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Consultores</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores da regional">Regional</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-regional"></div>
                            </div>
                            <div class="value">{{ number_format($regiao->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores do Sebrae MG, a partir das soluções da regional">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($consultorGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelecida para os consultores">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format( (($regiao->notaConsultor()*100/8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Metodologias</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das metodologias da regional">Regional</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-regional"></div>
                            </div>
                            <div class="value">{{ number_format($regiao->notaMetodologia(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das metodologias do Sebrae MG, a partir das soluções da regional">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($metodologiaGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelecida para as metodologias">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format( (($regiao->notaMetodologia()*100/8)-100), 1, '.', '') }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Atendimento</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do atendimento na regional">Regional</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-regional"></div>
                            </div>
                            <div class="value">{{ number_format($regiao->notaAtendimento(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do atendimento do Sebrae MG, a partir das soluções da regional">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($atendimentoGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelecida para o atendimento">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format( (($regiao->notaAtendimento()*100/8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>


@endsection