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
    preco DECIMAL(10,2),
    pagamento VARCHAR(20)
);

CREATE TABLE servico(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    tipo VARCHAR(100),
    preco DECIMAL(10,2),
    profissionais VARCHAR(255)
);

/*Comandos rodados pra inserir valores na tabela serviço*/
INSERT INTO servico(nome,tipo,preco,profissionais) VALUES
('Cabelo','Corte Curto',40,'Ana,Julia'),
('Cabelo','Coloração Capilar',120,'Ana,João'),
('Cabelo','Progressiva',180,'Maria,Julia'),
('Cabelo','Fade disfarçado',60,'Carlos,João'),
('Barbearia','Barba simples',30,'Carlos,Pedro'),
('Barbearia','Barba pigmentada',45,'Pedro'),
('Barbearia','Corte undercut',50,'Pedro,João'),
('Massagem','Relaxante',80,'Fernanda,Camila'),
('Massagem','Pedras Quentes',120,'Fernanda'),
('Manicure','Manicure',30,'Bruna,Patrícia'),
('Manicure','Manicure + Pedicure',60,'Bruna,Patrícia'),
('Maquiagem',NULL,70,'Juliana,Beatriz'),
('Sobrancelha',NULL,40,'Camila,Larissa');