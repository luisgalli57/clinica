# Sistema Web de Gestão de Usuários e Criação de Agendamentos

Este projeto foi desenvolvido como parte do desafio técnico do processo seletivo **Iniciativa Dev Pool**. Trata-se de uma aplicação web completa que integra autenticação de usuários, gerenciamento de sessões e criação de agendamentos através de uma arquitetura desacoplada, onde o Frontend consome endpoints de uma API RESTful.

---

## 1. Tecnologias Utilizadas

* **Frontend:** HTML5, CSS3 e JavaScript Puro (Vanilla JS com Fetch API).
* **Backend:** PHP 8+ (Estruturado com foco em isolamento de camadas e respostas JSON).
* **Banco de Dados:** MySQL (utilizando a extensão `MySQLi` com *Prepared Statements* para prevenção contra SQL Injection).
* **Segurança:** Criptografia de senhas via `password_hash()` (BCrypt), controle de sessão nativo (`$_SESSION`) e sanitização de saídas contra XSS.

---

## 2. Estrutura de Diretórios

```text
/
├── api/
│   ├── conexao.php          # Configuração e conexão com o banco de dados MySQL
│   ├── users.php            # Endpoints REST para CRUD de usuários
│   └── agendamentos.php     # Endpoints REST para criação de agendamentos
├── assets/
│   ├── style.css            # Folha de estilos da aplicação
│   └── agendamentos.js      # Lógica de consumo da API e manipulação do DOM
├── agendamentos.php         # Tela de criação de agendamentos
├── login.php                # Tela de autenticação de usuários
├── logout.php               # Script de encerramento seguro de sessão
├── processar_cadastro.php   # Processamento de registro de novos usuários
├── processar_login.php      # Validação de credenciais e criação de sessão
├── verificar_sessao.php     # Middleware para proteção de rotas autenticadas
└── README.md                # Documentação do projeto
```

---

## 3. Configuração do Banco de Dados (SQL)

Para rodar o projeto localmente, crie um banco de dados no seu servidor MySQL (ex: `clinica`) e execute o script SQL abaixo para criar as tabelas necessárias:

```sql
CREATE DATABASE IF NOT EXISTS clinica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clinica;

-- Tabela de Usuários
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

---

## 4. Instruções de Instalação e Execução Local

1. **Clone o repositório** para a pasta pública do seu servidor web local (ex: `htdocs` no XAMPP):
   ```bash
   git clone <URL_DO_SEU_REPOSITORIO>
   ```
2. **Configure o Banco de Dados:**
   * Inicie os serviços do **Apache** e **MySQL**.
   * Execute o script SQL detalhado na seção anterior através do phpMyAdmin ou terminal MySQL.
3. **Ajuste a Conexão:**
   * Abra o arquivo `api/conexao.php` e verifique se as credenciais (`host`, `usuario`, `senha` e `banco`) correspondem ao seu ambiente local.
4. **Acesse a Aplicação:**
   * Abra o navegador e acesse `http://localhost/nome-da-pasta/login.php`.

---

## 5. Exemplos de Chamadas à API (Endpoints)

A comunicação entre o cliente e o servidor é realizada via JSON, respeitando os códigos de status HTTP padrão (`200 OK`, `201 Created`, `400 Bad Request`, `404 Not Found`).

### Usuários (`api/users.php`)

* **Listar todos os usuários (`GET /api/users.php`)**
  ```bash
  curl -X GET http://localhost/nome-da-pasta/api/users.php
  ```

* **Cadastrar novo usuário (`POST /api/users.php`)**
  ```bash
  curl -X POST http://localhost/nome-da-pasta/api/users.php \
       -H "Content-Type: application/json" \
       -d '{
             "name": "Micael Calza",
             "email": "micael@exemplo.com",
             "login": "micaelcalza",
             "password": "SenhaForte123"
           }'
  ```

* **Atualizar usuário (`PUT /api/users.php?id=1`)**
  ```bash
  curl -X PUT "http://localhost/nome-da-pasta/api/users.php?id=1" \
       -H "Content-Type: application/json" \
       -d '{
             "name": "Micael Calza",
             "active": true
           }'
  ```

* **Excluir usuário (`DELETE /api/users.php?id=1`)**
  ```bash
  curl -X DELETE "http://localhost/nome-da-pasta/api/users.php?id=1"
  ```

### Agendamentos (`api/agendamentos.php`)

* **Criar agendamento (`POST /api/agendamentos.php`)**
  ```bash
  curl -X POST http://localhost/nome-da-pasta/api/agendamentos.php \
       -H "Content-Type: application/json" \
       -d '{
             "titulo": "Consulta médica",
             "data_hora": "2026-11-20T14:30",
             "descricao": "Dor de cabeça."
           }'
  ```