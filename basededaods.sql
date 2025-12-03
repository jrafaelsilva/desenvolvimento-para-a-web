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

-- A despejar estrutura para tabela web2.chefs
DROP TABLE IF EXISTS `chefs`;
CREATE TABLE IF NOT EXISTS `chefs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` text,
  `imagem` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.chefs: ~10 rows (aproximadamente)
INSERT INTO `chefs` (`id`, `nome`, `descricao`, `imagem`) VALUES
	(1, 'Carlos Afonso', 'O Chef Carlos Afonso é uma referência na cozinha de mar em Portugal, conhecido pela sua paixão por ostras e produtos frescos. É o rosto do aclamado "Ostras & Coisas" em Lisboa, onde celebra os sabores autênticos. A sua cozinha é uma fusão de tradição e criatividade com o melhor produto nacional.', 'imgs/chefs/carlos.afonso.webp'),
	(2, 'Margarita Pugovka', 'Margarita Pugovka é uma aclamada chef de pastelaria de origem letã, mas com uma forte presença em Portugal. Ganhou notoriedade após a sua passagem pela "Ladurée" e tornou-se um fenómeno digital com as suas criações elegantes. É especialista em sobremesas que combinam técnica francesa com um toque moderno.', 'imgs/chefs/margarita.pugovka.webp'),
	(3, 'Miguel Mesquita', 'O Chef Miguel Mesquita é conhecido por transformar a cozinha de conforto em experiências gastronómicas de luxo. Ganhou destaque na "Cantina de Ventozelo", no Douro, onde aposta em produtos locais. A sua filosofia foca-se na sazonalidade e no respeito pelo ingrediente, reinventando receitas tradicionais.', 'imgs/chefs/miguel.mesquita.webp'),
	(4, 'Henrique Sá Pessoa', 'Um dos chefs portugueses mais conceituados, Henrique Sá Pessoa é a mente criativa por trás do "Alma", galardoado com duas estrelas Michelin. A sua carreira é marcada pela excelência técnica e uma cozinha de autor inovadora. É também o cérebro por trás de projetos de sucesso como o "Tapisco".', 'imgs/chefs/henrique.sa.pessoa.webp'),
	(5, 'José Avillez', 'Referência incontornável da gastronomia nacional e o primeiro chef português a conquistar duas estrelas Michelin no "Belcanto". A sua cozinha destaca-se pela criatividade, técnica e pela reinterpretação sofisticada dos sabores tradicionais portugueses.', 'imgs/chefs/jose.avillez.webp'),
	(6, 'Rui Paula', 'Mestre na fusão entre a memória e a modernidade, com uma forte ligação às raízes e ao Douro. Comanda a "Casa de Chá da Boa Nova" (duas estrelas Michelin), onde o mar é a grande inspiração. É conhecido pela sua exigência e pela estética impecável dos seus pratos.', 'imgs/chefs/rui.paula.jpg'),
	(7, 'Kiko Martins', 'Conhecido pela sua ousadia e pelas influências das viagens que traz para a mesa. Criador d\' "A Cevicheria" e "O Talho", a sua cozinha é uma viagem de sabores, marcada pela irreverência e pela paixão por ingredientes do mundo inteiro.', 'imgs/chefs/kiko.martins.jpg'),
	(8, 'Marlene Vieira', 'Uma das chefs mais proeminentes de Portugal, defensora da cozinha tradicional com alma e técnica moderna. No seu restaurante homónimo, eleva os produtos nacionais a um nível de excelência, focando-se na autenticidade e no sabor genuíno.', 'imgs/chefs/marlene.vieira.jpg'),
	(9, 'Vítor Sobral', 'Um verdadeiro embaixador da gastronomia portuguesa e mestre dos petiscos. Reconhecido pela renovação que trouxe à cozinha tradicional, é o rosto da "Tasca da Esquina". A sua cozinha privilegia a qualidade da matéria-prima e o respeito pelos temperos lusos.', 'imgs/chefs/vitor.sobral.jpg'),
	(10, 'Justa Nobre', 'A grande embaixadora da cozinha transmontana em Lisboa. Famosa pela sua icónica Sopa de Santola, pratica uma cozinha de conforto, cheia de sabor e carinho. O seu restaurante é um santuário para quem procura os sabores mais autênticos de Portugal.', 'imgs/chefs/justa.nobre.png');

