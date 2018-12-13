<hgroup style="width: 100%; margin-bottom: 20px;">
    <h1 class="turma">Consultor: {{ $consultor->nome }} </h1>
    <h2><a class="close" href="/consultores" title="Fechar"></a></h2>
</hgroup>

<nav class="tab-nav">
    <ul>

        <li class="visao {{ $aba=='visaoGeral'?'select':'' }}">
            <a href="/consultores/ver/{{ $consultor->id }}/visaoGeral">
                Visão geral
            </a>
        </li>
        <li class="solucoes {{ $aba=='solucoes'?'select':'' }}">
            <a href="/consultores/ver/{{ $consultor->id }}/solucoes" data-toggle="tab">
                Soluções
            </a>
        </li>
    </ul>
</nav>