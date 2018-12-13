@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('consultor.abas')

    <style>
        .lineV{
            background-color:#DDD;
            width:1px;
            height: 260px;
            float: left;
            margin-left: 100px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .lineChart, .line{
            cursor: pointer;
        }
    </style>

    <div class="tab-content">

        <div id="solucoes" class="tab-select" style="padding: 20px;">
            <h2>Média das Soluções</h2>
            <div class="col-left">



                @foreach($consultor->solucoes() as $solucao)

                <?php
                if ($solucao->media > 8)
                    $meta = "graph-color-meta-blue";
                elseif ($solucao->media > 6)
                    $meta = "graph-color-meta-yellow";
                else
                    $meta = "graph-color-meta-red";
                ?>

                <div class="colored-bar-row" >
                    <div class="title"><?php echo $solucao->nome ?></div>
                    <div class="line" item-id="{{ $solucao->id }}">&nbsp;
                        <div class="total"></div>
                        <div class="colored <?php echo $meta; ?> transparent"></div>
                    </div>
                    <div class="value">{{ number_format($solucao->media, 1, '.', '') }}&nbsp;</div>
                </div>
               @endforeach

            </div>

            <div class="col-right">

                <div class="box-raia">
                    <div id="canvas" class="" style="padding-left: 20px; padding-right: 20px;">
                        <div id="div1" class="lineV" style="margin-left: 5px;"></div>
                        <div id="div2" class="lineV"></div>

                        <div id="div3" class="lineV" style="margin-left: 30px;"></div>
                        <div id="div4" class="lineV"></div>

                        <h3 style="position:absolute; top:0; left:48px;">Solução</h3>
                        <h3 style="position:absolute; top:0; left:180px;">Soluções</h3>
                        <h4 title="Nota do consultor para a solução selecionada" class="consultor-solucao solucao">
                            <div id="nota_a" style="margin-top: 20px;"></div>
                        </h4>
                        <h4 title="Nota dos consultores do Sebrae MG para a solução selecionada" class="consultores-solucao solucao">
                            <div id="nota_b" style="margin-top: 20px;"></div>
                        </h4>
                        <h4 title="Média do consultor para as soluções listadas" class="consultor-solucao solucoes">
                            <div style="margin-top: 20px;">{{ number_format($consultor->notaConsultor(), 1, '.', '') }}</div>
                        </h4>
                        <h4 title="Média dos consultores do Sebrae MG para as soluções listadas" class="consultores-solucao solucoes">
                            <div style="margin-top: 20px;">{{ number_format($consultorGeral, 1, '.', '') }}</div>
                        </h4>

                    </div>
                </div>

            </div>

            <div style="clear: both;"></div>
        </div>

    </div>



    <script type="text/javascript">

        var linesHTML = [];


        $(function() {
            var off1 = getOffset(document.getElementById('div1'));
            var off2 = getOffset(document.getElementById('div2'));

            var off3 = getOffset(document.getElementById('div3'));
            var off4 = getOffset(document.getElementById('div4'));

            addLineHTML(0, off3, off4, <?php echo number_format($consultor->notaConsultor(), 1, '.', '')  ?>, <?php echo number_format($consultorGeral, 1, '.', '')  ?>);

            @foreach($consultor->solucoes() as $solucao)
                        addLineHTML(<?php echo $solucao->id ?>, off1, off2, <?php echo number_format($solucao->media, 1, '.', '') ?>, <?php echo number_format($consultorGeral, 1, '.', '') ?>);
            @endforeach

                    $.each(linesHTML, function(index, value) {
                        $("body").append(value.div);
                    });

            $(".lineChart, .line").click(function() {
                var id = $(this).attr('item-id');

                $(".line[item-id!=" + id + "]").each(function() {
                    $(this).find('.colored:first').addClass('transparent');
                    $(this).attr('clicked', 'false');
                });

                $(".lineChart[item-id!=" + id + "]").each(function() {
                    $(this).css("backgroundColor", "#DDD");
                    $(this).css('zIndex', '0');
                });

                if ($(this).attr('clicked') !== 'true') {

                    $("#nota_a").text($(".a[item-id=" + id + "]").attr('data-hint'));
                    $("#nota_b").text($(".b[item-id=" + id + "]").attr('data-hint'));

                    $(".line[item-id=" + id + "]").attr('clicked', 'true');
                    $(".lineChart[item-id=" + id + "]").attr('clicked', 'true');
                } else {
                    $("#nota_a").text("");
                    $("#nota_b").text("");
                    $(".line[item-id=" + id + "]").attr('clicked', 'false');
                    $(".lineChart[item-id=" + id + "]").attr('clicked', 'false');
                }
            });

            $(".lineChart, .line").hover(function() {
                var id = $(this).attr('item-id');
                $(".line[item-id=" + id + "]").find('.colored:first').addClass('select');

                $(".line").each(function() {
                    if ($(this).attr('clicked') !== 'true' && $(this).attr('item-id')!==id)
                        $(this).find('.colored:first').addClass('transparent');
                    else
                        $(this).find('.colored:first').removeClass('transparent');
                });

                $(".lineChart[item-id=" + id + "]").css("backgroundColor", "#777");
                $(".lineChart[item-id=" + id + "]").css('zIndex', '1');
            }, function() {
                var id = $(this).attr('item-id');
                $(".line[clicked!='true']").find('.colored:first').addClass('transparent');

                if ($(this).attr('clicked') !== 'true') {
                    $(this).find('.colored:first').removeClass('select');
                    $(".lineChart[item-id=" + id + "]").css("backgroundColor", "#DDD");
                    $(".lineChart[item-id=" + id + "]").css('zIndex', '0');
                }
            });
        });

        function addLineHTML(id, off1, off2, pos1, pos2) {
            var color = "#DDD";

            var x1 = off1.left + off1.width;
            var y1 = off1.top + ((10 - pos1) * off1.height / 10);

            var x2 = off2.left + off2.width;
            var y2 = off2.top + ((10 - pos2) * off2.height / 10);

            var length = Math.sqrt(((x2 - x1) * (x2 - x1)) + ((y2 - y1) * (y2 - y1)));
            var cx = ((x1 + x2) / 2) - (length / 2);
            var cy = ((y1 + y2) / 2) - (2 / 2);

            var angle = Math.atan2((y1 - y2), (x1 - x2)) * (180 / Math.PI);
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "'' class='lineChart' style='padding:0px; margin:0px; height:1px; background-color:" + color + "; line-height:1px; position:absolute; left:" + cx + "px; top:" + cy + "px; width:" + length + "px; -moz-transform:rotate(" + angle + "deg); -webkit-transform:rotate(" + angle + "deg); -o-transform:rotate(" + angle + "deg); -ms-transform:rotate(" + angle + "deg); transform:rotate(" + angle + "deg);' />").contents()});

            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' class='lineChart point a hint--top' data-hint='" + pos1 + "' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x1 - 4) + "px; top:" + (y1 - 5) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' class='lineChart point b hint--top' data-hint='" + pos2 + "' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x2 - 4) + "px; top:" + (y2 - 5) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});

        }

        function getOffset(el) {
            var _x = 0;
            var _y = 0;
            var _w = el.offsetWidth | 0;
            var _h = el.offsetHeight | 0;
            while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
                _x += el.offsetLeft - el.scrollLeft;
                _y += el.offsetTop - el.scrollTop;
                el = el.offsetParent;
            }
            var r = {top: _y, left: _x, width: _w, height: _h};
            return r;
        }
    </script>


@endsection