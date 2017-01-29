#Creacion de base de datos
CREATE USER IF NOT EXISTS incidenceJuan IDENTIFIED BY '123';

DROP DATABASE IF EXISTS incidenciasJuanAntonio;
CREATE DATABASE IF NOT EXISTS incidenciasJuanAntonio;

GRANT ALL PRIVILEGES ON incidenciasJuanAntonio.* TO incidenceJuan;

#Usamos esa base de datos
USE incidenciasJuanAntonio;

#tabla profesores
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(30) NOT NULL,
    password VARCHAR(200) NOT NULL,
    borrado INT DEFAULT 0
);
#tabla type_incidence
CREATE TABLE IF NOT EXISTS type_incidence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(100) NOT NULL
);

#tabla incidencias
CREATE TABLE IF NOT EXISTS incidence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_teacher INT NOT NULL,
    name_alumno VARCHAR(30) NOT NULL,
    title VARCHAR(40) NOT NULL,
    id_typeincidence INT NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (id_teacher) REFERENCES teachers(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_typeincidence) REFERENCES type_incidence(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

#insertamos en las tablas

INSERT INTO teachers( user, password) VALUES ("superprofe", sha('123'));
INSERT INTO teachers( user, password) VALUES ("Juan", sha('123'));
INSERT INTO teachers( user, password) VALUES ("Lourdes", sha('123'));
INSERT INTO teachers( user, password) VALUES ("Sebastian", sha('123'));

INSERT INTO type_incidence(description) VALUES ("Retraso del alumno/a");
INSERT INTO type_incidence(description) VALUES ("Fuma en el baño el alumno/a");
INSERT INTO type_incidence(description) VALUES ("No trabaja el alumno/a");
INSERT INTO type_incidence(description) VALUES ("No respeta el alumno/a");
INSERT INTO type_incidence(description) VALUES ("Se saca mocos el alumno/a");
INSERT INTO type_incidence(description) VALUES ("Se ha suicidado el alumno/a");
INSERT INTO type_incidence(description) VALUES ("Miss Daisy porque le tengo manía al alumno/a");

INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (2,"Amador Fernandez","Trabaja demasiado",2, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (2,"Amador Fernandez","Trabaja demasiado",7, '2017-01-22');
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (3,"Samara Larara","No viene",1, '2017-01-22');
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (3,"Samara Larara","No viene",1, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (4,"Juan Antonio","Es una cerdaca",5, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (4,"Paquito perez","Insulta hasta a la pared",4, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (2,"Amador Fernandez","Ahora se ha cagado en mi persona",4, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (3,"Samara Larara","Sigue sin venir",1, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (2,"Juan Antonio","Es una cerdaca",5, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (4,"Paquito perez","He llamado a la funeraria",6, CURDATE());
INSERT INTO incidence(id_teacher,name_alumno,title,id_typeincidence,fecha) VALUES 
        (4,"Paquito perez","He llamado a la funeraria",7, '2017-01-22');
