CREATE DATABASE `web2`;
USE DATABASE `web2`;

CREATE TABLE `produtos` (
	`ìd` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `nome`VARCHAR(60) NOT NULL,
    `marca` VARCHAR(40),
    `categoria` VARCHAR(40),
    `descricao` TEXT,
    `preco_base` DECIMAL NOT NULL,
    `estoque` INT NOT NULL DEFAULT 0,
    `peso` DECIMAL NOT NULL,
    `condicao` ENUM('Novo','Usado','Recondicionado') NOT NULL,
    `frete_gratis` TINYINT NOT NULL DEFAULT 0,
    `caminho_imagem` VARCHAR(100),
    `criado_em` DATE NOT NULL,
    `modificado_em`TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
