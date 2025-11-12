# Sistema CRUD - Livraria (MVC em PHP + MySQL)

## Descrição
Aplicação MVC simples para gerenciar livros (CRUD). Arquitetura leve: Model, Controller e Views separados. Conexão via PDO.
Sistema voltado para livrarias que desejam controlar seus livros em estoque.

## Como configurar (Passo a passo)
Iniciar uma conexão com um SGBD sql

## SQL - criar banco / tabela / exemplos
Execute no MySQL (phpMyAdmin, Workbench ou CLI):

```sql
CREATE DATABASE IF NOT EXISTS Livraria;
USE Livraria;

CREATE TABLE IF NOT EXISTS Livro (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  autor VARCHAR(255) NOT NULL,
  genero VARCHAR(100) NOT NULL,
  data_lancamento DATE DEFAULT NULL,
  estoque INT NOT NULL DEFAULT 0
);

INSERT INTO Livro (titulo, autor, genero, data_lancamento, estoque)
VALUES
('1984', 'George Orwell', 'Distopia', '1949-06-08', 3),
('Dom Casmurro', 'Machado de Assis', 'Clássico', '1899-01-01', 2);
