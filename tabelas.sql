-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- A despejar estrutura para tabela web2.receitasdestaque
DROP TABLE IF EXISTS `receitasdestaque`;
CREATE TABLE IF NOT EXISTS `receitasdestaque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `descricao` text,
  `imagem` varchar(128) DEFAULT NULL,
  `visivel` tinyint NOT NULL DEFAULT '1',
  `referencia` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.receitasdestaque: ~4 rows (aproximadamente)
INSERT INTO `receitasdestaque` (`id`, `nome`, `descricao`, `imagem`, `visivel`, `referencia`) VALUES
	(1, 'Bolo de morango', 'Deliciosa receita que combina o sabor magnífico do morango com', 'imgs/bolo.morango.webp', 1, 'bolodemorango.php'),
	(2, 'Picanha grelhada', 'Deliciosa receita que combina o suculento sabor da picanha', 'imgs/picanha.jpg', 1, 'picanha.php'),
	(3, 'Esparguete à Bolonhesa\r\n', 'A clássica receita italiana, cheia de sabor a carne e tomate.', 'imgs/bolonhesa.jpg', 1, 'bolonhesa.php'),
	(4, 'Bolo de Cenoura', 'Um bolo húmido e delicioso, com cobertura de chocolate.', 'imgs/bolodecenoura.png', 1, 'bolodecenoura.php');

-- A despejar estrutura para tabela web2.utilizadores
DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `utilizador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`iduser`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.utilizadores: ~1 rows (aproximadamente)
INSERT INTO `utilizadores` (`iduser`, `utilizador`, `email`, `pass`) VALUES
	(3, 'rafael', 'rafaze08@gmail.com', '$2y$10$gaLOJCXaLAC6NQDh1H97j.ymLruI1ukiZuEQhuwN5qYXCCv3ZeMu.');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
