-- CRIAÇÃO DO BANCO DE DADOS E TABELAS

CREATE DATABASE IF NOT EXISTS `bd_primesolutions` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bd_primesolutions`;

CREATE TABLE CLIENTE 
(
    ID INT(3) UNSIGNED ZEROFILL AUTO_INCREMENT PRIMARY KEY,
    CPF VARCHAR(14) NOT NULL,
    NOME VARCHAR(50) NOT NULL,
    CELULAR VARCHAR(15) NOT NULL,
    DATA_C DATE NOT NULL
);

CREATE TABLE SERVICO
(
    ORDEM_SERVICO INT(5) UNSIGNED ZEROFILL PRIMARY KEY AUTO_INCREMENT,
    ID_CLIENTE INT(3) UNSIGNED ZEROFILL NOT NULL,
    PLACA_CARRO VARCHAR(8) NOT NULL,
    MODELO_CARRO VARCHAR(20) NOT NULL,
    ANO VARCHAR(4),
    DATA_S DATE,
    VALOR_SERV DECIMAL(10,2),
    FORMA_PGT VARCHAR(15),
    GARANTIA VARCHAR(10),
    RESPONSAVEL VARCHAR(20),
    SERVICO_REALIZADO VARCHAR(255),
    STATUS ENUM('andamento', 'finalizado') NOT NULL DEFAULT 'andamento',
    FOREIGN KEY (ID_CLIENTE) REFERENCES CLIENTE(ID)
);

CREATE TABLE CADASTRO
(
    ID INT(11) NOT NULL AUTO_INCREMENT,
    NOME VARCHAR(255) NOT NULL,
    CPF VARCHAR(11) NOT NULL,
    EMAIL VARCHAR(255) NOT NULL,
    SENHA VARCHAR(255) NOT NULL,
    REPETICAO_SENHA VARCHAR(255),
    STATUS ENUM('aprovado', 'pendente', 'rejeitado') NOT NULL DEFAULT 'pendente',
    verification_code VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_cpf (cpf)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- DADOS ADMIN
INSERT INTO CADASTRO (NOME, CPF, EMAIL, SENHA, REPETICAO_SENHA, STATUS, verification_code) 
VALUES 
('Admin TecnoAr', '00000000000', 'admintecnoar@admin.tecno', '$2y$10$1W7eV8MMZiQd.tNkV0xO2OvGANMAoDorqZpBgp9qG7KRSBPDVzqAu', '$2y$10$1W7eV8MMZiQd.tNkV0xO2OvGANMAoDorqZpBgp9qG7KRSBPDVzqAu', 'aprovado', 'c238034f94a6bce485b4ede0c52e4cca');

-- INSERÇÃO DE DADOS PARA TESTE

INSERT INTO CLIENTE (NOME, CPF, CELULAR, DATA_C) VALUES ('Lucas Silva', '123.456.789-00', '(11) 91234-5678', '2023-11-22'), ('Maria Santos', '234.567.890-12', '(11) 92345-6789', '2023-11-21'), ('Pedro Oliveira', '345.678.901-23', '(11) 93456-7890', '2023-11-20'), ('Ana Souza', '456.789.012-34', '(11) 94567-8901', '2023-11-19'), ('João Costa', '567.890.123-45', '(11) 95678-9012', '2023-11-18'), ('Julia Lima', '678.901.234-56', '(11) 96789-0123', '2023-11-17'), ('Bruno Alves', '789.012.345-67', '(11) 97890-1234', '2023-11-16'), ('Fernanda Rocha', '890.123.456-78', '(11) 98901-2345', '2023-11-15'), ('Carlos Dias', '901.234.567-89', '(11) 99012-3456', '2023-11-14'), ('Renata Martins', '012.345.678-90', '(11) 90123-4567', '2023-11-13');


INSERT INTO SERVICO (ID_CLIENTE, PLACA_CARRO, MODELO_CARRO, SERVICO_REALIZADO, DATA_S, VALOR_SERV, RESPONSAVEL) VALUES (001, 'ABC-1234', 'Fiat Uno', 'Troca de óleo', '2021-09-22', 132.00, 'José Augusto'), (002, 'DEF-5678', 'Ford Ka', 'Alinhamento e balanceamento', '2023-10-21', 157.99, 'José Augusto'),(003, 'GHI-9012', 'Chevrolet Onix', 'Revisão geral', '2021-11-20', 300.00, 'Pedro Abrão'), (004, 'JKL-3456', 'Volkswagen Gol', 'Troca de pneus', '2023-11-19', 450.00, 'Ana Cinza'), (005, 'MNO-7890', 'Renault Sandero', 'Troca de bateria', '2022-01-18', 197.00, 'João Kleber'), (006, 'PQR-1234', 'Honda Civic', 'Troca de pastilhas de freio', '2022-10-17', 250.00, 'Ana Cinza'), (007, 'STU-5678', 'Toyota Corolla', 'Troca de filtro de ar', '2023-11-16', 55.49, 'José Augusto'), (008, 'VWX-9012', 'Hyundai HB20', 'Troca de velas', '2023-11-15', 82.79, 'Fernanda Ferreira'), (009, 'YZA-3456', 'Nissan Versa', 'Reparo no ar-condicionado','2022-09-28',330.30,'Fernanda Ferreira'),(010, 'BZA-5556', 'Golf Bolinha', 'Reparo no filtro de ar','2022-09-27',61.39,'João Kleber');




