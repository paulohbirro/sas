@extends('app')

@section('breadcrumb')
    Regiões
@endsection

@section('content')

    @include('regiao.abas')

    <div class="tab-content">

        <div id="consultor" class="tab-select">

            <div class="col-left">
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
                            <div class="title" title="Média dos consultores do Sebrae MG, a partir das mesmas soluções da regional">Sebrae MG</div>
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

            </div>

            <div id="chart_div" style="min-width: 663px; height: 300px; margin-left: 30%;"></div>

            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['mes/ano', 'Regional', 'Sebrae', 'Meta'],
                            <?php
                                $anos = 0;

                                while($anos<12){
                                    $mesAno = \Carbon\Carbon::now()->firstOfMonth()->subMonth(12 - $anos);
                            ?>

                                ['<?php echo $mesAno->format('m/y') ?>', <?php echo number_format($regiao->mediaPorMes($mesAno, 'nota_consultor'), 1, '.', '') ?>, <?php echo number_format($mediaGeralUltimos12Meses[$mesAno->format('m/y')]['nota_consultor'], 1, '.', '') ?>, 8],

                        <?php
                                $anos++;
                            }
                        ?>
                    ]);

                    var options = {
                        title: 'Últimos 12 meses',
                        hAxis: {title: 'Mês/Ano', titleTextStyle: {color: '#333'}},
                        vAxis: {title: 'Percentual %'},
                        colors: ['#A75265', '#14A6D6', '#0085B2'],
                        series: {
                            2: {
                                areaOpacity: 0.0
                            }
                        }
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>


            <div style="clear: both;"></div>

        </div>
    </div>


@endsection