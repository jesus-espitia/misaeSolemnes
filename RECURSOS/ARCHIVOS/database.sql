CREATE DATABASE IF NOT EXISTS misae_solemnes;
USE misae_solemnes;

-- Tabla: Usuario
CREATE TABLE USUARIOS (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL,
    correo_usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña_usuario VARCHAR(255) NOT NULL,
    pais_usuario VARCHAR(50) NOT NULL,
    fechaRegistro_usuario DATE DEFAULT CURRENT_DATE NOT NULL
);

-- Tabla: Parroquia
CREATE TABLE PARROQUIAS (
    id_parroquia INT AUTO_INCREMENT PRIMARY KEY,
    nombre_parroquia VARCHAR(100) NOT NULL,
    direccion_parroquia VARCHAR(200) NOT NULL,
    ciudad_parroquia VARCHAR(100) NOT NULL,
    telefono_parroquia VARCHAR(20) NOT NULL,
    correoElectronico_parroquia VARCHAR(100)
);

-- Tabla: Sacerdote
CREATE TABLE SACERDOTES (
    id_sacerdote INT AUTO_INCREMENT PRIMARY KEY,
    nombre_sacerdote VARCHAR(100) NOT NULL,
    correoElectronico_sacerdote VARCHAR(100) UNIQUE NOT NULL,
    telefono_sacerdote VARCHAR(20) NOT NULL,
    parroquia_id INT,
    FOREIGN KEY (parroquia_id) REFERENCES PARROQUIAS(id_parroquia)
);

-- Tabla: Misa
CREATE TABLE MISAS (
    id_misa INT AUTO_INCREMENT PRIMARY KEY,
    titulo_misa VARCHAR(100) NOT NULL,
    fecha_misa DATE NOT NULL,
    hora_misa TIME NOT NULL,
    tipo_misa ENUM('dominical', 'funeral', 'boda', 'otra') NOT NULL,
    sacerdote_id INT,
    FOREIGN KEY (sacerdote_id) REFERENCES SACERDOTES(id_sacerdote)
);

-- Tabla: Transmision
CREATE TABLE TRANSMISIONES (
    id_transmision INT AUTO_INCREMENT PRIMARY KEY,
    enlaceVideo_transmision VARCHAR(255) NOT NULL,
    plataforma_transmision ENUM('YouTube', 'Facebook', 'Otra') NOT NULL,
    estado_transmision ENUM('en vivo', 'finalizada', 'programada') NOT NULL,
    misa_id INT,
    FOREIGN KEY (misa_id) REFERENCES MISAS(id_misa)
);

-- Tabla: Peticion
CREATE TABLE PETICIONES (
    id_peticion INT AUTO_INCREMENT PRIMARY KEY,
    contenido VARCHAR(255) NOT NULL,
    tipo ENUM('pública', 'privada') NOT NULL,
    fecha_envio DATE DEFAULT CURRENT_DATE NOT NULL,
    usuario_id INT,
    misa_id INT,
    FOREIGN KEY (usuario_id) REFERENCES USUARIOS(id_usuario),
    FOREIGN KEY (misa_id) REFERENCES MISAS(id_misa)
);


-- INSERCIONES 

INSERT INTO USUARIOS (nombre_usuario, correo_usuario, contraseña_usuario, pais_usuario)
VALUES 
('Ana Gómez', 'ana.gomez@example.com', 'pass123', 'México'),
('Luis Pérez', 'luis.perez@example.com', 'secure456', 'Colombia'),
('María Torres', 'maria.torres@example.com', 'clave789', 'Argentina'),
('Carlos López', 'carlos.lopez@example.com', 'qwerty123', 'Chile'),
('Lucía Fernández', 'lucia.fernandez@example.com', 'mypass321', 'Perú'),
('José Ramírez', 'jose.ramirez@example.com', 'pass654', 'México'),
('Camila Soto', 'camila.soto@example.com', 'contraseña1', 'Colombia'),
('Fernando Díaz', 'fernando.diaz@example.com', '123abc456', 'Ecuador'),
('Valentina Cruz', 'valentina.cruz@example.com', 'passcruz22', 'México'),
('Andrés Herrera', 'andres.herrera@example.com', 'securepass', 'Argentina');

