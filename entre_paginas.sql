-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/10/2026 às 20:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `entre_paginas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `ativo`) VALUES
(1, 'Literatura', 1),
(2, 'Literatura Fantastica', 1),
(3, 'Educação', 1),
(4, 'Religião', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cpf_cnpj`, `email`, `telefone`, `endereco`) VALUES
(1, 'Lucas', '452.653.985-77', 'lucas@gmail.com', '(22)98457-8546', 'R: luis gomes 90'),
(2, 'Amanda', '874.965.854-99', 'amanda@gmail.com', '(21)98745-8475', 'R: Bairro da Luz 30'),
(3, 'Henrique', '478.598.412-99', 'henriqueribeiro@gmail.com', '(71)94783-8930', 'R: Caxias da mata 076'),
(4, 'Luisa', '874.598.412-99', 'luisasantos@gmail.com', '(21)98745-6588', 'R: Nova Iguaçu 87'),
(5, 'Caio', '758.541.658-70', 'caiocastro@gmail.com', '(11)90908-4780', 'R: Ipiranga 03'),
(6, 'Carol', '456.741.963-88', 'carolcastro123@gmail.com', '(21)97854-3652', 'R: Paulista 32'),
(7, 'João', '426.874.952-44', 'joaocarlos@gmail.com', '(95)98744-8452', 'R: Nova Iorque 76'),
(8, 'Ana', '652.584.966-74', 'anaconda09@gmail.com', '(85)98752-8741', 'R: Maranhao 87'),
(9, 'Rita', '474.984.521-99', 'ritasemlee@gmail.com', '(87)9847-8744', 'R: Campo Grande 45'),
(10, 'Matheus', '451.487.958-66', 'matheusflor@gmail.com', '(21)98745-5544', 'R: Florista 34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL,
  `fornecedor_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `entrada`
--

INSERT INTO `entrada` (`id_entrada`, `fornecedor_id`, `data`) VALUES
(1, 2, '2026-10-07'),
(2, 1, '2026-10-07'),
(3, 1, '2026-10-07'),
(4, 1, '2026-10-07'),
(5, 1, '2026-10-07'),
(6, 3, '2026-10-07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `minimo` int(11) NOT NULL,
  `variacao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `quantidade`, `minimo`, `variacao_id`) VALUES
