
# API RESTful - CRUD de Carros (Porsche, Ferrari e Lamborghini)

Esta é uma API RESTful didática construída para fins de aprendizado, focada em carros esportivos (Porsche, Ferrari e Lamborghini). A API implementa conceitos de **REST** e **MVC**, utilizando **DAOs** (Data Access Objects) para abstrair o acesso ao banco de dados e **Middlewares** para validações e controle de acesso, permitindo realizar as operações **CRUD** (Criar, Ler, Atualizar e Deletar) nas tabelas **Marca**, **Carro** e **Tipo de Carro**.

A API foi projetada de forma simples e eficiente, com o objetivo de ensinar como estruturar uma API usando o padrão **REST**, **MVC**, **DAO** e **Middleware**.

### Recursos:

*   CRUD completo para **Marca**, **Carro** e **Tipo de Carro**.
*   Utiliza **REST** para comunicação.
*   Implementação de **MVC** com camadas **DAO**.
*   **Middlewares** para validações e autenticação.
*   Foco no aprendizado e na simplicidade de implementação.

---

## 🚀 Funcionalidades

*   **GET /marcas**: Lista todas as marcas.
*   **GET /marcas/{id}**: Retorna uma marca específica.
*   **POST /marcas**: Cria uma nova marca (Requer autenticação via `AuthMiddleware`).
*   **PUT /marcas/{id}**: Atualiza uma marca existente (Requer autenticação via `AuthMiddleware`).
*   **DELETE /marcas/{id}**: Deleta uma marca (Requer autenticação via `AuthMiddleware`).
*   **GET /tiposcarro**: Lista todos os tipos de carro.
*   **GET /tiposcarro/{id}**: Retorna um tipo de carro específico.
*   **POST /tiposcarro**: Cria um novo tipo de carro (Requer autenticação via `AuthMiddleware` e validação via `TipoCarroMiddleware`).
*   **PUT /tiposcarro/{id}**: Atualiza um tipo de carro existente (Requer autenticação via `AuthMiddleware` e validação via `TipoCarroMiddleware`).
*   **DELETE /tiposcarro/{id}**: Deleta um tipo de carro (Requer autenticação via `AuthMiddleware`).
*   **GET /carros**: Lista todos os carros (inclui nome da marca e nome do tipo de carro).
*   **GET /carros/{id}**: Retorna um carro específico (inclui nome da marca e nome do tipo de carro).
*   **POST /carros**: Cria um novo carro (Requer autenticação via `AuthMiddleware`).
*   **PUT /carros/{id}**: Atualiza um carro existente (Requer autenticação via `AuthMiddleware`).
*   **DELETE /carros/{id}**: Deleta um carro (Requer autenticação via `AuthMiddleware`).

---

## 🛠️ Tecnologias Utilizadas

*   **PHP 8.x ou superior**
*   **PDO** para interação com o banco de dados.
*   **MySQL/MariaDB** para persistência de dados.
*   **MVC** para organização do código.
*   **DAO** para abstração da camada de dados.
*   **Middlewares** para validação e autenticação.
*   **REST** para a estrutura da API.

---

## 📋 Requisitos

*   PHP 8.x ou superior.
*   Banco de dados MySQL ou MariaDB.

## 💻 Instalação

1.  Clone este repositório:
    ```bash
    git clone https://github.com/seu-usuario/api-carros.git
    ```
2.  Navegue até a pasta do projeto:
    ```bash
    cd api-carros
    ```
3.  Configure as credenciais do banco de dados no arquivo `system/Database.php`.
    *   `private $host = 'localhost';`
    *   `private $db_name = 'api_carros';`
    *   `private $username = 'root';`
    *   `private $password = '';`
4.  Crie o banco de dados e as tabelas necessárias. Um exemplo de estrutura SQL está disponível na pasta `db/` (`db/schema.sql`).
5.  Inicie o servidor PHP:
    ```bash
    php -S localhost:8000
    ```

---

## 🔑 Endpoints

### Autenticação

Para as rotas que exigem autenticação (`POST`, `PUT`, `DELETE`), você precisará enviar um cabeçalho `Authorization` com um token Bearer. Exemplo:

`Authorization: Bearer your_secret_token`

O token configurado para validação é `your_secret_token` no arquivo `system/middleware/AuthMiddleware.php`.

### Marca

*   **GET /marcas**
    *   Descrição: Lista todas as marcas.
    *   Resposta (Exemplo):
        ```json
        [
          {
            "idMarca": 1,
            "nomeMarca": "Porsche"
          }
        ]
        ```
