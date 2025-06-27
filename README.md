# Prompt Builder – Desafio Técnico Full Stack WordPress

Este repositório contém a solução do desafio técnico para desenvolvedor(a) Full Stack WordPress para a Jobs, com foco em back-end (PHP, MySQL, WordPress) e front-end (JS/UX).

## Sobre o Projeto

O projeto consiste em um plugin WordPress chamado **Prompt Builder**, que permite ao usuário gerar prompts estruturados a partir de um briefing e requisitos personalizados.

## Tecnologias utilizadas

- WordPress 6.5 LTS
- PHP 8.1
- MariaDB 10.6
- Docker + Docker Compose
- WP REST API
- JavaScript (Vanilla + Bootstrap)
- PHPUnit 9
- WP-CLI (para gerar `.pot` de tradução)

## Como rodar o ambiente local

1. **Clone este repositório:**

```bash
git clone https://github.com/seu-usuario/desafio-jobs.git
cd desafio-jobs
```

2. **Crie o arquivo `.env` na raiz com:**

```env
DB_NAME=wordpress
DB_USER=wordpress
DB_PASSWORD=wordpress
DB_ROOT_PASSWORD=root
```

3. **Suba os containers:**

```bash
docker-compose up -d
```

4. **Acesse:**

- WordPress: http://localhost:8000
- phpMyAdmin: http://localhost:8080

5. **Finalize a instalação do WordPress via navegador.**

## Estrutura esperada

```
.
├── docker-compose.yml
├── .env
├── wp-content/
│   └── plugins/
│       └── prompt-builder/
├── README.md
```

## Funcionalidades do Plugin (resumo)

- Campo de prompt base (textarea)
- Lista dinâmica de requisitos (key → value)
- Geração de prompt formatado
- Criação de post rascunho com o prompt (bônus)
- Submissão assíncrona via REST API
- Proteções XSS/CSRF
- UI responsiva com Bootstrap
- Testes unitários com PHPUnit
- Internacionalização via `.pot`

## Rodando os testes

```bash
cd wp-content/plugins/prompt-builder
vendor/bin/phpunit
```

## Licença

Este projeto está sob licença GNU v3.