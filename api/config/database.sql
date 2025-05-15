-- Active: 1746742835313@@127.0.0.1@3306@misae_solemnes
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

ALTER TABLE SACERDOTES ADD COLUMN usuario_id INT UNIQUE;
ALTER TABLE SACERDOTES ADD FOREIGN KEY (usuario_id) REFERENCES USUARIOS(id_usuario);

INSERT INTO PARROQUIAS (nombre_parroquia, direccion_parroquia, ciudad_parroquia, telefono_parroquia, correoElectronico_parroquia)
VALUES 
('Parroquia San Juan', 'Calle 10 #12-34', 'Medellín', '3100000001', 'sanjuan@iglesia.com'),
('Parroquia Nuestra Señora', 'Av. Bolívar 123', 'Bogotá', '3100000002', 'nuestra@iglesia.com'),
('Parroquia Cristo Rey', 'Cra 45 #33-21', 'Cali', '3100000003', 'cristorey@iglesia.com');



INSERT INTO PETICIONES (contenido, tipo, usuario_id, misa_id)
VALUES 
('Pido por la salud de mi madre.', 'pública', 2, 1),
('Oración por mi familia.', 'pública', 3, 1),
('Intención privada.', 'privada', 4, 2),
('Gracias por una nueva oportunidad.', 'pública', 3, 4);

-- Anadir la columna "quiere_correos" a la tabla usuarios para que 
--decida si desea que le lleguen correos o no

ALTER TABLE USUARIOS ADD COLUMN quiere_correos ENUM("si", "no") DEFAULT "si" NOT NULL;


-- Se elimina y cambia la foreing key con la misa, que es más rigido, además de que tiene que
--existir es misa para relacionar. Se añade la nueva constraint para con la parroquia, más flexible
ALTER TABLE PETICIONES
DROP FOREIGN KEY peticiones_ibfk_2;

ALTER TABLE PETICIONES
CHANGE misa_id parroquia_id INT;


ALTER TABLE PETICIONES
ADD CONSTRAINT fk_correcta_parroquia
FOREIGN KEY (parroquia_id)
REFERENCES PARROQUIAS(id_parroquia);
