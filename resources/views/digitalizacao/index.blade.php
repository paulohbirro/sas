@extends('app')

@section('breadcrumb')
    Digitalizações
@endsection

@section('content')

    <hgroup style="width: 100%; margin-bottom: 20px;">
        <h2 class="turma">Enviar digitalização:</h2>

        <div style="clear: both; margin-bottom: 10px;">Obs: O nome do(s) arquivo(s) *.tif deve ser o número da turma. (Exemplo: "212010.tif")</div>

        <div class="form-group">
            <input id="file" type="file" style="display: none;" multiple="true" class="form-control" />
            <button id="btnAddFiles" type="button" class="btn btn-primary select">Clique aqui para selecionar arquivo(s)</button>
        </div>

    </hgroup>


    <div class="col-left">
        <table class="table table-hover">
            <thead>
            <tr class="orderBy">
                <th><a href="{{Order::url('codigo')}}">Turma</a><i class="caret"></i></th>
                <th><a href="{{Order::url('created_at')}}">Data/Hora<i class="caret"></i></a></th>
                <th><a href="{{Order::url('quantidade')}}">Fichas<i class="caret"></i></a></th>
                <th><a href="{{Order::url('digitalizado')}}">Processadas<i class="caret"></i></a></th>
                <th><a href="#">Brancos e Nulos</a></th>
                <th><a href="{{Order::url('status')}}">Status<i class="caret"></i></a></th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @forelse($avaliacoes as $avaliacao)
                <tr>
                    <td>
                        @if(in_array($avaliacao->status, ['PROCESSADO', 'AUDITORIA']))
                            <a href="{{ route('digitalizacoes.ver', ['avaliacaoId' => $avaliacao->id]) }}">{{ Utils::highlighting($avaliacao->turma->codigo, Input::get('like')) }}</a>
                        @else
                            {{ Utils::highlighting($avaliacao->turma->codigo, Input::get('like')) }}
                        @endif
                    </td>
                    <td>{{ $avaliacao->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $avaliacao->quantidade }}</td>
                    <td>{{ $avaliacao->digitalizado }}</td>


                    <td>
                        @if($avaliacao->status=='PROCESSANDO')
                            -
                        @else
                            <?php $erros = $avaliacao->fichasComErro(); ?>

                            @if($erros == 0)
                                Nenhum
                            @else
                                <a href="{{ route('digitalizacoes.ver', ['avaliacaoId' => $avaliacao->id]) }}">{{ ( ($avaliacao->quantidade * 10) - $avaliacao->respostas->count()).' de '.($avaliacao->quantidade * 10) }} respostas</a>
                            @endif
                        @endif
                    </td>

                    <td style="{{ $avaliacao->status=='PROCESSANDO'?'color: #00C;':'' }} {{ $avaliacao->status=='AUDITORIA'?'color: #C00;':'' }}">
                        @if($avaliacao->status == 'ERRO')
                            <span style="color: #e74c3c;" onclick="alert('{{ str_replace("'", "", $avaliacao->erro) }}')">ERRO</span>
                        @else
                            {{ $avaliacao->status }}
                        @endif
                    </td>
                    <td>
                        @if(in_array($avaliacao->status, ['PROCESSADO', 'AUDITORIA', 'ERRO']) || $avaliacao->quantidade == 0)
                            <a class="excluirTurma" data-href="{{ route('digitalizacoes.excluir', ['avaliacaoId' => $avaliacao->id]) }}" href="#">Excluir</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro encontrado</td>
                </tr>
            @endforelse

            </tbody>
        </table>

        <?php echo $avaliacoes->appends(Input::query())->render() ?>

    </div>

    <div class="col-right space">

        <form id="formFilter" method="get">

            <div class="form-group">
                <h2>Palavra-chave:</h2>
                <input type="text" class="form-control input-sm textbox" name="like" value="{{ Input::get('like') }}" />
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary select">Filtrar</button>
            </div>

        </form>

    </div>