-- A despejar estrutura para tabela web2.comentarios
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_receita` int NOT NULL,
  `id_utilizador` int NOT NULL,
  `comentario` text NOT NULL,
  `data_comentario` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.comentarios: ~9 rows (aproximadamente)
INSERT INTO `comentarios` (`id`, `id_receita`, `id_utilizador`, `comentario`, `data_comentario`) VALUES
	(1, 2, 4, 'muito deliciosa, recomendo experimentarem!', '2025-11-24 20:36:58'),
	(2, 2, 4, 'boa!', '2025-11-24 20:37:44'),
	(3, 2, 3, 'adorei', '2025-11-24 20:39:00'),
	(4, 2, 3, 'amei', '2025-11-24 20:39:51'),
	(5, 2, 4, 'uma delicia', '2025-11-24 20:42:23'),
	(6, 1, 5, 'delicia', '2025-11-24 20:52:23'),
	(7, 2, 3, 'muito boa mesmo', '2025-11-24 21:26:58'),
	(12, 20, 6, 'Adorei a receita, ficou igualzinho', '2025-11-26 18:16:59'),
	(13, 45, 4, 'bela', '2025-11-29 15:34:23');

-- A despejar estrutura para tabela web2.dados_perfil
DROP TABLE IF EXISTS `dados_perfil`;
CREATE TABLE IF NOT EXISTS `dados_perfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `idade` int DEFAULT NULL,
  `prato_favorito` varchar(255) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT 'avpadrao.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.dados_perfil: ~4 rows (aproximadamente)
INSERT INTO `dados_perfil` (`id`, `id_utilizador`, `idade`, `prato_favorito`, `avatar`) VALUES
	(1, 3, NULL, 'francesinha', 'av3.png'),
	(2, 4, 23, 'arroz de pato', 'av1.png'),
	(3, 5, 22, NULL, 'avpadrao.png'),
	(4, 6, NULL, NULL, 'avpadrao.jpg');

-- A despejar estrutura para tabela web2.favoritos
DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_receita` int NOT NULL,
  `titulo_receita` varchar(100) DEFAULT NULL,
  `imagem_receita` varchar(255) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `ativado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.favoritos: ~21 rows (aproximadamente)
INSERT INTO `favoritos` (`id`, `id_utilizador`, `id_receita`, `titulo_receita`, `imagem_receita`, `referencia`, `ativado`) VALUES
	(68, 4, 44, 'Leite Creme', 'imgs/sobremesa/leitecreme.jpg', 'receita.php?id=44', 1),
	(69, 4, 46, 'Salada de Fruta', 'imgs/sobremesa/saladafruta.jpg', 'receita.php?id=46', 1),
	(70, 4, 41, 'Arroz Doce', 'imgs/sobremesa/arrozdoce.jpg', 'receita.php?id=41', 1),
	(71, 4, 45, 'Pudim de Ovos', 'imgs/sobremesa/pudim.jpg', 'receita.php?id=45', 1),
	(72, 9, 46, 'Salada de Fruta', 'imgs/sobremesa/saladafruta.jpg', 'receita.php?id=46', 1),
	(73, 9, 45, 'Pudim de Ovos', 'imgs/sobremesa/pudim.jpg', 'receita.php?id=45', 1),
	(74, 3, 46, 'Salada de Fruta', 'imgs/sobremesa/saladafruta.jpg', 'receita.php?id=46', 0),
	(75, 3, 45, 'Pudim de Ovos', 'imgs/sobremesa/pudim.jpg', 'receita.php?id=45', 1),
	(76, 3, 44, 'Leite Creme', 'imgs/sobremesa/leitecreme.jpg', 'receita.php?id=44', 1),
	(77, 3, 41, 'Arroz Doce', 'imgs/sobremesa/arrozdoce.jpg', 'receita.php?id=41', 1),
	(78, 3, 2, 'Bolonhesa', 'imgs/bolonhesa.jpg', 'receita.php?id=2', 0),
	(79, 3, 1, 'Picanha', 'imgs/picanha.jpg', 'receita.php?id=1', 0),
	(80, 3, 28, 'Bife à Portuguesa', 'imgs/bife_portuguesa.jpg', 'receita.php?id=28', 0),
	(81, 3, 32, 'Cozido à Portuguesa', 'imgs/cozido.jpg', 'receita.php?id=32', 1),
	(82, 3, 42, 'Mousse de Chocolate', 'imgs/sobremesa/mousse.jpg', 'receita.php?id=42', 1),
	(83, 4, 2, 'Bolonhesa', 'imgs/bolonhesa.jpg', 'receita.php?id=2', 0),
	(84, 4, 32, 'Cozido à Portuguesa', 'imgs/cozido.jpg', 'receita.php?id=32', 1),
	(85, 4, 42, 'Mousse de Chocolate', 'imgs/sobremesa/mousse.jpg', 'receita.php?id=42', 1),
	(86, 4, 43, 'Baba de Camelo', 'imgs/sobremesa/babacamelo.jpg', 'receita.php?id=43', 1),
	(87, 4, 24, 'Sopa da Pedra', 'imgs/sopas/sopapedra.jpg', 'receita.php?id=24', 0),
	(88, 3, 40, 'Filetes de Pescada', 'imgs/peixe/filetes.jpg', 'receita.php?id=40', 0);

