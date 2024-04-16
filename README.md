# Fullstack Challenge - Onfly 20231205

[![PHP Version](https://img.shields.io/badge/PHP-8.3-red.svg?style=flat)](https://secure.php.net/manual/en/versioning.php)
[![Laravel Version](https://img.shields.io/badge/Laravel-11-orange.svg?style=flat)](https://laravel.com/)
[![Vue Version](https://img.shields.io/badge/Vue-3.x-green.svg?style=flat)](https://vuejs.org/)
[![Nuxt Version](https://img.shields.io/badge/Nuxt-3-blue.svg?style=flat)](https://nuxtjs.org/)
[![Docker Version](https://img.shields.io/badge/Docker-gray.svg?style=flat)](https://docs.docker.com/)

Desafio Onfly para cargo de Dev Full Stack.

## Introdução

Antes de mais nada, muito obrigado pela oportunidade! Espero que tudo dê certo, será um prazer fazer parte do time Onfly.

## Tecnologias

A aplicação foi criada dentro da arquitetura monorepo para uma maior facilidade de distribuição.

Os arquivos e tabelas foram pensados de forma modular para facilitar a separação de responsabilidades. Para esse desafio, concluí que seriam necessários dois módulos: A base da aplicação, denominada pelo prefixo `app`, e o módulo responsável pela parte financeira, denominado pelo prefixo `financial`. Utilizando os prefixos corretamente, arquivos do sistema e tabelas no banco ficariam visualmente próximos, facilitando a localização e melhorando a organização.

Para o backend, foi utilizado o framework PHP 8.3 com Laravel 11, e para o frontend, Vue 3 com o framework Nuxt 3.

Além da aplicação, foram criados mais alguns serviços para auxiliar o desenvolvimento, sendo eles PHPMyAdmin, para visualização simplificada do banco de dados, e Swagger, para visualização dos endpoints da API.

Todas as telas foram pensados de maneira responsiva.

## Iniciando a aplicação

Para inicializar a aplicação, basta executar o comando abaixo na pasta raiz do repositório.

```bash
yarn dev
```

A aplicação instala as dependências de todos os serviços e executa as migrations e seeds do banco de dados, portanto você não precisa executar mais nenhum comando.

Se tudo ocorrer bem, a aplicação estará disponível nas seguintes portas:

| Serviço    | URL                   |
| ---------- | --------------------- |
| Backend    | http://localhost:8000 |
| Frontend   | http://localhost:3000 |
| PHPMyAdmin | http://localhost:8081 |
| Swagger    | http://localhost:8100 |

Abaixo, os dados de login padrão:

|        |             |
| ------ | ----------- |
| E-mail | main@grr.la |
| Senha  | main@grr.la |

## Observações finais

Alguns problemas que não tive tempo de melhorar, sendo os principais:

- Não conheço a fundo o Quasar Frameworl, por conta disso, não consegui implementar a alteração de pagina nos datatables. Um pouco mais de tempo para estudar a documentação e isso seria resolvido.

- Não tive tempo o suficiente para criar mais camadas de teste. Criei o básico via rest por acreditar ser o mais importante, mas tenho ciência de testes mockados com injeção de dependência.

- Não tive tempo para criar formatações de dados no datatable, as datas estão sendo exibidas em formato cru.

<br />
<br />

Muito obrigado!

> This is a challenge by [Coodesh](https://coodesh.com/)
