<hgroup style="width: 100%; margin-bottom: 20px;">
    <h1 class="turma">Solução: {{ $solucao->nome }}</h1>
    <h2><a class="close" href="/solucoes" title="Fechar"></a></h2>
</hgroup>

<nav class="tab-nav">
    <ul>

        <li class="visao {{ $aba=='visaoGeral'?'select':'' }}">
            <a href="/solucoes/ver/{{ $solucao->id }}/visaoGeral">
                Visão geral
            </a>
        </li>
        <li class="indicadores {{ $aba=='indicadores'?'select':'' }}">
            <a href="/solucoes/ver/{{ $solucao->id }}/indicadores" data-toggle="tab">
                Indicadores
            </a>
        </li>
    </ul>
</nav>