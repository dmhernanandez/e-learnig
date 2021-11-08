-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.14 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para dbgadalearning
CREATE DATABASE IF NOT EXISTS `dbgadalearning` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbgadalearning`;

-- Volcando estructura para tabla dbgadalearning.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL DEFAULT '0',
  `descripcion` varchar(300) DEFAULT '0',
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `nombre` (`nombre_categoria`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Esta tabla sirve para agrupar los cursos de acuerdo a su tematica\r\n';



-- Volcando estructura para tabla dbgadalearning.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(70) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(700) NOT NULL,
  `habilidades` varchar(1000) DEFAULT NULL,
  `oferta` varchar(1000) DEFAULT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Inactivo',
  `url_foto` varchar(300) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_instructor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_curso`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `FK_cursos_categorias` (`id_categoria`),
  KEY `FK_instructores_cursos` (`id_instructor`) USING BTREE,
  CONSTRAINT `FK_cursos_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE,
  CONSTRAINT `FK_instructores_cursos` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`idinstructores`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COMMENT='Esta tabla contendra todos los cursos registrados  por el usuario';



-- Volcando estructura para tabla dbgadalearning.cursos_registrados
CREATE TABLE IF NOT EXISTS `cursos_registrados` (
  `id_curso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `f_inscripcion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_curso`,`id_usuario`),
  KEY `FK_cursos_registrados_usuarios` (`id_usuario`),
  CONSTRAINT `FK_cursos_registrados_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON UPDATE CASCADE,
  CONSTRAINT `FK_cursos_registrados_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='En esta tabla apareceran los cursos registrados por un usuario\r\n';

-- Volcando datos para la tabla dbgadalearning.cursos_registrados: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos_registrados` DISABLE KEYS */;
/*!40000 ALTER TABLE `cursos_registrados` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.examenes
CREATE TABLE IF NOT EXISTS `examenes` (
  `id_examen` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '0',
  `instrucciones` varchar(500) DEFAULT '0',
  `valor` int(11) NOT NULL DEFAULT '0',
  `id_curso` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_examen`),
  UNIQUE KEY `id_curso` (`id_curso`),
  CONSTRAINT `FK_examenes_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbgadalearning.examenes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `examenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `examenes` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.glosario
CREATE TABLE IF NOT EXISTS `glosario` (
  `id_glosario` int(11) NOT NULL AUTO_INCREMENT,
  `palabra` varchar(50) NOT NULL DEFAULT '0',
  `significa` varchar(400) NOT NULL DEFAULT '0',
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id_glosario`),
  KEY `FK_glosario_cursos` (`id_curso`),
  CONSTRAINT `FK_glosario_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Aqui se guardaran palabras del glosario que nosotros necesitamos\r\n';

-- Volcando datos para la tabla dbgadalearning.glosario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `glosario` DISABLE KEYS */;
/*!40000 ALTER TABLE `glosario` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.instructores
CREATE TABLE IF NOT EXISTS `instructores` (
  `idinstructores` int(11) NOT NULL AUTO_INCREMENT,
  `Nombres` varchar(45) DEFAULT NULL,
  `Apellidos` varchar(45) DEFAULT NULL,
  `Correo` varchar(45) DEFAULT NULL,
  `Telefono` varchar(45) DEFAULT NULL,
  `Profesion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idinstructores`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `lecciones` (
  `id_leccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_leccion` varchar(60) NOT NULL DEFAULT '',
  `descripcion` varchar(300) NOT NULL DEFAULT '',
  `url_documento` varchar(200) NOT NULL DEFAULT '',
  `estado` varchar(30) NOT NULL DEFAULT 'Inactivo',
  `estado_visto` varchar(30) NOT NULL DEFAULT 'no_visto',
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id_leccion`),
  KEY `FK_lecciones_cursos` (`id_curso`),
  CONSTRAINT `FK_lecciones_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='Aqui se guardaran todas las lecciones que nosotros creemos';



-- Volcando estructura para tabla dbgadalearning.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id_examen` int(11) NOT NULL DEFAULT '0',
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `nota_final` int(11) NOT NULL DEFAULT '0',
  `fecha_realizado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`,`id_examen`) USING BTREE,
  KEY `FK_notas_examenes` (`id_examen`),
  CONSTRAINT `FK_notas_examenes` FOREIGN KEY (`id_examen`) REFERENCES `examenes` (`id_examen`) ON UPDATE CASCADE,
  CONSTRAINT `FK_notas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='aqui se mostraran las notas finales';

-- Volcando datos para la tabla dbgadalearning.notas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.preguntas
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id_pregunta` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(300) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT '0',
  `id_examen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pregunta`),
  KEY `FK_preguntas_examenes` (`id_examen`),
  CONSTRAINT `FK_preguntas_examenes` FOREIGN KEY (`id_examen`) REFERENCES `examenes` (`id_examen`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Aqui se guardaran todas las preguntas del examen';

-- Volcando datos para la tabla dbgadalearning.preguntas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.prueba
CREATE TABLE IF NOT EXISTS `prueba` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `anio` varchar(10) NOT NULL,
  `periodo` varchar(20) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `nota1` int(11) DEFAULT '0',
  `nota2` int(11) DEFAULT '0',
  `nota3` int(11) DEFAULT '0',
  `total` int(11) DEFAULT '0',
  `estado` varchar(30) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



-- Volcando estructura para tabla dbgadalearning.respuestas
CREATE TABLE IF NOT EXISTS `respuestas` (
  `id_respuesta` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta` varchar(300) NOT NULL,
  `estado` varchar(30) NOT NULL COMMENT 'El estado indica  si es la respuesta correcta o no',
  `id_pregunta` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_respuesta`),
  KEY `FK_respuestas_preguntas` (`id_pregunta`),
  CONSTRAINT `FK_respuestas_preguntas` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='En esta tabla se guardaran las respuestas de las preguntas que nosotros creamos';

-- Volcando datos para la tabla dbgadalearning.respuestas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '0',
  `apellido` varchar(50) NOT NULL DEFAULT '0',
  `correo` varchar(50) NOT NULL DEFAULT '0',
  `usuario` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `tipo_usuario` varchar(50) NOT NULL DEFAULT 'estudiante',
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='En esta tabla estaran registrados todos los usuarios y sus datos';


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
