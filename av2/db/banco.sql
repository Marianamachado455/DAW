CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(14),
    dta_nascimento DATE,
    email VARCHAR(100),
    telefone VARCHAR(20),
    senha VARCHAR(255)
);

CREATE TABLE agendamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    usuario_nome VARCHAR(100),
    data_hora DATETIME,
    servico VARCHAR(100),
    tipo VARCHAR(100),
    profissional VARCHAR(100),
);