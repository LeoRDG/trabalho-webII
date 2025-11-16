CREATE DATABASE `web2`;
USE DATABASE `web2`;

CREATE TABLE `produtos` (
	`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `nome`VARCHAR(100) NOT NULL,
    `marca` VARCHAR(40),
    `categoria` VARCHAR(40),
    `descricao` TEXT,
    `preco` DECIMAL(10,2) NOT NULL,
    `estoque` INT NOT NULL DEFAULT 0,
    `peso` DECIMAL(10,2) NOT NULL,
    `condicao` ENUM('Novo','Usado','Recondicionado') NOT NULL,
    `frete_gratis` TINYINT NOT NULL DEFAULT 0,
    `imagem` VARCHAR(100),
    `criado_em` DATE NOT NULL DEFAULT (CURDATE()),
    `modificado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
