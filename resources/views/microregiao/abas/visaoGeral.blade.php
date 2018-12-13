@extends('app')

@section('breadcrumb')
    Microrregiões
@endsection

@section('content')

    @include('microregiao.abas')

    <div class="tab-content">

        <div id="visao" class="tab-select">
            <div class="col-left">
                <div class="box">
                    <div class="box-content">
                        <h2>NPS das Soluções (%)</h2>
                        <div class="nps-bar-row">
                            <div class="title" title="Média das turma realizadas na microrregião">Microrregião</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-micro"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-micro"></div>
                            </div>
                            <div class="value">{{ number_format($microregiao->nps(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas realizadas pelo Sebrae MG, a partir das mesmas soluções da microrregião">Sebrae MG</div>
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
                        <div class="comparativo-meta-turma">{{ number_format( (($microregiao->nps()*100/80)-100), 1, '.', '') }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Consultores</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores da microrregião">Microrregião</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-micro"></div>
                            </div>
                            <div class="value">{{ number_format($microregiao->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média dos consultores do Sebrae MG, a partir das mesmas soluções da microrregião">Sebrae MG</div>
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
                        <div class="comparativo-meta-turma">{{ number_format( (($microregiao->notaConsultor()*100/8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Metodologias</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das metodologias da microrregião">Microrregião</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-micro"></div>
                            </div>
                            <div class="value">{{ number_format($microregiao->notaMetodologia(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das metodologias realizadas pelo Sebrae MG, a partir das mesmas soluções da microrregião">Sebrae MG</div>
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
                        <div class="comparativo-meta-turma">{{ number_format( (($microregiao->notaMetodologia()*100/8)-100), 1, '.', '') }}%</div>


                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Atendimento</h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do atendimento na microrregião">Microrregião</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-micro"></div>
                            </div>
                            <div class="value">{{ number_format($microregiao->notaAtendimento(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média do atendimento realizado pelo Sebrae MG, a partir das mesmas soluções da microrregião">Sebrae MG</div>
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
                        <div class="comparativo-meta-turma">{{ number_format( (($microregiao->notaAtendimento()*100/8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>
            </div>

            <div style="clear: both;"></div>
        </div>

    </div>




@endsection