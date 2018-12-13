<hgroup style="width: 100%; margin-bottom: 20px;">
    <h1 class="turma">Turma: {{ $turma->codigo }} - {{ $turma->solucao->nome }}</h1>
    <h2><a class="close" href="/avaliacoes" title="Fechar"></a></h2>
</hgroup>

<nav class="tab-nav">
    <ul>

        @if(!Sebrae::is('Consultor'))
            <li class="visao {{ $aba=='visaoGeral'?'select':'' }}">
                <a href="/avaliacoes/ver/{{ $turma->codigo }}/visaoGeral">
                    Visão geral
                </a>
            </li>
            <li class="nps {{ $aba=='nps'?'select':'' }}">
                <a href="/avaliacoes/ver/{{ $turma->codigo }}/nps" data-toggle="tab">
                    NPS
                </a>
            </li>
        @endif

        <li class="consultor {{ $aba=='consultor'?'select':'' }}">
            <a href="/avaliacoes/ver/{{ $turma->codigo }}/consultor" data-toggle="tab">
                Consultor
            </a>
        </li>

        @if(!Sebrae::is('Consultor'))
            <li class="metodologia {{ $aba=='metodologia'?'select':'' }}">
                <a href="/avaliacoes/ver/{{ $turma->codigo }}/metodologia" data-toggle="tab">
                    Metodologia
                </a>
            </li>
            <li class="atendimento {{ $aba=='atendimento'?'select':'' }}">
                <a href="/avaliacoes/ver/{{ $turma->codigo }}/atendimento" data-toggle="tab">
                    Atendimento
                </a>
            </li>
        @endif

        <li class="comentarios {{ $aba=='comentarios'?'select':'' }}">
            <a href="/avaliacoes/ver/{{ $turma->codigo }}/comentarios" data-toggle="tab">
                Comentários
            </a>
        </li>
    </ul>
</nav>