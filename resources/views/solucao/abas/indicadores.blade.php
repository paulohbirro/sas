@extends('app')

@section('breadcrumb')
    Soluções
@endsection

@section('content')

    @include('solucao.abas')

    <div class="tab-content" style="border-bottom: 0px !important;">
        <div id="indicadores" class="tab-select">

            <div class="col-left" style="padding: 5px; margin-top: 10px; margin-left: 5px; margin-bottom: 80px;">

                <div id="canvas" class="" style="">
                    <div class="box-nps">
                        <div id="div0" class="lineH" style="margin-left: 50px;"></div>
                    </div>
                    <div class="box-raia" style="padding-right: 72px;">
                        <div id="div1" class="lineV" style="margin-left: 50px;"></div>
                        <div id="div2" class="lineV"></div>
                        <div id="div3" class="lineV"></div>
                    </div>
                </div>

            </div>

            <div class="col-right">
                <div class="box">
                    <div class="box-content">
                        <?php $count = 0; ?>
                        <div style="font-size: 15px; padding-top: 10px;">
                            <?php foreach ($indicadores as $regional => $array) { ?>
                            <div class="group">
                                <div class="reg" ref="reg<?php echo $count ?>" clicked="false" textClick="<?php echo $regional ?>"><?php echo $regional ?></div>
                                <div id="reg<?php echo $count ?>"  style="margin-top: 0px;">
                                    <?php foreach ($array as $row) { ?>
                                    <div class="mrr" clicked="false" item-id="<?php echo $row['id_microrregiao'] ?>"><?php echo $row['microrregiao'] ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php $count++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="clear: both;"></div>
    </div>



    <script type="text/javascript">

        var linesHTML = [];

        var off0 = 0;
        var off1 = 0;
        var off2 = 0;
        var off3 = 0;

        var count = 1;

        $(function() {
            off0 = getOffset(document.getElementById('div0'));
            $("body").append("<div style='position:absolute; top:" + (off0.top - 4) + "px; left:" + (off0.left - 35) + "px;'>-100</div>");
            $("body").append("<div style='position:absolute; top:" + (off0.top - 4) + "px; left:" + (off0.left + off0.width + 10) + "px;'>+100</div>");
            $("body").append("<div style='position:absolute; top:" + (off0.top + 20) + "px; left:" + (off0.left - 10 + (off0.width / 2)) + "px;'>NPS</div>");

            off1 = getOffset(document.getElementById('div1'));
            $("body").append("<div style='position:absolute; top:" + (off1.top - 15) + "px; left:" + (off1.left - 5) + "px;'>10</div>");
            $("body").append("<div style='position:absolute; text-align:center; top:" + (off1.top + off1.height) + "px; left:" + (off1.left - 39) + "px;'>0<br />CONSULTORES</div>");


            off2 = getOffset(document.getElementById('div2'));
            $("body").append("<div style='position:absolute; top:" + (off2.top - 15) + "px; left:" + (off2.left - 5) + "px;'>10</div>");
            $("body").append("<div style='position:absolute; text-align:center; top:" + (off2.top + off1.height) + "px; left:" + (off2.left - 39) + "px;'>0<br />ATENDIMENTO</div>");

            off3 = getOffset(document.getElementById('div3'));
            $("body").append("<div style='position:absolute; top:" + (off3.top - 15) + "px; left:" + (off3.left - 5) + "px;'>10</div>");
            $("body").append("<div style='position:absolute; text-align:center; top:" + (off3.top + off1.height) + "px; left:" + (off3.left - 39) + "px;'>0<br />METODOLOGIA</div>");

            <?php foreach ($indicadores as $regional => $array) { ?>
                <?php foreach ($array as $row) { ?>
                            addLineHTML(<?php echo $row['id_microrregiao'] ?>, '<?php echo $row['microrregiao'] ?>', <?php echo $row['nps'] ?>, <?php echo $row['nota_consultor'] ?>, <?php echo $row['nota_atendimento'] ?>, <?php echo $row['nota_metodologia'] ?>);
            <?php } ?>
        <?php } ?>


                $.each(linesHTML, function(index, value) {
                        $("body").append(value.div);
                    });

            $(".lineChart, .mrr").hover(function() {
                var id = $(this).attr('item-id');
                var classe = $(".lineChart[item-id=" + id + "]:first").attr('item-sel-class');

                $(".mrr[item-id=" + id + "]").addClass(classe);
                $(".lineChart[item-id=" + id + "]").addClass(classe);
                $(".lineChart[item-id=" + id + "]").css('zIndex', '1');
            }, function() {
                if ($(this).attr('clicked') !== 'true') {
                    clearColorsLines($(this));
                }
            });

            $(".lineChart, .mrr").click(function() {
                var id = $(this).attr('item-id');
                if ($(this).attr('clicked') !== 'true') {
                    $(".mrr[item-id=" + id + "]").attr('clicked', 'true');
                    $(".lineChart[item-id=" + id + "]").attr('clicked', 'true');
                } else {
                    $(".mrr[item-id=" + id + "]").attr('clicked', 'false');
                    $(".lineChart[item-id=" + id + "]").attr('clicked', 'false');

                    clearColorsLines($(this));
                }
            });

            $(".reg").click(function() {

                if ($(this).attr('clicked') !== 'true') {
                    $(this).attr('clicked', 'true');

                    $("#" + $(this).attr('ref') + " > .mrr").each(function() {
                        var id = $(this).attr('item-id');
                        var classe = $(".lineChart[item-id=" + id + "]:first").attr('item-sel-class');

                        $(".mrr[item-id=" + id + "]").attr('clicked', 'true');
                        $(".lineChart[item-id=" + id + "]").attr('clicked', 'true');

                        $(".mrr[item-id=" + id + "]").addClass(classe);
                        $(".lineChart[item-id=" + id + "]").addClass(classe);
                        $(".lineChart[item-id=" + id + "]").css('zIndex', '1');
                    });
                } else {
                    $(this).attr('clicked', 'false');

                    $("#" + $(this).attr('ref') + " > .mrr").each(function() {
                        var id = $(this).attr('item-id');

                        $(".mrr[item-id=" + id + "]").attr('clicked', 'false');
                        $(".lineChart[item-id=" + id + "]").attr('clicked', 'false');
                        clearColorsLines($(this));
                    });
                }
            });

            function clearColorsLines(el) {
                var id = el.attr('item-id');
                var classe = $(".lineChart[item-id=" + id + "]:first").attr('item-sel-class');

                $(".mrr[item-id=" + id + "]").removeClass(classe);
                $(".lineChart[item-id=" + id + "]").removeClass(classe);
                $(".lineChart[item-id=" + id + "]").css('zIndex', '0');
            }

            $(".reg").mouseover(function() {
                var textClick = $(this).attr('textClick');
                $(this).attr('textClick', $(this).text());

                $(this).text(textClick);

                //$("#" + $(this).attr('ref')).slideDown('slow');
            });

            $(".group").mouseleave(function() {
                if ($(this).find(".mrr[clicked='true']").length === 0) {
                    var t = $(this).find('.reg:first');

                    var textClick = t.attr('textClick');
                    t.attr('textClick', t.text());
                    t.text(textClick);
                    //$("#" + t.attr('ref')).slideUp('slow');
                }
            });


        });

        function getStyleRuleValue(style, selector, sheet) {
            var sheets = typeof sheet !== 'undefined' ? [sheet] : document.styleSheets;
            for (var i = 0, l = sheets.length; i < l; i++) {
                var sheet = sheets[i];
                if (!sheet.cssRules) {
                    continue;
                }
                for (var j = 0, k = sheet.cssRules.length; j < k; j++) {
                    var rule = sheet.cssRules[j];
                    if (rule.selectorText && rule.selectorText.split(',').indexOf(selector) !== -1) {
                        return rule.style[style];
                    }
                }
            }
            return null;
        }


        function addLineHTML(id, label, pos0, pos1, pos2, pos3) {
            var color = "#DDD";

            if (pos0 >= 0)
                var x0 = (off0.width * (100 + pos0) / 200) + off0.left;
            else
                var x0 = ((off0.width / 2) + off0.left) - ((off0.width / 2) * (pos0 * -1) / 100);


            var x1 = off1.left + off1.width;
            var y1 = off1.top + ((10 - pos1) * off1.height / 10);

            var x2 = off2.left + off2.width;
            var y2 = off2.top + ((10 - pos2) * off2.height / 10);

            var x3 = off3.left + off3.width;
            var y3 = off3.top + ((10 - pos3) * off3.height / 10);

            var length = Math.sqrt(((x2 - x1) * (x2 - x1)) + ((y2 - y1) * (y2 - y1)));
            var cx = ((x1 + x2) / 2) - (length / 2);
            var cy = ((y1 + y2) / 2) - (2 / 2);

            var angle = Math.atan2((y1 - y2), (x1 - x2)) * (180 / Math.PI);
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart' style='padding:0px; margin:0px; height:1px; background-color:" + color + "; line-height:1px; position:absolute; left:" + cx + "px; top:" + cy + "px; width:" + length + "px; -moz-transform:rotate(" + angle + "deg); -webkit-transform:rotate(" + angle + "deg); -o-transform:rotate(" + angle + "deg); -ms-transform:rotate(" + angle + "deg); transform:rotate(" + angle + "deg);' />").contents()});

            var length2 = Math.sqrt(((x3 - x2) * (x3 - x2)) + ((y3 - y2) * (y3 - y2)));
            var cx2 = ((x2 + x3) / 2) - (length2 / 2);
            var cy2 = ((y2 + y3) / 2) - (2 / 2);
            var angle2 = Math.atan2((y2 - y3), (x2 - x3)) * (180 / Math.PI);
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart' style='padding:0px; margin:0px; height:1px; background-color:" + color + "; line-height:1px; position:absolute; left:" + cx2 + "px; top:" + cy2 + "px; width:" + length2 + "px; -moz-transform:rotate(" + angle2 + "deg); -webkit-transform:rotate(" + angle2 + "deg); -o-transform:rotate(" + angle2 + "deg); -ms-transform:rotate(" + angle2 + "deg); transform:rotate(" + angle2 + "deg);' />").contents()});

            //Pontos
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart point hint--top' data-hint='" + label + " - NPS: " + pos0 + "%' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x0 - 5) + "px; top:" + (off0.top - 3) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});

            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart point hint--top' data-hint='" + label + " - Consultores: " + pos1 + "' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x1 - 5) + "px; top:" + (y1 - 5) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart point hint--top' data-hint='" + label + " - Atendimento: " + pos2 + "' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x2 - 5) + "px; top:" + (y2 - 5) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});
            linesHTML.push({id: id, div: $('<div/>').html("<div item-id='" + id + "' item-sel-class='graph-color-" + lpad(count, 2) + "' class='lineChart point hint--top' data-hint='" + label + " - Metodologia: " + pos3 + "' style='padding:0px; margin:0px; height:10px; width:10px; background-color:" + color + "; position:absolute; left:" + (x3 - 5) + "px; top:" + (y3 - 5) + "px; -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px;' />").contents()});

            count++;

            if (count === 12)
                count = 1;
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

        function lpad(num, size) {
            var s = num + "";
            while (s.length < size)
                s = "0" + s;
            return s;
        }


    </script>

@endsection