# 🎮 Portal de Notícias E-Sports

Sistema web desenvolvido para gerenciamento e exibição de notícias sobre **games e e-sports**, com área pública e painel administrativo.

---

## 📌 Sobre o Projeto

O **Portal de Notícias E-Sports** é uma aplicação web que permite:

- Exibir notícias de jogos para visitantes  
- Cadastro e login de usuários  
- Área administrativa para gerenciar conteúdo e usuários  
- Publicação, edição e exclusão de notícias  

Projeto desenvolvido utilizando **PHP, MySQL, HTML e CSS**.

---

## 🚀 Funcionalidades

### 👥 Usuário
- Cadastro de conta  
- Login e logout  
- Visualização de notícias  
- Acesso a página individual de cada notícia  

### 📰 Notícias
- Listagem na página inicial  
- Visualização completa  
- Organização por data  

### 🔐 Admin
- Login administrativo  
- Criar novas notícias  
- Editar notícias existentes  
- Excluir notícias  
- Gerenciar usuários  

---

## 🛠️ Tecnologias Utilizadas

- PHP  
- MySQL  
- HTML5  
- CSS3  
- XAMPP  

---

## 📂 Estrutura do Projeto

    Site_E-Sports/
    │
    ├── admin/
    ├── assets/
    │   ├── css/
    │   └── img/
    │
    ├── include/
    │   ├── conexao.php
    │   ├── funcoes.php
    │   ├── verifica_login.php
    │   └── verifica_admin.php
    │
    ├── public/
    │   ├── index.php
    │   ├── login.php
    │   ├── cadastro.php
    │   └── noticia.php
    │
    └── noticiasge.sql

---

## ⚙️ Como Executar

### 1. Iniciar o XAMPP
- Apache  
- MySQL  

### 2. Banco de Dados
- Criar banco: **noticiasge**  
- Importar: **noticiasge.sql**  

### 3. Configurar Conexão

Arquivo: `include/conexao.php`

    $host = "localhost";
    $db   = "noticiasge";
    $user = "root";
    $pass = "";

### 4. Executar

Colocar a pasta dentro de:

    htdocs

Acessar no navegador:

    http://localhost/Site_E-Sports/public

---

## 🔑 Acesso

- Usuário: cadastro livre  
- Admin: definido no banco de dados  

---

## 🎯 Objetivo

- Praticar CRUD com PHP  
- Implementar login e autenticação  
- Criar painel administrativo  
- Desenvolver sistema completo (front + back-end)  

---

## 📈 Melhorias Futuras

- Sistema de categorias  
- Upload de imagens  
- Comentários nas notícias  
- Sistema de likes  
- Responsividade  
- Dashboard mais avançado  

---

## 👨‍💻 Autor

**Gabriel Santos de Sandes**  
Projeto acadêmico - Técnico em Informática
