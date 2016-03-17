
CREATE DATABASE UNISINOS;

CREATE TABLE Produtos (
	CodProduto 	INT(5) 			NOT NULL 	AUTO_INCREMENT,
	NmProduto  	VARCHAR(50) 	NOT NULL,
	DscProduto  VARCHAR(255) 	NOT NULL,
	VlrProduto  DOUBLE 			NOT NULL,
	QtdProduto 	INT(5) 			NOT NULL,
	PRIMARY KEY (CodProduto)
);

CREATE TABLE Usuarios(
	CodUsuario	INT(5)			NOT NULL	AUTO_INCREMENT,
	NmUsuario	VARCHAR(50)		NOT NULL,
	DtNascimento DATE			NULL,
	Cpf			INT(15)			NOT NULL,
	Endereco	VARCHAR(50)		NULL,
	Cidade		VARCHAR(40)		NULL,
	Estado		CHAR(2)			NULL,
	Email		VARCHAR(50)		NULL,
	Apelido		VARCHAR(20)		NULL,
	Senha		VARCHAR(20)		NOT NULL,
	PRIMARY KEY (CodUsuario) 
);

CREATE TABLE Carrinho(
	CodCarrinho	INT(5)		NOT NULL	AUTO_INCREMENT,
	IdSessao	INT(5)		NOT NULL,
	CodUsuario	INT(5)		NOT NULL,	
	DtPedido	DATE			NOT NULL,
	PRIMARY KEY(CodCarrinho),
	FOREIGN KEY (CodUsuario) REFERENCES Usuarios(CodUsuario)	
);

CREATE TABLE ItensCarrinho(
	CodCarrinho	INT(5)		NOT NULL,
	CodProduto	INT(5)		NOT NULL,
	QtdProdutos	INT(5)		NOT NULL,
	FOREIGN KEY (CodCarrinho)REFERENCES Carrinho(CodCarrinho),
	FOREIGN KEY (CodProduto) REFERENCES Produtos(CodProduto)
);

INSERT INTO Usuarios (NmUsuario,Cpf,Senha)VALUES('admin',99999999999,'123456');