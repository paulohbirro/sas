## SAS sistema

Aplicação web escrita com PHP 5.5.9 sob Laravel Framework 5.1 (LTS)

### Requisitos mínimos

* PHP >= 5.5.9
* ImageMagick
* SGDB (MySQL or Postgres or SQLite or SQL Server)
* HTTP Server (Apache, Nginx)

##### Extensões PHP

* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* Imagick PHP Extension
* LDAP PHP Extension
* GD PHP Extension

### Instalação

Clone este repositório

```ssh
$ git clone <url repo>
```

Execute o comando abaixo na raíz do diretório para baixar as bibliotecas necessárias para o software funcionar:

```ssh
$ composer create-project
```

Configure as variáveis no arquivo `.env` e execute o comando abaixo para criar a estrutura do banco e carregar os dados

```ssh
$ php artisan migrate --seed
```

Você pode executar iniciando um serviço na máquina local com o seguinte comando:

```ssh
$ php artisan serve
```

A aplicação irá rodar em [http://localhost:8000](http://localhost:8000) 

# Observações

#### Supervisord

O supervisor está sendo executado no servidor de produção para gerenciar os processos paralelos da aplicação (processamento de fichas, monitoramento de diretório, etc.)

Veja mais em: [https://laravel.com/docs/5.1/queues#supervisor-configuration]

#### Processamento das fichas (Queue Jobs)

Esse script pode ser executado com o comando `$ php artisan queue:listen`

Ele executa os Jobs que estão na fila (Saiba mais em [https://laravel.com/docs/5.1/queues])

Nome do worker supervisord: sas-processamento-worker

#### SasWatcher

Este script pode ser executado com o comando `$ php artisan sas:watcher <dir>`.

Ele monitora um diretório (informado por parametro) e detecta a criação de arquivos. Quando um arquivo com a extensão .tif for criado, ele tenta processá-lo.

Em produção, ele está monitorando o diretório `/digitalizacoes`

Nome do worker supervisord: sas-watcher-worker

#### Lexmark MX711

Esta multifuncional permite efetuar configurar aplicativos (Configurações > Apps > Gerenc. de apps) para salvar as digitalizações em um diretorio FTP. [Clique aqui](http://10.12.8.60) para ver o painel da multifuncional da T.I

Criamos a seguinte configuração para o SAS:

```ssh
FTP: 10.12.4.107 (porta: 21)
Directory: digitalizacoes
User: multifuncional
Senha: 123456
```

* Formato `.tif` (Um unico arquivo com várias páginas)
* 300dpi
* Preto e Branco
* Texto
* Escrever no diretório `/MultiMidia/FotosImagensVideosSons/Tecnologia da Informacao/SAS`

A multifuncional permite o usuário informar o nome do arquivo. Orientamos aos usuários do SAS informar neste campo o numero da turma.

Assim o nome do arquivo .tif será gravado no diretório da seguinte forma `{NUMERO_DA_TURMA}_YYYY_MM_DD_H_i_s_u.tif`

Obs: Arquivo de configurações exportado da interface da multifuncional para fazer importação: [scanToNet.ucf](scanToNet.ucf)