-- A despejar estrutura para tabela web2.ingredientes
DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_receita` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.ingredientes: ~158 rows (aproximadamente)
INSERT INTO `ingredientes` (`id`, `id_receita`, `nome`) VALUES
	(1, 1, 'Picanha'),
	(2, 1, 'Sal q.b.'),
	(3, 2, '400 g de esparguete'),
	(4, 2, '2 dentes de alho'),
	(5, 2, '1 cebola'),
	(6, 2, '1 c. de sopa azeite'),
	(7, 2, '300 g de carne de novilho picada'),
	(8, 2, '½ c. de chá de sal'),
	(9, 2, '200 g de tomate pelado em cubos'),
	(10, 2, '100 g de polpa de tomate'),
	(11, 2, '1 unidade de tomilho seco'),
	(12, 2, '2 c. de sopa de queijo parmesão ralado'),
	(13, 10, '200 g de manteiga amolecida'),
	(14, 10, '200 g de açúcar branco'),
	(15, 10, '1 c. chá de extrato de baunilha'),
	(16, 10, '4 ovos'),
	(17, 10, '200 g de farinha de trigo'),
	(18, 10, '1 c. chá de fermento em pó'),
	(19, 10, 'Compota de morango q.b.'),
	(20, 10, 'Morangos frescos q.b.'),
	(21, 10, 'Açúcar em pó q.b.'),
	(22, 11, '300 g de cenoura ralada'),
	(23, 11, '120 g de açúcar branco'),
	(24, 11, '1 c. sopa de óleo vegetal'),
	(25, 11, '4 ovos'),
	(26, 11, '80 g de farinha de trigo'),
	(27, 11, '1 c. chá de fermento em pó'),
	(63, 19, '400g de bacalhau desfiafo'),
	(64, 19, '500g de batata palha'),
	(65, 19, '6 ovos'),
	(66, 19, '1 cebola e 2 dentes de alho'),
	(67, 19, 'Salsa e azeitonas pretas q.b.'),
	(68, 20, '500g de batatas'),
	(69, 20, '200g de couve galega cortada em caldo verde'),
	(70, 20, '1 cebola e 2 dentes de alho'),
	(71, 20, '1 chouriço de carne'),
	(72, 20, 'Azeite e sal q.b.'),
	(73, 21, '3 batatas'),
	(74, 21, '2 cenouras'),
	(75, 21, '1 courgette'),
	(76, 21, '1 cebola'),
	(77, 21, '200g de feijão verde'),
	(78, 21, 'Azeite e sal q.b.'),
	(79, 22, '600g de abóbora'),
	(80, 22, '2 batatas doces'),
	(81, 22, '1 cebola'),
	(82, 22, '1 alho-francês'),
	(83, 22, 'Noz-moscada q.b.'),
	(84, 23, 'Meia galinha ou frango'),
	(85, 23, '100g de massinhas ou arroz'),
	(86, 23, '1 cebola'),
	(87, 23, 'Hortelã q.b.'),
	(88, 24, '500g de feijão encarnado'),
	(89, 24, 'Orelha de porco'),
	(90, 24, 'Chouriço negro e vermelho'),
	(91, 24, 'Batatas'),
	(92, 24, 'Coentros'),
	(93, 25, '4 tomates maduros'),
	(94, 25, '1 pepino'),
	(95, 25, '1 pimento verde'),
	(96, 25, '2 dentes de alho'),
	(97, 25, 'Vinagre e azeite'),
	(98, 25, 'Pão duro'),
	(99, 26, '1kg de tomates maduros'),
	(100, 26, '2 cebolas'),
	(101, 26, '4 ovos'),
	(102, 26, 'Fatias de pão torrado'),
	(103, 27, '1kg de cenouras'),
	(104, 27, '1 batata'),
	(105, 27, '1 cebola'),
	(106, 27, 'Coentros frescos'),
	(107, 28, '2 Bifes do lombo'),
	(108, 28, '2 fatias de presunto'),
	(109, 28, '2 ovos'),
	(110, 28, '4 dentes de alho'),
	(111, 28, 'Vinho branco'),
	(112, 28, 'Batatas às rodelas'),
	(113, 29, '800g de carne de porco em cubos'),
	(114, 29, '500g de amêijoas'),
	(115, 29, 'Batatas aos cubos'),
	(116, 29, 'Massa de pimentão'),
	(117, 29, 'Coentros'),
	(118, 30, '1 frango inteiro'),
	(119, 30, '2 limões'),
	(120, 30, '4 dentes de alho'),
	(121, 30, 'Pimentão doce'),
	(122, 30, 'Batatinhas para assar'),
	(123, 31, '1kg de perna de porco'),
	(124, 31, 'Vinho verde branco'),
	(125, 31, 'Banha de porco'),
	(126, 31, 'Cominhos'),
	(127, 31, 'Batatas aos cubos'),
	(128, 32, 'Várias carnes (vaca, porco, frango)'),
	(129, 32, 'Enchidos (chouriço, morcela, farinheira)'),
	(130, 32, 'Couve portuguesa'),
	(131, 32, 'Cenouras e nabos'),
	(132, 32, 'Batatas e feijão'),
	(133, 33, 'Meio pato'),
	(134, 33, '1 chouriço'),
	(135, 33, 'Arroz agulha'),
	(136, 33, '1 cebola'),
	(137, 33, 'Bacon fatiado'),
	(138, 34, '2 Douradas frescas'),
	(139, 34, 'Sal grosso'),
	(140, 34, 'Azeite e limão'),
	(141, 34, 'Batatas cozidas'),
	(142, 35, 'Mistura de marisco'),
	(143, 35, 'Arroz carolino'),
	(144, 35, 'Tomate e pimento'),
	(145, 35, 'Coentros'),
	(146, 35, 'Caldo de marisco'),
	(147, 36, '1 Polvo grande'),
	(148, 36, 'Batatas pequenas'),
	(149, 36, 'Muito azeite'),
	(150, 36, 'Alho picado'),
	(151, 37, '12 Sardinhas gordas'),
	(152, 37, 'Sal grosso'),
	(153, 37, 'Pimentos assados'),
	(154, 37, 'Broa de milho'),
	(155, 38, 'Tamboril e Raia'),
	(156, 38, 'Camarão e Ameijoas'),
	(157, 38, 'Pimentos e Tomate'),
	(158, 38, 'Batatas às rodelas'),
	(159, 39, '500g de batata'),
	(160, 39, '400g de bacalhau'),
	(161, 39, '1 cebola picada'),
	(162, 39, 'Salsa'),
	(163, 39, '3 ovos'),
	(164, 40, 'Filetes de pescada'),
	(165, 40, 'Limão e sal'),
	(166, 40, 'Farinha e ovo'),
	(167, 40, 'Arroz e tomate'),
	(168, 41, '1 chávena de arroz carolino'),
	(169, 41, '1L de leite'),
	(170, 41, 'Açúcar a gosto'),
	(171, 41, 'Casca de limão'),
	(172, 41, '3 gemas'),
	(173, 41, 'Canela em pó'),
	(174, 42, '200g de chocolate de culinária'),
	(175, 42, '6 ovos'),
	(176, 42, '6 colheres de açúcar'),
	(177, 42, 'Manteiga'),
	(178, 43, '1 lata de leite condensado cozido'),
	(179, 43, '5 ovos'),
	(180, 43, 'Amêndoa torrada (opcional)'),
	(181, 44, '1L de leite'),
	(182, 44, '6 gemas'),
	(183, 44, '150g de açúcar'),
	(184, 44, '40g de maisena'),
	(185, 44, 'Casca de limão'),
	(186, 45, '12 ovos'),
	(187, 45, '500g de açúcar'),
	(188, 45, '500ml de leite'),
	(189, 45, 'Caramelo líquido'),
	(190, 46, 'Maçã, Pera, Banana'),
	(191, 46, 'Laranja, Kiwi, Morangos'),
	(192, 46, 'Sumo de laranja natural'),
	(193, 46, 'Um pouco de Vinho do Porto (opcional)');

-- A despejar estrutura para tabela web2.preparacao
DROP TABLE IF EXISTS `preparacao`;
CREATE TABLE IF NOT EXISTS `preparacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_receita` int NOT NULL,
  `passo` text NOT NULL,
  `ordem` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.preparacao: ~133 rows (aproximadamente)
INSERT INTO `preparacao` (`id`, `id_receita`, `passo`, `ordem`) VALUES
	(1, 1, 'Escolha uma picanha com gordura entremeada e com gordura firme de 1 dedo de altura.', 1),
	(2, 1, 'Sele a picanha, de ambos os lados, em lume alto. E, de seguida, deixe repousar a picanha durante 5 minutos.', 2),
	(3, 1, 'Após este tempo, corte a picanha em pedaços, com dois dedos de espessura. Grelhe novamente a picanha de ambos os lados em lume alto.', 3),
	(4, 1, 'Assim que a picanha estiver no ponto que deseja, deixe repousar durante 2 a 3 minutos. E corte, de novo, em fatias pequenas, e tempere a picanha com flor de sal.', 4),
	(5, 2, 'Num tacho, coza o esparguete em água a ferver durante 8 minutos.', 1),
	(6, 2, 'Retire do lume, escorra e reserve.', 2),
	(7, 2, 'Pique o alho e a cebola.', 3),
	(8, 2, 'Numa frigideira antiaderente, refogue o alho e a cebola no azeite.', 4),
	(9, 2, 'Junte a carne de novilho picada, o sal e deixe cozinhar em lume médio.', 5),
	(10, 2, 'Acrescente o tomate pelado aos cubos, a polpa de tomate e o tomilho seco.', 6),
	(11, 2, 'Misture bem e deixe cozinhar mais um pouco para apurar.', 7),
	(12, 2, 'Sirva o esparguete à bolonhesa coberto com o molho e polvilhe com queijo parmesão ralado.', 8),
	(13, 10, 'Comece a bater a manteiga com o açúcar branco e o extrato de baunilha até obter uma mistura esbranquiçada.', 1),
	(14, 10, 'Junte a farinha e o fermento peneirando bem. Envolva delicadamente.', 2),
	(15, 10, 'Disponha numa forma redonda previamente untada e forrada com papel vegetal.', 3),
	(16, 10, 'Alise bem a superfície e leve ao forno a 180ºC por 30 a 35 minutos.', 4),
	(17, 10, 'Assim que o bolo tiver arrefecido corte-o ao meio ficando com 2 metades iguais.', 5),
	(18, 10, 'Disponha a compota de morango numa das metades alise bem e de seguida o mascarpone batido. Sobreponha a 2ª metade do bolo por cima do mascarpone.', 6),
	(19, 10, 'Decore com morangos frescos e polvilhe com açúcar em pó.', 7),
	(20, 11, 'Pré-aqueça o forno a 180 ºC.', 1),
	(21, 11, 'Unte uma forma com manteiga e farinha.', 2),
	(22, 11, 'Numa tigela bata as gemas, o açúcar, o óleo e a cenoura ralada.', 3),
	(23, 11, 'Junte a farinha e misture com um garfo.', 4),
	(24, 11, 'Envolva as claras batidas em castelo.', 5),
	(25, 11, 'Deite o preparado e leve ao forno durante 30 minutos.', 6),
	(26, 11, 'Retire do forno e desenforme o bolo.', 7),
	(57, 19, 'Refogue a cebola e o alho em azeite.', 1),
	(58, 19, 'Junte o bacalhau e deixe cozinhar um pouco.', 2),
	(59, 19, 'Adicione a batata palha e envolva bem.', 3),
	(60, 19, 'Junte os ovos batidos e mexa até ficarem cremosos (não secos).', 4),
	(61, 19, 'Sirva com salsa picada e azeitonas.', 5),
	(62, 20, 'Descasque as batatas, a cebola e os alhos e coza em água com sal.', 1),
	(63, 20, 'Triture tudo com a varinha mágica até obter um puré líquido.', 2),
	(64, 20, 'Leve ao lume e quando ferver junte a couve galega.', 3),
	(65, 20, 'Adicione o chouriço em rodelas e deixe cozer a couve.', 4),
	(66, 20, 'Regue com um fio de azeite antes de servir.', 5),
	(67, 21, 'Descasque e corte as batatas, cenouras, courgette e cebola.', 1),
	(68, 21, 'Coza tudo em água com sal e um fio de azeite.', 2),
	(69, 21, 'Triture os legumes até obter um creme.', 3),
	(70, 21, 'Adicione o feijão verde cortado em pedaços pequenos e deixe cozer.', 4),
	(71, 22, 'Refogue a cebola e o alho-francês em azeite.', 1),
	(72, 22, 'Junte a abóbora e a batata doce cortadas em cubos.', 2),
	(73, 22, 'Cubra com água e deixe cozer.', 3),
	(74, 22, 'Triture tudo e tempere com sal e noz-moscada.', 4),
	(75, 23, 'Coza a galinha em água com sal e a cebola inteira.', 1),
	(76, 23, 'Retire a galinha, desfie a carne e reserve.', 2),
	(77, 23, 'No caldo a ferver, junte as massinhas e deixe cozer.', 3),
	(78, 23, 'Volte a colocar a carne desfiada e sirva com folhas de hortelã.', 4),
	(79, 24, 'Demolhe o feijão e coza-o com as carnes.', 1),
	(80, 24, 'Retire as carnes e corte-as em pedaços.', 2),
	(81, 24, 'Junte as batatas em cubos ao caldo e deixe cozer.', 3),
	(82, 24, 'Adicione as carnes novamente e tempere com coentros.', 4),
	(83, 25, 'Pique todos os legumes em cubos muito pequenos.', 1),
	(84, 25, 'Numa taça, junte água gelada, vinagre, azeite e sal.', 2),
	(85, 25, 'Adicione os legumes e o pão cortado em cubos.', 3),
	(86, 25, 'Sirva bem fresco.', 4),
	(87, 26, 'Faça um refogado com cebola e tomate picado.', 1),
	(88, 26, 'Junte água e deixe apurar bem o tomate.', 2),
	(89, 26, 'Triture (opcional) e escalfe os ovos diretamente no caldo.', 3),
	(90, 26, 'Sirva sobre fatias de pão.', 4),
	(91, 27, 'Coza todos os legumes em água e sal.', 1),
	(92, 27, 'Triture tudo até ficar um creme liso.', 2),
	(93, 27, 'Retifique o tempero e adicione muitos coentros picados na hora.', 3),
	(94, 28, 'Frite as batatas às rodelas.', 1),
	(95, 28, 'Frite os bifes em azeite e alho laminado.', 2),
	(96, 28, 'Retire os bifes e no molho junte vinho branco e o presunto.', 3),
	(97, 28, 'Estrele os ovos e coloque sobre o bife.', 4),
	(98, 29, 'Marine a carne com massa de pimentão e vinho branco por 4 horas.', 1),
	(99, 29, 'Frite a carne e reserve. Frite as batatas em cubos.', 2),
	(100, 29, 'Junte a carne e as amêijoas na frigideira até abrirem.', 3),
	(101, 29, 'Envolva as batatas e polvilhe com coentros.', 4),
	(102, 30, 'Tempere o frango com sal, alho, pimentão e sumo de limão.', 1),
	(103, 30, 'Coloque num tabuleiro com as batatas à volta.', 2),
	(104, 30, 'Leve ao forno a 200ºC por cerca de 1 hora.', 3),
	(105, 30, 'Regue ocasionalmente com o próprio molho.', 4),
	(106, 31, 'Marine a carne em vinho, alho e cominhos de véspera.', 1),
	(107, 31, 'Cozinhe a carne lentamente na banha até dourar bem.', 2),
	(108, 31, 'Frite as batatas aos cubos e junte à carne.', 3),
	(109, 31, 'Sirva com pickles e azeitonas.', 4),
	(110, 32, 'Coza as carnes e os enchidos em água abundante.', 1),
	(111, 32, 'Retire as carnes conforme ficarem cozidas.', 2),
	(112, 32, 'No caldo das carnes, coza os legumes.', 3),
	(113, 32, 'Sirva tudo numa travessa grande com arroz do cozido.', 4),
	(114, 33, 'Coza o pato com o chouriço e a cebola.', 1),
	(115, 33, 'Desfie o pato. Coe a água da cozedura.', 2),
	(116, 33, 'Faça um refogado e junte o arroz, use a água do pato para cozer.', 3),
	(117, 33, 'Num tabuleiro, alterne camadas de arroz e pato. Cubra com chouriço e leve ao forno.', 4),
	(118, 34, 'Amanhe o peixe e tempere com sal grosso.', 1),
	(119, 34, 'Grelhe nas brasas ou num grelhador elétrico até a pele estar estaladiça.', 2),
	(120, 34, 'Sirva regado com azeite e sumo de limão.', 3),
	(121, 35, 'Faça um refogado com cebola, alho, tomate e pimento.', 1),
	(122, 35, 'Junte o marisco e deixe ganhar cor.', 2),
	(123, 35, 'Adicione o arroz e o triplo da água a ferver.', 3),
	(124, 35, 'Deixe cozer de modo a ficar com bastante molho. Polvilhe com coentros.', 4),
	(125, 36, 'Coza o polvo na panela de pressão (sem sal) por 20 min.', 1),
	(126, 36, 'Coloque o polvo num tabuleiro com as batatas pré-cozidas e esmagadas.', 2),
	(127, 36, 'Regue com muito azeite e alho. Leve ao forno a dourar.', 3),
	(128, 37, 'Tempere as sardinhas com sal grosso 30 min antes.', 1),
	(129, 37, 'Asse na brasa até a pele ficar dourada.', 2),
	(130, 37, 'Sirva em cima de uma fatia de broa ou com pimentos.', 3),
	(131, 38, 'Na cataplana, faça camadas de cebola, batata, peixe e marisco.', 1),
	(132, 38, 'Regue com vinho branco e tape a cataplana.', 2),
	(133, 38, 'Deixe cozinhar em lume médio por 20 a 25 minutos.', 3),
	(134, 39, 'Coza as batatas e o bacalhau. Reduza a puré e desfie o peixe.', 1),
	(135, 39, 'Misture tudo com a cebola, salsa e os ovos.', 2),
	(136, 39, 'Molde os pastéis com duas colheres.', 3),
	(137, 39, 'Frite em óleo bem quente até dourarem.', 4),
	(138, 40, 'Tempere os filetes com limão, sal e pimenta.', 1),
	(139, 40, 'Passe por farinha e ovo batido.', 2),
	(140, 40, 'Frite em óleo quente e sirva com arroz de tomate malandrinho.', 3),
	(141, 41, 'Coza o arroz em água até abrir. Escorra.', 1),
	(142, 41, 'Junte o leite e o limão e deixe cozer lentamente.', 2),
	(143, 41, 'Junte o açúcar e, por fim, as gemas batidas fora do lume.', 3),
	(144, 41, 'Decore com desenhos de canela.', 4),
	(145, 42, 'Derreta o chocolate com a manteiga.', 1),
	(146, 42, 'Bata as gemas com o açúcar e junte ao chocolate.', 2),
	(147, 42, 'Bata as claras em castelo e envolva delicadamente.', 3),
	(148, 42, 'Leve ao frigorífico pelo menos 4 horas.', 4),
	(149, 43, 'Separe as gemas das claras.', 1),
	(150, 43, 'Misture as gemas com o leite condensado cozido.', 2),
	(151, 43, 'Bata as claras em castelo e envolva na mistura.', 3),
	(152, 43, 'Sirva fresco com amêndoa por cima.', 4),
	(153, 44, 'Misture o açúcar, a maisena e as gemas.', 1),
	(154, 44, 'Ferva o leite com o limão e verta sobre a mistura.', 2),
	(155, 44, 'Leve ao lume brando até engrossar.', 3),
	(156, 44, 'Polvilhe com açúcar e queime com um maçarico antes de servir.', 4),
	(157, 45, 'Bata os ovos com o açúcar e junte o leite.', 1),
	(158, 45, 'Unte uma forma com caramelo e verta o preparado.', 2),
	(159, 45, 'Coza em banho-maria no forno a 180ºC por 50 minutos.', 3),
	(160, 45, 'Desenforme apenas quando estiver frio.', 4),
	(161, 46, 'Descasque e corte todas as frutas em pedaços pequenos.', 1),
	(162, 46, 'Coloque numa taça e regue com o sumo de laranja.', 2),
	(163, 46, 'Deixe marinar no frigorífico antes de servir.', 3);

-- A despejar estrutura para tabela web2.receitas
DROP TABLE IF EXISTS `receitas`;
CREATE TABLE IF NOT EXISTS `receitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `tempo_preparo` int DEFAULT NULL,
  `descricao` text,
  `id_chef` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.receitas: ~32 rows (aproximadamente)
