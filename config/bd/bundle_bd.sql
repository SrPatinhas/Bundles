-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2014 at 02:45 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bundle_bd`
--
CREATE DATABASE IF NOT EXISTS `bundle_bd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bundle_bd`;

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE IF NOT EXISTS `bundles` (
  `id_bundle` int(3) NOT NULL AUTO_INCREMENT,
  `nome_bundle` varchar(60) NOT NULL,
  `preco_bundle` float(10,2) NOT NULL,
  `capa_bundle` varchar(300) NOT NULL,
  `data_ini_bundle` date NOT NULL,
  `data_fim_bundle` date NOT NULL,
  PRIMARY KEY (`id_bundle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bundles`
--

INSERT INTO `bundles` (`id_bundle`, `nome_bundle`, `preco_bundle`, `capa_bundle`, `data_ini_bundle`, `data_fim_bundle`) VALUES
(1, 'Sonic (1,2,3)', 2.98, 'public/img/capas/sonic_bundle.png', '2013-12-01', '2013-12-08'),
(2, 'Late 2013 Indies', 2.98, 'public/img/capas/bundle_2.png', '2014-01-09', '2014-01-16'),
(3, 'NFS (1, 2 ,3)', 3.99, 'public/img/capas/need_for_speed.png', '2014-01-17', '2014-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `bundle_jogos`
--

CREATE TABLE IF NOT EXISTS `bundle_jogos` (
  `id_bundle` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bundle_jogos`
--

