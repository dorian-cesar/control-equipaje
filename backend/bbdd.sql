CREATE DATABASE equipaje_bus;
USE equipaje_bus;

CREATE TABLE registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rut VARCHAR(12) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    origen VARCHAR(50) NOT NULL,
    destino VARCHAR(50) NOT NULL,
    asiento INT NOT NULL,
    servicio VARCHAR(20) NOT NULL,
    equipaje INT NOT NULL,
    codigo_equipaje VARCHAR(30) NOT NULL,
    fecha_hora DATETIME NOT NULL
);

CREATE TABLE ciudades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO ciudades (nombre) VALUES
('Arica'),
('Iquique'),
('Antofagasta'),
('Copiapó'),
('La Serena'),
('Valparaíso'),
('Rancagua'),
('Talca'),
('Chillán'),
('Concepción'),
('Temuco'),
('Valdivia'),
('Puerto Montt'),
('Coyhaique'),
('Punta Arenas'),
('Santiago');