INSERT INTO `receitas` (`id`, `titulo`, `categoria`, `imagem`, `tempo_preparo`, `descricao`, `id_chef`) VALUES
	(1, 'Picanha', 'Receitas de carne', 'imgs/carne/picanha.jpg', 0, 'Deliciosa receita que combina o suculento sabor da picanha com flor de sal.', 10),
	(2, 'Bolonhesa', 'Receitas de carne', 'imgs/carne/bolonhesa.jpg', 35, 'Deliciosa receita de esparguete à bolonhesa com carne de novilho e molho de tomate.', 9),
	(10, 'Bolo de morango', 'Sobremesa', 'imgs/sobremesa/bolo.morango.webp', 40, 'Um bolo suave e húmido, recheado com compota e decorado com morangos frescos.', 2),
	(11, 'Bolo de cenoura', 'Sobremesa', 'imgs/sobremesa/bolodecenoura.png', 40, 'O clássico bolo de cenoura, fofo e delicioso, perfeito para o lanche.', 2),
	(19, 'Bacalhau à Brás', 'Peixe', 'imgs/peixe/bacalhau.jpg', 40, 'O prato de bacalhau mais famoso de Portugal, com ovos e batata palha.', 1),
	(20, 'Caldo Verde', 'Sopas e Cremes', 'imgs/sopas/caldoverde.webp', 45, 'A rainha das sopas portuguesas, com couve galega e chouriço.', 3),
	(21, 'Sopa de Legumes', 'Sopas e Cremes', 'imgs/sopas/sopalegumes.avif', 30, 'Uma sopa rica em vitaminas, perfeita para iniciar qualquer refeição.', 4),
	(22, 'Creme de Abóbora', 'Sopas e Cremes', 'imgs/sopas/cremeabobora.jpg', 35, 'Um creme aveludado e doce, com um toque de especiarias.', 3),
	(23, 'Canja de Galinha', 'Sopas e Cremes', 'imgs/sopas/canja.jpg', 45, 'A tradicional canja reconfortante, ideal para dias frios.', 3),
	(24, 'Sopa da Pedra', 'Sopas e Cremes', 'imgs/sopas/sopapedra.jpg', 90, 'A famosa sopa de Almeirim, rica e consistente.', 7),
	(25, 'Gaspacho Alentejano', 'Sopas e Cremes', 'imgs/sopas/gaspacho.jpeg', 20, 'Sopa fria típica do Alentejo, perfeita para o verão.', 3),
	(26, 'Sopa de Tomate', 'Sopas e Cremes', 'imgs/sopas/sopatomate.webp', 30, 'Sopa reconfortante com ovos escalfados.', 4),
	(27, 'Creme de Cenoura', 'Sopas e Cremes', 'imgs/sopas/cremecenoura.jpg', 25, 'Simples, rápido e delicioso.', 4),
	(28, 'Bife à Portuguesa', 'Receitas de carne', 'imgs/carne/bife_portuguesa.webp', 25, 'Bife do lombo com molho de alho, presunto e ovo a cavalo.', 7),
	(29, 'Carne de Porco à Alentejana', 'Receitas de carne', 'imgs/carne/carne_alentejana.jpg', 60, 'A combinação perfeita entre carne e marisco.', 3),
	(30, 'Frango Assado no Forno', 'Receitas de carne', 'imgs/carne/frango_forno.jpg', 75, 'Frango suculento com limão e ervas.', 4),
	(31, 'Rojões à Minhota', 'Receitas de carne', 'imgs/carne/rojoes.jpg', 90, 'Prato tradicional do norte com carne de porco e cominhos.', 3),
	(32, 'Cozido à Portuguesa', 'Receitas de carne', 'imgs/carne/cozido.jpeg', 120, 'O prato rei da cozinha portuguesa.', 3),
	(33, 'Arroz de Pato', 'Receitas de carne', 'imgs/carne/arroz_pato.jpg', 80, 'Arroz solto cozido no caldo do pato e gratinado no forno.', 4),
	(34, 'Dourada Grelhada', 'Peixe', 'imgs/peixe/dourada.jpg', 30, 'Peixe fresco grelhado com legumes.', 1),
	(35, 'Arroz de Marisco', 'Peixe', 'imgs/peixe/arroz_marisco.jpg', 45, 'Arroz malandrinho com camarão, amêijoas e delícias do mar.', 5),
	(36, 'Polvo à Lagareiro', 'Peixe', 'imgs/peixe/polvo.jpeg', 90, 'Polvo tenro assado no forno com muito azeite e batatas a murro.', 1),
	(37, 'Sardinhas Assadas', 'Peixe', 'imgs/peixe/sardinhas.jpg', 20, 'O prato típico dos Santos Populares.', 6),
	(38, 'Cataplana de Peixe', 'Peixe', 'imgs/peixe/cataplana.jpg', 40, 'Uma explosão de sabores do mar cozinhados a vapor.', 1),
	(39, 'Pastéis de Bacalhau', 'Peixe', 'imgs/peixe/pasteis_bacalhau.jpg', 60, 'Salgadinhos tradicionais estaladiços por fora e macios por dentro.', 1),
	(40, 'Filetes de Pescada', 'Peixe', 'imgs/peixe/filetes.jpg', 30, 'Filetes dourados com arroz de tomate.', 1),
	(41, 'Arroz Doce', 'Sobremesa', 'imgs/sobremesa/arrozdoce.jpg', 40, 'Cremoso e polvilhado com canela, como a avó fazia.', 8),
	(42, 'Mousse de Chocolate', 'Sobremesa', 'imgs/sobremesa/mousse.jpg', 20, 'A sobremesa clássica que agrada a todos.', 2),
	(43, 'Baba de Camelo', 'Sobremesa', 'imgs/sobremesa/babacamelo.jpg', 15, 'Muito simples e deliciosa, feita com leite condensado.', 2),
	(44, 'Leite Creme', 'Sobremesa', 'imgs/sobremesa/leitecreme.jpg', 30, 'Leite creme queimado com açúcar crocante.', NULL),
	(45, 'Pudim de Ovos', 'Sobremesa', 'imgs/sobremesa/pudim.jpg', 60, 'Pudim caseiro com muito caramelo.', 2),
	(46, 'Salada de Fruta', 'Sobremesa', 'imgs/sobremesa/saladafruta.jpg', 20, 'Fresca e saudável, com frutos da época.', 2);

