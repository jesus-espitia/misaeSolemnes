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
    correoElectronico_sacerdote VARCHAR(100) UNIQUE,
    telefono_sacerdote VARCHAR(20),
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
    fecha_envio DATE DEFAULT CURRENT_DATE,
    usuario_id INT,
    misa_id INT,
    FOREIGN KEY (usuario_id) REFERENCES USUARIOS(id_usuario),
    FOREIGN KEY (misa_id) REFERENCES MISAS(id_misa)
);
