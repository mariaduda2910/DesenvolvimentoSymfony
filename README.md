# DesenvolvimentoSymfony
Teste de Desenvolvimento de Aplicação Symfony
# Sistema de Registro e Login - Projeto Symfony

## Rota Principal

A rota principal do sistema é `/Login`, onde os usuários podem se autenticar.

## Descrição do Projeto

Este projeto implementa um sistema básico de registro e login, onde os usuários podem se registrar como `Customer` (cliente) ou `Admin` (administrador). Após o registro, o sistema separa os usuários em duas categorias distintas, com base no tipo de usuário (cliente ou administrador).

## Estrutura do Banco de Dados

O sistema utiliza as seguintes entidades:

- **User**: Contém as colunas comuns para todos os usuários, como `email`, `senha` e `isAdmin`. Todo usuário cadastrado será inserido nesta tabela.
- **Customer**: Herda as colunas da entidade `User` e contém informações adicionais específicas para clientes.
- **Admin**: Herda as colunas da entidade `User` e contém informações específicas para administradores.

### Como Funciona:

1. **Registro de Usuário**: Ao se registrar, o usuário é inicialmente inserido na tabela `User`. Dependendo do tipo de usuário (cliente ou administrador), ele será redirecionado para a entidade apropriada (`Customer` ou `Admin`).
   
2. **Separação de Usuários**: A lógica de separação entre `Customer` e `Admin` é feita com base no campo `isAdmin` da tabela `User`. Quando o usuário se registra, ele é atribuído ao tipo correspondente, mas inicialmente a tabela `User` armazena todos os dados.

## Funcionalidade de Administração

Embora a página pública do cliente ainda não tenha sido criada, foi implementada uma página privada para o administrador.

### Página do Administrador

- O administrador pode ver a lista de clientes e tem a opção de **aceitar** ou **rejeitar** clientes.
- No entanto, as demais funcionalidades CRUD (Criar, Ler, Atualizar, Deletar) ainda não foram implementadas para o administrador.

## Limitações do Projeto

- A página pública para clientes ainda não foi criada.
- O sistema de **CRUD completo** para administradores não foi implementado (só a funcionalidade de aceitar ou rejeitar clientes está disponível até o momento).

## Rota de Login

A página de login é a porta de entrada para o sistema. A rota pode ser acessada por:

- `/Login`
- `/login` (a rota também responde com letras minúsculas)

### Fluxo de Login:

1. O usuário insere seu **email** e **senha** no formulário de login.
2. O sistema verifica se as credenciais são válidas:
   - Se o usuário for um **administrador**, ele será redirecionado para a página do administrador.
   - Se o usuário for um **cliente**, o sistema verifica se o cliente foi aprovado (caso o cliente esteja aguardando aprovação) e redireciona para a página do cliente.

3. Caso o email ou a senha estejam incorretos, o sistema exibirá uma mensagem de erro na tela.

