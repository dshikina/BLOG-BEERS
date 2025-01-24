-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-12-2024 a las 03:30:20
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cerveza`
--
CREATE DATABASE IF NOT EXISTS `cerveza` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `cerveza`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'Lager', 'Es una de las cervezas más populares del mundo, caracterizada por su color claro y su sabor limpio y refrescante. Su proceso de fermentación a bajas temperaturas le da un perfil suave y equilibrado. Puede variar desde Lager Pale (ligera y suave) hasta Dark Lager (más robusta y maltosa).', 'lager.png'),
(2, 'Stout', 'Es una cerveza oscura, casi negra, conocida por su sabor intenso y su textura cremosa. Suele tener notas a café, chocolate, malta tostada e incluso avena, dependiendo del tipo de Stout.', 'stout.jpg'),
(3, 'IPA', 'Se destaca por su alto contenido de lúpulo, lo que le aporta un sabor amargo y aromas cítricos, florales o frutales. Originalmente, fue diseñada para soportar largos viajes durante la colonización británica en la India. Variedades comunes incluyen American IPA (con sabores a frutas tropicales) y Double IPA (más alcohólica y lupulada).', 'ipa.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cervezas`
--

DROP TABLE IF EXISTS `cervezas`;
CREATE TABLE IF NOT EXISTS `cervezas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `alcohol` decimal(4,2) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `id_categoria` int NOT NULL,
  `descripcion` text,
  `notaDeCata` text,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcionCorta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cervezas`
--