-- A despejar estrutura para tabela web2.utilizadores
DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `utilizador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`iduser`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela web2.utilizadores: ~5 rows (aproximadamente)
INSERT INTO `utilizadores` (`iduser`, `utilizador`, `email`, `pass`) VALUES
	(3, 'Rafael', 'rafaze08@gmail.com', '$2y$10$gaLOJCXaLAC6NQDh1H97j.ymLruI1ukiZuEQhuwN5qYXCCv3ZeMu.'),
	(4, 'Rui', 'teste@gmail.com', '$2y$10$K/ZFTy1anMfftPG6N2kn2OQ/c574fpVEe1LTkiS9d9VXd8txLdY2e'),
	(5, 'Pedro', 'teste2@gmail.com', '$2y$10$JJ9U4HH1gq4D2Yugwt6Kk.UD1GzLQfgWME/5F7cFu4hKDvsvaPTWO'),
	(6, 'Beatriz', 'biaae5@gmail.com', '$2y$10$k1Mw6jWDKKLVVsJe1zRGXe7piBCFxDo1zAWXY2uqsckezoxJ1xGua'),
	(9, 'rafael', 'teste3@gmail.com', '$2y$10$3fl1deJfVvM1NGmRsC5xreb1SFC4fqPQR2CA.PBDe9epLDjd3mfJq');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
