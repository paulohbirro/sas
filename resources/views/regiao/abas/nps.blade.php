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
                            <div class="title" title="Média das turma realizadas na regional">Regional</div>
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
                            <div class="title" title="Média das turmas realizadas pelo Sebrae MG, a partir das mesmas soluções da regional">Sebrae MG</div>
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
                        <div class="comparativo-meta-turma">{{ number_format( (($regiao->nps()*100/80)-100), 1, '.', '') }}</div>
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

                                ['<?php echo $mesAno->format('m/y') ?>', <?php echo number_format($regiao->mediaPorMes($mesAno, 'nps'), 1, '.', '') ?>, <?php echo number_format($mediaGeralUltimos12Meses[$mesAno->format('m/y')]['nps'], 1, '.', '') ?>, 80],

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