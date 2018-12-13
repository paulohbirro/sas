$(function() {
    //CONTROLA BTN PERÍODO
    $(".btn-periodo").click(function() {
        $(".btn-periodo.select").removeClass("select");
        $(this).addClass("select");
    });
    //STATUS NPS
    $("td.smile").each(function() {

        var val = parseFloat($(this).text());

        if (val >= 50) {
            $(this).addClass("smile-blue");
            $(this).parent().addClass("blue");
        }
        else if (val >= 0) {
            $(this).addClass("smile-yellow");
            $(this).parent().addClass("yellow");
        }
        else {
            $(this).addClass("smile-red");
            $(this).parent().addClass("red");
        }
        $(this).text("");
    });
    
    //STATUS NOTA CONSULTOR
    $("td.smile2").each(function() {
        var val = parseFloat($(this).text());

        if (val >= 8) {
            $(this).addClass("smile-blue");
            $(this).parent().addClass("blue");
        }
        else if (val >= 5) {
            $(this).addClass("smile-yellow");
            $(this).parent().addClass("yellow");
        }
        else {
            $(this).addClass("smile-red");
            $(this).parent().addClass("red");
        }
        $(this).text("");
    });
    
    //STATUS EM DIAS - ENVIO MALOTE
    $("td.clock").each(function() {

        var val = parseFloat($(this).text());

        if (val >= 30) {
            $(this).addClass("clock-blue");
            $(this).parent().addClass("blue");
        }
        else if (val >= 12) {
            $(this).addClass("clock-yellow");
            $(this).parent().addClass("yellow");
        }
        else {
            $(this).addClass("clock-red");
        }

        $(this).text("");
    });
    //STATUS EM DIAS - ALERTA DIGITALIZAR
    $("td.letter").each(function() {

        var val = parseFloat($(this).text());

        if (val >= 30) {
            $(this).addClass("letter-blue");
            $(this).parent().addClass("blue");
        }
        else if (val >= 12) {
            $(this).addClass("letter-yellow");
            $(this).parent().addClass("yellow");
        }
        else {
            $(this).addClass("letter-red");
            $(this).parent().addClass("red");
        }

        $(this).text("");
    });
            
    //CONTROLA ABAS
    //$(".tab-nav ul li").click(function(){
    //    $(".tab-nav ul li.select").removeClass("select");
    //    
    //    var div = $(this).attr("class");
    //   
    //    $(this).addClass("select");
    //    $(".tab-select").attr("class", "tab-hidden");
    //    $("#"+div).attr("class", "tab-select");
    //});
    //+/-INFORMAÇÕES
    $(".showHide").click(function() {

        if ($(this).attr('clicked') !== 'true') {
            var textClick = $(this).attr('textClick');
            $(this).attr('textClick', $(this).text());

            $(this).text(textClick);
            $(this).attr('clicked', 'true');

            $("#" + $(this).attr('ref')).slideDown('slow');
        } else {
            var textClick = $(this).attr('textClick');
            $(this).attr('textClick', $(this).text());

            $(this).text(textClick);
            $(this).attr('clicked', 'false');

            $("#" + $(this).attr('ref')).slideUp('slow');
        }
    });
    //GRAPHICS
    $(".nps-bar-row").each(function() {
        var val = parseFloat($(this).find(".value").text());

        if (val < 0.0)
            $(this).find("div.line-negative > div.colored").css("width", -val + "%");

        if (val > 0.0)
            $(this).find("div.line-positive > div.colored").css("width", val + "%");
    });
    $(".colored-bar-row").each(function() {
        var val = parseFloat($(this).find(".value").text());

        if (val) {
            var normal = 100 * val / 10;
            $(this).find("div.line > div.colored").css("width", normal + "%");
        }
    });
    $(".basic-bar-row").each(function() {
        var val = parseFloat($(this).find(".value").text());

        if (val) {
            var normal = 100 * val / 5;
            $(this).find("div.line > div.colored").css("width", normal + "%");
        }

        $(this).find(".title, .line, .value").css("height", "24px");
    });
    $(".basic-bar-10-row").each(function() {
        var val = parseFloat($(this).find(".value").text());

        if (val) {
            var normal = 100 * val / 10;
            $(this).find("div.line > div.colored").css("width", normal + "%");
        }

        $(this).find(".title, .line, .value").css("height", "24px");
    });
    $(".basic-bar-10-row.tracks").each(function() {
        var val = parseFloat($(this).find(".value").text());
        var div = parseFloat($(".faixa-maior-numero").val());
        
        if (val) {
            var normal = 100 * val / div;
            $(this).find("div.line > div.colored").css("width", normal + "%");
        }

        $(this).find(".title, .line, .value").css("height", "24px");
    });
    $("div.comparativo-meta-turma").each(function() {
        var meta = parseFloat($(this).text());
        if (meta > 0)
            $(this).addClass("acima");
        else if (meta == 0)
            $(this).addClass("ok");
        else
            $(this).addClass("baixa");
    });


    //Paginação
    $(".paginacao").click(function() {
        $("#offset").val($(this).attr('itemref'));
        $("#formFilter").submit();
        return false;
    });

    // OrderBy
    $('.orderBy > th').click(function(e) {
        var itemid = $(this).attr('itemid');

        if (itemid.length > 0) {
            $("#orderBy").val(itemid);
            var ascDesc = $("#ascDesc");
            ascDesc.val(ascDesc.val() === 'ASC' ? 'DESC' : 'ASC');
            $("#formFilter").submit();
        }
    });
    
    // Comentários
    var valComentarios = $(".comentario-transcrito");
    if (valComentarios.length == 0){
        $(".titulo-comentarios").after("<p class='nao-ha-comentarios'>Não há itens transcritos</p>");
    }
    
    // Message-Box
    $("div.message-box").click(function(){
        $(this).fadeOut("slow");
    });   
    
    // Limita Texto Coluna 
    $('.limita-texto').each(function(){
        if($(this).text().length>45){
            $(this).attr("title",$(this).text());
            $(this).text($(this).text().substring(0,45)+' ...');
        }
    });
            
});
