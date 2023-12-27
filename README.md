# RPC - Gerenciamento de tarefas

Este é um projeto backend API REST desenvolvido em Laravel 10 utilizando o ambiente de contêineres Sail para facilitar a configuração e gerenciamento do ambiente de desenvolvimento. O sistema é um gerenciador de tarefas com funcionalidades básicas, incluindo a criação, edição, listagem e exclusão de tarefas, bem como a associação de tags às tarefas.

## Pré-requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configuração do Ambiente

1. **Clone o repositório:**

    ```bash
    git clone https://github.com/brunopoyer/rpc_backend.git
    cd rpc_backend
    ```

2. **Copie o arquivo de exemplo de ambiente e configure conforme necessário:**

    ```bash
    cp .env.example .env
    ```

3. **Inicialize o ambiente Sail:**

    ```bash
    ./vendor/bin/sail up -d
    ```

4. **Instale as dependências do Laravel:**

    ```bash
    ./vendor/bin/sail composer install
    ```

5. **Execute as migrações do banco de dados:**

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

6. **(Opcional) Execute os seeds para ter dados de exemplo:**

    ```bash
    ./vendor/bin/sail artisan db:seed
    ```
## Testes

### Executando Testes

Certifique-se de ter o ambiente configurado conforme as instruções de [Configuração do Ambiente](#configuração-do-ambiente).

Execute os testes usando o seguinte comando:

```bash
./vendor/bin/sail artisan test

## Funcionalidades

### Tarefas

- **Listar Tarefas:**

    - Endpoint: `/tasks`
    - Método: GET
    - Descrição: Retorna uma lista de todas as tarefas.

- **Listar uma Tarefa:**
    - Endpoint: `/tasks/{id}`
    - Método: GET
    - Descrição: Retorna dados de uma tarefa específica.

- **Criar Tarefa:**

    - Endpoint: `/tasks`
    - Método: POST
    - Descrição: Cria uma nova tarefa.
    - Parâmetros:
        - `name` (string): Título da tarefa.
        - `description` (string): Descrição da tarefa.
        - `due_date` (date): Prazo de execução da tarefa (formato: DD/MM/YYYY).
        - `user_id` (integer): Id do usuário que está criando a tarefa.
        - `tags` (array): Array com id das tags que serão associadas a tarefa.
            - `id` (integer): Id da tag que está contida dentro do array de tags. 

- **Editar Tarefa:**

    - Endpoint: `/tasks/{id}`
    - Método: PUT
    - Descrição: Edita uma tarefa existente.
    - Parâmetros:
        - `title` (string): Novo título da tarefa.
        - `description` (string): Nova descrição da tarefa.
        - `due_date` (date): Novo prazo de execução da tarefa (formato: YYYY-MM-DD).
        - `status` (string): Novo status da tarefa.
        - `tags` (array): Array com id das tags que serão associadas a tarefa.
            - `id`: (integer) Id da tag que está contida dentro do array de tags. 

- **Excluir Tarefa:**

    - Endpoint: `/tasks/{id}`
    - Método: DELETE
    - Descrição: Exclui uma tarefa.

### Tags

- **Listar Tags:**

    - Endpoint: `/tags`
    - Método: GET
    - Descrição: Retorna uma lista de todas as tags.
 
- **Listar uma Tag:**

    - Endpoint: `/tags/{id}`
    - Método: GET
    - Descrição: Retorna uma única tag.

- **Criar Tag:**

    - Endpoint: `/tags`
    - Método: POST
    - Descrição: Cria uma nova tag.
    - Parâmetros:
        - `name` (string): Nome da tag.
        - `color` (string): Cor da tag.

- **Editar Tag:**

    - Endpoint: `/tags/{id}`
    - Método: PUT
    - Descrição: Edita uma tag existente.
    - Parâmetros:
        - `name` (string): Novo nome da tag.
        - `color` (string): Nova cor da tag.

- **Excluir Tag:**

    - Endpoint: `/tags/{id}`
    - Método: DELETE
    - Descrição: Exclui uma tag.

## Contribuindo

Sinta-se à vontade para contribuir com melhorias, correções de bugs ou novas funcionalidades. Abra uma **issue** para discussões ou envie um **pull request**.

## Licença

Este projeto é licenciado sob a [MIT License](LICENSE).
