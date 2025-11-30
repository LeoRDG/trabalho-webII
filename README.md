# [Trabalho de Desenvolvimento Web II](https://github.com/LeoRDG/trabalho-webii)

O trabalho tem o objetivo de aplicar na prática os conceitos estudados na
disciplina **Web II** em uma aplicação que envolva a utilização de *JavaScript, jQuery e
PHP/MySQL.*

### Requisitos

- [x] **1. Uma tabela de *Banco de Dados*.**
   - [x] Com **6 ou mais** atributos (colunas).
   - [x] Com **4 ou mais** tipos diferentes de dados.
   - [x] Deve ser **diferente** da tabela usada nos materiais da disciplina

- [x] **2. Página para exibir os dados da tabela.**
   - [x] Com opção para **Inserir** dados.
   - [x] Com opção para **Excluir** dados.
   - [x] Com opção para **Alterar** dados.

- [x] **3. Formulário HTML para inserir dados.**
   - [x] Usando **tipos adequados.**
   - [x] **Formatação** com *CSS/Bootstrap/etc.*
   - [x] *JavaScript* funcional para **validação.**
   - [x] *PHP* para **Inserir** dados no *BD*.

- [x] **4. Página para Excluir Dados.**

- [x] **5. Página para Alteração de Dados.**
   - [x] Com as mesmas **validações** da *inserção*

***

### Estrutura do Banco de Dados

A tabela `produtos` possui os seguintes atributos:

- **id** (INT, AUTO_INCREMENT, PRIMARY KEY): Identificador único do produto
- **nome** (VARCHAR(60)): Nome do produto
- **marca** (VARCHAR(20)): Marca do produto
- **categoria** (VARCHAR(30)): Categoria do produto
- **descricao** (TEXT): Descrição detalhada do produto
- **preco** (DECIMAL(8,2)): Preço do produto (entre R$ 1,00 e R$ 100.000,00)
- **estoque** (SMALLINT UNSIGNED): Quantidade em estoque (0 a 5000)
- **peso** (DECIMAL(3,1)): Peso do produto em kg (0,1 a 50,0)
- **vencimento** (DATE): Data de vencimento do produto
- **condicao** (ENUM): Estado do produto (Novo, Usado, Recondicionado)
- **frete_gratis** (BOOLEAN): Indica se o produto possui frete grátis
- **criado_em** (DATETIME): Data e hora de criação do registro
- **modificado_em** (TIMESTAMP): Data e hora da última modificação

***

### Estrutura do Projeto
```
trabalho-webII/
├── banco.sql              # Script de criação do banco de dados
├── index.php              # Página inicial
├── css/                   # Arquivos de estilização
├── js/                    # Scripts JavaScript e jQuery
├── php/
│   ├── actions/           # Arquivos de CRUD
│   ├── include/           # Componentes reutilizáveis
│   ├── paginas/           # Páginas acessíveis
│   └── src/               # Classes PHP
└── README.md              
```