(1, 6, 3, 1),
(2, 6, 3, 2),
(3, 26, 3, 3),
(4, 6, 3, 4),
(5, 6, 3, 5),
(6, 26, 3, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`, `cnpj`, `telefone`, `email`, `endereco`, `ativo`) VALUES
(1, 'Editora Moderna', '12.345.678/0001-10', '(11)98765-4321', 'contato@mordena.com', 'R: Das flores 120', 0),
(2, 'Livros Brasil', '23.456.789/0001-20', '(11)97654-3210', 'vendas@livrosbrasil.com', 'Av. Central 450', 0),
(3, 'Editora Saber', '34.567.890/0001-30', '(11)96534-2109', 'suporte@editorasaber.com', 'R: Do livro 89', 0),
(4, 'Mundo literario', '45.678.901/0001-40', '(11)95432-1098', 'contato@mundoliterario.com', 'Av. Paulista 1001', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(11) NOT NULL,
  `nome_genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `genero`
--

INSERT INTO `genero` (`id_genero`, `nome_genero`) VALUES
(1, 'Terror'),
(2, 'Romance'),
(3, 'Suspense'),
(4, 'Fantasia'),
(5, 'Estudo'),
(6, 'Teologia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_entrada`
--

CREATE TABLE `item_entrada` (
  `id_item_entrada` int(11) NOT NULL,
  `entrada_id` int(11) NOT NULL,
  `variacao_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `custo_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item_entrada`
--

INSERT INTO `item_entrada` (`id_item_entrada`, `entrada_id`, `variacao_id`, `quantidade`, `custo_unitario`) VALUES
(1, 1, 6, 20, 20.00),
(2, 2, 16, 20, 20.00),
(3, 3, 16, 20, 20.00),
(4, 4, 16, 20, 20.00),
(5, 5, 16, 20, 20.00),
(6, 6, 3, 20, 20.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

CREATE TABLE `livro` (
  `id_livro` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `preco` float NOT NULL,
  `quantidade_estoque` int(11) NOT NULL,
  `id_genero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `titulo`, `preco`, `quantidade_estoque`, `id_genero`) VALUES
(1, 'It: A Coisa', 69, 3, 1),
(2, 'O Iluminado', 59, 9, 1),
(3, 'Drácula', 35, 2, 1),
(4, 'Frankenstein', 32, 9, 1),
(5, 'Coraline', 39, 9, 1),
(6, 'A Assombração da Casa da Colina', 47, 9, 1),
(7, 'Orgulho e Preconceito', 39, 9, 2),
(8, 'Como Eu Era Antes de Você', 49, 9, 2),
(9, 'A Culpa é das Estrelas', 42, 9, 2),
(10, 'É Assim que Acaba', 54, 9, 2),
(11, 'Dom Casmurro', 29, 9, 2),
(12, 'O Morro dos Ventos Uivante', 44, 9, 2),
(13, 'Garota Exemplar', 52, 9, 3),
(14, 'O Código Da Vinci', 45, 9, 3),
(15, 'Verity', 55, 9, 3),
(16, 'A Paciente Silenciosa', 49, 9, 3),
(17, 'Anjos e Demônios', 46, 9, 3),
(18, 'Caixa de Pássaros', 41, 3, 3),
(19, 'Harry Potter e a Pedra Filosofal', 59, 9, 4),
(20, 'O Hobbit', 48, 9, 4),
(21, 'Percy Jackson e o Ladrão de Raios', 44, 9, 4),
(22, 'As Crônicas de Nárnia', 64, 4, 4),
(23, 'Eragon', 39, 9, 4),
(24, 'A Bússola de Ouro', 42, 9, 4),
(25, 'Matemática Básica', 55, 9, 5),
(26, 'Gramática Completa', 47, 4, 5),
(27, 'Biologia Moderna', 63, 9, 5),
(28, 'Física para Iniciantes', 58, 9, 5),
(29, 'Química Essencial', 61, 3, 5),
(30, 'História Geral', 49, 9, 5),
(31, 'Bíblia Sagrada', 79, 2, 6),
(32, 'Cristianismo Puro e Simples', 45, 9, 6),
(33, 'O Peregrino', 39, 9, 6),
(34, 'Uma Vida com Propósitos', 42, 9, 6),
(35, 'Teologia Sistemática', 89, 9, 6),
(36, 'O Deus Pródigo', 44, 0, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimento_estoque`
--

CREATE TABLE `movimento_estoque` (
  `id_movimento_estoque` int(11) NOT NULL,
  `variacao_id` int(11) NOT NULL,
  `tipo` enum('entrada','saida') NOT NULL DEFAULT 'entrada',
  `quantidade` int(11) NOT NULL,
  `origem` enum('entrada','saida') NOT NULL DEFAULT 'entrada',
  `origem_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimento_estoque`
--

INSERT INTO `movimento_estoque` (`id_movimento_estoque`, `variacao_id`, `tipo`, `quantidade`, `origem`, `origem_id`, `data`) VALUES
(1, 1, 'entrada', 3, 'entrada', 11, '2026-05-20'),
(2, 2, 'entrada', 3, 'entrada', 12, '2026-05-20'),
(3, 3, 'entrada', 3, 'entrada', 13, '2026-05-20'),
(4, 4, 'entrada', 3, 'entrada', 14, '2026-05-21'),
(5, 5, 'entrada', 3, 'entrada', 15, '2026-05-21'),
(6, 6, 'entrada', 3, 'entrada', 16, '2026-05-21'),
(7, 7, 'entrada', 3, 'entrada', 17, '2026-05-22'),
(8, 8, 'entrada', 3, 'entrada', 18, '2026-05-22'),
(9, 9, 'entrada', 3, 'entrada', 19, '2026-05-22'),
(10, 10, 'entrada', 3, 'entrada', 20, '2026-05-23'),
(11, 11, 'entrada', 3, 'entrada', 21, '2026-05-23'),
(12, 12, 'entrada', 3, 'entrada', 22, '2026-05-23'),
(13, 13, 'entrada', 3, 'entrada', 23, '2026-05-24'),
(14, 14, 'entrada', 3, 'entrada', 24, '2026-05-24'),
(15, 15, 'entrada', 3, 'entrada', 25, '2026-05-24'),
(16, 16, 'entrada', 3, 'entrada', 26, '2026-05-25'),
(17, 17, 'entrada', 3, 'entrada', 27, '2026-05-25'),
(18, 18, 'entrada', 3, 'entrada', 28, '2026-05-25'),
(19, 19, 'entrada', 3, 'entrada', 29, '2026-05-26'),
(20, 20, 'entrada', 3, 'entrada', 30, '2026-05-26'),
(21, 21, 'entrada', 3, 'entrada', 31, '2026-05-26'),
(22, 22, 'entrada', 3, 'entrada', 32, '2026-05-27'),
(23, 23, 'entrada', 3, 'entrada', 33, '2026-05-27'),
(24, 24, 'entrada', 3, 'entrada', 34, '2026-05-27'),
(25, 25, 'entrada', 3, 'entrada', 35, '2026-05-28'),
(26, 26, 'entrada', 3, 'entrada', 36, '2026-05-28'),
(27, 27, 'entrada', 3, 'entrada', 37, '2026-05-28'),
(28, 28, 'entrada', 3, 'entrada', 38, '2026-05-29'),
(29, 29, 'entrada', 3, 'entrada', 39, '2026-05-29'),
(30, 30, 'entrada', 3, 'entrada', 40, '2026-05-29'),
(31, 31, 'entrada', 3, 'entrada', 41, '2026-05-30'),
(32, 32, 'entrada', 3, 'entrada', 42, '2026-05-30'),
(33, 33, 'entrada', 3, 'entrada', 43, '2026-05-30'),
(34, 34, 'entrada', 3, 'entrada', 44, '2026-05-31'),
(35, 35, 'entrada', 3, 'entrada', 45, '2026-06-01'),
(36, 36, 'entrada', 3, 'entrada', 46, '2026-06-02'),
(37, 6, 'entrada', 20, 'entrada', 1, '2026-10-07'),
(38, 16, 'entrada', 20, 'entrada', 5, '2026-10-07'),
(39, 3, 'entrada', 20, 'entrada', 6, '2026-10-07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `categoria_id`, `nome`, `descricao`, `ativo`) VALUES
(1, 1, 'It: A Coisa', 'Livro de terror psicológico', 1),
(2, 1, 'O Iluminado', 'Suspense e terror', 1),
(3, 1, 'Drácula', 'Clássico do terror', 1),
(4, 1, 'Frankenstein', 'Terror e ficção científica.', 1),
(5, 1, 'Coraline', 'Fantasia sombria e terror', 1),
(6, 1, 'A Assombração da Casa da Colina', 'Terror sobrenatural', 1),
(7, 1, 'Orgulho e Preconceito', 'Livro de romance clássico', 1),
(8, 1, 'Como Eu Era Antes de Você', 'Romance contemporâneo', 1),
(9, 1, 'A Culpa é das Estrelas', 'Romance juvenil', 1),
(10, 1, 'É Assim que Acaba', 'Romance dramático', 1),
(11, 1, 'Dom Casmurro', 'Clássico da literatura brasileira', 1),
(12, 1, 'O Morro dos Ventos Uivante', 'Romance clássico inglês', 1),
(13, 1, 'Garota Exemplar', 'Livro de suspense investigativo', 1),
(14, 1, 'O Código Da Vinci', 'Suspense e mistério', 1),
(15, 1, 'Verity', 'Thriller psicológico', 1),
(16, 1, 'A Paciente Silenciosa', 'Suspense psicológico', 1),
(17, 1, 'Anjos e Demônios', 'Mistério e suspense.', 1),
(18, 1, 'Caixa de Pássaros', 'Suspense pós-apocalíptico', 1),
(19, 2, 'Harry Potter e a Pedra Filosofal', 'Fantasia sobre magia', 1),
(20, 2, 'O Hobbit', 'Fantasia medieval', 1),
(21, 2, 'Percy Jackson e o Ladrão de Raios', 'Fantasia mitológica', 1),
(22, 2, 'As Crônicas de Nárnia', 'Série clássica de fantasia', 1),
(23, 2, 'Eragon', 'Fantasia épica', 1),
(24, 2, 'A Bússola de Ouro', 'Fantasia aventureira', 1),
(25, 3, 'Matemática Básica', 'Livro de estudos matemáticos', 1),
(26, 3, 'Gramática Completa', 'Livro de língua portuguesa', 1),
(27, 3, 'Biologia Moderna', 'Livro didático de biologia.', 1),
(28, 3, 'Física para Iniciantes', 'Introdução à física', 1),
(29, 3, 'Química Essencial', 'Livro básico de química', 1),
(30, 3, 'História Geral', 'Livro educacional de história', 1),
(31, 4, 'Bíblia Sagrada', 'Livro sagrado cristão', 1),
(32, 4, 'Cristianismo Puro e Simples', 'Livro cristão de C.S. Lewis', 1),
(33, 4, 'O Peregrino', 'Clássico cristão.', 1),
(34, 4, 'Uma Vida com Propósitos', 'Livro cristão motivacional', 1),
(35, 4, 'Teologia Sistemática', 'Livro acadêmico de teologia', 1),
(36, 4, 'O Deus Pródigo', 'Livro sobre graça e fé', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','vendedor') NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `perfil`, `ativo`) VALUES
(1, 'Luiza', 'luiza123@gmail.com', '415789', 'vendedor', 1),
(2, 'Brenda', 'brendasilva@gmail.com', '310478', 'vendedor', 1),
(3, 'Flor', 'flor12@gmail.com', '314789', 'vendedor', 1),
(13, 'ianbonitinho', 'ianbonitinho@gmail.com', '$2y$10$dghNb/I5U35Qw2ChLINALeL7IWvNHqkLeoJcjKep1dGCnVmBq3gjC', 'admin', 1),
(14, 'ian', 'ian@gmail.com', '$2y$10$UP372LxZrnS8nYTOIcQEYOrNv9lKplq49Qy5QZn.y7/hhiKt9kEui', 'vendedor', 1),
(15, 'Pablo Marçal', 'pablo@gmail.com', '$2y$10$lS/VxTIA/fbFt3iMaTRpWu0DEVyKozvCSKZ6cHlhyfXM26f/l.JDm', 'vendedor', 1),
(16, 'Gustavo', 'gustavoemidio99@gmail.com', '$2y$10$p5j7ORnybDe0CJZIcs5g6uprAtd4cPWguCT2ui9y0EVePFqjzeKrG', 'admin', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `variacao`
--

CREATE TABLE `variacao` (
  `id_variacao` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `formato` varchar(50) DEFAULT NULL,
  `edicao` varchar(50) DEFAULT NULL,
  `preco_custo` float NOT NULL,
  `preco_venda` float NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `variacao`
--

INSERT INTO `variacao` (`id_variacao`, `produto_id`, `isbn`, `formato`, `edicao`, `preco_custo`, `preco_venda`, `ativo`) VALUES
(1, 1, '9788556510781', 'Capa Dura', '1ª Edição', 45, 69, 1),
(2, 2, '9788581050486', 'Capa Comum', '2ª Edição', 38, 59, 1),
(3, 3, '9788572326975', 'Pocket', 'Clássico', 22, 35, 1),
(4, 4, '9788537814830', 'Capa Comum', '1ª Edição', 20, 32, 1),
(5, 5, '9788551006753', 'Capa Dura', 'Especial', 24, 39, 1),
(6, 6, '9788595083272', 'Capa Comum', '1ª Edição', 29, 47, 1),
(7, 7, '9788535902775', 'Capa Comum', '1ª Edição', 25, 39, 1),
(8, 8, '9788580573290', 'Capa Dura', '2ª Edição', 30, 49, 1),
(9, 9, '9788581634204', 'Pocket', '1ª Edição', 20, 42, 1),
(10, 10, '9786559811397', 'Capa Comum', '3ª Edição', 35, 54, 1),
(11, 11, '9788520932325', 'Capa Comum', '1ª Edição', 18, 29, 1),
(12, 12, '9788533613376', 'Capa Dura', 'Especial', 28, 44, 1),
(13, 13, '9788580572262', 'Capa Comum', '1ª Edição', 33, 52, 1),
(14, 14, '9788575421134', 'Capa Dura', 'Ilustrada', 28, 45, 1),
(15, 15, '9786559813407', 'Capa Comum', '1ª Edição', 35, 55, 1),
(16, 16, '9786555602760', 'Pocket', '2ª Edição', 31, 49, 1),
(17, 17, '9788575421141', 'Capa Comum', 'Especial', 29, 46, 1),
(18, 18, '9788551003394', 'Capa Dura', '1ª Edição', 26, 41, 1),
(19, 19, '9788532511010', 'Capa Dura', 'Especial', 40, 59, 1),
(20, 20, '9788595084743', 'Capa Comum', '1ª Edição', 32, 48, 1),
(21, 21, '9788598078398', 'Pocket', '2ª Edição', 30, 44, 1),
(22, 22, '9788578270692', 'Capa Dura', 'Colecionador', 45, 64, 1),
(23, 23, '9788576830171', 'Capa Comum', '1ª Edição', 25, 39, 1),
(24, 24, '9788576572002', 'Capa Dura', 'Especial', 27, 42, 1),
(25, 25, '9788539900012', 'Capa Comum', 'Atualizada', 36, 55, 1),
(26, 26, '9788539900029', 'Brochura', 'Completa', 30, 47, 1),
(27, 27, '9788539900036', 'Capa Dura', 'Universitaria', 42, 63, 1),
(28, 28, '9788539900043', 'Capa Comum', '1ª Edição', 39, 58, 1),
(29, 29, '9788539900050', 'Brochura', 'Atualizada', 41, 61, 1),
(30, 30, '9788539900067', 'Capa Comum', 'Ensino Medio', 32, 49, 1),
(31, 31, '9788941234561', 'Capa Luxo', 'Almeida', 55, 79, 1),
(32, 32, '9788578608129', 'Capa Comum', '1ª Edição', 28, 45, 1),
(33, 33, '9788573256981', 'Pocket', 'Classico', 22, 39, 1),
(34, 34, '9788578608136', 'Capa Dura', 'Especial', 26, 42, 1),
(35, 35, '9788527505553', 'Capa Dura', 'Academica', 60, 89, 1),
(36, 36, '9788578608143', 'Capa Comum', '1ª Edição', 27, 44, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor_total` float NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`id_venda`, `data`, `valor_total`, `usuario_id`, `cliente_id`) VALUES
(1, '2026-05-22', 128, 1, 1),
(2, '2026-05-23', 67, 3, 9),
(3, '2026-05-24', 86, 2, 6),
(4, '2026-05-25', 88, 1, 3),
(5, '2026-07-01', 107, 3, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `fk_entrada_fornecedor` (`fornecedor_id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Índices de tabela `item_entrada`
--
ALTER TABLE `item_entrada`
  ADD PRIMARY KEY (`id_item_entrada`),
  ADD KEY `fk_item_entrada` (`entrada_id`),
  ADD KEY `fk_item_variacao` (`variacao_id`);

--
-- Índices de tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`id_livro`);

--
-- Índices de tabela `movimento_estoque`
--
ALTER TABLE `movimento_estoque`
  ADD PRIMARY KEY (`id_movimento_estoque`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_categoria` (`categoria_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `variacao`
--
ALTER TABLE `variacao`
  ADD PRIMARY KEY (`id_variacao`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `item_entrada`
--
ALTER TABLE `item_entrada`
  MODIFY `id_item_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `movimento_estoque`
--
ALTER TABLE `movimento_estoque`
  MODIFY `id_movimento_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `fk_entrada_fornecedor` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`id`);

--
-- Restrições para tabelas `item_entrada`
--
ALTER TABLE `item_entrada`
  ADD CONSTRAINT `fk_item_entrada` FOREIGN KEY (`entrada_id`) REFERENCES `entrada` (`id_entrada`),
  ADD CONSTRAINT `fk_item_variacao` FOREIGN KEY (`variacao_id`) REFERENCES `variacao` (`id_variacao`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;