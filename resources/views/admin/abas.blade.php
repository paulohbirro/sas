<style>
    li.admtab{
        padding-left: 14px !important;
        display: inline-block !important;
        margin-top: 5px;
    }
    li.admtab.select{
        background-color: #01B7DF;
        color: #FFF;
    }
    li.admtab.select a{
        color: #FFF !important;
    }

    .tab-content {
        margin: 0px !important;
    }

</style>

<nav class="tab-nav">
    <ul>
        <li class="admtab {{ (Request::is('admin/regioes'))?'select':'' }}">
            <a href="/admin/regioes">
                Região
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/microregioes'))?'select':'' }}">
            <a href="/admin/microregioes" >
                Microregião
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/municipios'))?'select':'' }}">
            <a href="/admin/municipios" >
                Município
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/tecnicos'))?'select':'' }}">
            <a href="/admin/tecnicos" >
                Técnico
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/consultores'))?'select':'' }}">
            <a href="/admin/consultores" >
                Consultor
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/gerentesRegiao'))?'select':'' }}">
            <a href="/admin/gerentesRegiao" >
                G. Regional
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/solucoes'))?'select':'' }}">
            <a href="/admin/solucoes">
                Solução
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/gestores'))?'select':'' }}">
            <a href="/admin/gestores">
                Gestor
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/gerentesGestor'))?'select':'' }}">
            <a href="/admin/gerentesGestor">
                G. Gestor
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/ueds'))?'select':'' }}">
            <a href="/admin/ueds">
                UED
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/ugps'))?'select':'' }}">
            <a href="/admin/ugps">
                UGP
            </a>
        </li>
        <li class="admtab {{ (Request::is('admin/administradores'))?'select':'' }}">
            <a href="/admin/administradores">
                Admin
            </a>
        </li>
    </ul>
</nav>