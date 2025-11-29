CREATE DATABASE `Trabalho_webII_Leonardo`;
USE `Trabalho_webII_Leonardo`;

CREATE TABLE `produtos` (
	`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `nome` VARCHAR(60) NOT NULL,
    `marca` VARCHAR(20),
    `categoria` VARCHAR(30),
    `descricao` TEXT,
    `preco` DECIMAL(8,2) NOT NULL,
    `estoque` SMALLINT UNSIGNED NOT NULL,
    `peso` DECIMAL(3,1) NOT NULL,
    `vencimento` DATE,
    `condicao` ENUM('Novo','Usado','Recondicionado') NOT NULL,
    `frete_gratis` BOOLEAN NOT NULL DEFAULT 0,
    `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modificado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

    CHECK (preco >= 1.00 AND preco <= 100000.00),
    CHECK (estoque >= 0 AND estoque <= 5000),
    CHECK (peso >= 0.1 AND peso <= 50.0)
);
