CREATE DATABASE IF NOT EXISTS fabricio_nogueira_142012ADP;

USE fabricio_nogueira_142012ADP;

CREATE TABLE universidades(
	id INTEGER NOT NULL auto_increment PRIMARY KEY,
	nome VARCHAR(200) UNIQUE NOT NULL
)ENGINE = innodb;

CREATE TABLE cursos(
	id INTEGER NOT NULL auto_increment PRIMARY KEY,
	nome VARCHAR(200) NOT NULL,
	universidade_id INTEGER NOT NULL
)ENGINE = innodb;

CREATE TABLE alunos(
	id INTEGER NOT NULL auto_increment PRIMARY KEY,
	nome VARCHAR(200) NOT NULL,
	matricula VARCHAR(10) NOT NULL,
	curso_id INTEGER NOT NULL
)ENGINE = innodb;

ALTER TABLE `cursos` ADD CONSTRAINT `cursos_universidade_fk` 
    FOREIGN KEY (`universidade_id`) REFERENCES `universidades`(`id`);

ALTER TABLE `alunos` ADD CONSTRAINT `alunos_cursos_fk` 
    FOREIGN KEY (`curso_id`) REFERENCES `cursos` ( `id` );
