# Sistema Web de Gestão de Usuários e Agendamentos - Clínica Calvier

Este projeto foi desenvolvido como parte do desafio técnico do processo seletivo **Iniciativa Dev Pool**. Trata-se de uma aplicação web completa que integra autenticação de usuários, gerenciamento de sessões e criação de agendamentos, utilizando uma arquitetura com isolamento de camadas onde o Frontend consome endpoints de uma API RESTful em PHP.

## 1. Tecnologias Utilizadas

* **Frontend:** HTML5, CSS3 (modularizado) e JavaScript Puro (Vanilla JS com Fetch API).
* **Backend:** PHP 8+ (Estruturado com respostas JSON e proteção de rotas via sessão).
* **Banco de Dados:** MySQL (utilizando a extensão `MySQLi` com *Prepared Statements* para prevenção contra SQL Injection).
* **Segurança:** Criptografia de senhas via `password_hash()` (BCrypt), validação de entrada no back-end, controle de sessão nativo (`$_SESSION`) e sanitização contra XSS no front-end.

## 2. Estrutura de Diretórios do Projeto

A organização atual dos arquivos e pastas está estruturada da seguinte forma:

```text
/
├── api/
│   ├── agendamentos.php       # Endpoints REST para criação de agendamentos
│   ├── conexao.php            # Configuração de conexão com o banco MySQL para a API
│   └── users.php              # Endpoints REST para CRUD completo de usuários
├── CSS/
│   ├── forms.css              # Estilos de formulários, cards, botões e tela de login
│   ├── global.css             # CSS geral, variáveis base e layout flexível
│   ├── nav.css                # Estilização do cabeçalho e barras de navegação
│   └── tabelas.css            # Estilização das tabelas
├── img/
│   ├── logo.PNG               # Logotipo principal
│   ├── logoo.png              # Logotipo adaptado para cabeçalho e rodapé
│   ├── medica.jpg             # Imagem ilustrativa da página inicial
│   └── rs.png                 # Imagem ilustrativa de notícias na página inicial
├── agendamento.js             # Lógica JS para consumo da API de agendamentos
├── agendamentos.php           # Interface protegida do painel de agendamentos
├── cadastro.php              # Tela de cadastro e edição de usuários
├── cadastro.js                # Lógica JS para envio e validação do cadastro
├── conexao.php                # Arquivo auxiliar de conexão com o banco de dados
├── index.html                 # Página inicial institucional (Ponto de entrada)
├── login.php                  # Tela de autenticação de usuários
├── logout.php                 # Script de encerramento seguro de sessão
├── processar_login.php        # Validação de credenciais e criação de sessão
├── usuarios.php              # Interface de listagem e gerenciamento de usuários
├── usuarios.js                # Lógica JS para listar e excluir usuários via API
├── verificar_sessao.php       # Middleware para proteção de páginas restritas
└── README.md                  # Documentação técnica do projeto
```

## 3. Configuração do Banco de Dados (SQL)

Para executar o projeto localmente, crie um banco de dados no seu servidor MySQL (ex: `clinica`) e execute o script SQL abaixo para gerar as tabelas necessárias:

```sql
CREATE DATABASE IF NOT EXISTS clinica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clinica;

-- Tabela de Usuários (Atendendo às regras de negócio e unicidade)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    login VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    data_hora DATETIME NOT NULL,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 4. Instruções de Instalação e Execução Local

1. **Clone o repositório** para a pasta pública do seu servidor web local (ex: `htdocs` no XAMPP):
   ```bash
   git clone https://github.com/luisgalli57/clinica.git clinica
   ```

2. **Inicie os Serviços:**
   * Abra o painel de controle do seu servidor local (ex: XAMPP) e inicie os módulos **Apache** e **MySQL**.

3. **Crie o Banco de Dados:**
   * Acesse o phpMyAdmin (`http://localhost/phpmyadmin`) ou seu cliente SQL preferido e execute o script detalhado na seção anterior.

4. **Verifique a Conexão:**
   * Confira os arquivos `api/conexao.php` e `conexao.php` para garantir que o host (`localhost`), usuário (`root`), senha e o nome do banco de dados correspondem ao seu ambiente local.

5. **Acesse a Aplicação:**
   * Abra o navegador e acesse `http://localhost/clinica` (que carregará automaticamente a página `index.html`).

## 5. Exemplos de Chamadas à API (Endpoints)

A comunicação entre o Frontend e o Backend é feita via JSON, respeitando os códigos de status HTTP padrão (`200 OK`, `201 Created`, `400 Bad Request`, `404 Not Found`).

### Usuários (`api/users.php`)

* **Listar todos os usuários (`GET /api/users.php`)**
  ```bash
  curl -X GET http://localhost/clinica/api/users.php
  ```

* **Cadastrar novo usuário (`POST /api/users.php`)**
  ```bash
  curl -X POST http://localhost/clinica/api/users.php \
       -H "Content-Type: application/json" \
       -d '{
             "name": "Maria Silva",
             "email": "maria@exemplo.com",
             "login": "mariasilva",
             "password": "SenhaForte123"
           }'
  ```

* **Atualizar usuário (`PUT /api/users.php?id=1`)**
  ```bash
  curl -X PUT "http://localhost/clinica/api/users.php?id=1" \
       -H "Content-Type: application/json" \
       -d '{
             "name": "Maria Oliveira Silva",
             "active": true
           }'
  ```

* **Excluir usuário (`DELETE /api/users.php?id=1`)**
  ```bash
  curl -X DELETE "http://localhost/clinica/api/users.php?id=1"
  ```

### Agendamentos (`api/agendamentos.php`)

* **Listar agendamentos (`GET /api/agendamentos.php`)**
  ```bash
  curl -X GET http://localhost/clinica/api/agendamentos.php
  ```

* **Criar agendamento (`POST /api/agendamentos.php`)**
  ```bash
  curl -X POST http://localhost/clinica/api/agendamentos.php \
       -H "Content-Type: application/json" \
       -d '{
             "titulo": "Consulta Clínica Geral",
             "data_hora": "2026-11-20T14:30",
             "descricao": "Avaliação de rotina."
           }'
  ```

* **Excluir agendamento (`DELETE /api/agendamentos.php?id=1`)**
  ```bash
  curl -X DELETE "http://localhost/clinica/api/agendamentos.php?id=1"
  ```