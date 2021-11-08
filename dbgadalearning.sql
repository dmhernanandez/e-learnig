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

-- Volcando datos para la tabla dbgadalearning.categorias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
	(1, 'Computación', 'Esta categoria agrupa todos los cursos que tienen que estan relacionados con la rama de la commputación'),
	(2, 'Arte', 'Esta categoria contendra todas lo relacionado con el arte'),
	(3, 'Diseño web', 'En esta categoria encontrara todo lo relacionado con el diseño web ');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

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

-- Volcando datos para la tabla dbgadalearning.cursos: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`id_curso`, `codigo`, `nombre`, `descripcion`, `habilidades`, `oferta`, `estado`, `url_foto`, `id_categoria`, `id_instructor`) VALUES
	(22, 'CURSONUM4', 'Curso', 'Wiki es un concepto que se utiliza en el ámbito de Internet para referirse a las páginas web cuyos contenidos pueden ser editados por múltiples usuarios a través de cualquier navegador. El término wiki procede del hawaiano wiki wiki, que significa rápido, y fue propuesto por Ward Cunningham.', 'correr,rascar,morder,comoer,correr.', 'Sumar,restar,actualizar,eliminar,colocar,eliminar', 'Activo', 'CURSONUM4_1602877658.png', 3, 3),
	(23, 'CURSONUM40', 'Progamacion', 'Este curso esta orientado a  c++', 'Segunda actualizacion ', '30 horas de videos, compras en linea utilizando c++', 'Inactivo', 'Arqueo-Recuento-Dinero-Cierre-1024x768.jpg', 1, 3),
	(24, 'BPS58', 'Curso', 'Como hacer el continius deployment', 'fafafasfaf', 'dfjakfafafaf', 'Inactivo', 'BPS58_1597680092.jpg', 2, 3),
	(25, 'PRBA-12', 'Segunda prueba curso', 'Esta es una descripcion', 'nada de nada', 'no ofrece nada', 'Activo', 'logo-PRBA-121596949441.jpg', 3, 1),
	(26, 'PRBA-1', 'Segunda', 'Hola que tal', 'Hola que tal todo', 'Como estan', 'Inactivo', 'PRBA-1_1597691429.png', 1, 3),
	(27, 'CUR-25', 'Programacion', 'Al quitarle el banco de capacitores se puede notar la caída del factor de potencia, donde se da por entendido que se necesita y este a la vez está ejerciendo una función muy importante en la planta, ahorra perdida de energía y a la vez dinero que se refleja en los recibos de energía eléctrica.', 'Hola', 'Descripcion', 'Activo', 'CUR-25_1622836881.png', 3, 1),
	(28, 'UTMA-98', 'Curso', 'Elija una opcion', 'prueba', 'prueba ', 'Activo', 'UTMA-98_1597514793.png', 2, 1),
	(29, 'ADE-0601', 'Diseño web y arquitectura', 'En este curso aprenderas las habilidades basicas de la creacion.', 'Comprobar como ser mejor,caminar, correr,dormir', 'Este curso ofrece muchas ventajas al usuario', 'Activo', 'CODIGO-DANY_1597514921.png', 3, 3),
	(30, 'CRUDS01', 'Programacion Orientada a Objetos', 'Este curso esta orientado a la programación, especificamente de la programcion orientado en a objetos.', 'Maneja la precion., aprende a trabajar con las personas, compra nuevas cosas, Recorer los problemas.', 'Aprender, Conocer, Correr.', 'Activo', 'CRUDS01_1602883508.jpg', 3, 2);
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

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

-- Volcando datos para la tabla dbgadalearning.instructores: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `instructores` DISABLE KEYS */;
INSERT INTO `instructores` (`idinstructores`, `Nombres`, `Apellidos`, `Correo`, `Telefono`, `Profesion`) VALUES
	(1, 'Juan Antonio', 'Santos', 'jose@gada.com', '95079139', 'Experto en programcion y diseño'),
	(2, 'Dany', 'Hernandez', 'dany1999hernan@gmail.com', '333', 'Maestro en casa'),
	(3, 'Mauricio', 'Hernandez', 'dany@gamail.com', '95017', 'Experto en arreglo y diseño');
