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


--Alterar la tabla peticiones para que contenido llegue hasta 300 caracteres
ALTER TABLE `PETICIONES` CHANGE `contenido` `contenido` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

--inserciones para la tabla peticiones 
INSERT INTO PETICIONES (contenido, tipo, fecha_envio, usuario_id, parroquia_id) VALUES
-- Peticiones públicas
('Pido por la salud de mi madre que está enferma de gravedad, que Dios le dé fortaleza y sanación completa.', 'pública', '2023-11-15', 1, 1),
('Ruego que recen por mi familia para que superemos esta crisis económica y encontremos soluciones con la ayuda divina.', 'pública', '2023-11-16', 2, 3),
('Pido oraciones por mi hijo que está pasando por una depresión muy fuerte, y que la misa la pudiera hacer el padre Alberto, a quien admira mucho.', 'pública', '2023-11-17', 3, 2),
('Solicito oraciones por la paz en el mundo, especialmente en aquellos países que sufren guerras y violencia sin sentido.', 'pública', '2023-11-18', 4, 1),
('Pido por mi matrimonio que está pasando por momentos muy difíciles, que Dios nos ilumine y nos ayude a recuperar el amor y la comunicación.', 'pública', '2023-11-19', 5, 3),
-- Peticiones privadas
('Ruego en privado por la conversión de mi hermano que se ha alejado de la fe, que el Espíritu Santo toque su corazón.', 'privada', '2023-11-15', 6, 1),
('Pido secretamente por mi trabajo, que encuentre la fuerza para seguir adelante y que Dios me guíe en mis decisiones profesionales.', 'privada', '2023-11-16', 1, 1),
('Solicito oraciones privadas por mi abuela que cumple 90 años, que la Virgen María la proteja y le dé salud en sus días.', 'privada', '2023-11-17', 2, 2),
-- Peticiones más largas y específicas
('Pido con todo mi corazón por la salud de mi sobrino que está en el hospital con una enfermedad rara. Que los médicos encuentren el tratamiento adecuado y que el niño tenga fortaleza. Me gustaría que el padre Juan, que tiene un don especial con los niños, pudiera ofrecer la misa por él.', 'pública', '2023-11-20', 3, 2),
('Ruego por la unidad de mi familia que está dividida por rencores antiguos. Que el perdón y la reconciliación lleguen a nuestros corazones. Pido especialmente que en la misa del domingo se rece por esta intención y que el padre Luis, que es experto en consejería familiar, pueda guiarnos.', 'pública', '2023-11-21', 4, 3),
('Pido por todos los enfermos de cáncer, especialmente por aquellos que no tienen familia o recursos. Que encuentren consuelo en Dios y buena atención médica. Desearía que esta intención se incluyera en la misa de sanación del mes que viene.', 'pública', '2023-11-22', 5, 2),
('Solicito oraciones por mi vocación, pues estoy discerniendo si debo entrar al seminario. Que Dios me ilumine y me muestre claramente su voluntad. Me gustaría que el padre Miguel, que fue mi director espiritual en el retiro, pudiera ofrecer una misa por esta intención.', 'privada', '2023-11-23', 6, 1);


SELECT id_parroquia, nombre_parroquia FROM PARROQUIAS