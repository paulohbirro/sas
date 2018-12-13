@extends('app')

@section('breadcrumb')
    Soluções
@endsection

@section('content')

    @include('solucao.abas')

    <div class="tab-content">
        <div id="visao" class="tab-select">

            <div class="col-left">
                <div class="box">
                    <div class="box-content">
                        <h2>NPS da Solução</h2>

                        <div class="nps-bar-row">
                            <div class="title">Solução</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-01"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-01"></div>
                            </div>
                            <div class="value nps">{{ number_format($solucao->nps(), 1, '.', '') }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title">Soluções</div>
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
                            <div class="title">Unidade</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-07"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-07"></div>
                            </div>
                            <div class="value nps">{{ number_format($solucao->gestor->unidade->nps(), 1, '.', '') }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title">Meta</div>
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
                        <div class="comparativo-meta-turma">{{ number_format((($solucao->nps() * 100 / 80)-100), 1, '.', '') }}%</div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Consultores</h2>
                        <div class="colored-bar-row">
                            <div class="title">Solução</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Soluções</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($consultorGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Unidade</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->gestor->unidade->notaConsultor(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format((($solucao->notaConsultor() * 100 / 8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Metodologia</h2>
                        <div class="colored-bar-row">
                            <div class="title">Solução</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->notaMetodologia(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Soluções</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($metodologiaGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Unidade</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->gestor->unidade->notaMetodologia(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format((($solucao->notaMetodologia() * 100 / 8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>

                <div class="box">
                    <div class="box-content">
                        <h2>Atendimento</h2>
                        <div class="colored-bar-row">
                            <div class="title">Solução</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->notaAtendimento(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Soluções</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($atendimentoGeral, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Unidade</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($solucao->gestor->unidade->notaAtendimento(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">8.0&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ number_format((($solucao->notaAtendimento() * 100 / 8)-100), 1, '.', '') }}%</div>

                    </div>
                </div>
            </div>

            <div class="col-right">
                <div>
                    <h3>Gestor da Solução</h3>
                    <p>{{ $solucao->gestor->nome }}</p>
                </div>

                <div>
                    <h3>Unidade do Gestor</h3>
                    <p>{{ $solucao->gestor->unidade->nome }}</p>
                </div>

                <div>
                    <h3>Gerente do Gestor</h3>
                    <p>{{ $solucao->gestor->gerenteGestor->nome }}</p>
                </div>
            </div>

            <div style="clear: both;"></div>
        </div>
    </div>

@endsection