<style>

    .modal-open {
        overflow: hidden;
    }
    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 99999999 !important;
        display: none;
        overflow: hidden;
        -webkit-overflow-scrolling: touch;
        outline: 0;
        margin-top: 100px;
    }
    .modal.fade .modal-dialog {
        -webkit-transition: -webkit-transform .3s ease-out;
        -o-transition:      -o-transform .3s ease-out;
        transition:         transform .3s ease-out;
        -webkit-transform: translate(0, -25%);
        -ms-transform: translate(0, -25%);
        -o-transform: translate(0, -25%);
        transform: translate(0, -25%);
    }
    .modal.in .modal-dialog {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0);
    }
    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }
    .modal-dialog {
        position: relative;
        width: auto;
        margin: 10px;
    }
    .modal-content {
        position: relative;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #999;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 6px;
        outline: 0;
        -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
        box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    }
    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #000;
    }
    .modal-backdrop.fade {
        filter: alpha(opacity=0);
        opacity: 0;
        display: none;
    }
    .modal-backdrop.in {
        filter: alpha(opacity=50);
        opacity: .5;
        display: none;
    }
    .modal-header {
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }
    .modal-header .close {
        margin-top: -2px;
    }
    .modal-title {
        margin: 0;
        line-height: 1.42857143;
    }
    .modal-body {
        position: relative;
        padding: 15px;
    }
    .modal-footer {
        padding: 15px;
        text-align: right;
        border-top: 1px solid #e5e5e5;
    }
    .modal-footer .btn + .btn {
        margin-bottom: 0;
        margin-left: 5px;
    }
    .modal-footer .btn-group .btn + .btn {
        margin-left: -1px;
    }
    .modal-footer .btn-block + .btn-block {
        margin-left: 0;
    }
    .modal-scrollbar-measure {
        position: absolute;
        top: -9999px;
        width: 50px;
        height: 50px;
        overflow: scroll;
    }
    @media (min-width: 768px) {
        .modal-dialog {
            width: 600px;
            margin: 30px auto;
        }
        .modal-content {
            -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
        }
        .modal-sm {
            width: 300px;
        }
    }
    @media (min-width: 992px) {
        .modal-lg {
            width: 900px;
        }
    }

    @-webkit-keyframes progress-bar-stripes {
        from {
            background-position: 40px 0;
        }
        to {
            background-position: 0 0;
        }
    }
    @-o-keyframes progress-bar-stripes {
        from {
            background-position: 40px 0;
        }
        to {
            background-position: 0 0;
        }
    }
    @keyframes progress-bar-stripes {
        from {
            background-position: 40px 0;
        }
        to {
            background-position: 0 0;
        }
    }
    .progress {
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
        background-color: #f5f5f5;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
    }
    .progress-bar {
        float: left;
        width: 0;
        height: 100%;
        font-size: 12px;
        line-height: 20px;
        color: #fff;
        text-align: center;
        background-color: #337ab7;
        -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        -webkit-transition: width .6s ease;
        -o-transition: width .6s ease;
        transition: width .6s ease;
    }
    .progress-striped .progress-bar,
    .progress-bar-striped {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        -webkit-background-size: 40px 40px;
        background-size: 40px 40px;
    }
    .progress.active .progress-bar,
    .progress-bar.active {
        -webkit-animation: progress-bar-stripes 2s linear infinite;
        -o-animation: progress-bar-stripes 2s linear infinite;
        animation: progress-bar-stripes 2s linear infinite;
    }
    .progress-bar-success {
        background-color: #5cb85c;
    }
    .progress-striped .progress-bar-success {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
    }
    .progress-bar-info {
        background-color: #5bc0de;
    }
    .progress-striped .progress-bar-info {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
    }
    .progress-bar-warning {
        background-color: #f0ad4e;
    }
    .progress-striped .progress-bar-warning {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
    }
    .progress-bar-danger {
        background-color: #d9534f;
    }
    .progress-striped .progress-bar-danger {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
    }

</style>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enviando arquivos</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th width="100">Progresso</th>
                            <th>Arquivo</th>
                            <th>Resultado</th>
                        </tr>
                        </thead>
                        <tbody id="lista">
                        </tbody>
                    </table>
                    <a href="/digitalizacoes" id="modalFechar" class="btn btn-primary select" style="color: #FFF !important; text-decoration: none; display: none; margin-top: 10px; text-align: center;">Clique aqui para fechar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Excluir digitalização</strong></h4>
                </div>
                <div class="modal-body">
                    <h3>Deseja realmente excluir essa digitalização?</h3><br />
                    <a href="#" id="linkExcluir" class="btn btn-primary select" style="color: #FFF !important; text-decoration: none;">Sim</a>
                    <a href="#" data-dismiss="modal" class="btn btn-primary" style="text-decoration: none;">Não</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(function(){
            var count;
            var files = [];
            var pronto;

            $("a.excluirTurma").click(function(){

                $("#linkExcluir").attr('href', $(this).attr('data-href'));
                $('#modalConfirm').modal('show');

            });

            $('#btnAddFiles').click(function(){
                $('#file').click();
                count = 0;
                pronto = 0;
            });

            $("#file").change(function(e){
                $('#modal').modal('show');

                var numFiles = e.currentTarget.files.length;
                for (var i=0; i<numFiles; i++){
                    files[count] = e.currentTarget.files[i];
                    //Add row
                    $("#lista").append(createRow(count, files[count].name));
                    processar(count);
                    count++;
                }
            });

            function processar(key){
                var file = files[key];
                // Set up the request.
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ action('DigitalizacaoController@upload') }}', true);
                xhr.upload.addEventListener("progress", buildProgress(key), false);
                xhr.onload = buildOnload(key);
                // Create a new FormData object.
                var formData = new FormData();
                formData.append('file', file, file.name);
                formData.append('_token', '{{ csrf_token() }}');
                xhr.send(formData);
            }
            function buildProgress(id){
                return function(evt) {
                    if (evt.lengthComputable) {
                        //Calc percent
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        //div
                        var divProgress = $("#"+id+' > td > div.progress-bar').first();
                        divProgress.css('width', percentComplete+'%');
                        divProgress.html(percentComplete+'%');
                        if (percentComplete === 100)
                            divProgress.removeClass('active');
                    }
                }
            }
            function buildOnload(id){
                return function() {
                    var response = $.parseJSON(this.responseText);
                    var tdMessage = $("#"+id+' > td.message').first();
                    if (response.code === 0)
                        tdMessage.html('<span class="label label-success">'+response.message+'</span>');
                    else
                        tdMessage.html('<span class="label label-danger">'+response.message+'</span>');
                    pronto++;
                    checkFim();

                }
            }
            function createRow(id, filename){
                var html = '<tr id="'+id+'">';
                html += '<td><div class="progress-bar progress-bar active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></td>';
                html += '<td class="file">'+filename+'</td>';
                html += '<td class="message">Enviando ..</td>';
                html += '</tr>'
                return $(html);
            }
            function checkFim(){
                if(count == pronto)
                  $("#modalFechar").css('display', 'block');
            }
        });
    </script>
@endsection