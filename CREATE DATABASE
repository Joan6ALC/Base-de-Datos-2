# CREACIÓ DE LA BASE DE DADES

CREATE DATABASE pelistube;

USE pelistube;

CREATE TABLE Tarifa(
	nomTarifa varchar(15) PRIMARY KEY,
	preu integer NOT NULL,
	periodicitat INTEGER NOT NULL,
	estatTarifa boolean
);

CREATE TABLE Categoria(
	nomCat varchar(20) PRIMARY KEY,
visible boolean
);

CREATE TABLE Tipus(
IdTipus integer AUTO_INCREMENT PRIMARY KEY,
	edat varchar(15) NOT NULL # <9, 9-18 i >18
	
);

CREATE TABLE Contingut(
IdContingut integer AUTO_INCREMENT PRIMARY KEY,
	titol varchar(20) NOT NULL,
	link varchar(250) NOT NULL,
	camiFoto varchar(250) NOT NULL,
	nomCat varchar(20),
	visible boolean,
	FOREIGN KEY (nomCat) REFERENCES Categoria(nomCat)
);

CREATE TABLE R_Tipus_Contingut(
	IdTipus integer,
	IdContingut integer,
	FOREIGN KEY (IdTipus) REFERENCES Tipus(IdTipus),
	FOREIGN KEY (IdContingut) REFERENCES Contingut(IdContingut),
	PRIMARY KEY (IdTipus,IdContingut)
);

CREATE TABLE Persona(
	dataAlta DATE NOT NULL,
	username varchar(15)PRIMARY KEY,
	password varchar(45) NOT NULL,
	nom varchar(25) NOT NULL,
	llinatge1 varchar(20) NOT NULL,
	llinatge2 varchar(20), # pot ser null, ja que moltes persones no tenen segon llinatge
	dataNaixament DATE NOT NULL, 
	administrador boolean,
	IdTipus integer,
	FOREIGN KEY (IdTipus) REFERENCES Tipus(IdTipus)
);

CREATE TABLE Contracte(
	dataAlta DATE,
	dataBaixa DATE,
	estat boolean,
	IdContracte integer AUTO_INCREMENT PRIMARY KEY,
	nomTarifa varchar(15),
	username varchar(15),
	FOREIGN KEY (nomTarifa) REFERENCES Tarifa(nomTarifa),
FOREIGN KEY (username) REFERENCES Persona(username)	
);

CREATE TABLE Factura(
	import integer NOT NULL,
	dataInici DATE, # període de la factura de dataInici a dataFinal
	dataFinal DATE,
	dataPagament DATE,
	IdFactura integer AUTO_INCREMENT PRIMARY KEY,
	IdContracte integer,
	FOREIGN KEY (IdContracte) REFERENCES Contracte(IdContracte)
);


CREATE TABLE Missatge(
	data DATE,
	assumpte varchar(50),
	descripcio varchar(280),
	estatMissatge boolean,
	IdMissatge integer AUTO_INCREMENT PRIMARY KEY,
	username varchar(15),
	IdContingut integer,
	FOREIGN KEY (username) REFERENCES Persona(username),
	FOREIGN KEY (IdContingut) REFERENCES Contingut(IdContingut)
);

CREATE TABLE ContingutFavorits(
	IdContracte integer,
	IdContingut integer,
	FOREIGN KEY (IdContracte) REFERENCES Contracte(IdContracte),
	FOREIGN KEY (IdContingut) REFERENCES Contingut(IdContingut),
	PRIMARY KEY (IdContracte,IdContingut)
);

CREATE TABLE CategoriaFavorits(
	IdContracte integer,
	nomCat varchar(20),
	FOREIGN KEY (IdContracte) REFERENCES Contracte(IdContracte),
	FOREIGN KEY (nomCat) REFERENCES Categoria(nomCat),
	PRIMARY KEY (IdContracte,nomCat)
);

# INSERTS NECESSARIS

INSERT INTO tipus(edat) VALUES ("<9 años"),  ("9-18 años"),  ("+18 años");
INSERT INTO categoria(nomCat, visible) VALUES ("Terror", true), ("Comedia", true), ("Intriga", true),("Ciencia ficción", true),("Aventuras", true),("Drama", true),("Fantasía", true),("Suspense", true),("Musical", true),("Animación", true),("Documental", true),("Histórica", true),("Bélica", true),("Crimen", true),("Policíaca", true),("Acción", true);
INSERT INTO tarifa(nomTarifa, preu, periodicitat, estatTarifa) VALUES('MENSUAL', 10, 30, 'VIGENT'),('TRIMESTRAL', 25, 90, 'VIGENT');

# USUARI ADMINISTRADOR (PASSWORD 1234)
INSERT INTO persona(dataAlta, username, password, nom, llinatge1, llinatge2, dataNaixament, administrador, IdTipus) values ('0000-00-00','admin', '$1$ciJ2Am3s$jy1CJ0uIm7q9CwmFw.hvS/', 'admin', 'admin', 'admin', '0000-00-00', true, NULL);
