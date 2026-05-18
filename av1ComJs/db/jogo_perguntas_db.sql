CREATE DATABASE banco_jogo_perguntas;

USE banco_jogo_perguntas;

CREATE TABLE multipla_escolha (
  id_pergunta INT AUTO_INCREMENT PRIMARY KEY
  pergunta TEXT NOT NULL
  resp_certa TEXT NOT NULL

  resp_errada1 TEXT NOT NULL
  resp_errada2 TEXT NOT NULL
  resp_errada3 TEXT NOT NULL
  resp_errada4 TEXT NOT NULL
)

CREATE TABLE discursiva (
  id_pergunta INT AUTO_INCREMENT PRIMARY KEY
  pergunta TEXT NOT NULL
  resp_certa 
)

CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY
  nome VARCHAR[100] NOT NULL
  senha VARCHAR[50] NOT NULL
)
