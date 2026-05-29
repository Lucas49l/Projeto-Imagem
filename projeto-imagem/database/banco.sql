CREATE DATABASE IF NOT EXISTS db_formulario_produtos;
USE db_formulario_produtos;

CREATE TABLE IF NOT EXISTS produto(
    id_produto INT  PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    descricao TEXT  
);

CREATE TABLE IF NOT EXISTS imagem(
    id_imagem INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT,
    nome_imagem VARCHAR(255),
    CONSTRAINT fk_imagem_produto FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

INSERT INTO produto(nome, descricao, foto) VALUES(:n, :d, :f)