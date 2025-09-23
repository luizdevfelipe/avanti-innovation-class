# 📦 Sistema de Controle de Estoque - Avanti Innovation Class

Um sistema completo de gerenciamento de inventário desenvolvido em **PHP** com arquitetura **MVC**, containerizado com **Docker** e com autenticação de usuários robusta.

<p align="center">
 <img width="500" height="300" src="https://github.com/user-attachments/assets/65cc3f68-3458-4a15-8192-e37ca2a1a720" alt="Dashboard">
</p>

## 🖼️ Veja Imagens [Aqui](https://github.com/luizdevfelipe/avanti-innovation-class/issues/1)

## 🚀 Tecnologias Utilizadas

- **PHP 8.1** com PHP-FPM
- **MySQL 8.0** para banco de dados
- **Nginx** como servidor web
- **Docker & Docker Compose** para containerização
- **Composer** para gerenciamento de dependências

## 🏗️ Arquitetura do Projeto

O projeto segue o padrão **MVC (Model-View-Controller)** com as seguintes camadas:

```
src/
├── Controllers/       # Controladores (AuthController, ProductsController)
├── Core/              # Classes principais (Application, Router, Request, etc.)
├── Models/            # Modelos de dados (BaseModel, ProductModel, UserModel)
├── Services/          # Lógica de negócio (ProductService, UserService)
├── Views/             # Interfaces de usuário (dashboard.php, login.php)
└── public/            # Ponto de entrada da aplicação (index.php)
```

## 🐳 Configuração Inicial com Docker

