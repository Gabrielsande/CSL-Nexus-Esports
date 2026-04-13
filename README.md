# 🎮 Nexus Esports

Portal de notícias sobre games e e-sports desenvolvido com PHP, MySQL, HTML, CSS e JavaScript.  
O sistema permite publicação, visualização e gerenciamento de notícias com interface moderna e responsiva.

---

## 📌 Sobre o Projeto

O **Nexus Esports** é um portal digital focado no universo gamer, trazendo:

- 📰 Notícias atualizadas  
- 🏆 Cobertura de e-sports  
- 🚀 Lançamentos de jogos  
- 💡 Dicas e conteúdos exclusivos  

O projeto conta com um sistema administrativo para criação e gerenciamento de notícias.

---

## 🛠️ Tecnologias Utilizadas

- 💻 PHP (Backend)  
- 🗄️ MySQL (Banco de Dados)  
- 🎨 HTML5 + CSS3  
- ⚡ JavaScript  
- 🌐 API de Clima (Open-Meteo)  

---

## 📂 Estrutura do Projeto

```
Site_E-sports/
│
├── admin/
├── assets/
├── include/
├── public/
└── noticiasge.sql
```

---

## 🗄️ Banco de Dados

O sistema utiliza um banco MySQL chamado **`noticiasge`**.

### 🔹 Tabela: `usuarios`

Armazena os usuários do sistema.

| Campo  | Tipo     | Descrição                  |
|--------|---------|---------------------------|
| id     | INT     | Identificador do usuário  |
| nome   | VARCHAR | Nome do usuário           |
| email  | VARCHAR | Email                     |
| senha  | VARCHAR | Senha criptografada       |
| tipo   | VARCHAR | admin ou comum            |

---

### 🔹 Tabela: `noticias`

Armazena as notícias publicadas.

| Campo     | Tipo     | Descrição                       |
|-----------|---------|--------------------------------|
| id        | INT     | ID da notícia                  |
| titulo    | VARCHAR | Título                         |
| noticia   | TEXT    | Conteúdo                       |
| imagem    | VARCHAR | Nome da imagem                 |
| autor     | INT     | ID do usuário (FK)             |
| data      | DATETIME| Data de publicação             |
| categoria | VARCHAR | Categoria da notícia           |

---

### 🔗 Relacionamento

- Uma notícia pertence a um usuário (autor)

```
noticias.autor → usuarios.id
```

---

## ⚙️ Funcionalidades

### 👤 Usuário
- Cadastro e login  
- Visualização de notícias  
- Busca por palavras-chave  
- Filtro por categorias  

### 🛠️ Administrador
- Criar notícias  
- Gerenciar usuários  
- Acesso ao dashboard  

### 🌐 Sistema
- Modo claro/escuro 🌙☀️  
- Interface responsiva  
- Categorias dinâmicas  
- Exibição de temperatura  

---

## 🗂️ Categorias

- 🎮 Games  
- 🏆 E-Sports  
- 🥇 Campeonatos  
- 🚀 Lançamentos  
- 🔍 Análises  
- 💡 DicasNexus  

---

## 🧪 Como Executar o Projeto

### 📌 Pré-requisitos:
- XAMPP ou similar  
- PHP 7+  
- MySQL  

---

### 🚀 Passos:

1. Coloque o projeto em:
```
C:\xampp\htdocs\
```

2. Inicie o XAMPP (Apache + MySQL)

3. Acesse:
```
http://localhost/phpmyadmin
```

4. Crie um banco chamado:
```
noticiasge
```

5. Importe o arquivo:
```
noticiasge.sql
```

6. Execute o sistema:
```
http://localhost/Site_E-sports/public
```

---

## 🔐 Sistema de Login

- Usuário comum: acesso ao conteúdo  
- Administrador: acesso ao painel  

---

## 🎨 Diferenciais

- Layout moderno estilo portal real  
- Código organizado com includes  
- Sistema dinâmico com PHP + MySQL  
- Experiência interativa  

---

## 👨‍💻 Autor

**Gabriel Santos de Sandes**  
Estudante de Ensino Médio Técnico  

---

## 📚 Objetivo

Aplicar conhecimentos de:

- Desenvolvimento Web  
- Banco de Dados  
- Programação  
- Interface de Usuário  

---

## 🚀 Melhorias Futuras

- Sistema de comentários  
- Curtidas nas notícias  
- Upload avançado de imagens  
- API de jogos  

---

## 🏁 Conclusão

O **Nexus Esports** é um projeto completo que demonstra habilidades em desenvolvimento web full stack, com foco em organização, funcionalidade e design moderno.
