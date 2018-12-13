<hgroup style="width: 100%; margin-bottom: 20px;">
    <h1 class="turma">Microregião: {{ $microregiao->nome }}</h1>
    <h2><a class="close" href="/microregioes" title="Fechar"></a></h2>
</hgroup>

<nav class="tab-nav">
    <ul>

        <li class="visao {{ $aba=='visaoGeral'?'select':'' }}">
            <a href="/microregioes/ver/{{ $microregiao->id }}/visaoGeral">
                Visão geral
            </a>
        </li>
        <li class="nps {{ $aba=='nps'?'select':'' }}">
            <a href="/microregioes/ver/{{ $microregiao->id }}/nps" data-toggle="tab">
                NPS
            </a>
        </li>

        <li class="consultor {{ $aba=='consultor'?'select':'' }}">
            <a href="/microregioes/ver/{{ $microregiao->id }}/consultor" data-toggle="tab">
                Consultor
            </a>
        </li>

        <li class="metodologia {{ $aba=='metodologia'?'select':'' }}">
            <a href="/microregioes/ver/{{ $microregiao->id }}/metodologia" data-toggle="tab">
                Metodologia
            </a>
        </li>
        <li class="atendimento {{ $aba=='atendimento'?'select':'' }}">
            <a href="/microregioes/ver/{{ $microregiao->id }}/atendimento" data-toggle="tab">
                Atendimento
            </a>
        </li>

    </ul>
</nav>