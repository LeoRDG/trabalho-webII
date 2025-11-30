<?php require_once __DIR__ . "/../src/util.php" ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <link rel="stylesheet" href="../../css/index.css">
</head>

<body>

    <?php 
    include __DIR__ . "/../include/menu.php"; 
    include __DIR__ . "/../include/msg.php"; 
    ?>

    <main>
        <h1><a target="_blank" href="https://github.com/LeoRDG/trabalho-webii">Trabalho de Desenvolvimento Web II</a></h1>

        <p>O trabalho tem o objetivo de aplicar na prática os conceitos estudados na
        disciplina <b>Web II</b> em uma aplicação que envolva a utilização de <i>JavaScript, jQuery e
        PHP/MySQL.</i></p>

        <h2>Requisitos</h2>
        <div>
            <ol>
                <li><span class="material-symbols-outlined">check</span><b>Uma tabela de <i>Banco de Dados</i>.</b>
                    <ul>
                        <li><span class="material-symbols-outlined">check</span>Com <b>6 ou mais</b> atributos (colunas).</li>
                        <li><span class="material-symbols-outlined">check</span>Com <b>4 ou mais</b> tipos diferentes de dados.</li>
                        <li><span class="material-symbols-outlined">check</span>Deve ser <b>diferente</b> da tabela usada nos materiais da disciplina.</li>
                    </ul>
                </li>

                <li><span class="material-symbols-outlined">check</span><b>Página para exibir os dados da tabela.</b>
                    <ul>
                        <li><span class="material-symbols-outlined">check</span>Com opção para <b>Inserir</b> dados.</li>
                        <li><span class="material-symbols-outlined">check</span>Com opção para <b>Excluir</b> dados.</li>
                        <li><span class="material-symbols-outlined">check</span>Com opção para <b>Alterar</b> dados.</li>
                    </ul>
                </li>

                <li><span class="material-symbols-outlined">check</span><b>Formulário HTML para inserir dados.</b>
                    <ul>
                        <li><span class="material-symbols-outlined">check</span> Usando <b>tipos adequados.</b></li>
                        <li><span class="material-symbols-outlined">check</span> <b>Formatação</b> com <i>CSS/<s>Bootstrap/etc.</s></i></li>
                        <li><span class="material-symbols-outlined">check</span> <i>JavaScript</i> funcional para <b>validação.</b></li>
                        <li><span class="material-symbols-outlined">check</span> <i>PHP</i> para <b>Inserir</b> dados no <i>BD</i>.</li>
                    </ul>
                </li>

                <li><span class="material-symbols-outlined">check</span><b>Página para Excluir Dados.</b></li>

                <li><span class="material-symbols-outlined">check</span><b>Página para Alteração de Dados.</b>
                    <ul>
                        <li><span class="material-symbols-outlined">check</span>Com as mesmas <b>validações</b> da <i>inserção</i></li>
                    </ul>
                </li>
            </ol>
        </div>

        <h2>Estrutura do Banco de Dados</h2>
        <div>
            <p>A tabela <code>produtos</code> possui os seguintes atributos:</p>
            <ul>
                <li><b>id</b> (INT, AUTO_INCREMENT, PRIMARY KEY): Identificador único do produto</li>
                <li><b>nome</b> (VARCHAR(60)): Nome do produto</li>
                <li><b>marca</b> (VARCHAR(20)): Marca do produto</li>
                <li><b>categoria</b> (VARCHAR(30)): Categoria do produto</li>
                <li><b>descricao</b> (TEXT): Descrição detalhada do produto</li>
                <li><b>preco</b> (DECIMAL(8,2)): Preço do produto (entre R$ 1,00 e R$ 100.000,00)</li>
                <li><b>estoque</b> (SMALLINT UNSIGNED): Quantidade em estoque (0 a 5000)</li>
                <li><b>peso</b> (DECIMAL(3,1)): Peso do produto em kg (0,1 a 50,0)</li>
                <li><b>vencimento</b> (DATE): Data de vencimento do produto</li>
                <li><b>condicao</b> (ENUM): Estado do produto (Novo, Usado, Recondicionado)</li>
                <li><b>frete_gratis</b> (BOOLEAN): Indica se o produto possui frete grátis</li>
                <li><b>criado_em</b> (DATETIME): Data e hora de criação do registro</li>
                <li><b>modificado_em</b> (TIMESTAMP): Data e hora da última modificação</li>
            </ul>
        </div>

        <h2>Estrutura do Projeto</h2>

        <div>
            <pre class="code">trabalho-webII/
├── banco.sql              # Script de criação do banco de dados
├── index.php              # Página inicial
├── css/                   # Arquivos de estilização
├── js/                    # Scripts JavaScript e jQuery
├── php/
│   ├── actions/           # Arquivos de CRUD
│   ├── include/           # Componentes reutilizáveis
│   ├── paginas/           # Páginas acessíveis
│   └── src/               # Classes PHP
└── README.md</pre>
        </div>
    </main>
</body>

</html>