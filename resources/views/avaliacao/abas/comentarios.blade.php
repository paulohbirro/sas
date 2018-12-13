@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')

    @include('avaliacao.abas')

    <div class="tab-content">
        <div id="comentarios" class="tab-select">


            @if($comentarios->count() > 0)
                <div class="col-left">


                    <div class="imagem-comentario">
                        <img src="{{ route('avaliacoes.comentario', ['avaliacaoComentarioId' => $comentario->id]) }}" />
                    </div>

                    <div id="detalhes">

                        <h2>Transcrição</h2>
                        @if($comentario->comentario_transcrito == '0' || $comentario->comentario_transcrito == '')
                            <i>Nenhuma transcrição foi realizada</i>
                            <br />
                            <br />
                        @else
                            <pre>{{ $comentario->comentario_transcrito }}</pre>
                        @endif

                        <p class="tags">

                            @if($comentario->comentario_tags == '0' || $comentario->comentario_tags == '')
                                <i style="">Nenhuma tag foi marcada</i>
                            @else
                                {{ $comentario->comentario_tags }}
                            @endif
                        </p>

                        @if(Sebrae::in(['Admin', 'UED']))
                            <p>
                                <input type="button" id="btnTranscrever" value="Editar" class="btn-form" />
                            </p>
                        @endif

                    </div>


                    @if(Sebrae::in(['Admin', 'UED']))
                        <div id="editar" style="display: none;">
                            <form action="{{ route('avaliacoes.transcricao', ['avaliacaoComentarioId' => $comentario->id]) }}" method="POST">
                                <h2>Transcrição</h2>
                                <textarea style="width:100%; height: 150px; border: 1px solid #CCC;" placeholder="Transcreva aqui a imagem" name="transcricao">{{ $comentario->comentario_transcrito | '' }}</textarea>

                                <p class="tags">
                                    <input class="checkbox-inline" type="checkbox" name="tags[]" value="NPS" {{ (strpos($comentario->comentario_tags, 'NPS') !== false) ? 'checked' : '' }} /> NPS
                                    <input class="checkbox-inline" type="checkbox" name="tags[]" value="CONSULTOR" {{ (strpos($comentario->comentario_tags, 'CONSULTOR') !== false) ? 'checked' : '' }}  /> Consultor
                                    <input class="checkbox-inline" type="checkbox" name="tags[]" value="METODOLOGIA" {{ (strpos($comentario->comentario_tags, 'METODOLOGIA') !== false) ? 'checked' : '' }}  /> Metodologia
                                    <input class="checkbox-inline" type="checkbox" name="tags[]" value="ATENDIMENTO" {{ (strpos($comentario->comentario_tags, 'ATENDIMENTO') !== false) ? 'checked' : '' }}  /> Atendimento
                                </p>

                                <p style="margin-top: 20px;">
                                    <input type="submit" value="Salvar"  class="btn-form" />
                                    <input type="button" id="btnCancelar" value="Cancelar"  class="btn-form" />
                                </p>

                            </form>
                        </div>
                    @endif


                </div>
                <div class="col-right space">
                    <div>

                        <div class="panel-heading">
                            <p>
                                Lista de comentários digitalizados
                            </p>
                            <p class="inner-nav filters">

                                @foreach($tipos as $tipo)
                                    <a href="#{{ $tipo }}">{{ ucfirst(strtolower($tipo)) }}</a>
                                @endforeach

                            </p>
                        </div>

                        <div class="panel-body">

                            @foreach($tipos as $tag)

                                <div class="inner-tab" id="{{ $tag }}">

                                    @foreach($comentarios as $row)

                                        <a href="{{ route('avaliacoes.ver', ['codigoTurma' => $turma->codigo, 'aba' => 'comentarios']) }}?comentarioId={{ $row->id }}#{{ $tag }}">
                                            <div class="gallery {{ $row->id == $comentario->id ? 'select' : '' }}" style="background-image: url({{ route('avaliacoes.comentario', ['avaliacaoComentarioId' => $row->id]) }})"></div>
                                        </a>

                                    @endforeach
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>

                <script>
                    $(function() {
                        $("#btnTranscrever").click(function() {
                            $("#detalhes").css('display', 'none');
                            $("#editar").css('display', '');
                        });

                        $("#btnCancelar").click(function() {
                            $("#detalhes").css('display', '');
                            $("#editar").css('display', 'none');
                        });

                        $(".inner-tab").hide().first().show();
                        $(".inner-nav a:first").css('fontWeight', 'bold');

                        $(".inner-nav a").on('click', function(e) {
                            e.preventDefault();
                            $(".inner-nav a").css('fontWeight', 'normal');
                            $(this).css('fontWeight', 'bold');
                            $($(this).attr('href')).show().siblings('.inner-tab').hide();
                        });

                        var hash = $.trim(window.location.hash);

                        if (hash)
                            $('.inner-nav a[href$="' + hash + '"]').trigger('click');

                    });
                </script>

            @else
                <div>Nenhum comentario encontrado para esta turma</div>
            @endif
        </div>

        <div style="clear: both; "></div>
    </div>



@endsection