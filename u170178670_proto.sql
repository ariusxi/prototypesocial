
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 03/10/2018 às 18:16:17
-- Versão do Servidor: 10.1.24-MariaDB
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u170178670_proto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Extraindo dados da tabela `comments`
--

INSERT INTO `comments` (`id`, `id_post`, `id_user`, `comment`, `created_at`) VALUES
(1, 1, 1, 'teste', '2015-11-09 15:28:33'),
(2, 3, 1, 'Quiet', '2015-11-09 16:38:59'),
(3, 9, 1, 'teste', '2015-11-10 18:03:05'),
(4, 10, 1, 'teste', '2015-11-17 18:52:30'),
(5, 10, 1, 'teste', '2015-11-17 18:52:33'),
(15, 10, 1, 'teste1231231234', '2015-11-25 13:19:17'),
(14, 10, 1, 'teste323333', '2015-11-25 13:19:07'),
(13, 10, 5, 'eaw', '2015-11-24 14:59:34'),
(12, 10, 5, 'eaw', '2015-11-24 14:59:31'),
(16, 10, 1, 'Testando', '2015-11-25 13:20:22'),
(17, 9, 1, 'Teste33', '2015-11-25 13:20:42'),
(18, 10, 1, 'teste3', '2015-11-25 13:21:09'),
(19, 2, 1, 'bonita frase', '2015-11-25 13:21:31'),
(20, 8, 1, 'testando', '2015-11-25 17:27:48'),
(22, 10, 2, 'wow such a cat', '2016-03-16 21:31:17'),
(23, 10, 1, 'eu to comentando nessa bosta', '2016-06-02 21:57:56'),
(24, 15, 1, 'EITA MAINHA', '2016-06-02 21:58:54'),
(25, 15, 1, 'EITA MAINHA DANADA', '2016-06-08 22:28:11'),
(26, 15, 1, 'assim vai matar papai viu', '2016-06-08 22:28:21'),
(27, 15, 1, 'GOSTOSA DO CARALHO', '2016-08-25 21:30:14'),
(28, 9, 1, 'wow suck a wolf', '2016-08-26 18:08:58'),
(35, 23, 1, 'ISSO É UM COMENTARIO DE TESTE, VOU DESLOGAR', '2018-03-28 20:59:30'),
(31, 23, 1, 'QUE DELICIA CARA!', '2017-05-12 22:05:13'),
(32, 23, 1, 'AAAAAI', '2017-09-10 01:28:33'),
(33, 23, 1, 'AAAAAAI', '2018-03-28 20:58:43'),
(34, 23, 1, 'DOTPET QUE DELICIA PORRA', '2018-03-28 20:58:50'),
(37, 22, 1, 'testeeeeee', '2018-09-25 23:02:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `friendship_official` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `date_made` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `friends`
--

INSERT INTO `friends` (`id`, `user_one`, `user_two`, `friendship_official`, `date_made`) VALUES
(1, 2, 1, '0', '2015-11-09 16:39:21'),
(2, 5, 1, '0', '2015-11-23 13:15:58'),
(3, 50, 5, '0', '2015-11-24 15:00:22'),
(4, 8, 1, '0', '2017-09-10 01:26:01'),
(5, 8, 1, '0', '2017-09-10 01:26:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Extraindo dados da tabela `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(31, 1, 1),
(3, 1, 2),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),
(7, 2, 5),
(8, 1, 5),
(9, 2, 6),
(10, 1, 6),
(11, 1, 9),
(12, 1, 8),
(13, 1, 7),
(24, 1, 10),
(15, 5, 10),
(25, 1, 15),
(21, 2, 10),
(41, 1, 23),
(39, 1, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_log` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `mensagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `lido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `id_de`, `id_para`, `mensagem`, `time`, `lido`) VALUES
(1, 1, 2, 'teste', 1458050790, 0),
(2, 1, 6, 'teste', 1458050833, 0),
(3, 1, 6, 'teste', 1458051105, 0),
(4, 1, 6, 'teste', 1458053105, 0),
(5, 2, 1, 'teste', 1458058504, 0),
(6, 1, 2, 'teste', 1458059133, 0),
(7, 1, 2, ':D', 1458059453, 0),
(8, 2, 1, 'teste', 1458063727, 0),
(9, 2, 1, 'teste2', 1458063860, 0),
(10, 2, 1, 'teste3', 1458063921, 0),
(11, 1, 6, 'teste', 1461022865, 0),
(12, 1, 2, ':/', 1461022881, 0),
(13, 1, 2, '8|', 1461022895, 0),
(14, 1, 2, 'teste', 1464220893, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_send` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `texto`, `imagem`, `tipo`, `likes`, `created_at`) VALUES
(1, 1, '', 'steam.png', 'imagem', 1, '2015-11-09 15:28:29'),
(2, 1, '&#34;Insanidade é fazer a mesma coisa esperando um resultado diferente&#34;', '', 'texto', 2, '2015-11-09 16:38:05'),
(3, 2, '', '7b5b7614904f852ccfd6e4f249bcbfe688fffc9f_full.jpg', 'imagem', 1, '2015-11-09 16:38:41'),
(4, 1, '', 'FB_IMG_1447013880265.jpg', 'imagem', 0, '2015-11-09 16:44:54'),
(5, 1, '', 'FB_IMG_1447023126039.jpg', 'imagem', 2, '2015-11-09 16:45:19'),
(6, 2, 'Eu temo o dia em que a tecnologia ultrapasse nossa interação humana, e o mundo terá uma geração de idiotas.', '', 'texto', 2, '2015-11-09 16:47:02'),
(7, 2, 'Teste', '', 'texto', 1, '2015-11-10 17:52:55'),
(8, 2, 'Teste', '', 'texto', 1, '2015-11-10 17:52:55'),
(9, 2, '', '16f74b740d7b54cf87188b0108f40523da806478_full.jpg', 'imagem', 1, '2015-11-10 17:54:39'),
(10, 1, '', 'FB_IMG_1447009284271.jpg', 'imagem', 3, '2015-11-11 18:37:17'),
(15, 1, '', 'thumb2_original.jpg', 'imagem', 1, '2016-06-02 21:58:45'),
(18, 1, 'testando', '', 'texto', 0, '2016-10-11 13:06:52'),
(21, 8, 'texto', '', 'texto', 1, '2016-10-11 22:29:42'),
(22, 8, '0.0\r\n', '', 'texto', 0, '2016-10-11 23:10:19'),
(23, 1, '', '14482076_210346176075679_2670547945245376512_n.jpg', 'imagem', 1, '2017-05-12 22:05:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `capa` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `horario` datetime NOT NULL,
  `limite` datetime NOT NULL,
  `blocks` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `image`, `capa`, `email`, `password`, `data_nascimento`, `link`, `status`, `horario`, `limite`, `blocks`) VALUES
(1, 'Alef', 'Felix de Farias', 'gato.jpg', 'capa_padrao.jpg', 'alefgamer3@gmail.com', 'alef35924781', '1997-10-27', 'Alef.Felix de Farias1', 1, '2018-09-25 20:03:53', '2018-09-25 20:05:53', ''),
(2, 'Teste', 'Teste', 'default.jpg', 'capa_padrao.jpg', 'alef.farias@etec.sp.gov.br', 'alef35924781', '1997-10-27', 'Teste.Teste1', 1, '2017-01-28 21:47:29', '2017-01-28 21:49:29', ''),
(6, 'aasd', 'fedfs', 'default.jpg', 'capa_padrao.jpg', 'sdfsd@fgfdg.tyu', 'qazqaz', '0000-00-00', 'aasd.1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(5, 'joao', 'paulo', '12241293_1130417167010638_1372907879884138688_n.jpg', 'capa_padrao.jpg', 'linter013plusxsp@gmail.com', 'qawqawqaw', '0000-00-00', 'joao.1', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(7, 'Daniel', 'Christovão', 'default.jpg', 'capa_padrao.jpg', 'contato_danielchistovao@outlook.com', 'dani19', '1967-01-25', 'daniel.chistovao1', 1, '2016-06-08 19:31:56', '2016-06-08 19:33:56', ''),
(8, 'Giovanna', 'Ribeiro', 'pp.jpg', 'capa_padrao.jpg', 'giioribeiroo@gmail.com', '123', '1997-04-05', '', 1, '2016-10-11 19:29:32', '2016-10-11 19:31:32', ''),
(9, 'Mateus', 'Nascimento', 'default.jpg', 'capa_padrao.jpg', 'mateusnascimentto@gmail.com', '123', '2016-10-11', 'mateus1', 1, '2016-10-11 19:12:54', '2016-10-11 19:14:54', ''),
(10, 'Igor ', 'Santanna', 'default.jpg', 'capa_padrao.jpg', 'igor.santanna@live.com', 'igor181096', '1996-10-18', 'Igor_.1', 1, '2016-10-11 19:17:19', '2016-10-11 19:19:19', ''),
(11, '', '', 'default.jpg', 'capa_padrao.jpg', '', '', '0000-00-00', '.', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
