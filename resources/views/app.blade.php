<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SAS - Sistema de Avaliação de Soluções</title>

    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/sas/style.css">
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/sas/scripts.js"></script>

</head>

<body>
<div id="wrapper">
    <header>
        <hgroup>
            <h1>SAS</h1>
            <h2>Sistema de Avaliação de Soluções (2.0.0)</h2>
        </hgroup>

        <nav>
            <ul>
                @if(Sebrae::check())

                    @if(Sebrae::is('Admin'))
                        <li class="{{ (Request::is('admin/*'))?'select':'' }}"><a href="/admin">Admin</a></li>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED']))
                        <li class="{{ (Request::is('digitalizacoes') || Request::is('digitalizacoes/*'))?'select':'' }}"><a href="/digitalizacoes">Digitalizações</a></li>
                    @endif

                    @if(!Sebrae::is('Expedição'))
                        <li class="{{ (Request::is('avaliacoes') || Request::is('avaliacoes/*'))?'select':'' }}"><a href="/avaliacoes">Avaliações</a>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED', 'UGP']))
                        <li class="{{ (Request::is('consultores') || Request::is('consultores/*'))?'select':'' }}"><a href="/consultores">Consultores</a></li>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED', 'Gerente de Regional']))
                        <li class="{{ (Request::is('microregioes') || Request::is('microregioes/*'))?'select':'' }}"><a href="/microregioes">Microrregiões</a></li>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED', 'Gerente de Regional']))
                        <li class="{{ (Request::is('regioes') || Request::is('regioes/*'))?'select':'' }}"><a href="/regioes">Regiões</a></li>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED', 'Gestor de Solução', 'Gerente de Gestor', 'Gerente de Regional']))
                        <li class="{{ (Request::is('solucoes') || Request::is('solucoes/*'))?'select':'' }}"><a href="/solucoes">Soluções</a></li>
                    @endif

                    @if(Sebrae::in(['Admin', 'UED', 'Gerente de Regional', 'Técnico de Microregião', 'Expedição']))
                        <li class="{{ (Request::is('fichas') || Request::is('fichas/*'))?'select':'' }}"><a href="/fichas">Fichas</a></li>
                    @endif

                    <li><a href="{{ action('SelecionarController@getSair') }}">Perfil</a></li>

                @endif

                @if(Auth::check())
                    <li><a href="/auth/logout">Sair</a></li>
                @endif
            </ul>
        </nav>

    </header>

    <section id="breadcrumb">
        <div style="float:left;"><h1>@yield('breadcrumb')</h1></div>
        <div style="float:right;padding: 40px 20px 0 0;">
            @if(Sebrae::check())
                <h4>{{ Sebrae::getPerfil() }}: {{ Sebrae::getDetalhes()->nome }}</h4>
            @endif

        </div>
    </section>


    <section id="content">


        @if (count($errors) > 0)
            <div class="div message-box alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif


        @yield('content')

    </section>

</div>

<script>

    $(function(){

        $("ul.pagination li").click(function(){
            if($(this).has('a').length){
                window.location = $(this).find('a').first().attr('href');
            }
        });

    });

</script>

</body>
</html>