*   **GET /marcas/{id}**
    *   Descrição: Retorna uma marca específica.
    *   Parâmetros:
        *   `id` (int): ID da marca.
    *   Resposta (Exemplo):
        ```json
        {
          "idMarca": 1,
          "nomeMarca": "Ferrari"
        }
        ```
*   **POST /marcas** (Requer autenticação)
    *   Descrição: Cria uma nova marca.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "nomeMarca": "Lamborghini"
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Marca criada com sucesso."
        }
        ```
*   **PUT /marcas/{id}** (Requer autenticação)
    *   Descrição: Atualiza uma marca existente.
    *   Parâmetros:
        *   `id` (int): ID da marca.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "nomeMarca": "McLaren"
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Marca atualizada com sucesso."
        }
        ```
*   **DELETE /marcas/{id}** (Requer autenticação)
    *   Descrição: Deleta uma marca específica.
    *   Parâmetros:
        *   `id` (int): ID da marca.
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Marca deletada com sucesso."
        }
        ```

---

### Tipo de Carro

*   **GET /tiposcarro**
    *   Descrição: Lista todos os tipos de carro.
    *   Resposta (Exemplo):
        ```json
        [
          {
            "idTipoCarro": 1,
            "nomeTipoCarro": "Esportivo"
          }
        ]
        ```
*   **GET /tiposcarro/{id}**
    *   Descrição: Retorna um tipo de carro específico.
    *   Parâmetros:
        *   `id` (int): ID do tipo de carro.
    *   Resposta (Exemplo):
        ```json
        {
          "idTipoCarro": 1,
          "nomeTipoCarro": "SUV"
        }
        ```
*   **POST /tiposcarro** (Requer autenticação e validação)
    *   Descrição: Cria um novo tipo de carro.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "nomeTipoCarro": "Sedan"
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Tipo de carro criado com sucesso."
        }
        ```
*   **PUT /tiposcarro/{id}** (Requer autenticação e validação)
    *   Descrição: Atualiza um tipo de carro existente.
    *   Parâmetros:
        *   `id` (int): ID do tipo de carro.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "nomeTipoCarro": "Hatch"
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Tipo de carro atualizado com sucesso."
        }
        ```
*   **DELETE /tiposcarro/{id}** (Requer autenticação)
    *   Descrição: Deleta um tipo de carro específico.
    *   Parâmetros:
        *   `id` (int): ID do tipo de carro.
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Tipo de carro deletado com sucesso."
        }
        ```

---

### Carro

*   **GET /carros**
    *   Descrição: Lista todos os carros (inclui nome da marca e nome do tipo de carro).
    *   Resposta (Exemplo):
        ```json
        [
          {
            "idCarro": 1,
            "modelo": "911 Carrera",
            "ano": 2023,
            "idMarca": 1,
            "nomeMarca": "Porsche",
            "idTipoCarro": 1,
            "nomeTipoCarro": "Esportivo"
          }
        ]
        ```
*   **GET /carros/{id}**
    *   Descrição: Retorna um carro específico (inclui nome da marca e nome do tipo de carro).
    *   Parâmetros:
        *   `id` (int): ID do carro.
    *   Resposta (Exemplo):
        ```json
        {
          "idCarro": 1,
          "modelo": "F8 Tributo",
          "ano": 2022,
          "idMarca": 2,
          "nomeMarca": "Ferrari",
          "idTipoCarro": 1,
          "nomeTipoCarro": "Esportivo"
        }
        ```
*   **POST /carros** (Requer autenticação)
    *   Descrição: Cria um novo carro.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "modelo": "Huracan EVO",
          "ano": 2024,
          "idMarca": 3,
          "idTipoCarro": 1
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Carro criado com sucesso."
        }
        ```
*   **PUT /carros/{id}** (Requer autenticação)
    *   Descrição: Atualiza um carro existente.
    *   Parâmetros:
        *   `id` (int): ID do carro.
    *   Corpo da requisição (Exemplo):
        ```json
        {
          "modelo": "Revuelto",
          "ano": 2024,
          "idMarca": 3,
          "idTipoCarro": 1
        }
        ```
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Carro atualizado com sucesso."
        }
        ```
*   **DELETE /carros/{id}** (Requer autenticação)
    *   Descrição: Deleta um carro específico.
    *   Parâmetros:
        *   `id` (int): ID do carro.
    *   Resposta (Exemplo):
        ```json
        {
          "message": "Carro deletado com sucesso."
        }
        ```

---

## 📜 Licença

Esta API é licenciada sob a **MIT License**.

---

Se você tiver dúvidas ou sugestões, sinta-se à vontade para **abrir um problema** ou **contribuir**!