/*!40000 ALTER TABLE `instructores` ENABLE KEYS */;

-- Volcando estructura para tabla dbgadalearning.lecciones
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

-- Volcando datos para la tabla dbgadalearning.lecciones: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `lecciones` DISABLE KEYS */;
INSERT INTO `lecciones` (`id_leccion`, `nombre_leccion`, `descripcion`, `url_documento`, `estado`, `estado_visto`, `id_curso`) VALUES
	(8, 'Introduccion a html', 'Descripcion', 'Introducion_a_html_y_css_1597005397.pdf', 'Inactivo', 'no_visto', 22),
	(18, 'Introduccion a java', 'En este se detallara los conceptos basicos de java', 'Introduccion_a_Java_1597649560.pdf', 'Inactivo', 'no_visto', 26),
	(19, 'Primera leccion de prueba', 'Esto es una leccion de prueba', 'Primera_leccion_de_prueba_1597695387.pdf', 'Activo', 'no_visto', 27),
	(20, 'Introducción a conceptos básicos de POO', 'En esta leccion se abordan las tematicas principales, relacionadas con el analisis y diseño de la programación orientada a objetos', 'Introducción_a_conceptos_básicos_de_POO_1602885886.pdf', 'Activo', 'no_visto', 30);
/*!40000 ALTER TABLE `lecciones` ENABLE KEYS */;

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

-- Volcando datos para la tabla dbgadalearning.prueba: 3 rows
/*!40000 ALTER TABLE `prueba` DISABLE KEYS */;
INSERT INTO `prueba` (`id`, `codigo`, `nombre`, `anio`, `periodo`, `campus`, `nota1`, `nota2`, `nota3`, `total`, `estado`) VALUES
	(5, 'ADE-0601', 'ANALISIS Y DISEÑO DE ALGORITMOS', '2020', '1', 'Siguatepeque', 17, 31, 45, 93, 'Reprodado'),
	(6, 'ESG-2020', 'ESPAÑOL I', '2023', '2', 'Santa Bárbara', 18, 34, 45, 97, 'Ausente'),
	(7, 'ADE-0601', 'ANALISIS Y DISEÑO DE ALGORITMOS', '2020', '1', 'Siguatepeque', 17, 31, 45, 93, 'Reprodado');
/*!40000 ALTER TABLE `prueba` ENABLE KEYS */;

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

-- Volcando datos para la tabla dbgadalearning.usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `correo`, `usuario`, `password`, `tipo_usuario`) VALUES
	(4, 'Mauricio', 'Hernana', 'noodprohn+sosidos@gmail.com', 'dany', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'estudiante'),
	(5, 'Dany', 'Hernandez', 'dhhernan@yahoo.com', 'mauricio', '8cb2237d0679ca88db6464eac60da96345513964', 'estudiante'),
	(6, 'Erick', 'España', 'her', 'erick', '7c222fb2927d828af22f592134e8932480637c0d', 'estudiante'),
	(9, 'Dany', 'Hernandez', 'dany1999heran@gmail.com', 'danym', '8cb2237d0679ca88db6464eac60da96345513964', 'estudiante'),
	(10, 'Marvin', 'Rodriguez', 'dany1999hernandez@hotmail.com', 'marvin', '8cb2237d0679ca88db6464eac60da96345513964', 'estudiante'),
	(11, 'Sara ', 'Ramos', '12345678', 'Sosorto', '7c222fb2927d828af22f592134e8932480637c0d', 'estudiante'),
	(15, 'Dany', 'Hernandez', 'dany1999hernan@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrador');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