### 1. Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) instalado
- [Docker Compose](https://docs.docker.com/compose/install/) instalado

### 2. Clone o Repositório

```bash
git clone https://github.com/luizdevfelipe/avanti-innovation-class.git
cd avanti-innovation-class
```

### 3. Configuração de Ambiente

Copie o arquivo de configuração de exemplo:

```bash
cd docker
cp .env.example .env
```

O arquivo `.env` contém as seguintes configurações padrão:

```env
DB_HOST=mysql-server
DB_USER=root
DB_PASSWORD=pass
DB_DATABASE=avanti_test
FORWARD_DB_PORT=3306
COMPOSE_PROJECT_NAME=avanti-test
```

### 4. Subir os Containers

```bash
# A partir do diretório docker/
docker-compose up -d
```

Este comando irá:
- 🐘 **PHP-FPM**: Executar a aplicação PHP
- 🌐 **Nginx**: Servir a aplicação na porta 8000
- 🗄️ **MySQL**: Banco de dados na porta 3306

### 5. Instalar Dependências

```bash
# Entrar no container da aplicação
docker exec -it avanti-test-app bash

# Instalar dependências do Composer
composer install
```

### 6. Configurar Banco de Dados

Importe os schemas do banco de dados:

```bash
# Importar os arquivos externos (Via terminal WLS/Bash)
docker exec -i mysql-server mysql -u root -ppass avanti_test < schemas/avanti_test_users.sql
docker exec -i mysql-server mysql -u root -ppass avanti_test < schemas/avanti_test_products.sql

# Importar os arquivos externos (Via terminal PowerShell)
Get-Content .\schemas\avanti_test_users.sql | docker exec -i mysql-server mysql -u root -ppass avanti_test
Get-Content .\schemas\avanti_test_products.sql | docker exec -i mysql-server mysql -u root -ppass avanti_test
```

### 7. Criar um usuário

```bash
# Conectar ao MySQL
docker exec -it mysql-server mysql -u root -ppass avanti_test

# A senha está sendo manipulada em texto puro, o que não é o ideal em uma aplicação real!
INSERT INTO avanti_test.users (name, email, password) VALUES ('usuario', 'email@email.com', '123123123');
```

### 8. Acessar a Aplicação

Acesse: [http://localhost:8000](http://localhost:8000)

## 🔐 Sistema de Autenticação

### Funcionalidades de Login

- **Validação de entrada rigorosa** para email e senha
- **Proteção de sessão** com regeneração de ID
- **Redirecionamento automático** para usuários logados
- **Logout seguro** com destruição completa da sessão

### Exemplo de Validação de Login

```php
// Validações aplicadas no AuthController
$errors = $this->request->validate($data, [
    'email' => ['required', 'email'],
    'password' => ['required', 'string']
]);
```

**Mensagens de erro personalizadas:**
- ✅ "Email" é obrigatório. || ✅ "Email" deve ser um endereço de email válido.
- ✅ "Senha" é obrigatório.
- ✅ "Credenciais" inválidas, verifique seu usuário e senha.

## 📦 Gerenciamento de Produtos

### Funcionalidades Principais

1. **➕ Adicionar Produtos**
2. **📝 Editar Produtos**
3. **🗑️ Remover Produtos**
4. **🔍 Pesquisar Produtos**
5. **📊 Visualizar Inventário**

### Sistema de Validação Robusto

O sistema possui validações implementadas na classe `Request`:

#### Regras de Validação Disponíveis:

| Regra | Descrição | Exemplo de Uso |
|-------|-----------|----------------|
| `required` | Campo obrigatório | `'name' => ['required']` |
| `string` | Deve ser texto | `'name' => ['string']` |
| `string:null` | Texto ou vazio | `'description' => ['string:null']` |
| `email` | Email válido | `'email' => ['email']` |
| `float` | Número decimal | `'price' => ['float']` |
| `float:null` | Decimal ou vazio | `'price' => ['float:null']` |
| `integer` | Número inteiro | `'quantity' => ['integer']` |
| `integer:null` | Inteiro ou vazio | `'quantity' => ['integer:null']` |

#### Exemplo de Validação para Produtos:

```php
// Validações aplicadas no ProductsController
$errors = $this->request->validate($data, [
    'name' => ['required', 'string'],        // Nome obrigatório
    'sku' => ['required', 'string'],         // SKU obrigatório e único
    'category' => ['string:null'],           // Categoria opcional
    'price' => ['float:null'],               // Preço opcional (decimal)
    'quantity' => ['integer:null'],          // Quantidade opcional (inteiro)
    'supplier' => ['string:null'],           // Fornecedor opcional
    'description' => ['string:null'],        // Descrição opcional
]);
```

#### Mensagens de Erro Personalizadas:

- ✅ **"Nome" é obrigatório** - quando nome não é fornecido
- ✅ **"Preço" deve ser um número decimal ou vazio.** - quando preço não é numérico
- ✅ **"Quantidade" deve ser um número inteiro ou vazio.** - quando quantidade é inválida
- ✅ **"SKU já existe!"** - prevenção de duplicatas

### Rotas Definidas

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/dashboard` | Visualizar inventário |
| `POST` | `/products` | Adicionar produto |
| `GET` | `/products?q=termo` | Pesquisar produtos |
| `GET` | `/products/{id}` | Obter dados do produto |
| `POST` | `/products/{id}/edit` | Editar produto |
| `POST` | `/products/{id}/delete` | Remover produto |

### Estrutura do Banco de Dados

#### Tabela `users`:
```sql
- id (int, auto_increment, primary key)
- name (varchar 255, not null)
- email (varchar 255, not null)
- password (varchar 255, not null)
```

#### Tabela `products`:
```sql
- id (int, auto_increment, primary key)
- SKU (varchar 255, not null, unique)
- name (varchar 255, not null)
- description (varchar 1000, nullable)
- category (varchar 255, nullable)
- price (decimal, nullable)
- quantity (int, nullable)
- supplier (varchar 255, nullable)
```

## 🔒 Recursos de Segurança

- **Validação de entrada** em todos os formulários
- **Sanitização de dados** antes de inserção no banco e nas páginas
- **Prevenção de duplicatas** com validação de SKU único
- **Sessões seguras** com configurações `httponly` e `secure`
- **Regeneração de ID de sessão** no login
- **Logout completo** com destruição da sessão

## 📁 Estrutura de Diretórios

```
avanti-innovation-class/
├── docker/                 # Configurações Docker
│   ├── docker-compose.yml  # Orquestração dos containers
│   ├── Dockerfile          # Imagem da aplicação PHP
│   ├── .env                # Variáveis de ambiente
│   └── nginx/              # Configurações do Nginx
├── schemas/                # Scripts SQL para criação do banco
├── src/                    # Código fonte da aplicação
│   ├── Controllers/        # Controladores MVC
│   ├── Core/               # Classes principais do framework
│   ├── Models/             # Modelos de dados
│   ├── Services/           # Lógica de negócio
│   ├── Views/              # Templates HTML/PHP
│   ├── public/             # Ponto de entrada (index.php)
│   └── tests/              # Testes automatizados
├── vendor/                 # Dependências do Composer
├── composer.json           # Configuração do Composer
└── README.md              # Este arquivo
```

## 📄 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

---

**Desenvolvido com ❤️ para a Avanti Innovation Class**
