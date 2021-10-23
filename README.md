## Sobre o projeto

API desenvolvida para cadastrar produtos e controlar suas movimentações de entrada e saída no estoque.

## Tabela de conteúdos

<p align="center">
    <ol>
    <li><a href="#funcionalidades">Funcionalidades</a></li>
    <li><a href="#instalacao">Instalação</a></li>
    <ul>
        <li><a href="#configurando-env">Configurando .env</a></li>
        <li><a href="#gerando-banco">Gerando tabelas do banco de dados</a></li>
        <li><a href="#executando-projeto">Executando o projeto</a></li>
    </ul>
    <li><a href="#tecnologias">Tecnologias utilizadas</a></li>
    <li><a href="#documentacao">Documentação da API</a></li>
    </ol>
</p>


<!-- FUNCIONALIDADES -->
## Funcionalidades

- [X] Cadastro de Produtos
- [X] Controle de movimentação dos produtos
- [X] Consulta do saldo atual do estoque


<!-- INSTALAÇÃO -->
## Instalação

- Clone o repositório em uma pasta

```bash
$ git clone https://github.com/mzcs84Jj/app-df879d
```

- Acesse a pasta do projeto no terminal

```bash
$ cd app-df879d
```

- Instale as dependências

```bash
$ composer install
```


<!-- CONFIGURANDO ENV -->
### Configurando .env
- Renomeie o arquivo .env.example para o .env
- Altere os dados de acesso ao banco de dados conforme as suas configurações locais


<!-- GERANDO BANCO -->
### Gerando tabelas do banco de dados Mysql
- Crie um banco de dados Mysql com o nome <i>app-df879d</i>
- Caso queira escolher outro nome, altere o valor do <b>DB_DATABASE</b> no seu .env
- Para gerar as tabelas, execute no terminal:

```bash
$ php artisan migrate
```


<!-- EXECUTANDO PROJETO -->
## Executando o projeto
- Para rodar o servidor, execute no terminal:

```bash
$ php artisan serve
```


<!-- TECNOLOGIAS -->
## Tecnologias utilizadas

As seguintes tecnologias foram utilizadas no projeto:

- [PHP] - Versão 8.0.8
- [Laravel] - Framework PHP Laravel - Versão 8.65
- [Mysql] - Banco de dados Mysql
- [Composer] - Gerenciamento de dependências
- [Git] - Versionamento
- [l5-swagger] - Criação da documentação - https://github.com/DarkaOnLine/L5-Swagger


<!-- DOCUMENTACAO -->
## Documentação da API
- Com o servidor rodando, acesse a url
http://127.0.0.1:8000/api/docs
para ter acesso a documentação dos endpoints.

