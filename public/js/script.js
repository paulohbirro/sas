$(function() {

    $('ul.keep a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.keep > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('ul.keep a[href="' + hash + '"]').tab('show');


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

    $.date = function(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "/" + month + "/" + year;
        return date;
    };

    //Mask
    $('.cep').mask('00.000-000', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});


    $(".integer").mask('000');

    $(".decimalNegative").maskMoney({prefix: '', allowNegative: true, thousands: '', decimal: '.', affixesStay: false});
    $(".decimal").numeric();
    $(".money").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});

    $('.formEdit input:not(".none")').blur(changeFields);
    $('.formEdit textarea:not(".none")').blur(changeFields);
    $('.formEdit select:not(".none")').blur(changeFields);
    $('.formEdit input[type=checkbox]:not(".none")').on('switchChange', changeFields);

    var masks = ['(00) 00000-0000', '(00) 0000-00009'],
            maskBehavior = function(val, e, field, options) {
                return val.length > 14 ? masks[0] : masks[1];
            };

    $('.telefone').mask(maskBehavior, {onKeyPress:
                function(val, e, field, options) {
                    field.mask(maskBehavior(val, e, field, options), options);
                }
    });

    $('.datePicker').each(function() {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            inline: true
        });
    });

    $('.dateTimePicker').datetimepicker();

    $('.dtpick').each(function() {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            inline: true
        }).on('changeDate', changeFields);
    });

    $('.toggle').bootstrapSwitch();
});


function changeFields() {
    var element = $(this);
    console.log(element);

    var form = element.parents('form:first');
    var formGroup = element.parents('.form-group');

    var action = form.attr('itemtype');

    if (typeof action === "undefined")
        action = 'editar';

    var url = '/' + form.attr('itemref') + '/' + action + '/' + form.attr('itemid');

    var param = {};

    if (element.attr('type') == 'checkbox') {
        param[element.attr('name')] = element.prop('checked') ? element.attr('data-on') : element.attr('data-off');
    } else
        param[element.attr('name')] = element.val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: url,
        data: param,
        success: function(json) {
            if (json.code === 0) {
                formGroup.removeClass('has-error');
                formGroup.append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                formGroup.addClass('has-success has-feedback');
                element.removeAttr('data-toggle');
                element.removeAttr('title', json.message);
                element.tooltip('destroy');

                if (json.refresh)
                    location.reload();

            } else {
                element.attr('data-toggle', 'tooltip').attr('title', json.message).tooltip('toggle');
                formGroup.addClass('has-error');
            }
        },
        error: function(data) {
            element.attr('data-toggle', 'tooltip').attr('title', 'Erro desconhecido. Tente novamente.').tooltip('toggle');
            formGroup.addClass('has-error');
        }
    });
}

function loadUF(selectUF, selectFK) {
    $.post('/common/util/getJsonUf', null, function(json) {
        $.each(json, function(i, item) {
            if (selectUF.attr('itemid') === item) {
                aux = 'selected';
            } else
                aux = '';

            selectUF.append('<option value="' + item + '" ' + aux + '>' + item + '</option>');

            if (selectUF.attr('itemid') === item)
                selectUF.trigger("change");
        });
    }, 'json');

    selectUF.change(function() {
        var uf = $(this).val();
        selectFK.html('<option>Carregando..</option>');
        if (uf.length === 2) {
            $.post('/common/util/getJsonCidades/' + uf, null, function(json) {
                selectFK.html('');
                $.each(json, function(i, item) {
                    if (selectFK.attr('itemid') === item.id || selectFK.attr('itemname') === item.nome)
                        aux = 'selected';
                    else
                        aux = '';
                    selectFK.append('<option value="' + item.id + '" ' + aux + '>' + item.nome + '</option>');
                });
            }, 'json');
        }
    });
}

Number.prototype.formatMoney = function(c, d, t) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function dateUsToBR(datestr) {
    var arr = datestr.split('-');
    return arr[2] + "/" + arr[1] + "/" + arr[0];
}