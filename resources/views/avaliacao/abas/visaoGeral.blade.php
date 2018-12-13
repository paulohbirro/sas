@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('avaliacao.abas')

    <div class="tab-content">

        <div id="visao" class="tab-select">

            <div class="col-left">

                <!-- Nível de Satisfação -->
                <div class="box">
                    <div class="box-content">
                        <h2>Nível de Satisfação </h2>

                        <div class="nps-bar-row">
                            <div class="title" title="Média desta turma">Turma</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nps, 1, '.', '') }}&nbsp;</div>
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
                            <div class="value nps">{{ number_format($turma->consultor->nps(), 1, '.', '') }}&nbsp;</div>
                        </div>

                        <div class="nps-bar-row">
                            <div class="title" title="Média das turmas ministradas pelos consultores do Sebrae MG para esta solução">Sebrae MG</div>
                            <div class="line-negative">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="line-positive">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-13"></div>
                            </div>
                            <div class="value nps">{{ number_format($turma->solucao->nps(), 1, '.', '') }}&nbsp;</div>
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
                            <div class="value nps">{{ number_format($turma->avaliacao->nps_meta, 1, '.', '') }}&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <h2>Meta</h2>
                        <div class="comparativo-meta-turma">{{ ($turma->avaliacao->nps*100/$turma->avaliacao->nps_meta)-100 }}%</div>
                    </div>
                </div>

                <!-- Consultor -->
                <div class="box">
                    <div class="box-content">
                        <h2>Consultor </h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média desta turma">Turma</div>
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

                <!-- Metodologia -->
                <div class="box">
                    <div class="box-content">
                        <h2>Metodologia </h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média desta turma">Turma</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_metodologia, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das turmas realizadas para esta solução">Sebrae MG</div>
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

                <!-- Atendimento -->
                <div class="box">
                    <div class="box-content">
                        <h2>Atendimento </h2>
                        <div class="colored-bar-row">
                            <div class="title" title="Média desta turma">Turma</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-turma"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_atendimento, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Média das turmas realizadas para esta solução">Sebrae MG</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-sebrae"></div>
                            </div>
                            <div class="value">{{ number_format($turma->solucao->notaAtendimento(), 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="colored-bar-row">
                            <div class="title" title="Meta estabelecida para o atendimento">Meta</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored graph-color-meta"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_atendimento_meta, 1, '.', '') }}&nbsp;</div>
                        </div>

                        <span class="break-bar-graph"></span>

                        <div class="basic-bar-10-row">
                            <div class="title">Atendimento</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_atendimento_prestado, 1, '.', '') }}&nbsp;</div>
                        </div>
                        <div class="basic-bar-10-row">
                            <div class="title">Ambiente</div>
                            <div class="line">&nbsp;
                                <div class="total"></div>
                                <div class="colored"></div>
                            </div>
                            <div class="value">{{ number_format($turma->avaliacao->nota_atendimento_ambiente, 1, '.', '') }}&nbsp;</div>
                        </div>
                    </div>
                </div>

            </div>

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
                    <h3>Participantes/Avaliações</h3>
                    <p>{{ $turma->participantes }}/{{ $turma->avaliacao->quantidade }}</p>
                </div>
                <div class="form-group">
                    <h3>Data</h3>
                    <p>{{ $turma->inicio->format('d/m/Y') }}</p>
                </div>
                <div class="form-group">
                    <h3>Local</h3>
                    <p>{{ $turma->local_execucao }}</p>
                </div>
                <div class="form-group">
                    <h3>Município</h3>
                    <p>{{ $turma->municipio->nome }}</p>
                </div>

                <div class="form-group"><a class="showHide" ref="info" textClick="- Informações">+ Informações</a></div>

                <div id="info" class="hide">
                    <div class="form-group">
                        <h3>Regional</h3>
                        <p>{{ $turma->municipio->microregiao->regiao->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Responsável</h3>
                        <p>-</p>
                    </div>

                    <div class="form-group">
                        <h3>Microregião</h3>
                        <p>{{ $turma->municipio->microregiao->nome }}</p>
                    </div>

                    <div class="form-group">
                        <h3>Técnico/Assistente</h3>
                        <p>-</p>
                    </div>

                    <div class="form-group">
                        <h3>Gestor da solução</h3>
                        <p>{{ $turma->solucao->gestor->nome }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div style="clear: both;"></div>

    </div>




@endsection