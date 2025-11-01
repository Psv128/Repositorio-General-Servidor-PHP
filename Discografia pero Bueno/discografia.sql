-- Creacion de la base de datos
CREATE DATABASE discografia DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE discografia;

-- Creamos las tablas
DROP TABLE IF EXISTS `album`;
CREATE TABLE album (
codigo INT (7) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
titulo VARCHAR(50) NOT NULL ,
discografica VARCHAR(25) NOT NULL ,
formato ENUM('vinilo','cd','dvd','mp3') COLLATE utf8_bin NOT NULL,
fechaLanzamiento DATE,
fechaCompra DATE,
precio decimal(5,2)
) ENGINE = INNODB;

DROP TABLE IF EXISTS `cancion`;
CREATE TABLE cancion (
titulo VARCHAR(50) NOT NULL ,
album INT(7) NOT NULL ,
posicion INT(2),
duracion TIME,
genero ENUM('Acustica','BSO','Blues','Folk','Jazz','New age','Pop','Rock','Electronica') COLLATE utf8_bin NOT NULL,
PRIMARY KEY (titulo, album),
FOREIGN KEY (album) REFERENCES album(codigo)
) ENGINE = INNODB;


CREATE USER 'discografia'@'localhost'
IDENTIFIED BY 'discografia';
GRANT ALL PRIVILEGES ON discografia.* TO 'discografia'@'localhost' WITH GRANT OPTION;

INSERT INTO album (codigo, titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio) VALUES
('1', 'Greatest Hits', 'Sony Music', 'cd', '2000-01-01', '2001-05-10', 19.99),
('2', 'Rock Classics', 'Universal', 'vinilo', '1995-06-15', '1996-02-20', 29.99),
('3', 'Pop Essentials', 'Warner', 'dvd', '2010-09-05', '2010-12-01', 15.50);

-- Insertar canciones de ejemplo
INSERT INTO cancion (titulo, album, posicion, duracion, genero) VALUES
('Hit Song 1', '1', 1, '3:45', 'Pop'),
('Hit Song 2', '1', 2, '4:05', 'Pop'),
('Rock Anthem', '2', 1, '5:20', 'Rock'),
('Classic Tune', '2', 2, '3:55', 'Rock'),
('Pop Song 1', '3', 1, '4:10', 'Pop'),
('Pop Song 2', '3', 2, '3:50', 'Pop');