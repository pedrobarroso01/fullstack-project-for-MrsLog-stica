CREATE DATABASE Tickets;
USE Tickets;

-- Tabela para Empreiteiras
CREATE TABLE Empreiteiras (
    idEmpreiteira INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

 INSERT INTO Empreiteiras(nome,endereco,telefone) VALUES ('Mata Atlantica','Rua Alburquerque,nº102, São Roque, Sabara','5499340605'),
								('Mediterrâneo','Rua Pentagono,nº15, Mantiqueiras, Belo Horizonte','5499340605');

-- Tabela para Sedes
CREATE TABLE Sedes (
    idSede INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

INSERT INTO Sedes(nome,endereco,telefone) VALUES('Central BH','Rua Rio de Janeiro,nº238, Centro, Belo Horizonte','5499340605');

create table Acesso (
	idAcesso INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome varchar(30) not null
) ENGINE = InnoDB;

insert into Acesso(nome) values ("Empreiteira");
insert into Acesso(nome) values ("Sede");
-- Tabela de Status
CREATE TABLE StatusOs (
    idStatus INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nameStatus VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

INSERT INTO StatusOS(nameStatus) VALUES ('Concluída'),('Em Andamento'),('Pendência'),('Reenviada');

-- Tipo de Ordem de Serviço
CREATE TABLE AssuntoOs (
    idAssunto INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nameAssunto VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

INSERT INTO AssuntoOs(nameAssunto) VALUES ('Administrativo'),('Financeiro'),('Manutenção');

-- Tabela para Ordens de Serviço (OS) com informações do solicitante e destinatario
CREATE TABLE OrdensDeServico (
    idOS INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titulo varchar(100) NOT NULL,
    descricao TEXT NOT NULL,
    path_ LONGBLOB NULL,
    justificativa TEXT NULL,
    dataAbertura DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    dataFechamento DATE NULL,
    idStatus INT NOT NULL DEFAULT 2,
    idAssunto INT NOT NULL,
    idEmpreiteira INT NOT NULL,
    idSede INT NOT NULL,
    FOREIGN KEY (idEmpreiteira) REFERENCES Empreiteiras(idEmpreiteira) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idSede) REFERENCES Sedes(idSede) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idStatus) REFERENCES StatusOs(idStatus) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idAssunto) REFERENCES AssuntoOS(idAssunto) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Order of Service 1
INSERT INTO OrdensDeServico (titulo,descricao, idStatus, idAssunto, idEmpreiteira, idSede)
VALUES ('0000021212','Manutenção elétrica na área externa', 3, 3, 1, 1);

-- Order of Service 2
INSERT INTO OrdensDeServico (titulo,descricao, idAssunto, idEmpreiteira, idSede)
VALUES ('000000','Solicitação de materiais para reforma',3, 1, 1);

-- Order of Service 3
INSERT INTO OrdensDeServico (titulo,descricao, idStatus, idAssunto, idEmpreiteira, idSede)
VALUES ('999989','Verificação de pendência na sede', 1, 2, 1, 1);

-- Order of Service 4
INSERT INTO OrdensDeServico (titulo,descricao, dataFechamento, idStatus, idAssunto, idEmpreiteira, idSede)
VALUES ('5454646','Manutenção preventiva nas instalações', '2024-02-25', 2, 3, 2, 1);

-- Order of Service 5
INSERT INTO OrdensDeServico (titulo,descricao, idStatus, idAssunto, idEmpreiteira, idSede)
VALUES ('oiio','Manutenção de redes', 4, 3, 2, 1);

-- Tabela de cargos
CREATE TABLE Cargos (
    idCargo INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomeCargo VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

INSERT INTO Cargos(nomeCargo) VALUES ('Técnico'),('Analista'),('Supervisor');

-- Tabela de Funcionarios com Nome, Cargo, Local
CREATE TABLE Funcionarios (
    idFuncionario INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nameFuncionario VARCHAR(100) NOT NULL,
    idCargo INT NOT NULL,
    LocalEmpreiteira INT NULL,
    LocalSede INT NULL,
    path TEXT,
    FOREIGN KEY (LocalEmpreiteira) REFERENCES Empreiteiras(idEmpreiteira) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (LocalSede) REFERENCES Sedes(idSede) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idCargo) REFERENCES Cargos(idCargo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO Funcionarios(nameFuncionario,idCargo,LocalEmpreiteira,LocalSede) VALUES('Ana Clara Rodrigues','1',null,'1'),
						('Fabio Leonardo','2',null,'1'),
						('Kaique Dias Barroso',1,1,null),
						('Rikelme Leandro',3,1,null),
						('Pedro Barroso',1,2,null),
						('Luiz Henrique De Oliveira Santos',3,2,null);
			
CREATE TABLE Usuarios (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
	tentativas INT DEFAULT 0,
    bloqueado BOOLEAN DEFAULT 0,
	email VARCHAR(255) NOT NULL UNIQUE,
    idEmpreiteira INT NULL UNIQUE,
    idSede INT NULL UNIQUE,
    idAcesso INT NOT NULL,
    path TEXT NOT NULL,
    FOREIGN KEY (idAcesso) REFERENCES Acesso(idAcesso) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idEmpreiteira) REFERENCES Empreiteiras(idEmpreiteira) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idSede) REFERENCES Sedes(idSede) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;


SELECT usuarios.id, usuarios.username, usuarios.password, usuarios.tentativas, usuarios.bloqueado, usuarios.idAcesso
FROM usuarios
INNER JOIN Acesso ON Acesso.idAcesso = usuarios.idAcesso;
-- WHERE username = 'lucas';

insert into Usuarios(username,password, email,idEmpreiteira, idSede, idAcesso, path) values ('Mata Atlantica','123', "mataatlanticamrs@gmail.com,",1, NUll, 1, '../imgs/mataatlantica.jpg');
insert into Usuarios(username,password, email,idEmpreiteira, idSede, idAcesso, path) values ('Mediterraneo','123', "mediterraneomrs@gmail.com",2, NUll, 1, '../imgs/mediterraneo.jpg');
insert into Usuarios(username,password, email,idEmpreiteira, idSede, idAcesso, path) values ('Central BH','123', "sedeBHmrs@gmail.com",NULL, 1, 2, '../imgs/sedeP.png');

-- Selct de todos os user
SELECT usuarios.id AS idUsuario, usuarios.username,usuarios.email,usuarios.path,  usuarios.password,
       emprei.idEmpreiteira, emprei.nome AS nomeEmpreiteira,
       sede.idSede, sede.nome AS nomeSede
FROM usuarios
LEFT JOIN Empreiteiras AS emprei ON emprei.idEmpreiteira = usuarios.idEmpreiteira
LEFT JOIN Sedes AS sede ON sede.idSede = usuarios.idSede WHERE usuarios.idAcesso=2;


SELECT OS.idOS, OS.descricao as descricao,OS.dataAbertura as dataAbertura,OS.dataFechamento,OS.path_ as path,StatusOs.nameStatus AS status,StatusOs.idStatus AS idStatus,
            AssuntoOS.nameAssunto AS assunto, Empreiteiras.nome AS nomeEmpreiteira, Empreiteiras.idEmpreiteira AS idEmpreiteira,
            Sedes.nome AS nomeSede, Sedes.idSede AS idSede FROM OrdensDeServico as OS INNER JOIN Empreiteiras ON OS.idEmpreiteira = Empreiteiras.idEmpreiteira
            INNER JOIN Sedes ON OS.idSede = Sedes.idSede INNER JOIN StatusOs ON OS.idStatus = StatusOs.idStatus INNER JOIN AssuntoOS ON OS.idAssunto = AssuntoOS.idAssunto;

SELECT COUNT(*) as total FROM OrdensDeServico WHERE DATE(dataAbertura) = CURDATE() AND OrdensDeServico.idEmpreiteira = 2;
