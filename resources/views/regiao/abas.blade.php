<hgroup style="width: 100%; margin-bottom: 20px;">
    <h1 class="turma">Região: {{ $regiao->nome }}</h1>
    <h2><a class="close" href="/regioes" title="Fechar"></a></h2>
</hgroup>

<nav class="tab-nav">
    <ul>

        <li class="visao {{ $aba=='visaoGeral'?'select':'' }}">
            <a href="/regioes/ver/{{ $regiao->id }}/visaoGeral">
                Visão geral
            </a>
        </li>
        <li class="nps {{ $aba=='nps'?'select':'' }}">
            <a href="/regioes/ver/{{ $regiao->id }}/nps" data-toggle="tab">
                NPS
            </a>
        </li>

        <li class="consultor {{ $aba=='consultor'?'select':'' }}">
            <a href="/regioes/ver/{{ $regiao->id }}/consultor" data-toggle="tab">
                Consultor
            </a>
        </li>

        <li class="metodologia {{ $aba=='metodologia'?'select':'' }}">
            <a href="/regioes/ver/{{ $regiao->id }}/metodologia" data-toggle="tab">
                Metodologia
            </a>
        </li>
        <li class="atendimento {{ $aba=='atendimento'?'select':'' }}">
            <a href="/regioes/ver/{{ $regiao->id }}/atendimento" data-toggle="tab">
                Atendimento
            </a>
        </li>

    </ul>
</nav>