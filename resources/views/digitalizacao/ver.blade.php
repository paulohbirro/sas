@extends('app')

@section('breadcrumb')
    Digitalizações
@endsection

@section('content')

    <style>
        .formItensRadio{
            margin-bottom: 30px;
        }

        .formItensRadio > input{
            width: 10px;
        }

        .formItensRadio > div > input{
            width: 10px;
        }

        .frmValidacao{
            font-size: 8px;
        }

        .ficha-erro{
            background-color: #CC0000 !important;
        }

        .ficha-erro.active{
            background-color: #830a07 !important;
        }

        .ficha-erro > a{
            color: #FFF !important;
        }

        .col-left2{
            width: 50%;
            clear: both;
        }

    </style>

    <hgroup style="width: 100%; margin-bottom: 20px;">
        <h1 class="turma">Turma: {{ $avaliacao->turma->codigo }} - {{ $avaliacao->turma->solucao->nome }}</h1>
        <h2><a class="close" href="/digitalizacoes" title="Fechar"></a></h2>
    </hgroup>

    <div>
        <ul class="pagination">

            <?php $count = 1; ?>

            @foreach($avaliacao->fichas as $row)

                @if($row->id == $ficha->id)
                    <li class="active {{ $row->isValido()?'':'ficha-erro' }}"><span>{{$count}}</span></li>
                @else
                    <li class="{{ $row->isValido()?'':'ficha-erro' }}"><a href="{{ action('DigitalizacaoController@ver', ['avaliacaoId' => $avaliacao->id, 'avaliacaoFichaId' => $row->id]) }}">{{$count}}</a></li>
                @endif

                <?php $count++; ?>
            @endforeach
        </ul>
    </div>

    <br />
    <br />
    <br />
    <br /><br />

    <div class="col-left col-left2">
        <form class="frmValidacao">

            @foreach($perguntas as $pergunta)

                <?php $resposta = $ficha->respostas->where('avaliacao_pergunta_id', $pergunta->id)->first(); ?>

                <p style="font-weight:bold; {{ is_null($resposta)?'color: #C00;':'' }}">{{ $pergunta->pergunta }}</p>

                <div class="formItensRadio">

                    <?php for($i=0; $i<$pergunta->opcoes; $i++){ ?>

                    <?php $number = in_array($pergunta->numero, ['ba', 'bb', 'bc', 'bd']) ? $i+1 : $i;  ?>

                    <div style="display: inline-block; padding: 0 5px;">
                        <input style="margin: 0 auto;" type="radio" name="resposta_{{$pergunta->id}}" class="resposta" idAvaliacaoPergunta="{{ $pergunta->id }}" {{ (!is_null($resposta) && $resposta->resposta == $number)?'checked':'' }} value="{{ $number }}"  />
                        <span style="display: block; text-align: center;">{{ $number }}</span>
                    </div>

                    <?php } ?>

                    | <input type="radio" class="resposta" name="resposta_{{$pergunta->id}}" idAvaliacaoPergunta="{{ $pergunta->id }}" {{ (!is_null($resposta) && is_null($resposta->resposta))?'checked':'' }} value="null" /> Branco

                </div>

            @endforeach

            <p>5) Você gostaria de fazer algum comentário a respeito do treinamento e dos consultores?</p>

            @if(is_null($ficha->comentario))
                <div style="font-size: 10px; padding: 20px 5px 20px 5px;  background-color: #fff1b0">
                    <h2>Não foi identificado um comentário para extrair da ficha.</h2>
                    <span id="extrairComentario" class="btn btn-primary">Clique aqui</span> <span >para extrair manualmente o comentário da ficha ao lado</span>
                </div>

            @else
                <img style="width: 100%;" src="{{ action('DigitalizacaoController@comentario', ['avaliacaoComentarioId' => $ficha->comentario->id]) }}">
                <br /><br /><br /><br /><a href="{{ action('DigitalizacaoController@deletarComentario', ['avaliacaoComentarioId' => $ficha->comentario->id]) }}" style="color: #C00; font-size: 15px !important;">Clique aqui para excluir este comentário</a>
            @endif

        </form>
    </div>

    <div class="col-right">
        <img id="image" src="{{ action('DigitalizacaoController@ficha', ['avaliacaoFichaId' => $ficha->id]) }}" width="600" height="780" />

        <span style="display: none; margin-top: 20px;" id="cortarComentario" class="btn btn-primary">Clique aqui para Recortar e Salvar</span></span>


        <a href="{{ action('DigitalizacaoController@ficha', ['avaliacaoFichaId' => $ficha->id]) }}?debug=true" target="_blank">Ver debug OMR</a>

    </div>

    <link rel="stylesheet" href="/css/cropper.min.css">
    <script src="/js/cropper.min.js"></script>
    <script src="/js/canvas-toBlob.js"></script>

    <script>
        $(function(){
            var $image = $('#image');

            $("#extrairComentario").click(function(){
                $image.cropper({
                    zoomable:false,
                    croppable: true,

                    built: function (e) {
                        $image.cropper("setCropBoxData", { width: 410, height: 120, left:30, top:540 });
                        $("#cortarComentario").css('display', 'block');
                    }
                });

            });

            $("#cortarComentario").click(function() {
                $image.cropper('getCroppedCanvas').toBlob(function (blob) {

                    var formData = new FormData();

                    formData.append('croppedImage', blob);

                    $.ajax('/digitalizacoes/uploadComentario/{{ $ficha->id }}', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () {
                            window.location.reload(true);
                        },
                        error: function () {
                            alert('Ocorreu um erro ao enviar imagem. Consulte o administrador.');
                        }
                    });

                });
            });

            $('body').click(function(){
                $("#msg").remove();
            });

            $(".resposta").click(function(){


                var params = {
                    avaliacao_pergunta_id : $(this).attr('idAvaliacaoPergunta'),
                    resposta : $(this).val()
                };

                var url = '<?php echo route('digitalizacoes.atualizarResposta', ['avaliacaoFichaId' =>  $ficha->id]) ?>';

                $.get(url, params, function(json){

                    if(json.code===0)
                        $("body").append('<div id="msg" class="div message-box alert-danger">'+json.message+'</div>')

                }, 'json');

            });
        });
    </script>


@endsection