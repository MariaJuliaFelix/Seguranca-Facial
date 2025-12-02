DROP DATABASE IF EXISTS seguranca_facial;

CREATE DATABASE seguranca_facial;

USE seguranca_facial;

CREATE TABLE `instituicoes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `alunos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_instituicao` INT NOT NULL,
  `nome_completo` VARCHAR(255) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `cpf` VARCHAR(14) NOT NULL UNIQUE,
  `turma` VARCHAR(10),
  FOREIGN KEY (`id_instituicao`) REFERENCES `instituicoes`(`id`) ON DELETE CASCADE
);

CREATE TABLE `responsaveis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cpf` VARCHAR(14) NOT NULL UNIQUE,
  `nome_completo` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR (14) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `endereco` VARCHAR(255) NOT NULL,
  `parentesco` VARCHAR(10) NOT NULL
);

CREATE TABLE `aluno_responsavel` (
  `id_aluno` INT NOT NULL,
  `id_responsavel` INT NOT NULL,
  PRIMARY KEY (`id_aluno`, `id_responsavel`),
  FOREIGN KEY (`id_aluno`) REFERENCES `alunos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis`(`id`) ON DELETE CASCADE
);

CREATE TABLE `historico_saidas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_aluno` INT NOT NULL,
  `id_responsavel` INT NOT NULL,
  `data_saida` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_aluno`) REFERENCES `alunos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_responsavel`) REFERENCES `responsaveis`(`id`) ON DELETE CASCADE
);


CREATE TABLE `super_admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);