INSERT INTO `bundle_jogos` (`id_bundle`, `id_jogo`, `data`) VALUES
(1, 1, '2013-12-09 17:23:47'),
(1, 2, '2013-12-09 17:23:47'),
(1, 3, '2013-12-09 17:23:47'),
(2, 4, '2014-01-13 03:43:18'),
(2, 5, '2014-01-13 03:43:18'),
(2, 6, '2014-01-13 03:43:18'),
(3, 7, '2014-01-17 01:55:40'),
(3, 8, '2014-01-17 01:55:40'),
(3, 9, '2014-01-17 01:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_cat` int(2) NOT NULL AUTO_INCREMENT,
  `nome_cat` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_cat`, `nome_cat`) VALUES
(1, 'Ação'),
(2, 'Corridas'),
(3, 'Indie'),
(4, 'Desporto'),
(5, 'Estratégia'),
(6, 'Aventura'),
(7, 'Simulador'),
(8, 'RPG'),
(9, 'Massive Multiplayer'),
(10, 'Plataforma'),
(11, 'Puzzle');

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE IF NOT EXISTS `compras` (
  `id_compras` int(6) NOT NULL AUTO_INCREMENT,
  `id_user` int(3) NOT NULL,
  `email_gift` varchar(100) NOT NULL,
  `valor` float NOT NULL,
  `id_bundle` int(3) NOT NULL,
  `data_compra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(50) NOT NULL,
  PRIMARY KEY (`id_compras`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `compras`
--

INSERT INTO `compras` (`id_compras`, `id_user`, `email_gift`, `valor`, `id_bundle`, `data_compra`, `key`) VALUES
(1, 1, 'migas_cerejo-1993@hotmail.com', 3.1, 1, '2014-01-16 00:49:59', '31541r21t4g3q54tgbw4q32tw'),
(2, 1, 'migascc69@gmail.com', 2, 2, '2014-01-16 00:49:47', 'qtw4grq34grq35yg3q4wgr3q');

-- --------------------------------------------------------

--
-- Table structure for table `favoritos`
--

CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_fav` int(6) NOT NULL AUTO_INCREMENT,
  `id_user` int(3) NOT NULL,
  `id_bundle` int(6) NOT NULL,
  PRIMARY KEY (`id_fav`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `favoritos`
--

INSERT INTO `favoritos` (`id_fav`, `id_user`, `id_bundle`) VALUES
(1, 1, 2),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jogos`
--

CREATE TABLE IF NOT EXISTS `jogos` (
  `id_jogo` int(6) NOT NULL AUTO_INCREMENT,
  `nome_jogo` varchar(50) NOT NULL,
  `informacao` text NOT NULL,
  `trailer` varchar(300) NOT NULL,
  `img_jogo` varchar(250) NOT NULL,
  `lanc_jogo` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_jogo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jogos`
--

INSERT INTO `jogos` (`id_jogo`, `nome_jogo`, `informacao`, `trailer`, `img_jogo`, `lanc_jogo`) VALUES
(1, ' Sonic the Hedgehog (1991)', 'Um cientista louco chamado Dr. Robotnik quer dominar o mundo roubando as Esmeraldas do Caos, e para isso montou uma base na ilha em que Sonic mora, e transformando os animais da ilha em robôs escravos. Sonic não gostou nada disso e resolveu acabar com os planos de Robotnik. Especialmente porque as Esmeraldas só podem ser encontradas por Sonic, quando ele entra em uma zona criada por sua velocidade.', 'http://www.youtube.com/embed/dws4ij2IFH4?rel=0', 'http://1.bp.blogspot.com/-2eKhEyHbREo/UG4rjrNVRNI/AAAAAAAAAYM/BTVuKfS0JCA/s640/8.jpg', '1991-06-23'),
(2, 'Sonic the Hedgehog 2', 'Sonic decide viajar em busca de aventuras. Quando volta para casa, descobre o lugar quase deserto, e apenas uma pista sobre o desaparecimento: uma nota escrita pelo seu amigo raposa, Miles "Tails" Prower, em que este dizia ter sido sequestrado pelo Dr. Robotnik. O resgate de Tails eram as 6 Esmeraldas do Caos, a serem entregues a 6 chefes-robôs.', 'http://www.youtube.com/embed/RmpIkrl-B5M?rel=0', 'https://lh5.ggpht.com/PYenvBD0jyeXaFy7tfd1-DajFXeWLtgFj9LxLx7rlbHZAzOxokDD7JgaO-XZST1CmC4%3Dh900', '1992-10-06'),
(3, 'Sonic the Hedgehog 3', 'No final de Sonic the Hedgehog 2 , o malvado Dr. Ivo Robotnik teve seu Death Egg destruído na órbita da Terra pelos heróis: Sonic the Hedgehog e seu companheiro Miles "Tails" Prower . Entretanto, Robotnik descobre que a Angel Island guarda um segredo: o santuário da jóia mágica chamada Master Emerald que é tão poderosa, que pode fazer a ilha flutuar. Assim, ao descobrir esse segredo, Robotnik tenta se apoderar da Master Emerald para usá-la como fornecimento de energia para o Death Egg. É claro, Sonic e Tails tem que colocar um fim a este plano, coletando as Chaos Emeralds e impedir os planos do vilão. Enquanto os heróis estão ocupados com sua missão, Robotnik conseguiu enganar o guardião da Master Emerald, um equidna chamado Knuckles, fazendo-o pensar que Sonic e Tails são os ladrões, então ele tenta o seu melhor para detê-los.', 'http://www.youtube.com/embed/aTy3ARcgZmo?rel=0', 'http://info.sonicretro.org/images/1/13/Sonic3_title.png', '1994-01-23'),
(4, 'Twin Bots', 'TwinBots de Marcos Diez é um jogo de que te coloca no controlo dos Twinbots - criaturas clonadas que compartilham o mesmo pensamento e são controlados por uma entidade desconhecida. Vais ter que ajudá-los através das 40 câmaras de teste que foram preparados para eles como um experimento.', 'http://www.youtube.com/embed/eA_KHcoBmEs?rel=0', 'http://i1.ytimg.com/vi/x0FTx1v_8Xs/hqdefault.jpg', '2013-11-26'),
(5, 'Core of Innocence', 'O ano é 2528. A história segue uma jovem chamada Lila - que recentemente se formou na faculdade de estudos arqueológicos e é convocada pelo seu avô para ajudá-lo em sua pesquisa em uma instalação de mineração subterrânea, onde um novo mineral raro foi descoberto. As coisas tomam um rumo para o pior, como um antigo mal de um mundo distante se revela e reacende o fogo que alimentou uma sangrenta guerra que aconteceu mais de 2000 anos atrás, desta vez ameaçando trazer a luta para a Terra. Lila tem um encontro com o antagonista que ataca com seu poder recém-descoberto, mas o ataque faz com que seu sangue não mundana se fundir com seu implante ''Sistema Outfit Variável'', dando-lhe capacidade sobre-humana. Foi neste momento em que ela decide tomar uma posição e proteger seu mundo a qualquer custo.', 'http://www.youtube.com/embed/EQrSQbZvdIM?rel=0', 'http://s2.n4g.com/media/11/news/1385000/1389141_0.jpg', '2013-10-09'),
(6, 'Another Perspective', 'Um jogo de plataforma sobre teclas, correr, saltar, portas e absurdo. Another Perspective segue as aventuras muito confusas de um homem que está procurando por algo que ele não consegue se lembrar. Ele logo descobre que ele tem o poder de aparentemente se tornar uma pessoa diferente em um lugar diferente e ver a realidade de um número infinito de maneiras diferentes. Combinando estas realidades leva ao progresso, ou fazer algo que pelo menos se assemelha progresso. Mas esta nova capacidade encontrada confunde profundamente e lhe diz respeito. Ele saiu com a missão de não só encontrar o que quer que era que ele estava procurando, mas também de apenas fazer algum tipo de sentido fora do mundo ao seu redor.', 'http://www.youtube.com/embed/mmJ31lDFe5U?rel=0', 'http://media.desura.com/images/games/1/28/27154/boxart.jpg', '2013-11-07'),
(7, 'The Need For Speed', 'Foi o primeiro título da série Need for Speed, que renderia muitos outros títulos sob o mesmo nome. O jogo foi produzido conjuntamente com uma revista especializada em carros esportivos, a Road & Track, que inclusive cedeu seu nome ao jogo, para que através de testes o comportamento real dos carros fosse reproduzido no jogo, do desempenho ao som das trocas de marcha. Foram incluídos ainda vídeos, fotos e comentários sobre os veículos do jogo.', 'http://www.youtube.com/embed/4D6ViP_uUrA', 'http://upamais.com/images/30533527127634598551.jpg', '1994-06-02'),
(8, 'Need For Speed 2', 'O jogo é de corrida, corridas estas que são realizadas em diversas pistas ambientadas em lugares diferentes do mundo. Cada carro possui características (como aceleração, curva, velocidade, etc.) diferentes e possuem uma visão de cockpit detalhada. O jogo possui um "showcase", informação completa sobre os carros com fotos vídeo, mecânica e até breve história sobre a montadora. O jogador pode escolher o jogo em modo Simulação ou Arcade.', 'http://www.youtube.com/embed/xNKy8wrRAHA', 'http://www.juegomania.org/Need%2Bfor%2BSpeed%2BII/fotos/pc/0/645_t/Foto%2BNeed%2Bfor%2BSpeed%2BII.jpg', '1997-03-30'),
(9, 'Need for Speed III: Hot Pursuit', 'O jogo também conta com 4 Modalidades diferentes de jogo: Single Race (onde o jogador livremente poderá escolher o carro para corrida e seus oponentes e também a pista que desejar), Hot Pursuit (onde o jogador pode optar por ser o policial ou ser o fugitivo), Tournament (campeonato de pontos corridos de determinada classe), Practice (para poder praticar) e a modalidade Knockout (onde quem chega na última colocação na corrida é eliminado automaticamente do torneo).', 'http://www.youtube.com/embed/D6ouHWP0KrY', 'http://upload.wikimedia.org/wikipedia/pt/a/a6/NFS_III_Hot_Pursuit_(PC,_US)_cover_art.jpg', '1998-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `jogos_cat`
--

CREATE TABLE IF NOT EXISTS `jogos_cat` (
  `id_jogo` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jogos_cat`
--

INSERT INTO `jogos_cat` (`id_jogo`, `id_cat`) VALUES
(1, 10),
(2, 10),
(3, 10),
(4, 3),
(5, 3),
(6, 3),
(7, 2),
(8, 2),
(9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jogos_plat`
--

CREATE TABLE IF NOT EXISTS `jogos_plat` (
  `id_jogo` int(11) NOT NULL,
  `id_plat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jogos_plat`
--

INSERT INTO `jogos_plat` (`id_jogo`, `id_plat`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(3, 1),
(3, 2),
(3, 5),
(3, 3),
(4, 4),
(4, 5),
(5, 4),
(5, 5),
(6, 4),
(6, 5),
(7, 2),
(7, 4),
(7, 5),
(8, 2),
(8, 4),
(8, 5),
(9, 2),
(9, 4),
(9, 5);

-- --------------------------------------------------------

--
-- Table structure for table `plataforma`
--

CREATE TABLE IF NOT EXISTS `plataforma` (
  `id_plat` int(2) NOT NULL AUTO_INCREMENT,
  `nome_plat` varchar(30) NOT NULL,
  `img_plat` varchar(250) NOT NULL,
  PRIMARY KEY (`id_plat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `plataforma`
--

INSERT INTO `plataforma` (`id_plat`, `nome_plat`, `img_plat`) VALUES
(1, 'Android', 'public/img/plat/android.png'),
(2, 'IOS', 'public/img/plat/ios.png'),
(3, 'Linux', 'public/img/plat/linux.png'),
(4, 'Steam', 'public/img/plat/steam.png'),
(5, 'Windows', 'public/img/plat/windows.png');

-- --------------------------------------------------------

--
-- Table structure for table `subscritor`
--

CREATE TABLE IF NOT EXISTS `subscritor` (
  `id_subscritor` int(11) NOT NULL AUTO_INCREMENT,
  `email_subscritor` varchar(200) NOT NULL,
  `data_subscritor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_subscritor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(3) NOT NULL AUTO_INCREMENT,
  `nome_user` varchar(150) NOT NULL,
  `pass_user` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `type` varchar(15) NOT NULL,
  `avatar_user` varchar(250) NOT NULL,
  `token` varchar(200) NOT NULL,
  `verificado` varchar(15) NOT NULL,
  `data_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nome_user`, `pass_user`, `username`, `email_user`, `type`, `avatar_user`, `token`, `verificado`, `data_user`) VALUES
(1, 'Miguel Cerejo', 'bb86098225f16bcb61bcab36ece7f0f1', 'm1gas', 'migas_cerejo-1993@hotmail.com', 'developer', '', 'Li6e1FVRVTvwuu2VIEEe5c3inUOGxzqIfAA42QMPwWfmu3CJCwoP76sqxsTs26G95GUKqJ51iAgtP98RRCrFcrLtk2eUsIuszmNki5IpJqQNlCAE1BKxCsy8MW6sn', 'ativo', '2014-01-18 20:02:07'),
(2, 'Joao Tavares', '332a3e2d11d41744bd29fcd76d1eeb5c', 'Malaiko', 'jmalaiko@gmail.com', 'developer', '', 'EQWj3yzunpCh6CsdWgoeNGdLj2cywVTsvP8IuMWTtB3hMJXQyeXyByTiOTiqsjIuB4zJM8CrpBi5YmBkiDopMEil6Vu7N2cdYABlSr7LURN1v2MUZTqGhCKcA5wma', 'ativo', '2014-01-17 01:52:57'),
(3, 'Ricardo Gomes', '61e10b3c35aad6a61318f62d93f329fd', 'TBricky', 'ricardo.shoes@gmail.com', 'developer', '', 'Lwliq0nlToLpOyRIb3YJdNsCl3SPiNGczlN7LOG0PX6OdJmHbHCGYamEn7tP6kAdeUVXAjqxIBl15sVHkomyFCkVGDeFrLSUxQR70EEw5Nl3Oegs2liyvULrmRM2u', 'ativo', '2014-01-17 01:52:57'),
(4, 'João Duarte', '460ae85df2408dee976849adba3baa67', 'joaolouro', 'louro.joao96@gmail.com', 'developer', '', 'ausCcOcpfOPWnXmxaC6gUm9wTtVTtBVR6NTBfJ5lQpSDZO925f', 'ativo', '2014-01-17 01:52:57'),
(5, 'Administrador', 'e00cf25ad42683b3df678c61f42c6bda', 'admin', 'admin@admin.com', 'developer', '', '9cqC21AjrBprHaw8IWbND0N1unJnanffVkohrjaWZrcD8jis6U', 'ativo', '2014-01-19 14:45:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