INSERT INTO PARROQUIAS (nombre_parroquia, direccion_parroquia, ciudad_parroquia, telefono_parroquia, correoElectronico_parroquia)
VALUES 
('Parroquia San Juan', 'Av. Reforma 123', 'Ciudad de México', '555-1234', 'sanjuan@parroquia.com'),
('Parroquia La Merced', 'Calle Bolívar 456', 'Bogotá', '312-3456', 'lamerced@iglesia.co'),
('Parroquia San Pedro', 'Jr. Ayacucho 789', 'Lima', '987-6543', 'sanpedro@parroquia.pe'),
('Parroquia Santa María', 'Carrera 10 #20-30', 'Medellín', '301-2345', 'santamaria@iglesia.co'),
('Parroquia Cristo Rey', 'Av. Las Palmas 55', 'Quito', '099-8765', 'cristorey@parroquia.ec'),
('Parroquia San José', 'Calle 100 #45-67', 'Santiago', '567-8901', 'sanjose@iglesia.cl'),
('Parroquia Sagrada Familia', 'Av. Libertador 321', 'Buenos Aires', '011-4567', 'sagradafamilia@iglesia.ar'),
('Parroquia Santa Cruz', 'Av. del Sol 78', 'Monterrey', '818-3344', 'santacruz@parroquia.mx'),
('Parroquia Inmaculada Concepción', 'Calle Real 9', 'Cusco', '084-5678', 'inmaculada@iglesia.pe'),
('Parroquia San Rafael', 'Av. Central 101', 'Guadalajara', '333-1234', 'sanrafael@parroquia.mx');

INSERT INTO SACERDOTES (nombre_sacerdote, correoElectronico_sacerdote, telefono_sacerdote, parroquia_id)
VALUES 
('Padre Juan Carlos', 'juan.carlos@iglesia.com', '555-0001', 1),
('Padre Martín Ríos', 'martin.rios@iglesia.com', '312-0002', 2),
('Padre Pedro Gómez', 'pedro.gomez@iglesia.com', '987-0003', 3),
('Padre Álvaro Díaz', 'alvaro.diaz@iglesia.com', '301-0004', 4),
('Padre Luis Romero', 'luis.romero@iglesia.com', '099-0005', 5),
('Padre José Morales', 'jose.morales@iglesia.com', '567-0006', 6),
('Padre Esteban Lara', 'esteban.lara@iglesia.com', '011-0007', 7),
('Padre Tomás Herrera', 'tomas.herrera@iglesia.com', '818-0008', 8),
('Padre Ernesto Valdez', 'ernesto.valdez@iglesia.com', '084-0009', 9),
('Padre Manuel Ruiz', 'manuel.ruiz@iglesia.com', '333-0010', 10);

INSERT INTO MISAS (titulo_misa, fecha_misa, hora_misa, tipo_misa, sacerdote_id)
VALUES 
('Misa de Domingo de Ramos', '2025-03-23', '10:00:00', 'dominical', 1),
('Misa de Difuntos', '2025-02-15', '18:00:00', 'funeral', 2),
('Misa de Bodas de Plata', '2025-04-05', '16:00:00', 'boda', 3),
('Misa Familiar', '2025-01-12', '09:00:00', 'otra', 4),
('Misa por la Paz', '2025-03-01', '12:00:00', 'dominical', 5),
('Misa de Bodas', '2025-04-01', '17:00:00', 'boda', 6),
('Misa Especial', '2025-04-07', '11:00:00', 'otra', 7),
('Misa Dominical', '2025-04-06', '08:00:00', 'dominical', 8),
('Misa de Reposo', '2025-03-30', '19:00:00', 'funeral', 9),
('Misa Pascual', '2025-04-20', '10:30:00', 'dominical', 10);

INSERT INTO TRANSMISIONES (enlaceVideo_transmision, plataforma_transmision, estado_transmision, misa_id)
VALUES 
('https://youtube.com/misa1', 'YouTube', 'finalizada', 1),
('https://facebook.com/misa2', 'Facebook', 'finalizada', 2),
('https://youtube.com/misa3', 'YouTube', 'finalizada', 3),
('https://otro.com/misa4', 'Otra', 'finalizada', 4),
('https://youtube.com/misa5', 'YouTube', 'programada', 5),
('https://facebook.com/misa6', 'Facebook', 'en vivo', 6),
('https://youtube.com/misa7', 'YouTube', 'programada', 7),
('https://otro.com/misa8', 'Otra', 'finalizada', 8),
('https://facebook.com/misa9', 'Facebook', 'finalizada', 9),
('https://youtube.com/misa10', 'YouTube', 'en vivo', 10);

INSERT INTO PETICIONES (contenido, tipo, usuario_id, misa_id)
VALUES 
('Oración por la salud de mi madre', 'privada', 1, 1),
('Por el alma de los difuntos', 'pública', 2, 2),
('Bendición para mi matrimonio', 'privada', 3, 3),
('Gracias por un año más de vida', 'pública', 4, 4),
('Oración por los niños del mundo', 'pública', 5, 5),
('Intención por los enfermos', 'pública', 6, 6),
('Petición por empleo', 'privada', 7, 7),
('Por los jóvenes en crisis', 'pública', 8, 8),
('Agradecimiento por la familia', 'privada', 9, 9),
('Paz y unidad en nuestra comunidad', 'pública', 10, 10);