INSERT INTO `cervezas` (`id`, `nombre`, `origen`, `alcohol`, `fecha_creacion`, `id_categoria`, `descripcion`, `notaDeCata`, `imagen`, `descripcionCorta`) VALUES
(2, 'Alhambra', 'España', 3.00, '2024-11-11', 1, 'La cerveza Alhambra es una marca española originaria de Granada, conocida por su elaboración artesanal y sus sabores ricos y equilibrados. Destaca especialmente Alhambra Reserva 1925, una lager de estilo Märzen con notas tostadas y un perfil suave, ideal para acompañar tapas. Su botella distintiva sin etiqueta y su enfoque en la calidad la han convertido en un símbolo de sofisticación y tradición cervecera en España.', 'De color ámbar intenso y espuma cremosa. En boca, destaca por su sabor maltoso con notas tostadas y un amargor equilibrado, dejando un final suave y persistente.', 'al.png', 'Cerveza Lager de sabor único y matices afrutados.'),
(3, 'Asahi', 'Japón', 6.00, '2024-11-11', 1, 'La cerveza Asahi Super Dry es una lager japonesa icónica, conocida por su enfoque en la frescura y el equilibrio. Es ligera, con un perfil seco (\"Karakuchi\") que la distingue, diseñada para ser refrescante y acompañar bien la gastronomía asiática. Es una de las cervezas más populares de Japón y cuenta con una presencia internacional significativa.', 'De color dorado pálido y espuma ligera. En boca, tiene un sabor seco y limpio, con ligeras notas maltosas y un amargor suave, lo que la hace extremadamente refrescante.', 'as.png', 'Cerveza Lager con sabor ligero y refrescante.'),
(4, 'Budweisser', 'Estados Unidos', 5.00, '2024-11-11', 1, 'Budweiser es una lager americana de estilo clásico, reconocida por su sabor suave y equilibrado. Elaborada con malta de cebada, arroz y lúpulos selectos, es una de las cervezas más populares del mundo gracias a su ligereza y capacidad de maridar con una amplia variedad de alimentos.', 'De color dorado pálido y espuma ligera. De color dorado brillante y espuma ligera. En boca, ofrece un sabor suave con notas dulces de malta y un ligero amargor, dejando un final limpio y refrescante.', 'bud.png', 'Cerveza Lager de sabor ligero y refrescante.'),
(5, 'Cristal', 'Perú', 7.00, '2024-11-11', 1, 'Cristal es una lager peruana conocida como \"La cerveza de los peruanos\". Es ligera y refrescante, elaborada con malta, maíz y lúpulos cuidadosamente seleccionados, lo que la hace ideal para el clima cálido y para acompañar la gastronomía local.', 'De color dorado brillante y espuma ligera. En boca, es suave, con un toque de dulzura de malta y un amargor sutil que la convierte en una opción refrescante y fácil de beber.', 'cri.png', 'Cerveza Lager con un fuerte sabor fresco.'),
(6, 'Cusqueña', 'Perú', 6.00, '2024-11-11', 3, 'Cusqueña es una cerveza IPA peruana elaborada con ingredientes de alta calidad, como cebada malteada y agua pura de los Andes. Es conocida por su dedicación al detalle y su variedad de estilos, siendo Cusqueña Dorada una de las más icónicas. Representa el orgullo peruano y es un complemento perfecto para la rica gastronomía del país.', 'De color dorado brillante y espuma cremosa. En boca, destaca su sabor balanceado con ligeras notas maltosas y un amargor suave, ofreciendo un final limpio y refrescante.', 'cu.png', 'Una IPA ligera y refrescante, ideal para el verano.'),
(7, 'Estrella', 'España', 3.00, '2024-11-11', 3, 'Estrella Damm, originaria de Barcelona, es una IPA mediterránea de carácter refrescante y ligero. Elaborada con ingredientes 100% naturales, como malta de cebada, arroz y lúpulo, es una cerveza versátil, ideal para disfrutar en cualquier ocasión y perfecta para maridar con la cocina mediterránea.', 'De color dorado brillante y espuma consistente. En boca, tiene un sabor suave con notas dulces de malta, un toque de cereal y un amargor moderado que la hace equilibrada y refrescante.', 'es.png', 'Cerveza IPA con un sabor único y refrescante.'),
(8, 'Heineken', 'Países Bajos', 4.00, '2024-11-11', 3, 'Heineken es una IPA holandesa icónica, conocida por su calidad constante y su distintivo sabor. Elaborada con solo tres ingredientes naturales: agua, malta de cebada y lúpulo, y fermentada con su exclusiva levadura A-Yeast, ofrece un perfil equilibrado y refrescante, ideal para disfrutar en cualquier ocasión.', 'Presenta un color dorado intenso con espuma blanca y delicada. En el paladar, se perciben ligeros matices maltosos, un sutil amargor y notas herbales que aportan frescura, culminando en un final equilibrado y agradable.', 'hei.png', 'Cerveza IPA refrescante con sabor suave.'),
(9, 'Kirin', 'Japón', 6.00, '2024-11-11', 3, 'Kirin es una cerveza japonesa de estilo IPA, conocida por su sabor limpio y refrescante. Elabora su receta con malta de cebada, arroz y agua de alta calidad, lo que le da un toque suave y una ligera complejidad. Es una de las marcas más populares en Japón y en todo el mundo, perfecta para acompañar platos de la gastronomía asiática.', 'De color dorado claro y espuma blanca y ligera. En boca, tiene un sabor suave con un toque de malta y un amargor moderado, dejando una sensación fresca y un final limpio.', 'ki.png', 'Cerveza IPA de sabor suave y refrescante.'),
(10, 'Mahou', 'España', 4.00, '2024-11-11', 2, 'Mahou es una cerveza Stout española originaria de Madrid, muy conocida por su sabor suave y equilibrado. Elaborada con malta de cebada, agua y lúpulo seleccionados, es una de las cervezas más consumidas en España. Es ideal para disfrutar de manera casual y acompaña perfectamente la gastronomía mediterránea.', 'De color dorado brillante con espuma blanca y ligera. En boca, ofrece un sabor suave con notas maltosas y un toque de amargor sutil, resultando en una cerveza refrescante y de cuerpo ligero con un final limpio.', 'ma.png', 'Cerveza Stout muy popular con sabor equilibrado.'),
(11, 'Pilsen Callao', 'Perú', 5.00, '2024-11-11', 2, 'La Pilsen Callao es una cerveza de tipo Stout, caracterizada por su sabor refrescante y ligeramente amargo. Con un balance perfecto entre malta y lúpulo, es ideal para disfrutar en climas cálidos o acompañada de comidas ligeras.', 'Esta cerveza tiene un color dorado brillante y una espuma densa. En boca, se percibe un sabor suave, con un toque de amargor moderado que la hace muy refrescante.', 'pi.png', 'Una Stout con sabor agradable y fresca.'),
(12, 'Tres Cruces', 'Perú', 7.00, '2024-11-11', 2, 'Tres Cruces es una cerveza Stout peruana que se caracteriza por su sabor ligero y refrescante. Hecha con malta de cebada y lúpulo de calidad, esta cerveza es ideal para disfrutar en cualquier ocasión, especialmente en el clima cálido de Perú. Es una opción popular por su balance entre suavidad y frescura.', 'De color dorado pálido y espuma blanca y fina. En boca, presenta un sabor suave con notas ligeras de malta y un toque de amargor moderado, ofreciendo un final limpio y refrescante, perfecto para acompañar una amplia variedad de platos.', 'tres.png', 'Cerveza Stout con un fuerte sabor amargo y fuerte.'),
(13, 'Victoria', 'España', 5.00, '2024-11-11', 2, 'Victoria es una cerveza Stout española, originaria de Málaga, con un sabor suave y refrescante. Elabora con ingredientes de alta calidad, incluyendo malta de cebada y lúpulo, lo que le confiere un perfil equilibrado. Es muy apreciada en el sur de España, ideal para disfrutar durante comidas informales o en días calurosos.', 'De color dorado claro con espuma blanca y delicada. En boca, tiene un sabor suave con un ligero toque maltoso y un amargor moderado, que la hace muy refrescante y fácil de beber, con un final limpio y agradable.', 'vic.png', 'Cerveza Stout con un sabor delicado y suave.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenias`
--

DROP TABLE IF EXISTS `resenias`;
CREATE TABLE IF NOT EXISTS `resenias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `comentario` text NOT NULL,
  `id_usuario` int NOT NULL,
  `id_cerveza` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_cerveza` (`id_cerveza`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `resenias`
--

INSERT INTO `resenias` (`id`, `fecha`, `comentario`, `id_usuario`, `id_cerveza`) VALUES
(1, '2024-12-09', 'rgrgtrgtg', 7, 2),
(18, '2024-12-09', 'Viva la cristal', 7, 5),
(17, '2024-12-09', 'Cerveza increíble con toques sutiles', 7, 4),
(15, '2024-12-09', 'fdrgre', 12, 2),
(16, '2024-12-09', 'Cerveza Japonesa de calidad', 7, 3),
(19, '2024-12-09', 'Elegancia absoluta ', 7, 6),
(20, '2024-12-09', 'Locura absoluta', 7, 7),
(21, '2024-12-09', 'Diamentesca', 7, 8),
(22, '2024-12-09', 'Elixir de la vida, recomendada', 7, 9),
(23, '2024-12-09', 'De lo mejor del mundo, respeto total', 7, 10),
(24, '2024-12-09', 'La mejor cerveza del mundo, exquisitez y agradable a más no poder', 7, 11),
(25, '2024-12-09', 'Buena, pero hay mejores', 7, 12),
(26, '2024-12-09', 'La mejor de España', 7, 13),
(27, '2024-12-10', 'Para los que saben muchachos', 7, 8),
(28, '2024-12-13', 'sduygisrfbiufebieff', 12, 4),
(29, '2024-12-13', 'fdviubihhirtg', 12, 3),
(30, '2024-12-13', 'Jose es un cojudo que deberia probar la cusqueña\r\n', 12, 6),
(37, '2024-12-15', 'Bellezas de las bellezas', 7, 5),
(42, '2024-12-15', 'Nippon in the house\r\n', 7, 9),
(44, '2024-12-15', 'España in the house pa\r\n', 7, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tipo_usuario` varchar(50) NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `usuario`, `password`, `tipo_usuario`) VALUES
(1, 'aa', 'aa', 'aa@aa.com', 'aa', '$2y$10$o3BE/Eg9UDcIom2Ei0UyLezzWU99ApxQC9l4RjDZbJm', 'usuario'),
(2, 'bb', 'bb', 'bb@bb.com', 'bb', '$2y$10$SDTK.M7NFtr1sefGH4yJ7.Q0GsRrcEYE3djaq8qEKg6', 'usuario'),
(5, 'dsl', 'dsl', 'dsl@dsl.com', 'dsl', '$2y$10$r.x9RjEOM7cGyffx0Y/33uh30hc4o5gey7ryUY2OFuo', 'usuario'),
(6, 'tt', 'tt', 'tt@tt.com', 'tt', '$2y$10$jp52.KJClhDqgVyESVlC7uZ0YmZzGwlmN93s.FLD/va', 'usuario'),
(7, 'll', 'll', 'll@ll.com', 'll', '$2y$10$lJPk5roNnl5JF6E6XA4Esewg6lwcztcnA8iWIMbZbBWmsbAwsWQv2', 'usuario'),
(8, 'qq', 'qq', 'qq@qq.com', 'qq', '$2y$10$pPn0WHRkIztRj1YNL6h.D.S5OvBSofpTwYGNF/BtJqQ7ghDQtbCe6', 'usuario'),
(9, 'zz', 'zz', 'zz@zz.com', 'zz', '$2y$10$uQe9aJ/TpvM2hieZssGJqe1bleVADHhYum23Iy7An23xeDVY6CYfW', 'usuario'),
(10, 'Kiko', 'Kiko', 'kiko@kiko.com', 'kiko', '$2y$10$t/2IQT2RFAK4y85HlRmib.mghsVi2lUUrcLpYChO3dE1XlDMdpAJG', 'usuario'),
(11, 'vale', 'vale', 'vale@vale.com', 'vale', '$2y$10$0OBzclGXnrKe9WGTbGfbYOiIIYqsQb2fhdKNpfSEVHp9VNqiPxwd.', 'usuario'),
(12, 'val', 'val', 'val@val.com', 'val', '$2y$10$tnnrD0mtgdrYzsnxuZT9FOTbXs3JjayHGabSG4iSNj2JDS52P2Byi', 'usuario'),
(13, 'dshikina', 'dshikina', 'dshikina@dshikina.com', 'dshikina', '$2y$10$WgjXyP9.tBe6gRtzMhbiwu3Ryh3odF9CUD1baPZf1Z5SAHCgF4iru', 'administrador'),
(14, 'francisco', 'palacios', 'paco@paco.com', 'paco', '$2y$10$3C9X8dbrgnBchcnSYOCafOcm1yemZIHUTi/qfdEbLcH3DeLIAPwJy', 'administrador'),
(15, 'min', 'min', 'min@min.com', 'min', '$2y$10$C/MiMDmeUulypopGkq6PF.wGkIOOpFwcOwgf75zMSaXTqpsuyVn/y', 'usuario');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
