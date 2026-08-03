-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 25/07/2026 às 00:40
-- Versão do servidor: 8.4.3
-- Versão do PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `automatorv2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_24_121434_create_users_types_table', 1),
(5, '2026_04_24_122053_create_users_types_rels_table', 1),
(6, '2026_04_24_122758_create_sys_configs_table', 1),
(7, '2026_04_24_130047_create_sys_routes_table', 1),
(8, '2026_04_24_130048_create_sys_routes_access_table', 1),
(9, '2026_04_24_140111_create_sys_functions_table', 1),
(10, '2026_04_24_142449_create_sys_translations_table', 1),
(11, '2026_04_24_142519_create_sys_translations_words_table', 1),
(12, '2026_04_24_172332_create_sys_field_types_groups_table', 1),
(13, '2026_04_24_172334_create_sys_field_types_table', 1),
(14, '2026_04_24_172335_create_sys_forms_table', 1),
(15, '2026_04_24_172336_create_sys_forms_fields_table', 1),
(16, '2026_04_24_172337_create_sys_forms_fields_access_table', 1),
(17, '2026_04_24_172338_create_sys_forms_access_table', 1),
(18, '2026_04_24_172339_create_sys_paginations_table', 1),
(19, '2026_04_24_172340_create_sys_paginations_args_table', 1),
(20, '2026_04_24_172341_create_sys_paginations_cols_table', 1),
(21, '2026_04_24_172342_create_sys_paginations_cols_access_table', 1),
(22, '2026_04_27_182422_create_sys_navs_table', 1),
(23, '2026_04_27_182438_create_sys_menus_table', 1),
(24, '2026_04_27_182502_create_sys_menus_items_table', 1),
(25, '2026_04_27_182519_create_sys_menus_access_table', 1),
(26, '2026_04_27_182520_create_sys_menus_item_access_table', 1),
(27, '2026_05_08_030403_create_sys_shortcodes_table', 1),
(28, '2026_05_17_025857_create_sys_notifications_table', 1),
(29, '2026_05_17_114134_create_sys_modulos_table', 1),
(30, '2026_05_27_071854_create_sys_uploads_types_table', 1),
(31, '2026_05_27_071855_create_sys_uploads_table', 1),
(32, '2026_05_27_071935_create_sys_uploads_access_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_configs`
--

CREATE TABLE `tbl_sys_configs` (
  `tbl_sys_config_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_config_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_config_value` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_config_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_config_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_configs`
--

INSERT INTO `tbl_sys_configs` (`tbl_sys_config_ID`, `tbl_sys_config_name`, `tbl_sys_config_description`, `tbl_sys_config_value`, `tbl_sys_config_created_at`, `tbl_sys_config_updated_at`) VALUES
(1, 'system-default-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Idioma do sistema\"]', 'pt-br', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(2, 'system-multi-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Habilitar seleção de Idiomas\"]', 'false', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(3, 'site-home', '[sysfunction return=\"string\" fn=\"translate\" params=\"Página inicial do site\"]', '/', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(4, 'system-admin', '[sysfunction return=\"string\" fn=\"translate\" params=\"URL de administração\"]', '/admin/', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(5, 'site-title', '[sysfunction return=\"string\" fn=\"translate\" params=\"Título do site\"]', 'Automator v2', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(6, 'site-description', '[sysfunction return=\"string\" fn=\"translate\" params=\"Descrição do site\"]', 'Sistema de gerenciamento de informações automatizado.', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(7, 'site-favicon', '[sysfunction return=\"string\" fn=\"translate\" params=\"Ícone do site\"]', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(8, 'site-logo', '[sysfunction return=\"string\" fn=\"translate\" params=\"Logo do site\"]', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(9, 'system-enable-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Registro público liberado\"]', 'false', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(10, 'site-default-user-type-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Tipo de usuário padrão de cadastro\"]', '3', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(11, 'system-enable-date-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de datas do sistema\"]', '{\'j \\d F \\d Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"j \\d\\e F \\d\\e Y\";\"sysconfig(system-default-language)\"]\', \'Y-m-d\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"Y-m-d\";\"sysconfig(system-default-language)\"]\', \'m/d/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"m/d/Y\";\"sysconfig(system-default-language)\"]\', \'d/m/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d/m/Y\";\"sysconfig(system-default-language)\"]\', \'d.m.Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d.m.Y\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(12, 'system-default-date-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de data\"]', 'Y-m-d', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(13, 'system-enable-time-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de horas do sistema\"]', '{\'H:i\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"H:i\"]\', \'g:i A\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"g:i A\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(14, 'system-default-time-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de hora\"]', 'H:i', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(15, 'system-week-days-name', '[sysfunction return=\"string\" fn=\"translate\" params=\"Nome dos dias da semana\"]', '{\'1\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"segunda-feira\"]\', \'2\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"terça-feira\"]\', \'3\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quarta-feira\"]\', \'4\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quinta-feira\"]\', \'5\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sexta-feira\"]\', \'6\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sábado\"]\', \'7\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"domingo\"]\'}', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(16, 'system-default-week-day-start', '[sysfunction return=\"string\" fn=\"translate\" params=\"Dia de inicio da semana\"]', '1', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(17, 'system-default-uploads-dir', '[sysfunction return=\"string\" fn=\"translate\" params=\"Diretório padrão de uploads do sistema\"]', 'uploads', '2026-07-25 03:40:00', '2026-07-25 03:40:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_field_types`
--

CREATE TABLE `tbl_sys_field_types` (
  `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_group_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_field_type_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'id-card',
  `tbl_sys_field_type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_params` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_pagination` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_layout` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_field_type_configs` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_field_type_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_field_type_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_field_types`
--

INSERT INTO `tbl_sys_field_types` (`tbl_sys_field_type_ID`, `tbl_sys_field_type_group_ID`, `tbl_sys_field_type_name`, `tbl_sys_field_type_class`, `tbl_sys_field_type_icon`, `tbl_sys_field_type_title`, `tbl_sys_field_type_description`, `tbl_sys_field_type_params`, `tbl_sys_field_type_pagination`, `tbl_sys_field_type_layout`, `tbl_sys_field_type_configs`, `tbl_sys_field_type_locked`, `tbl_sys_field_type_created_at`, `tbl_sys_field_type_updated_at`) VALUES
(1, 1, 'text', 'AutomatorFieldText', 'font', 'Texto', 'Uma entrada de texto básica, útil para armazenar valores de texto únicos.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"mask\":{\"label\":\"Máscara\",\"type\":\"input[type=\'text\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Mascara de caracteres permitidos.\",\"default\":\"\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados do tipo texto\",\"args\":{\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"attrs\":{\"label\":\"Atributos\",\"fields\":{\"replaced\":{\"label\":\"Substitui\\u00e7\\u00e3o\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"\",\"default\":[]}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(2, 1, 'textarea', 'AutomatorFieldTextArea', 'paragraph', 'Área de texto', 'Uma entrada de área de texto básica para armazenar parágrafos de texto.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"textarea\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"rows\":{\"label\":\"Linhas\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"8\",\"description\":\"Número de linhas do campo.\",\"default\":\"4\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(3, 1, 'number', 'AutomatorFieldNumber', 'hashtag', 'Número', 'Uma entrada limitada a valores numéricos.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Tipo de valor numérico.\",\"default\":\"int\",\"values\":{\"int\":\"Inteiro\",\"float\":\"Flutuante\"}},\"escala\":{\"label\":\"Tamanho da escala\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Tamanho da escala.\",\"required\":\"false\",\"default\":\"\"},\"min\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"max\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"mask\":{\"label\":\"Máscara\",\"type\":\"input[type=\'text\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Mascara de caracteres permitidos.\",\"default\":\"\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados do tipo numero\",\"args\":{\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(4, 1, 'interval', 'AutomatorFieldInterval', 'sliders-h', 'Invervalo', 'Uma entrada para selecionar um valor numérico dentro de um intervalo especificado usando um elemento deslizante de intervalo.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"escala\":{\"label\":\"Tamanho da escala\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Tamanho da escala.\",\"required\":\"false\",\"default\":\"\"},\"min\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"max\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(5, 1, 'email', 'AutomatorFieldEmail', 'envelope-square', 'E-Mail', 'Uma entrada de texto projetada especificamente para armazenar endereços de e-mail.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"email\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(6, 1, 'url', 'AutomatorFieldURL', 'globe', 'URL', 'Uma entrada de texto projetada especificamente para armazenar endereços da web.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(7, 1, 'password', 'AutomatorFieldPassword', 'key', 'Senha', 'Uma entrada para fornecer uma senha usando um campo mascarado.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"hasButton\":{\"label\":\"Botão de visualização\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Exibir botão de visualização ao lado do campo.\",\"default\":\"false\",\"choices\":{\"true\":\"Sim\",\"false\":\"Não\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(8, 2, 'image', 'AutomatorFieldImage', 'image', 'Imagem', 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher imagens.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"required\":{\"label\":\"Obrigat\\u00f3rio\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigat\\u00f3rio.\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"type\":{\"label\":\"Tipo(s) de arquivo\",\"type\":\"checkbox\",\"required\":\"false\",\"nullable\":\"true\",\"description\":\"Tipo de imagem permitida do campo.\",\"default\":\"png\",\"choices\":{\"png\":\"PNG\",\"gif\":\"GIF\",\"psd\":\"PSD\",\"jpg\":\"JPG\",\"jpeg\":\"JPEG\"}},\"multiple\":{\"label\":\"Multiplo\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Permitir selecionar varios arquivos para upload.\",\"required\":\"true\",\"default\":\"false\",\"choices\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}}},\"aparencia\":{\"label\":\"Apar\\u00eancia\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] src=\\\"[$image$]\\\" class=\\\"[$class$]\\\"\",\"sufix\":\" \\/>\",\"tag\":\"img\",\"rendered\":true,\"editor\":false,\"has_child\":false},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Galeria\",\"onclick\":\"SysAutomatorEditor.OpenGalery(this)\",\"label\":\"<i class=\\\"fa fa-image\\\"><\\/i>\"}]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(9, 2, 'link', 'AutomatorFieldLink', 'link', 'Link', 'Um elemento HTML para adicionar links.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"has_child\":false,\"editor\":true,\"tag\":\"a\"},\"block\":{\"configs\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"href\":{\"label\":\"URL do link\",\"field\":\"text\",\"default\":\"\"},\"target\":{\"label\":\"Target do link\",\"field\":\"select\",\"default\":\"_self\",\"choices\":{\"_self\":\"_self\",\"_blank\":\"_blank\",\"_parent\":\"_parent\",\"_top\":\"_top\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do link\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"},\"onclick\":{\"label\":\"ON CLICK\",\"field\":\"text\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(10, 2, 'button', 'AutomatorFieldButton', 'square-check', 'Botão', 'Um elemento HTML para adicionar um botão.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"has_child\":false,\"editor\":true,\"tag\":\"button\"},\"block\":{\"configs\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"field\":\"select\",\"default\":\"button\",\"choices\":{\"button\":\"Bot\\u00e3o\",\"submit\":\"Submit\",\"reset\":\"Reset\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do bot\\u00e3o\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"},\"onclick\":{\"label\":\"ON CLICK\",\"field\":\"text\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(11, 2, 'title', 'AutomatorFieldTitle', 'heading', 'Titulo', 'Um elemento HTML para adicionar um titulo.', '', NULL, 1, '{\"code\":{\"default\":\"h1\",\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"has_child\":false,\"editor\":true,\"tag\":[\"h1\",\"h2\",\"h3\",\"h4\",\"h5\",\"h6\"]},\"block\":{\"tipograph\":{\"label\":\"Tipografia\",\"fields\":{\"type\":{\"label\":\"Tipo do titulo\",\"field\":\"radio-buttons\",\"default\":\"h1\",\"choices\":{\"h1\":\"H1\",\"h2\":\"H2\",\"h3\":\"H3\",\"h4\":\"H4\",\"h5\":\"H5\",\"h6\":\"H6\"}},\"size\":{\"label\":\"Tamanho da fonte\",\"field\":\"radio-buttons\",\"default\":\"medium\",\"custom\":true,\"choices\":{\"small\":\"P\",\"medium\":\"M\",\"large\":\"G\",\"extra-large\":\"GG\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do T\\u00edtulo\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(12, 2, 'paragraph', 'AutomatorFieldParagraph', 'font', 'Paragrafo', 'Um elemento HTML para adicionar um paragrafo.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"p\",\"editor\":true,\"has_child\":false},\"block\":{\"tipograph\":{\"label\":\"Tipografia\",\"fields\":{\"size\":{\"label\":\"Tamanho da fonte\",\"field\":\"radio-buttons\",\"default\":\"medium\",\"custom\":true,\"choices\":{\"small\":\"P\",\"medium\":\"M\",\"large\":\"G\",\"extra-large\":\"GG\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Paragrafo\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Negrito\",\"onclick\":\"SysAutomatorEditor.formatButton(this, \'bold\')\",\"label\":\"<i class=\\\"fa fa-bold\\\"><\\/i>\"},{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Italico\",\"onclick\":\"SysAutomatorEditor.formatButton(this, \'italic\')\",\"label\":\"<i class=\\\"fa fa-italic\\\"><\\/i>\"}]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(13, 2, 'file', 'AutomatorFieldFile', 'file', 'Arquivo', 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher arquivos.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"type\":{\"label\":\"Tipo(s) de arquivo\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Tipos de arquivos que podem ser enviados.\",\"default\":\"\"},\"multiple\":{\"label\":\"Multiplo\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permitir selecionar varios arquivos para upload.\",\"default\":\"false\",\"choices\":{\"true\":\"Sim\",\"false\":\"Não\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(14, 2, 'editor', 'AutomatorFieldEditor', 'pencil', 'Editor', 'Exibe o editor Visual WYSIWYG como visto em areas de conteudo, permitindo uma rica experiência de edição de texto que também permite conteúdo multimídia.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(15, 3, 'select', 'AutomatorFieldSelect', 'object-group', 'Seleção', 'Uma lista suspensa com uma seleção de escolhas que você especifica.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"choices\":{\"label\":\"Escolhas\",\"fields\":{\"hasNull\":{\"label\":\"Tem vazio?\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"\",\"default\":\"false\",\"choices\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"nullText\":{\"label\":\"Valor vazio\",\"field\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"class\":\"disabled\",\"default\":\"\"},\"option\":{\"label\":\"Opções\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"\",\"default\":[]}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados do tipo sele\\u00e7\\u00e3o\",\"args\":{\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"props\":{\"label\":\"Op\\u00e7\\u00f5es\",\"fields\":{\"replaced\":{\"label\":\"Valores\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"As op\\u00e7\\u00f5es s\\u00e3o carregadas automaticamente quando a coluna selecionada for do tipo ENUM. Tamb\\u00e9m \\u00e9 poss\\u00edvel adicionar ou alterar op\\u00e7\\u00f5es manualmente.\",\"default\":[]}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(16, 3, 'checkbox', 'AutomatorFieldCheckbox', 'check-square', 'Checkbox', 'Uma lista com botões de escolhas que você especifica.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Escolhas\",\"fields\":{\"choices\":{\"label\":\"Opções\",\"type\":\"dynamic-list\",\"nullable\":\"false\",\"required\":\"true\",\"placeholder\":\"\",\"description\":\"\",\"default\":\"\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(17, 3, 'dynamic-list', 'AutomatorFieldDynamicList', 'list', 'Lista Dinamica', 'Um campo para carregar um lista dinamica através da seleção de um campo atualizado.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"choices\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(18, 4, 'relation', 'AutomatorFieldRelation', 'sync', 'Relacional', 'Uma interface interativa e personalizável para escolher um ou vários itens, páginas ou itens com a opção de pesquisa da relação criada para o campo.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"type\":{\"label\":\"Tipo de seleção\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"\",\"default\":\"select\",\"choices\":{\"select\":\"Caixa de seleção\",\"checkbox\":\"Botões de seleção\",\"radio\":\"Lista de seleção\",\"hidden\":\"Oculto\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"max-selection\":{\"label\":\"Máximo de escolhas\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"Número máximo de escolhas via checkbox da relação.\",\"description\":\"\",\"default\":\"\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados relacionados entre tabelas do banco de dados.\",\"args\":{\"relation\":{\"label\":\"Relacionamento\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"single\",\"values\":{\"single\":\"Unico\",\"multiple\":\"Multiplo\"}},\"mode\":{\"label\":\"Modo\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"revert\",\"values\":{\"revert\":\"Reverso\",\"relational\":\"Relacional\"}},\"table\":{\"label\":\"Tabela\",\"type\":\"dynamic-table-list\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"\",\"values\":[]},\"column\":{\"label\":\"Coluna\",\"type\":\"dynamic-column-list\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"\",\"values\":[]},\"display\":{\"label\":\"Display\",\"type\":\"dynamic-column-list\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"\",\"values\":[]},\"relational-table\":{\"label\":\"Tabela Relacional\",\"type\":\"dynamic-table-list\",\"required\":\"true\",\"nullable\":\"true\",\"description\":\"\",\"default\":\"\",\"values\":[]},\"relational-column\":{\"label\":\"Coluna Relacional\",\"type\":\"dynamic-column-list\",\"required\":\"false\",\"nullable\":\"true\",\"description\":\"\",\"default\":\"\",\"values\":[]},\"empty\":{\"label\":\"Vazio\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"\",\"default\":\"- - -\"}}},\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(19, 5, 'horizontal-ruler', 'AutomatorFieldHorizontalRuler', 'ruler-horizontal', 'Linha Horizontal', 'Um elemento HTML para adicionar uma linha horizontal.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] \",\"sufix\":\"\\/>\",\"editor\":false,\"has_child\":false,\"tag\":\"hr\"},\"block\":{\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor da linha\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Linha\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(20, 5, 'breakline', 'AutomatorFieldBreakLine', 'arrows-left-right', 'Quebra de Linha', 'Um elemento HTML para adicionar uma quebra de linha.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"editor\":false,\"has_child\":false,\"class\":\"col col-12 m-0 p-0\",\"tag\":\"div\"},\"block\":[],\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(21, 5, 'breakpoint', 'AutomatorFieldBreakPoint', 'arrows-left-right', 'Quebra de Linha', 'Um elemento HTML para adicionar uma quebra de linha no formulário.', '{\"aparencia\":{\"label\":\"Apar\\u00eancia\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"editor\":false,\"has_child\":false,\"class\":\"col col-12 m-0 p-0\",\"tag\":\"div\"},\"block\":[],\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(22, 5, 'block', 'AutomatorFieldBlock', 'th-large', 'Bloco', 'Um elemento HTML para adicionar um bloco na tela.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"has_child\":true},\"block\":{\"margin\":{\"label\":\"Margens\",\"fields\":{\"margin\":{\"label\":\"Margem\",\"field\":\"select\",\"default\":\"mb-2\",\"choices\":{\"mb-0\":\"Nenhuma\",\"mb-2\":\"Pequena\",\"mb-4\":\"M\\u00e9dia\",\"mb-5\":\"Grande\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01');
INSERT INTO `tbl_sys_field_types` (`tbl_sys_field_type_ID`, `tbl_sys_field_type_group_ID`, `tbl_sys_field_type_name`, `tbl_sys_field_type_class`, `tbl_sys_field_type_icon`, `tbl_sys_field_type_title`, `tbl_sys_field_type_description`, `tbl_sys_field_type_params`, `tbl_sys_field_type_pagination`, `tbl_sys_field_type_layout`, `tbl_sys_field_type_configs`, `tbl_sys_field_type_locked`, `tbl_sys_field_type_created_at`, `tbl_sys_field_type_updated_at`) VALUES
(23, 5, 'container', 'AutomatorFieldContainer', 'square', 'Container', 'Um elemento HTML para adicionar um container para inserir linhas e colunas.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"container\",\"has_child\":true},\"block\":{\"fluid\":{\"label\":\"Fluid\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"field\":\"select\",\"default\":\"container\",\"choices\":{\"container\":\"Container\",\"container-fluid\":\"Container Fluid\"}}}},\"margin\":{\"label\":\"Margens\",\"fields\":{\"margin\":{\"label\":\"Margem\",\"field\":\"select\",\"default\":\"mb-2\",\"choices\":{\"mb-0\":\"Nenhuma\",\"mb-2\":\"Pequena\",\"mb-4\":\"M\\u00e9dia\",\"mb-5\":\"Grande\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Container\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(24, 5, 'row', 'AutomatorFieldRow', 'ruler-horizontal', 'Linha (Row)', 'Um elemento HTML para adicionar uma linha com uma ou várias colunas.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"row\",\"has_child\":true},\"block\":{\"options\":{\"label\":\"Op\\u00e7\\u00f5es da linha\",\"fields\":{\"horizontal\":{\"label\":\"Margens Horizontais\",\"field\":\"select\",\"default\":\"gx-4\",\"choices\":{\"gx-4\":\"M\\u00e9dia (Padr\\u00e3o)\",\"gx-0\":\"Nenhuma\",\"gx-3\":\"Pequena\",\"gx-5\":\"Grande\"}},\"vertical\":{\"label\":\"Margens Verticais\",\"field\":\"select\",\"default\":\"gy-0\",\"choices\":{\"gy-0\":\"Nenhuma (Padr\\u00e3o)\",\"gy-3\":\"Pequena\",\"gy-4\":\"M\\u00e9dia\",\"gy-5\":\"Grande\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da linha\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(25, 5, 'col', 'AutomatorFieldCol', 'ruler-vertical', 'Coluna (Col)', 'Um elemento HTML para adicionar uma coluna dentro de uma linha.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"col\",\"has_child\":true,\"data\":{\"col\":12,\"col-sm\":12,\"col-md\":6,\"col-lg\":6,\"col-xl\":6,\"col-xxl\":6},\"onload\":[\"SysAutomator.getCurrentResolutionSize()\"]},\"block\":{\"size\":{\"label\":\"Tamanho da coluna\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-\')\"},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-sm-\')\"},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-md-\')\"},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-lg-\')\"},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-xl-\')\"},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-xxl-\')\"}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"radio-color-class\",\"default\":\"none\",\"custom\":true,\"choices\":{\"none\":\"Transparente\",\"bg-primary\":\"primary\",\"bg-secondary\":\"secondary\",\"bg-danger\":\"danger\",\"bg-info\":\"info\",\"bg-warning\":\"warning\",\"bg-white\":\"white\",\"bg-black\":\"black\",\"custom\":\"Personalizado\"}},\"color\":{\"label\":\"Cor do texto\",\"field\":\"radio-color-class\",\"default\":\"text-black\",\"custom\":true,\"choices\":{\"text-black\":\"black\",\"text-primary\":\"primary\",\"text-secondary\":\"secondary\",\"text-danger\":\"danger\",\"text-info\":\"info\",\"text-warning\":\"warning\",\"text-white\":\"white\",\"custom\":\"Personalizado\",\"none\":\"Transparente\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da coluna\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(26, 8, 'card', 'AutomatorFieldCard', 'window-maximize', 'Card', 'Um elemento HTML para adicionar card com titulo e conteudo personalizável.', '', NULL, 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"card\",\"has_child\":true},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do card\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(27, 8, 'card-header', 'AutomatorFieldCardHeader', 'minus', 'Card Header', 'Um elemento HTML para adicionar card com titulo e conteudo personalizável.', NULL, NULL, 1, '{\"code\":{\"prefix\":\"<div class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/div>\",\"tag\":\"div\",\"class\":\"card-header\",\"has_child\":true},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Header\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 0, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(28, 8, 'card-body', 'AutomatorFieldCardBody', 'square', 'Card Body', 'Um elemento HTML para adicionar o conteudo a um card personalizável.', NULL, NULL, 1, '{\"code\":{\"prefix\":\"<div class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/div>\",\"tag\":\"div\",\"class\":\"card-body\",\"has_child\":true},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Body\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 0, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(29, 8, 'card-footer', 'AutomatorFieldCardFooter', 'window-minimize', 'Card Footer', 'Um elemento HTML para adicionar o conteudo do footer a um card personalizável.', NULL, NULL, 1, '{\"code\":{\"prefix\":\"<div class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/div>\",\"tag\":\"div\",\"class\":\"card-footer\",\"has_child\":true},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do Footer\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 0, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(30, 6, 'hidden', 'AutomatorFieldHidden', 'eye-slash', 'Hidden (Invisível)', 'Um campo sem aparencia visual para enviar ou armazenar valores.', '{\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Tipo de valor do campo.\",\"default\":\"string\",\"values\":{\"string\":\"Texto\",\"int\":\"Inteiro\",\"float\":\"Flutuante\"}}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(31, 6, 'json', 'AutomatorFieldJson', 'code', 'JSON', 'Um campo para armazenar valores em forma de json dentro do banco de dados.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"textarea\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"placeholder\":{\"label\":\"Texto auxiliar\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"Adicione propriedades ao documento JSON.\",\"description\":\"Texto auxiliar associado ao editor JSON.\",\"default\":\"Adicione propriedades ao documento JSON.\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"root-type\":{\"label\":\"Tipo da estrutura principal\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Define a estrutura inicial esperada para o documento JSON.\",\"default\":\"object\",\"values\":{\"object\":\"Objeto\",\"array\":\"Array\"}},\"allow-object\":{\"label\":\"Permitir objetos\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite adicionar objetos dentro da estrutura JSON.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"allow-array\":{\"label\":\"Permitir arrays\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite adicionar arrays dentro da estrutura JSON.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"allow-string\":{\"label\":\"Permitir textos\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite utilizar valores do tipo texto.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"allow-number\":{\"label\":\"Permitir números\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite utilizar valores numéricos.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"allow-boolean\":{\"label\":\"Permitir booleanos\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite utilizar valores true ou false.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"allow-null\":{\"label\":\"Permitir valores nulos\",\"type\":\"select\",\"nullable\":\"false\",\"required\":\"true\",\"description\":\"Permite utilizar valores do tipo null.\",\"default\":\"true\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', NULL, 0, NULL, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(32, 6, 'datetime', 'AutomatorFieldDateTime', 'calendar', 'Data e Hora', 'Uma entrada de data e hora, útil para armazenar valores com data e hora em formatos desejados.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"min\":{\"label\":\"Data Minima\",\"field\":\"input[type=\'date\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"max\":{\"label\":\"Data Máxima\",\"field\":\"input[type=\'date\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados do tipo data e hora.\",\"args\":{\"attrs\":{\"label\":\"Formata\\u00e7\\u00e3o\",\"fields\":{\"format\":{\"label\":\"Formato dos dados\",\"type\":\"text\",\"nullable\":\"false\",\"required\":\"true\",\"placeholder\":\"Y-m-d H:i:s\",\"description\":\"\",\"default\":\"Y-m-d H:i:s\"},\"display\":{\"label\":\"Formato de exibi\\u00e7\\u00e3o\",\"type\":\"text\",\"nullable\":\"false\",\"required\":\"true\",\"placeholder\":\"Y-m-d H:i:s\",\"description\":\"\",\"default\":\"Y-m-d H:i:s\"}}},\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(33, 6, 'icon-picker', 'AutomatorFieldIconPicker', 'icons', 'Icon Picker', 'Uma entrada de texto básica, útil para armazenar valores de classe de icones do font-awesome.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de um icone salvo no banco de dados\",\"args\":{\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(34, 7, 'pagination', 'AutomatorFieldPagination', 'list', 'Paginação', 'Um elemento que inclui uma paginação de resultados gerada pelo sistema.', '', NULL, 1, '{\"code\":{\"prefix\":\"<div style=\\\"width: 100%;\\\"><code>[automator function=\\\"pagination\\\" name=\\\"${pagination}\\\"\",\"sufix\":\"]<\\/code><\\/div>\",\"tag\":\"<code>\",\"has_child\":false,\"vars\":{\"pagination\":{\"type\":\"relation\",\"table\":\"tbl_sys_paginations\",\"index\":\"tbl_sys_pagination_name\",\"label\":\"tbl_sys_pagination_title\"}}},\"block\":{\"config\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"pagination\":{\"label\":\"Pagina\\u00e7\\u00e3o\",\"field\":\"select\",\"default\":\"\",\"choices\":[]}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da pagina\\u00e7\\u00e3o\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(35, 7, 'shortcode', 'AutomatorFieldShortcode', 'code', 'Shortcode', 'Um elemento para executar um comando registrado no sistema através de um código específico.', '', NULL, 1, '{\"code\":{\"prefix\":\"<div style=\\\"width: 100%;\\\"><code>[${shortcode}\",\"sufix\":\"]<\\/code><\\/div>\",\"tag\":\"<code>\",\"has_child\":false,\"vars\":{\"shortcode\":{\"type\":\"relation\",\"table\":\"tbl_sys_shortcodes\",\"index\":\"tbl_sys_shortcode_code\",\"label\":\"tbl_sys_shortcode_title\",\"description\":\"tbl_sys_shortcode_description\",\"params\":\"tbl_sys_shortcode_params\"}}},\"block\":{\"config\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"shortcode\":{\"label\":\"Shortcode\",\"field\":\"select\",\"default\":\"\",\"choices\":[]}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID do shortcode\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(36, 1, 'slug', 'AutomatorFieldSlug', 'text-width', 'Slug', 'Uma entrada de texto básica, útil para armazenar valores de texto que são convertidos para formatação de slug.', '{\"wrapper\":{\"label\":\"Tamanho do campo\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6}}},\"configs\":{\"label\":\"Configurações\",\"fields\":{\"required\":{\"label\":\"Obrigatório\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Campo Obrigatório.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"value\":{\"label\":\"Valor Padrão\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padrão.\",\"default\":\"\"},\"disabled\":{\"label\":\"Desabilitado\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Impede a interação com o campo e não envia seu valor durante o submit.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}},\"readonly\":{\"label\":\"Somente leitura\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"Permite visualizar o valor, mas impede sua edição.\",\"default\":\"false\",\"values\":{\"false\":\"Não\",\"true\":\"Sim\"}}}},\"advanced\":{\"label\":\"Avançado\",\"fields\":{\"minlenght\":{\"label\":\"Minímo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"maxlenght\":{\"label\":\"Máximo de caracteres\",\"field\":\"input[type=\'number\']\",\"default\":\"\",\"nullable\":\"true\",\"required\":\"false\"},\"mask\":{\"label\":\"Máscara\",\"type\":\"input[type=\'text\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Mascara de caracteres permitidos.\",\"default\":\"\"}}},\"aparencia\":{\"label\":\"Aparência\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"editor-css\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}', '{\"description\":\"Exibi\\u00e7\\u00e3o simples de dados do tipo texto com formata\\u00e7\\u00e3o de slug.\",\"args\":{\"header\":{\"label\":\"Cabe\\u00e7alho\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"body\":{\"label\":\"Conteudo\",\"fields\":{\"class\":{\"label\":\"Classe\",\"type\":\"text\",\"nullable\":\"true\",\"required\":\"false\",\"placeholder\":\"\",\"description\":\"Valor padr\\u00e3o.\",\"default\":\"\"}}},\"canSearch\":{\"label\":\"Busca\",\"fields\":{\"search\":{\"label\":\"Ativo na busca?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}},\"canSort\":{\"label\":\"Ordena\\u00e7\\u00e3o\",\"fields\":{\"sort\":{\"label\":\"Habilitar ordena\\u00e7\\u00e3o?\",\"type\":\"select\",\"required\":\"true\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"false\",\"values\":{\"false\":\"N\\u00e3o\",\"true\":\"Sim\"}}}}}}', 0, '', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_field_types_groups`
--

CREATE TABLE `tbl_sys_field_types_groups` (
  `tbl_sys_field_type_group_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_group_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_group_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_field_type_group_ordem` int NOT NULL,
  `tbl_sys_field_type_group_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_field_type_group_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_field_types_groups`
--

INSERT INTO `tbl_sys_field_types_groups` (`tbl_sys_field_type_group_ID`, `tbl_sys_field_type_group_name`, `tbl_sys_field_type_group_title`, `tbl_sys_field_type_group_locked`, `tbl_sys_field_type_group_ordem`, `tbl_sys_field_type_group_created`, `tbl_sys_field_type_group_updated`) VALUES
(1, 'basic', 'Básico', 1, 1, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(2, 'content', 'Conteúdo', 1, 2, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(3, 'choose', 'Escolha', 1, 3, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(4, 'relations', 'Relacional', 1, 4, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(5, 'layout', 'Layout', 1, 5, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(6, 'advanced', 'Avançado', 1, 7, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(7, 'automator', 'Automator', 1, 8, '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(8, 'card', 'Card', 1, 6, '2026-07-25 03:40:00', '2026-07-25 03:40:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_forms`
--

CREATE TABLE `tbl_sys_forms` (
  `tbl_sys_form_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_form_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_form_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_form_cancel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cancelar',
  `tbl_sys_form_submit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_form_method` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_form_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_form_modal` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_form_admin` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_form_validate` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_form_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_form_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_form_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_forms`
--

INSERT INTO `tbl_sys_forms` (`tbl_sys_form_ID`, `tbl_sys_form_name`, `tbl_sys_form_title`, `tbl_sys_form_cancel`, `tbl_sys_form_submit`, `tbl_sys_form_method`, `tbl_sys_form_route`, `tbl_sys_form_modal`, `tbl_sys_form_admin`, `tbl_sys_form_validate`, `tbl_sys_form_locked`, `tbl_sys_form_created_at`, `tbl_sys_form_updated_at`) VALUES
(1, 'admin-minha-conta', 'Minha Conta', 'Cancelar', 'Salvar', 'POST', 'admin-api-minha-conta', 0, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(2, 'admin-routes-apis', 'API\'s', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(3, 'admin-routes-apis-access', 'Permissões das Rotas de API', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(4, 'admin-routes', 'Páginas', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(5, 'admin-routes-access', 'Permissões das Rotas de Páginas', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(6, 'admin-navs', 'Áreas de navegação', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(7, 'admin-users-types', 'Tipos de usuários', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(8, 'admin-users-types-access', 'Permissões dos tipos de usuários', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(9, 'admin-users', 'Usuários', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(10, 'admin-users-edit', 'Usuários', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(11, 'admin-notifications', 'Notificações', 'Cancelar', 'Enviar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(12, 'admin-shortcodes', 'Shortcodes', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(13, 'admin-open-view-modal', 'Abrir View Modal', 'Cancelar', 'Gerar Código', NULL, NULL, 1, 1, 0, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(14, 'admin-open-form-modal', 'Abrir Formulário Modal', 'Cancelar', 'Gerar Código', NULL, NULL, 1, 1, 0, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(15, 'admin-user-notification', 'Visualizar Notificação', 'Fechar', 'Atualizar', NULL, NULL, 1, 1, 0, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(16, 'admin-galeria-uploads-types', 'Tipos de mídia', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(17, 'admin-languages', 'Idiomas', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(18, 'admin-functions', 'Funções', 'Cancelar', 'Salvar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(19, 'admin-menus', 'Menus', 'Cancelar', 'Criar', NULL, NULL, 1, 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_forms_access`
--

CREATE TABLE `tbl_sys_forms_access` (
  `tbl_sys_forms_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_form_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_forms_access_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_forms_access`
--

INSERT INTO `tbl_sys_forms_access` (`tbl_sys_forms_access_ID`, `tbl_users_type_ID`, `tbl_sys_form_ID`, `tbl_sys_forms_access_created_at`) VALUES
(1, 1, 1, '2026-07-25 00:40:02'),
(2, 2, 1, '2026-07-25 00:40:02'),
(3, 3, 1, '2026-07-25 00:40:02'),
(4, 4, 1, '2026-07-25 00:40:02'),
(5, 1, 2, '2026-07-25 00:40:02'),
(6, 2, 2, '2026-07-25 00:40:02'),
(7, 1, 3, '2026-07-25 00:40:02'),
(8, 2, 3, '2026-07-25 00:40:02'),
(9, 1, 4, '2026-07-25 00:40:02'),
(10, 2, 4, '2026-07-25 00:40:02'),
(11, 1, 5, '2026-07-25 00:40:02'),
(12, 2, 5, '2026-07-25 00:40:02'),
(13, 1, 6, '2026-07-25 00:40:02'),
(14, 2, 6, '2026-07-25 00:40:02'),
(15, 1, 7, '2026-07-25 00:40:02'),
(16, 2, 7, '2026-07-25 00:40:02'),
(17, 1, 8, '2026-07-25 00:40:02'),
(18, 2, 8, '2026-07-25 00:40:02'),
(19, 1, 9, '2026-07-25 00:40:02'),
(20, 2, 9, '2026-07-25 00:40:02'),
(21, 1, 10, '2026-07-25 00:40:02'),
(22, 2, 10, '2026-07-25 00:40:02'),
(23, 1, 11, '2026-07-25 00:40:02'),
(24, 2, 11, '2026-07-25 00:40:02'),
(25, 1, 12, '2026-07-25 00:40:02'),
(26, 1, 13, '2026-07-25 00:40:02'),
(27, 2, 13, '2026-07-25 00:40:02'),
(28, 1, 14, '2026-07-25 00:40:02'),
(29, 2, 14, '2026-07-25 00:40:02'),
(30, 1, 15, '2026-07-25 00:40:02'),
(31, 2, 15, '2026-07-25 00:40:02'),
(32, 3, 15, '2026-07-25 00:40:02'),
(33, 4, 15, '2026-07-25 00:40:02'),
(34, 1, 16, '2026-07-25 00:40:02'),
(35, 2, 16, '2026-07-25 00:40:02'),
(36, 1, 17, '2026-07-25 00:40:02'),
(37, 2, 17, '2026-07-25 00:40:02'),
(38, 1, 18, '2026-07-25 00:40:02'),
(39, 1, 19, '2026-07-25 00:40:02'),
(40, 2, 19, '2026-07-25 00:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_forms_fields`
--

CREATE TABLE `tbl_sys_forms_fields` (
  `tbl_sys_forms_field_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_form_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_forms_field_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_forms_field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_forms_field_index` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_forms_field_class` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_forms_field_default` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_forms_field_props` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_forms_field_attrs` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_forms_field_required` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_forms_field_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_forms_field_ordem` int NOT NULL,
  `tbl_sys_forms_field_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_forms_field_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_forms_fields`
--

INSERT INTO `tbl_sys_forms_fields` (`tbl_sys_forms_field_ID`, `tbl_sys_form_ID`, `tbl_sys_field_type_ID`, `tbl_sys_forms_field_title`, `tbl_sys_forms_field_name`, `tbl_sys_forms_field_index`, `tbl_sys_forms_field_class`, `tbl_sys_forms_field_default`, `tbl_sys_forms_field_props`, `tbl_sys_forms_field_attrs`, `tbl_sys_forms_field_required`, `tbl_sys_forms_field_locked`, `tbl_sys_forms_field_ordem`, `tbl_sys_forms_field_created_at`, `tbl_sys_forms_field_updated_at`) VALUES
(1, 1, 30, 'ID', 'tbl_user_ID', 'id', '', '', '{\"type\":\"int\"}', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(2, 1, 1, 'Nome', 'tbl_user_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(3, 1, 5, 'E-mail', 'tbl_user_email', 'email', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":12,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_email\"}}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(4, 1, 7, 'Nova senha', 'tbl_user_password', 'new_password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true,\"cast\":\"hash\"}', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(5, 1, 7, 'Confirmar Nova senha', 'tbl_user_confirm_password', 'confirm_password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true,\"cast\":\"hash\"}', '', 0, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(6, 2, 30, 'ID', 'tbl_sys_route_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(7, 2, 1, 'Nome', 'tbl_sys_route_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_sys_routes\",\"column\":\"tbl_sys_route_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(8, 2, 1, 'Titulo', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(9, 2, 1, 'Link Permanente', 'tbl_sys_route_permalink', 'permalink', '', '', '', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(10, 2, 2, 'Descrição', 'tbl_sys_route_description', 'description', '', '', '{\"rows\":4}', '', 0, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(11, 2, 15, 'Ponto de API', 'tbl_sys_route_api', 'api', '', '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\"}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(12, 2, 15, 'Página Administrativa', 'tbl_sys_route_admin', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(13, 2, 15, 'Bloqueado', 'tbl_sys_route_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(14, 2, 15, 'Tipo', 'tbl_sys_route_type', 'type', '', 'GET', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"GET\":\"GET\",\"POST\":\"POST\"}}', '', 1, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(15, 2, 1, 'Método', 'tbl_sys_route_method', 'mathod', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 10, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(16, 2, 1, 'Controller', 'tbl_sys_route_controller', 'controller', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 11, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(17, 2, 1, 'Argumentos', 'tbl_sys_route_args', 'args', '', '', '', '', 0, 1, 12, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(18, 2, 14, 'Conteúdo', 'tbl_sys_route_content', 'content', '', '', '{\"rows\":6}', '', 0, 1, 13, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(19, 2, 15, 'Status', 'tbl_sys_route_area', 'area', '', 'public', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"public\":\"Publica\",\"restrict\":\"Restrita\"}}', '', 1, 1, 14, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(20, 2, 15, 'Status', 'tbl_sys_route_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 15, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(21, 3, 30, 'ID da Rota', 'tbl_sys_route_ID', 'id', '', '', '', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(22, 3, 1, 'Nome da rota', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(23, 3, 18, 'Permissões da Rota', 'tbl_users_type_ID', 'access', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"label\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"display\":\"tbl_users_type_name\"},\"filters\":{\"tbl_users_type_status\":{\"inativo\":{\"class\":\"disabled\",\"tooltip\":\"Tipo de usu\\u00e1rio inativo\"}}}}}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(24, 4, 30, 'ID', 'tbl_sys_route_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(25, 4, 1, 'Nome', 'tbl_sys_route_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_sys_routes\",\"column\":\"tbl_sys_route_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(26, 4, 1, 'Titulo', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(27, 4, 1, 'Link Permanente', 'tbl_sys_route_permalink', 'permalink', '', '', '', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(28, 4, 2, 'Descrição', 'tbl_sys_route_description', 'description', '', '', '{\"rows\":4}', '', 0, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(29, 4, 15, 'Ponto de API', 'tbl_sys_route_api', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(30, 4, 15, 'Página Administrativa', 'tbl_sys_route_admin', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(31, 4, 15, 'Bloqueado', 'tbl_sys_route_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(32, 4, 15, 'Tipo', 'tbl_sys_route_type', 'type', '', 'GET', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"GET\":\"GET\",\"POST\":\"POST\",\"PUT\":\"PUT\",\"DELETE\":\"DELETE\"}}', '', 1, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(33, 4, 1, 'Método', 'tbl_sys_route_method', 'mathod', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 10, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(34, 4, 1, 'Controller', 'tbl_sys_route_controller', 'controller', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 11, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(35, 4, 1, 'Argumentos', 'tbl_sys_route_args', 'args', '', '', '', '', 0, 1, 12, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(36, 4, 14, 'Conteúdo', 'tbl_sys_route_content', 'content', '', '', '{\"rows\":6}', '', 0, 1, 13, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(37, 4, 15, 'Status', 'tbl_sys_route_area', 'area', '', 'public', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"public\":\"Publica\",\"restrict\":\"Restrita\"}}', '', 1, 1, 14, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(38, 4, 15, 'Status', 'tbl_sys_route_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 15, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(39, 5, 30, 'ID da Rota', 'tbl_sys_route_ID', 'id', '', '', '', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(40, 5, 1, 'Nome da rota', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(41, 5, 18, 'Permissões da Rota', 'tbl_users_type_ID', 'access', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"label\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"display\":\"tbl_users_type_name\"},\"filters\":{\"tbl_users_type_status\":{\"inativo\":{\"class\":\"disabled\",\"tooltip\":\"Tipo de usu\\u00e1rio inativo\"}}}}}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(42, 6, 30, 'ID', 'tbl_sys_nav_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(43, 6, 1, 'Nome', 'tbl_sys_nav_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255,\"minlenght\":5,\"unique\":{\"table\":\"tbl_sys_navs\",\"column\":\"tbl_sys_nav_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(44, 6, 1, 'Titulo', 'tbl_sys_nav_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":5}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(45, 6, 15, 'Bloqueado', 'tbl_sys_nav_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(46, 6, 15, 'Administrativo', 'tbl_sys_nav_admin', 'admin', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(47, 7, 30, 'ID', 'tbl_users_type_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(48, 7, 1, 'Nome', 'tbl_users_type_name', 'name', '', '', '{\"maxlenght\":255,\"minlenght\":5,\"unique\":{\"table\":\"tbl_users_types\",\"column\":\"tbl_users_type_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(49, 7, 2, 'Descrição', 'tbl_users_type_description', 'description', '', '', '{\"rows\":4}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(50, 7, 15, 'Bloqueado', 'tbl_users_type_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(51, 7, 15, 'Status', 'tbl_users_type_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(52, 8, 30, 'Tipo de usuário', 'tbl_users_type_ID', 'id', '', '', '', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(53, 8, 1, 'Tipo de usuário', 'tbl_users_type_name', 'name', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(54, 8, 18, 'Permissões concedidas', 'tbl_sys_route_ID', 'access', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_sys_routes\",\"value\":\"tbl_sys_route_ID\",\"label\":\"tbl_sys_route_title\",\"filters\":{\"tbl_sys_route_area\":{\"public\":{\"class\":\"disabled \",\"tooltip\":\"Somente p\\u00e1ginas restritas podem ter as permiss\\u00f5es de acesso alteradas.\",\"disabled\":true,\"remove\":false},\"restrict\":{\"class\":\"\",\"disabled\":false,\"remove\":false}},\"tbl_sys_route_status\":{\"ativo\":{\"class\":\"\",\"disabled\":false,\"remove\":false},\"inativo\":{\"class\":\"disabled\",\"tooltip\":\"Somente p\\u00e1ginas ativas podem ter as permiss\\u00f5es de acesso alteradas.\",\"disabled\":true,\"remove\":false}}}}}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(55, 9, 30, 'ID', 'tbl_user_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(56, 9, 1, 'Usuário', 'tbl_user_login', 'login', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":5,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_login\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(57, 9, 5, 'E-mail', 'tbl_user_email', 'email', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":5,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_email\"}}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(58, 9, 1, 'Nome', 'tbl_user_name', 'name', '', '', '{\"wrapper_class\":\"col-12\",\"maxlenght\":255,\"minlenght\":5}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(59, 9, 7, 'Senha', 'tbl_user_password', 'password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true,\"cast\":\"hash\"}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(60, 9, 15, 'Bloqueado', 'tbl_user_blocked', 'blocked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(61, 9, 21, 'Quebra de linha', 'quebra', '', '', '0', '', '', 0, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(62, 9, 15, 'Cadastro ativo', 'tbl_user_actived', 'actived', '', '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(63, 9, 15, 'Status', 'tbl_user_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(64, 9, 18, 'Tipo de usuário', 'UserGetTypesIDs', 'userTypes', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"label\":\"tbl_users_type_name\"}}', '', 0, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(65, 10, 30, 'ID', 'tbl_user_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(66, 10, 1, 'Usuário', 'tbl_user_login', 'login', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":5,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_login\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(67, 10, 5, 'E-mail', 'tbl_user_email', 'email', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_email\"}}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(68, 10, 1, 'Nome', 'tbl_user_name', 'name', '', '', '{\"wrapper_class\":\"col-12\",\"maxlenght\":255,\"minlenght\":5}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(69, 10, 7, 'Senha', 'tbl_user_password', 'password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true,\"cast\":\"hash\"}', '', 0, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(70, 10, 15, 'Bloqueado', 'tbl_user_blocked', 'blocked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(71, 10, 21, 'Quebra de linha', 'quebra', '', '', '0', '', '', 0, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(72, 10, 15, 'Cadastro ativo', 'tbl_user_actived', 'actived', '', '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(73, 10, 15, 'Status', 'tbl_user_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(74, 10, 18, 'Tipo de usuário', 'UserGetTypesIDs', 'userTypes', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"label\":\"tbl_users_type_name\"}}', '', 0, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(75, 11, 30, 'ID', 'tbl_sys_notification_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(76, 11, 18, 'Usuário', 'tbl_user_ID', 'userID', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"type\":\"select\",\"relation\":{\"table\":\"tbl_users\",\"value\":\"tbl_user_ID\",\"label\":\"tbl_user_name\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(77, 11, 1, 'Titulo', 'tbl_sys_notification_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(78, 11, 2, 'Mensagem', 'tbl_sys_notification_text', 'text', '', '', '{\"wrapper_class\":\"col-12\"}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(79, 11, 15, 'Visualizada', 'tbl_sys_notification_opened', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":[\"N\\u00e3o\",\"Sim\"]}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(80, 12, 30, 'ID', 'tbl_sys_shortcode_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(81, 12, 1, 'Código', 'tbl_sys_shortcode_code', 'code', '', '', '{\"maxlenght\":255}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(82, 12, 1, 'Titulo', 'tbl_sys_shortcode_title', 'title', '', '', '{\"maxlenght\":255}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(83, 12, 2, 'Descrição', 'tbl_sys_shortcode_description', 'description', '', '', '', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(84, 12, 1, 'Class/Classe', 'tbl_sys_shortcode_class', 'class', '', '', '{\"maxlenght\":255}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(85, 12, 1, 'Metodo/Função', 'tbl_sys_shortcode_method', 'method', '', '', '{\"maxlenght\":255}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(86, 12, 2, 'Parametros', 'tbl_sys_shortcode_params', 'params', '', '', '', '', 0, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(87, 12, 15, 'Bloqueado', 'tbl_sys_shortcode_locked', 'locked', '', 'false', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(88, 13, 1, 'View', 'view', 'view', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255}', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(89, 13, 1, 'Título do Modal', 'title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(90, 13, 15, 'Tamanho', 'size', 'size', '', 'lg', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"sm\":\"Small\",\"md\":\"Medium\",\"lg\":\"Large\",\"xl\":\"Extra Large\",\"fullscreen\":\"Tela inteira\"}}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(91, 13, 15, 'Backdrop', 'backdrop', 'backdrop', '', '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(92, 13, 15, 'Fechar com ESC', 'keyboard', 'keyboard', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(93, 13, 15, 'Conteúdo Rolável', 'scrollable', 'scrollable', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(94, 13, 2, 'Callback', 'callback', 'callback', '', '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(95, 13, 2, 'Before Show', 'beforeShow', 'beforeShow', '', '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(96, 13, 2, 'After Hide', 'afterHide', 'afterHide', '', '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(97, 14, 18, 'Formulário', 'form', 'form', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"type\":\"select\",\"relation\":{\"table\":\"tbl_sys_forms\",\"value\":\"tbl_sys_form_name\",\"label\":\"tbl_sys_form_title\"}}', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(98, 14, 1, 'Título do Modal', 'title', 'title', NULL, '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(99, 14, 15, 'Método de Carregamento', 'loadMethod', 'loadMethod', '', 'GET', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"GET\":\"GET\",\"POST\":\"POST\"}}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(100, 14, 18, 'Rota de Carregamento', 'loadRoute', 'loadRoute', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"type\":\"select\",\"relation\":{\"table\":\"tbl_sys_routes\",\"value\":\"tbl_sys_route_name\",\"label\":\"tbl_sys_route_title\",\"filters\":{\"tbl_sys_route_api\":{\"false\":{\"class\":\"\",\"disabled\":true,\"remove\":true},\"0\":{\"class\":\"\",\"disabled\":true,\"remove\":true}}},\"where\":{\"tbl_sys_route_api\":true}}}', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(101, 14, 15, 'Método de Envio', 'submitMethod', 'submitMethod', '', 'POST', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"POST\":\"POST\"}}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(102, 14, 18, 'Rota de Envio', 'submitRoute', 'submitRoute', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"type\":\"select\",\"relation\":{\"table\":\"tbl_sys_routes\",\"value\":\"tbl_sys_route_name\",\"label\":\"tbl_sys_route_title\",\"filters\":{\"tbl_sys_route_api\":{\"false\":{\"class\":\"\",\"disabled\":true,\"remove\":true},\"0\":{\"class\":\"\",\"disabled\":true,\"remove\":true}}},\"where\":{\"tbl_sys_route_api\":true,\"tbl_sys_route_status\":\"ativo\"}}}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(103, 14, 15, 'Tamanho', 'size', 'size', NULL, 'lg', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"sm\":\"Small\",\"md\":\"Medium\",\"lg\":\"Large\",\"xl\":\"Extra Large\",\"fullscreen\":\"Tela inteira\"}}', '', 1, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(104, 14, 15, 'Backdrop', 'backdrop', 'backdrop', NULL, '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(105, 14, 15, 'Fechar com ESC', 'keyboard', 'keyboard', NULL, '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 9, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(106, 14, 15, 'Conteúdo Rolável', 'scrollable', 'scrollable', NULL, '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 10, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(107, 14, 2, 'Callback', 'callback', 'callback', NULL, '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 11, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(108, 14, 2, 'Before Show', 'beforeShow', 'beforeShow', NULL, '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 12, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(109, 14, 2, 'After Hide', 'afterHide', 'afterHide', NULL, '', '{\"wrapper_class\":\"col-12\",\"rows\":3}', '', 0, 1, 13, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(110, 15, 30, 'ID', 'tbl_sys_notification_ID', 'id', '', '', '{\"type\":\"int\"}', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(111, 15, 18, 'Usuário', 'tbl_user_ID', 'userID', '', '', '{\"type\":\"hidden\",\"relation\":{\"table\":\"tbl_users\",\"value\":\"tbl_user_ID\",\"label\":\"tbl_user_ID\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(112, 15, 1, 'Titulo', 'tbl_sys_notification_title', 'title', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(113, 15, 2, 'Mensagem', 'tbl_sys_notification_text', 'text', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true,\"rows\":4}', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(114, 15, 15, 'Status', 'tbl_sys_notification_opened', 'opened', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":[\"Fechada\",\"Aberta\"]}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(115, 15, 32, 'Data de envio', 'tbl_sys_notification_created_at', 'created_at', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"readonly\":true,\"disabled\":true,\"format\":\"Y-m-d H:i:s\",\"display\":\"d\\/m\\/Y - H:i:s\",\"attrs\":{\"format\":\"Y-m-d H:i:s\",\"display\":\"d\\/m\\/Y - H:i:s\"}}', '', 0, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(116, 16, 30, 'ID', 'tbl_sys_uploads_type_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(117, 16, 33, 'Icone', 'tbl_sys_uploads_type_icon', 'icon', '', 'icons', '{\"maxlenght\":255,\"wrapper_class\":\"col-12 col-md-5\"}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(118, 16, 1, 'Mine Type', 'tbl_sys_uploads_type_mine', 'mine', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":2}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(119, 16, 36, 'Type', 'tbl_sys_uploads_type_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255,\"minlenght\":2,\"unique\":{\"table\":\"tbl_sys_uploads_types\",\"column\":\"tbl_sys_uploads_type_name\"}}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(120, 16, 1, 'Nome', 'tbl_sys_uploads_type_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":3}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(121, 16, 2, 'Descrição', 'tbl_sys_uploads_type_description', 'description', '', '', '{\"wrapper_class\":\"col-12\",\"rows\":4}', '', 1, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(122, 16, 15, 'Bloqueado', 'tbl_sys_uploads_type_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 7, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(123, 17, 30, 'ID', 'tbl_sys_translation_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(124, 17, 36, 'Key', 'tbl_sys_translation_key', 'key', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255,\"minlenght\":2,\"unique\":{\"table\":\"tbl_sys_translations\",\"column\":\"tbl_sys_translation_key\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(125, 17, 1, 'Nome', 'tbl_sys_translation_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":3}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(126, 17, 2, 'Descrição', 'tbl_sys_translation_description', 'description', '', '', '{\"wrapper_class\":\"col-12\",\"rows\":4}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(127, 17, 15, 'Bloqueado', 'tbl_sys_translation_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(128, 18, 30, 'ID', 'tbl_sys_function_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(129, 18, 15, 'Tipo', 'tbl_sys_function_type', 'type', '', 'custom', '{\"wrapper_class\":\"col-12 col-md-4\",\"choices\":{\"custom\":\"Custom\",\"nativo\":\"Nativa\"}}', '', 1, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(130, 18, 36, 'Nome', 'tbl_sys_function_name', 'key', '', '', '{\"wrapper_class\":\"col-12 col-md-4\",\"maxlenght\":255,\"minlenght\":2,\"unique\":{\"table\":\"tbl_sys_functions\",\"column\":\"tbl_sys_function_name\"}}', '', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(131, 18, 1, 'Função', 'tbl_sys_function_fn', 'function', '', '', '{\"wrapper_class\":\"col-12 col-md-4\",\"maxlenght\":255,\"minlenght\":3}', '', 1, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(132, 18, 31, 'Parâmetros', 'tbl_sys_function_params', 'params', '', '{}', '{\"wrapper_class\":\"col-12\",\"placeholder\":\"Adicione os par\\u00e2metros aceitos pela fun\\u00e7\\u00e3o.\",\"root-type\":\"object\",\"allow-object\":true,\"allow-array\":true,\"allow-string\":true,\"allow-number\":true,\"allow-boolean\":true,\"allow-null\":true}', '', 0, 1, 5, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(133, 18, 31, 'Propriedades', 'tbl_sys_function_props', 'props', '', '{}', '{\"wrapper_class\":\"col-12\",\"placeholder\":\"Adicione os provedores e propriedades associados aos par\\u00e2metros.\",\"root-type\":\"object\",\"allow-object\":true,\"allow-array\":true,\"allow-string\":true,\"allow-number\":true,\"allow-boolean\":true,\"allow-null\":true}', '', 0, 1, 6, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(134, 19, 1, 'Nome do menu', 'tbl_sys_menu_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":2}', '', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(135, 19, 36, 'ID do Menu', 'tbl_sys_menu_index', 'index', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255}', '', 0, 1, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(136, 19, 1, 'Classes do Menu', 'tbl_sys_menu_class', 'class', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255}', '', 0, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(137, 19, 15, 'Bloqueado', 'tbl_sys_menu_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 0, 1, 4, '2026-07-25 03:40:02', '2026-07-25 03:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_forms_fields_access`
--

CREATE TABLE `tbl_sys_forms_fields_access` (
  `tbl_sys_forms_fields_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_forms_field_ID` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_forms_fields_access`
--

INSERT INTO `tbl_sys_forms_fields_access` (`tbl_sys_forms_fields_access_ID`, `tbl_users_type_ID`, `tbl_sys_forms_field_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 1, 2),
(6, 2, 2),
(7, 3, 2),
(8, 4, 2),
(9, 1, 3),
(10, 2, 3),
(11, 3, 3),
(12, 4, 3),
(13, 1, 4),
(14, 2, 4),
(15, 3, 4),
(16, 4, 4),
(17, 1, 5),
(18, 2, 5),
(19, 3, 5),
(20, 4, 5),
(21, 1, 6),
(22, 2, 6),
(23, 1, 7),
(24, 2, 7),
(25, 1, 8),
(26, 2, 8),
(27, 1, 9),
(28, 2, 9),
(29, 1, 10),
(30, 2, 10),
(31, 1, 11),
(32, 2, 11),
(33, 1, 12),
(34, 2, 12),
(35, 1, 13),
(36, 1, 14),
(37, 2, 14),
(38, 1, 15),
(39, 2, 15),
(40, 1, 16),
(41, 2, 16),
(42, 1, 17),
(43, 2, 17),
(44, 1, 18),
(45, 2, 18),
(46, 1, 19),
(47, 2, 19),
(48, 1, 20),
(49, 2, 20),
(50, 1, 21),
(51, 2, 21),
(52, 1, 22),
(53, 2, 22),
(54, 1, 23),
(55, 2, 23),
(56, 1, 24),
(57, 2, 24),
(58, 1, 25),
(59, 2, 25),
(60, 1, 26),
(61, 2, 26),
(62, 1, 27),
(63, 2, 27),
(64, 1, 28),
(65, 2, 28),
(66, 1, 29),
(67, 2, 29),
(68, 1, 30),
(69, 2, 30),
(70, 1, 31),
(71, 1, 32),
(72, 2, 32),
(73, 1, 33),
(74, 2, 33),
(75, 1, 34),
(76, 2, 34),
(77, 1, 35),
(78, 2, 35),
(79, 1, 36),
(80, 2, 36),
(81, 1, 37),
(82, 2, 37),
(83, 1, 38),
(84, 2, 38),
(85, 1, 39),
(86, 2, 39),
(87, 1, 40),
(88, 2, 40),
(89, 1, 41),
(90, 2, 41),
(91, 1, 42),
(92, 2, 42),
(93, 1, 43),
(94, 2, 43),
(95, 1, 44),
(96, 2, 44),
(97, 1, 45),
(98, 1, 46),
(99, 2, 46),
(100, 1, 47),
(101, 2, 47),
(102, 1, 48),
(103, 2, 48),
(104, 1, 49),
(105, 2, 49),
(106, 1, 50),
(107, 1, 51),
(108, 2, 51),
(109, 1, 52),
(110, 2, 52),
(111, 1, 53),
(112, 2, 53),
(113, 1, 54),
(114, 2, 54),
(115, 1, 55),
(116, 2, 55),
(117, 1, 56),
(118, 2, 56),
(119, 1, 57),
(120, 2, 57),
(121, 1, 58),
(122, 2, 58),
(123, 1, 59),
(124, 2, 59),
(125, 3, 59),
(126, 4, 59),
(127, 1, 60),
(128, 1, 61),
(129, 2, 61),
(130, 1, 62),
(131, 1, 63),
(132, 2, 63),
(133, 1, 64),
(134, 2, 64),
(135, 1, 65),
(136, 2, 65),
(137, 1, 66),
(138, 2, 66),
(139, 1, 67),
(140, 2, 67),
(141, 1, 68),
(142, 2, 68),
(143, 1, 69),
(144, 2, 69),
(145, 3, 69),
(146, 4, 69),
(147, 1, 70),
(148, 1, 71),
(149, 2, 71),
(150, 1, 72),
(151, 1, 73),
(152, 2, 73),
(153, 1, 74),
(154, 2, 74),
(155, 1, 75),
(156, 2, 75),
(157, 1, 76),
(158, 2, 76),
(159, 1, 77),
(160, 2, 77),
(161, 1, 78),
(162, 2, 78),
(163, 1, 79),
(164, 2, 79),
(165, 1, 80),
(166, 1, 81),
(167, 1, 82),
(168, 1, 83),
(169, 1, 84),
(170, 1, 85),
(171, 1, 86),
(172, 1, 87),
(173, 1, 88),
(174, 2, 88),
(175, 1, 89),
(176, 2, 89),
(177, 1, 90),
(178, 2, 90),
(179, 1, 91),
(180, 2, 91),
(181, 1, 92),
(182, 2, 92),
(183, 1, 93),
(184, 2, 93),
(185, 1, 94),
(186, 2, 94),
(187, 1, 95),
(188, 2, 95),
(189, 1, 96),
(190, 2, 96),
(191, 1, 97),
(192, 2, 97),
(193, 1, 98),
(194, 2, 98),
(195, 1, 99),
(196, 2, 99),
(197, 1, 100),
(198, 2, 100),
(199, 1, 101),
(200, 2, 101),
(201, 1, 102),
(202, 2, 102),
(203, 1, 103),
(204, 2, 103),
(205, 1, 104),
(206, 2, 104),
(207, 1, 105),
(208, 2, 105),
(209, 1, 106),
(210, 2, 106),
(211, 1, 107),
(212, 2, 107),
(213, 1, 108),
(214, 2, 108),
(215, 1, 109),
(216, 2, 109),
(217, 1, 110),
(218, 2, 110),
(219, 3, 110),
(220, 4, 110),
(221, 1, 111),
(222, 2, 111),
(223, 3, 111),
(224, 4, 111),
(225, 1, 112),
(226, 2, 112),
(227, 3, 112),
(228, 4, 112),
(229, 1, 113),
(230, 2, 113),
(231, 3, 113),
(232, 4, 113),
(233, 1, 114),
(234, 2, 114),
(235, 3, 114),
(236, 4, 114),
(237, 1, 115),
(238, 2, 115),
(239, 3, 115),
(240, 4, 115),
(241, 1, 116),
(242, 2, 116),
(243, 1, 117),
(244, 2, 117),
(245, 1, 118),
(246, 2, 118),
(247, 1, 119),
(248, 2, 119),
(249, 1, 120),
(250, 2, 120),
(251, 1, 121),
(252, 2, 121),
(253, 1, 122),
(254, 1, 123),
(255, 2, 123),
(256, 1, 124),
(257, 2, 124),
(258, 1, 125),
(259, 2, 125),
(260, 1, 126),
(261, 2, 126),
(262, 1, 127),
(263, 1, 128),
(264, 1, 129),
(265, 1, 130),
(266, 1, 131),
(267, 2, 131),
(268, 1, 132),
(269, 1, 133),
(270, 1, 134),
(271, 2, 134),
(272, 1, 135),
(273, 2, 135),
(274, 1, 136),
(275, 2, 136),
(276, 1, 137);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_functions`
--

CREATE TABLE `tbl_sys_functions` (
  `tbl_sys_function_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_function_type` enum('native','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'native',
  `tbl_sys_function_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_function_fn` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_function_params` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_function_props` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_function_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_function_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_functions`
--

INSERT INTO `tbl_sys_functions` (`tbl_sys_function_ID`, `tbl_sys_function_type`, `tbl_sys_function_name`, `tbl_sys_function_fn`, `tbl_sys_function_params`, `tbl_sys_function_props`, `tbl_sys_function_created_at`, `tbl_sys_function_updated_at`) VALUES
(1, 'custom', 'sysTranslations', 'AutomatorGetTranslations', '', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(2, 'custom', 'sysTranslate', 'AutomatorTranslate', '{ \'word\': true, \'lang\': false }', '{ \'lang\': @SysFunctions[\'sysTranslations\'] }', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(3, 'custom', 'sysDateFormat', 'AutomatorDateFormat', '{ \'date\': true, \'translate\': false }', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(4, 'custom', 'sysGetRouteDataInfo', 'AutomatorGetRouteDataInfo', '', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(5, 'custom', 'sysGetCurrentRouteData', 'AutomatorGetCurrentRouteData', '{ \'data\': true }', '{ \'data\': @SysFunctions[\'sysGetRouteDataInfo\'] }', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(6, 'custom', 'sysGetRouteData', 'AutomatorGetRouteData', '{ \'data\': true, \'route\': true }', '{ \'data\': @SysFunctions[\'sysGetRouteDataInfo\'] }', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(7, 'custom', 'sysGetUserDataInfo', 'AutomatorGetUserDataInfo', '', '', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(8, 'custom', 'sysGetUserData', 'AutomatorGetUserData', '{ \'data\': true, \'user\': true }', '{ \'data\': @SysFunctions[\'sysGetUserDataInfo\'] }', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(9, 'custom', 'sysGetCurrentUserData', 'AutomatorGetCurrentUserData', '{ \'data\': true }', '{ \'data\': @SysFunctions[\'sysGetUserDataInfo\'] }', '2026-07-25 03:40:00', '2026-07-25 03:40:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_menus`
--

CREATE TABLE `tbl_sys_menus` (
  `tbl_sys_menu_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_nav_ID` bigint UNSIGNED DEFAULT NULL,
  `tbl_sys_menu_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_menu_index` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_menu_class` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_menu_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_menu_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_menu_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_menus`
--

INSERT INTO `tbl_sys_menus` (`tbl_sys_menu_ID`, `tbl_sys_nav_ID`, `tbl_sys_menu_title`, `tbl_sys_menu_index`, `tbl_sys_menu_class`, `tbl_sys_menu_locked`, `tbl_sys_menu_created_at`, `tbl_sys_menu_updated_at`) VALUES
(1, 1, 'Sidebar Menu Painel Administrativo', '', 'app-sidebar-menu', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(2, 2, 'Header Menu Painel Administrativo', '', 'dropdown-menu dropdown-menu-end shadow', 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_menus_access`
--

CREATE TABLE `tbl_sys_menus_access` (
  `tbl_menus_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_menu_item_ID` bigint UNSIGNED NOT NULL,
  `tbl_menus_access_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_menus_access`
--

INSERT INTO `tbl_sys_menus_access` (`tbl_menus_access_ID`, `tbl_users_type_ID`, `tbl_sys_menu_item_ID`, `tbl_menus_access_created_at`) VALUES
(1, 1, 1, '2026-07-25 00:40:01'),
(2, 2, 1, '2026-07-25 00:40:01'),
(3, 3, 1, '2026-07-25 00:40:01'),
(4, 4, 1, '2026-07-25 00:40:01'),
(5, 1, 2, '2026-07-25 00:40:01'),
(6, 2, 2, '2026-07-25 00:40:01'),
(7, 3, 2, '2026-07-25 00:40:01'),
(8, 4, 2, '2026-07-25 00:40:01'),
(9, 1, 3, '2026-07-25 00:40:01'),
(10, 2, 3, '2026-07-25 00:40:01'),
(11, 3, 3, '2026-07-25 00:40:01'),
(12, 4, 3, '2026-07-25 00:40:01'),
(13, 1, 4, '2026-07-25 00:40:01'),
(14, 2, 4, '2026-07-25 00:40:01'),
(15, 1, 5, '2026-07-25 00:40:01'),
(16, 2, 5, '2026-07-25 00:40:01'),
(17, 1, 6, '2026-07-25 00:40:01'),
(18, 2, 6, '2026-07-25 00:40:01'),
(19, 1, 7, '2026-07-25 00:40:01'),
(20, 2, 7, '2026-07-25 00:40:01'),
(21, 1, 8, '2026-07-25 00:40:01'),
(22, 2, 8, '2026-07-25 00:40:01'),
(23, 1, 9, '2026-07-25 00:40:01'),
(24, 2, 9, '2026-07-25 00:40:01'),
(25, 1, 10, '2026-07-25 00:40:01'),
(26, 2, 10, '2026-07-25 00:40:01'),
(27, 1, 11, '2026-07-25 00:40:01'),
(28, 2, 11, '2026-07-25 00:40:01'),
(29, 1, 12, '2026-07-25 00:40:01'),
(30, 2, 12, '2026-07-25 00:40:01'),
(31, 1, 13, '2026-07-25 00:40:01'),
(32, 2, 13, '2026-07-25 00:40:01'),
(33, 1, 14, '2026-07-25 00:40:01'),
(34, 2, 14, '2026-07-25 00:40:01'),
(35, 1, 15, '2026-07-25 00:40:01'),
(36, 2, 15, '2026-07-25 00:40:01'),
(37, 1, 16, '2026-07-25 00:40:01'),
(38, 2, 16, '2026-07-25 00:40:01'),
(39, 1, 17, '2026-07-25 00:40:01'),
(40, 2, 17, '2026-07-25 00:40:01'),
(41, 1, 18, '2026-07-25 00:40:01'),
(42, 2, 18, '2026-07-25 00:40:01'),
(43, 1, 19, '2026-07-25 00:40:01'),
(44, 2, 19, '2026-07-25 00:40:01'),
(45, 1, 20, '2026-07-25 00:40:01'),
(46, 1, 21, '2026-07-25 00:40:01'),
(47, 2, 21, '2026-07-25 00:40:01'),
(48, 1, 22, '2026-07-25 00:40:01'),
(49, 2, 22, '2026-07-25 00:40:01'),
(50, 1, 23, '2026-07-25 00:40:01'),
(51, 2, 23, '2026-07-25 00:40:01'),
(52, 1, 24, '2026-07-25 00:40:01'),
(53, 1, 25, '2026-07-25 00:40:01'),
(54, 1, 26, '2026-07-25 00:40:01'),
(55, 2, 26, '2026-07-25 00:40:01'),
(56, 1, 27, '2026-07-25 00:40:02'),
(57, 2, 27, '2026-07-25 00:40:02'),
(58, 3, 27, '2026-07-25 00:40:02'),
(59, 4, 27, '2026-07-25 00:40:02'),
(60, 1, 28, '2026-07-25 00:40:02'),
(61, 2, 28, '2026-07-25 00:40:02'),
(62, 3, 28, '2026-07-25 00:40:02'),
(63, 4, 28, '2026-07-25 00:40:02'),
(64, 1, 29, '2026-07-25 00:40:02'),
(65, 2, 29, '2026-07-25 00:40:02'),
(66, 3, 29, '2026-07-25 00:40:02'),
(67, 4, 29, '2026-07-25 00:40:02'),
(68, 1, 30, '2026-07-25 00:40:02'),
(69, 2, 30, '2026-07-25 00:40:02'),
(70, 3, 30, '2026-07-25 00:40:02'),
(71, 4, 30, '2026-07-25 00:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_menus_items`
--

CREATE TABLE `tbl_sys_menus_items` (
  `tbl_sys_menu_item_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_menu_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_menu_item_index` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_menu_item_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_menu_item_class` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_menu_item_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_menu_item_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'route',
  `tbl_sys_route_ID` bigint UNSIGNED DEFAULT NULL,
  `tbl_sys_menu_item_link` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_menu_item_props` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_menu_item_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_sys_menu_item_parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_menu_item_admin` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_menu_item_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_menu_item_ordem` int NOT NULL,
  `tbl_sys_menu_item_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_menu_item_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_menus_items`
--

INSERT INTO `tbl_sys_menus_items` (`tbl_sys_menu_item_ID`, `tbl_sys_menu_ID`, `tbl_sys_menu_item_index`, `tbl_sys_menu_item_icon`, `tbl_sys_menu_item_class`, `tbl_sys_menu_item_title`, `tbl_sys_menu_item_type`, `tbl_sys_route_ID`, `tbl_sys_menu_item_link`, `tbl_sys_menu_item_props`, `tbl_sys_menu_item_status`, `tbl_sys_menu_item_parent_id`, `tbl_sys_menu_item_admin`, `tbl_sys_menu_item_locked`, `tbl_sys_menu_item_ordem`, `tbl_sys_menu_item_created_at`, `tbl_sys_menu_item_updated_at`) VALUES
(1, 1, '', 'gauge', 'sidebar-link', 'Dashboard', 'route', 8, '', '{\"data-sidebar-title\":\"Dashboard\"}', 'ativo', '0', 1, 1, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(2, 1, '', 'bell', 'sidebar-link', 'Notificações', 'route', 9, '', '{\"data-sidebar-title\":\"Notifica\\u00e7\\u00f5es\"}', 'ativo', '0', 1, 1, 2, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(3, 1, '', 'user', 'sidebar-link', 'Minha Conta', 'route', 13, '', '{\"data-sidebar-title\":\"Minha Conta\"}', 'ativo', '0', 1, 1, 3, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(4, 1, '', 'image', 'sidebar-link', 'Galeria', 'button', NULL, '', '{\"data-sidebar-title\":\"Galeria\"}', 'ativo', '0', 1, 1, 4, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(5, 1, '', '', 'sidebar-submenu-link', 'Tipos de Midia', 'route', 16, '', '', 'ativo', '4', 1, 1, 5, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(6, 1, '', '', 'sidebar-submenu-link', 'Uploads', 'route', 21, '', '', 'ativo', '4', 1, 1, 6, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(7, 1, '', 'shield-halved', 'sidebar-link', 'Administração', 'button', NULL, '', '{\"data-sidebar-title\":\"Administra\\u00e7\\u00e3o\"}', 'ativo', '0', 1, 1, 7, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(8, 1, '', '', 'sidebar-submenu-link', 'Rotas de API', 'route', 28, '', '', 'ativo', '7', 1, 1, 8, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(9, 1, '', '', 'sidebar-submenu-link', 'Páginas', 'route', 35, '', '', 'ativo', '7', 1, 1, 9, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(10, 1, '', '', 'sidebar-submenu-link', 'Navegação', 'route', 42, '', '', 'ativo', '7', 1, 1, 10, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(11, 1, '', '', 'sidebar-submenu-link', 'Menus', 'route', 47, '', '', 'ativo', '7', 1, 1, 11, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(12, 1, '', 'users', 'sidebar-link', 'Usuários', 'button', NULL, '', '{\"data-sidebar-title\":\"Usu\\u00e1rios\"}', 'ativo', '0', 1, 1, 12, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(13, 1, '', '', 'sidebar-submenu-link', 'Tipos de Usuários', 'route', 52, '', '', 'ativo', '12', 1, 1, 13, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(14, 1, '', '', 'sidebar-submenu-link', 'Usuários', 'route', 59, '', '', 'ativo', '12', 1, 1, 14, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(15, 1, '', '', 'sidebar-submenu-link', 'Notificações', 'route', 64, '', '', 'ativo', '12', 1, 1, 15, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(16, 1, '', 'language', 'sidebar-link', 'Idiomas', 'button', NULL, '', '{\"data-sidebar-title\":\"Idiomas\"}', 'ativo', '0', 1, 1, 16, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(17, 1, '', '', 'sidebar-submenu-link', 'Idiomas', 'route', 105, '', '', 'ativo', '16', 1, 1, 17, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(18, 1, '', '', 'sidebar-submenu-link', 'Traduções', 'route', 110, '', '', 'ativo', '16', 1, 1, 18, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(19, 1, '', 'layer-group', 'sidebar-link', 'Automator', 'route', 71, '', '{\"data-sidebar-title\":\"Automator\"}', 'ativo', '0', 1, 1, 19, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(20, 1, '', '', 'sidebar-submenu-link', 'Campos', 'route', 72, '', '', 'ativo', '19', 1, 1, 20, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(21, 1, '', '', 'sidebar-submenu-link', 'Módulos', 'route', 77, '', '', 'ativo', '19', 1, 1, 21, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(22, 1, '', '', 'sidebar-submenu-link', 'Formulários', 'route', 82, '', '', 'ativo', '19', 1, 1, 22, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(23, 1, '', '', 'sidebar-submenu-link', 'Paginações', 'route', 90, '', '', 'ativo', '19', 1, 1, 23, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(24, 1, '', '', 'sidebar-submenu-link', 'Shortcodes', 'route', 95, '', '', 'ativo', '19', 1, 1, 24, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(25, 1, '', '', 'sidebar-submenu-link', 'Funções', 'route', 100, '', '', 'ativo', '19', 1, 1, 25, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(26, 1, '', 'cog', 'sidebar-link', 'Configurações', 'route', 69, '', '{\"data-sidebar-title\":\"Configura\\u00e7\\u00f5es\"}', 'ativo', '0', 1, 1, 26, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(27, 1, '', 'right-from-bracket', 'sidebar-btn', 'Sair', 'button', NULL, '', '{\"class\": \"btn-logout-system sidebar-link\", \"data-sidebar-title\": \"Sair\"}', 'ativo', '0', 1, 1, 27, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(28, 2, '', '', 'dropdown-item py-2', 'Minha Conta', 'route', 13, '', '', 'ativo', '0', 1, 1, 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(29, 2, '', '', '', 'Divisor', 'divider', NULL, '', '', 'ativo', '0', 0, 0, 2, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(30, 2, '', '', 'dropdown-item p-0', 'Sair', 'button', NULL, '', '{\"class\": \"btn-logout-system btn-header-painel p-2\"}', 'ativo', '0', 1, 1, 3, '2026-07-25 03:40:02', '2026-07-25 03:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_menus_item_access`
--

CREATE TABLE `tbl_sys_menus_item_access` (
  `tbl_menus_item_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_menu_item_ID` bigint UNSIGNED NOT NULL,
  `tbl_menus_item_access_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_menus_item_access`
--

INSERT INTO `tbl_sys_menus_item_access` (`tbl_menus_item_access_ID`, `tbl_users_type_ID`, `tbl_sys_menu_item_ID`, `tbl_menus_item_access_created_at`) VALUES
(1, 1, 1, '2026-07-25 00:40:01'),
(2, 1, 2, '2026-07-25 00:40:01'),
(3, 2, 2, '2026-07-25 00:40:01'),
(4, 1, 3, '2026-07-25 00:40:01'),
(5, 2, 3, '2026-07-25 00:40:01'),
(6, 1, 4, '2026-07-25 00:40:01'),
(7, 1, 5, '2026-07-25 00:40:01'),
(8, 1, 6, '2026-07-25 00:40:01'),
(9, 1, 7, '2026-07-25 00:40:01'),
(10, 1, 8, '2026-07-25 00:40:01'),
(11, 1, 9, '2026-07-25 00:40:01'),
(12, 1, 10, '2026-07-25 00:40:01'),
(13, 1, 11, '2026-07-25 00:40:01'),
(14, 1, 12, '2026-07-25 00:40:01'),
(15, 1, 13, '2026-07-25 00:40:01'),
(16, 1, 14, '2026-07-25 00:40:01'),
(17, 1, 15, '2026-07-25 00:40:01'),
(18, 1, 16, '2026-07-25 00:40:01'),
(19, 1, 17, '2026-07-25 00:40:01'),
(20, 1, 18, '2026-07-25 00:40:01'),
(21, 1, 19, '2026-07-25 00:40:01'),
(22, 1, 20, '2026-07-25 00:40:01'),
(23, 1, 21, '2026-07-25 00:40:01'),
(24, 1, 22, '2026-07-25 00:40:01'),
(25, 1, 23, '2026-07-25 00:40:01'),
(26, 1, 24, '2026-07-25 00:40:01'),
(27, 1, 25, '2026-07-25 00:40:01'),
(28, 1, 26, '2026-07-25 00:40:02'),
(29, 1, 27, '2026-07-25 00:40:02'),
(30, 2, 27, '2026-07-25 00:40:02'),
(31, 1, 28, '2026-07-25 00:40:02'),
(32, 2, 28, '2026-07-25 00:40:02'),
(33, 1, 29, '2026-07-25 00:40:02'),
(34, 2, 29, '2026-07-25 00:40:02'),
(35, 1, 30, '2026-07-25 00:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_modulos`
--

CREATE TABLE `tbl_sys_modulos` (
  `tbl_sys_modulo_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_modulo_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_modulo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_modulo_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_modulo_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_modulo_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_sys_modulo_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_modulo_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_navs`
--

CREATE TABLE `tbl_sys_navs` (
  `tbl_sys_nav_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_nav_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_nav_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_nav_admin` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_nav_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_nav_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_nav_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_navs`
--

INSERT INTO `tbl_sys_navs` (`tbl_sys_nav_ID`, `tbl_sys_nav_name`, `tbl_sys_nav_title`, `tbl_sys_nav_admin`, `tbl_sys_nav_locked`, `tbl_sys_nav_created_at`, `tbl_sys_nav_updated_at`) VALUES
(1, 'admin-sidebar', 'Sidebar Painel Administrativo', 1, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(2, 'admin-header', 'Header Menu Painel Administrativo', 1, 1, '2026-07-25 03:40:01', '2026-07-25 03:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_notifications`
--

CREATE TABLE `tbl_sys_notifications` (
  `tbl_sys_notification_ID` bigint UNSIGNED NOT NULL,
  `tbl_user_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_notification_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_notification_text` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_notification_opened` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_notification_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_notification_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_paginations`
--

CREATE TABLE `tbl_sys_paginations` (
  `tbl_sys_pagination_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_pagination_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_pagination_route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_pagination_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_pagination_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_pagination_index` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_pagination_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_pagination_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_pagination_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_paginations`
--

INSERT INTO `tbl_sys_paginations` (`tbl_sys_pagination_ID`, `tbl_sys_pagination_name`, `tbl_sys_pagination_route`, `tbl_sys_pagination_title`, `tbl_sys_pagination_table`, `tbl_sys_pagination_index`, `tbl_sys_pagination_locked`, `tbl_sys_pagination_created_at`, `tbl_sys_pagination_updated_at`) VALUES
(1, 'admin-navs-pagination', 'admin-navs', 'Paginação posições de menus de navegação.', 'tbl_sys_navs', 'tbl_sys_nav_ID', 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(2, 'admin-apis-pagination', 'admin-apis', 'Paginação de Rotas de API do sistema', 'tbl_sys_routes', 'tbl_sys_route_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(3, 'admin-routes-pagination', 'admin-routes', 'Paginação de Rotas/Páginas do sistema', 'tbl_sys_routes', 'tbl_sys_route_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(4, 'admin-users-types-pagination', 'admin-users-types', 'Paginação tipos de usuários', 'tbl_users_types', 'tbl_users_type_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(5, 'admin-users-pagination', 'admin-users', 'Paginação de usuários', 'tbl_users', 'tbl_user_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(6, 'admin-notifications-pagination', 'admin-notifications', 'Paginação notificações do sistema de usuarios.', 'tbl_sys_notifications', 'tbl_sys_notification_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(7, 'admin-fields-pagination', 'admin-fields', 'Paginação de tipos de campos', 'tbl_sys_field_types', 'tbl_sys_field_type_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(8, 'admin-modulos-pagination', 'admin-modulos', 'Paginação de módulos', 'tbl_sys_modulos', 'tbl_sys_modulo_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(9, 'admin-forms-pagination', 'admin-forms', 'Paginação de formulários', 'tbl_sys_forms', 'tbl_sys_form_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(10, 'admin-paginations-pagination', 'admin-paginations', 'Paginações', 'tbl_sys_paginations', 'tbl_sys_pagination_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(11, 'admin-shortcodes-pagination', 'admin-shortcodes', 'Shortcodes do sistema', 'tbl_sys_shortcodes', 'tbl_sys_shortcode_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(12, 'admin-user-notifications-pagination', 'admin-notificacoes', 'Notificações do usuario', 'tbl_sys_notifications', 'tbl_sys_notification_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(13, 'admin-galeria-uploads-types-pagination', 'admin-galeria-uploads-types', 'Paginação tipos de midia', 'tbl_sys_uploads_types', 'tbl_sys_uploads_type_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(14, 'admin-languages-pagination', 'admin-languages', 'Paginação idiomas', 'tbl_sys_translations', 'tbl_sys_translation_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(15, 'admin-functions-pagination', 'admin-functions', 'Paginação Funções', 'tbl_sys_functions', 'tbl_sys_function_ID', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_paginations_args`
--

CREATE TABLE `tbl_sys_paginations_args` (
  `tbl_sys_paginations_arg_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_pagination_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_paginations_arg_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_paginations_arg_value` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_paginations_arg_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_paginations_arg_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_paginations_args`
--

INSERT INTO `tbl_sys_paginations_args` (`tbl_sys_paginations_arg_ID`, `tbl_sys_pagination_ID`, `tbl_sys_paginations_arg_name`, `tbl_sys_paginations_arg_value`, `tbl_sys_paginations_arg_created`, `tbl_sys_paginations_arg_updated`) VALUES
(1, 1, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(2, 1, 'per_page', '15', '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(3, 1, 'actions', '{\"get\":{\"route\":\"admin-api-navs-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-navs-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-navs-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-navs-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_nav_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(4, 1, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-nav\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova \\u00c1rea de navega\\u00e7\\u00e3o\', 6, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(5, 1, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar \\u00c1rea de navega\\u00e7\\u00e3o\', 6, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"\"}]', '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(6, 2, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(7, 2, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(8, 2, 'where', '[[\"tbl_sys_route_api\",\">=\",1]]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(9, 2, 'actions', '{\"access\":{\"route\":\"admin-api-routes-apis-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-routes-apis-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-routes-apis-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-routes-apis-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-routes-apis-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-routes-apis-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_route_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(10, 2, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-route-apis\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova API\', 2);\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(11, 2, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-routes-apis\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar API\', 2, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es da Rota de API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Permiss\\u00f5es da API\', 3, \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete-routes-apis\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir P\\u00e1gina\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(12, 3, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(13, 3, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(14, 3, 'where', '[[\"tbl_sys_route_api\",\"<=\",0]]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(15, 3, 'actions', '{\"access\":{\"route\":\"admin-api-routes-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-routes-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-routes-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-routes-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-routes-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-routes-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_route_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(16, 3, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-route\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova P\\u00e1gina\",\"onclick\":\"AutomatorCreateViewModal(\\n                        {\\n                          view: \'system-page-editor\',\\n                          editorAction: \'store\'\\n                        },\\n                        {\\n                          editorAction: \'store\',\\n                          size: \'fullscreen\',\\n                          backdrop: true,\\n                          keyboard: false,\\n                          keepLoaderUntilCallback: true,\\n\\n                          beforeShow: function(response, modalEl, modal, recordData) {\\n\\n                            SysAutomatorConfigPageEditor(\\n                              response,\\n                              modalEl,\\n                              modal,\\n                              recordData,\\n                              {\\n                                method: \'POST\',\\n                                action: \'add\'\\n                              }\\n                            );\\n\\n                          },\\n\\n                          callback: function(response, modalEl, modal, recordData) {\\n\\n                            SysAutomatorInitPageEditor(\\n                              response,\\n                              modalEl,\\n                              modal,\\n                              recordData\\n                            );\\n\\n                          },\\n\\n                          afterHideOn: function(response, modalEl, modal, recordData) {\\n\\n                            SysAutomatorDestroyPageEditor(\\n                              response,\\n                              modalEl,\\n                              modal,\\n                              recordData\\n                            );\\n\\n                          }\\n                        }\\n                      );\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(17, 3, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar P\\u00e1gina\",\"onclick\":\"AutomatorCreateViewModal(\\n                      {\\n                        view: \'system-page-editor\',\\n                        editorAction: \'update\',\\n                        pageID: \'{id}\'\\n                      },\\n                      {\\n                        acao: \'get\',\\n                        id: \'{id}\',\\n                        pageID: \'{id}\',\\n                        editorAction: \'update\',\\n                        size: \'fullscreen\',\\n                        backdrop: true,\\n                        keyboard: false,\\n                        keepLoaderUntilCallback: true,\\n\\n                        beforeShow: function(response, modalEl, modal, recordData) {\\n\\n                          SysAutomatorConfigPageEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData,\\n                            {\\n                              method: \'POST\',\\n                              action: \'edit\',\\n                              tbl_sys_route_ID: \'{id}\'\\n                            }\\n                          );\\n\\n                        },\\n\\n                        callback: function(response, modalEl, modal, recordData) {\\n\\n                          SysAutomatorInitPageEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData\\n                          );\\n\\n                        },\\n\\n                        afterHideOn: function(response, modalEl, modal, recordData) {\\n\\n                          SysAutomatorDestroyPageEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData\\n                          );\\n\\n                        }\\n                      }\\n                    );\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es da P\\u00e1gina\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Permiss\\u00f5es da P\\u00e1gina\', 5, \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir P\\u00e1gina\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(18, 4, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(19, 4, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(20, 4, 'actions', '{\"access\":{\"route\":\"admin-api-users-types-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-users-types-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-users-types-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-users-types-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-users-types-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-users-types-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_users_type_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(21, 4, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-user-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Tipo de usu\\u00e1rio\', 7, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(22, 4, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Tipo de usu\\u00e1rio\', 7, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es do Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-lg\', \'Permiss\\u00f5es do Tipo de usu\\u00e1rio\', 8, \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Tipo de usu\\u00e1rio\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(23, 5, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(24, 5, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(25, 5, 'actions', '{\"get\":{\"route\":\"admin-api-users-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-users-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-users-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-users-delete\",\"params\":[],\"show\":false}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(26, 5, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-user\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Usu\\u00e1rio\', 9, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(27, 5, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Usu\\u00e1rio\', 10, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Usu\\u00e1rio\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(28, 6, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(29, 6, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(30, 6, 'actions', '{\"get\":{\"route\":\"admin-api-notifications-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-notifications-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-notifications-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-notifications-delete\",\"params\":[],\"show\":false}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(31, 6, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-notification\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova Notifica\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova Notifica\\u00e7\\u00e3o\', 11, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(32, 6, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-notification\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Notifica\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Notifica\\u00e7\\u00e3o\', 11, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete-notification\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Notifica\\u00e7\\u00e3o\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(33, 7, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(34, 7, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(35, 7, 'actions', '{\"get\":{\"route\":\"admin-api-fields-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-fields-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-fields-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-fields-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_field_type_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(36, 7, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-field-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Tipo de campo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Tipo de campo\', );\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(37, 7, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Tipo de campo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Tipo de campo\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Tipo de campo\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(38, 8, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(39, 8, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(40, 8, 'actions', '{\"get\":{\"route\":\"admin-api-modulos-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-modulos-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-modulos-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-modulos-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_modulo_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(41, 8, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-modulo\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Adicionar M\\u00f3dulo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Adicionar M\\u00f3dulo\', );\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(42, 8, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar M\\u00f3dulo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar M\\u00f3dulo\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir M\\u00f3dulo\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(43, 9, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(44, 9, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(45, 9, 'actions', '{\"access\":{\"route\":\"admin-api-forms-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-forms-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-forms-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-forms-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-forms-update\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"delete\":{\"route\":\"admin-api-forms-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_form_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(46, 9, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-form\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Formul\\u00e1rio\",\"onclick\":\"AutomatorCreateViewModal({ view: \'system-form-editor\' }, { size: \'fullscreen\', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = \'store\'; response.formID = null; response.form_id = null; response.tbl_sys_form_ID = null; SysAutomatorConfigFormEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyFormEditor(response, modalEl, modal, recordData); } });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(47, 9, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Formul\\u00e1rio\",\"onclick\":\"AutomatorCreateViewModal({ view: \'system-form-editor\', formID: \'{id}\' }, { size: \'fullscreen\', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = \'edit\'; response.formID = \'{id}\'; SysAutomatorConfigFormEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyFormEditor(response, modalEl, modal, recordData); } });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Formul\\u00e1rio\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(48, 10, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(49, 10, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(50, 10, 'actions', '{\"get\":{\"route\":\"admin-api-paginations-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-paginations-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-paginations-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-paginations-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_pagination_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(51, 10, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-pagination\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova Pagina\\u00e7\\u00e3o\",\"onclick\":\"AutomatorCreateViewModal(\\n                      {\\n                        view: \'system-pagination-editor\',\\n                        editorAction: \'add\'\\n                      },\\n                      {\\n                        editorAction: \'add\',\\n                        size: \'fullscreen\',\\n                        backdrop: true,\\n                        keyboard: false,\\n                        scrollable: false,\\n                        keepLoaderUntilCallback: true,\\n\\n                        callback: function(response, modalEl, modal, recordData) {\\n\\n                          response.acao = \'add\';\\n                          response.editorAction = \'add\';\\n                          response.submitAction = \'add\';\\n                          response.paginationID = null;\\n                          response.pagination_id = null;\\n                          response.tbl_sys_pagination_ID = null;\\n                          response.pageID = null;\\n\\n                          SysAutomatorConfigPaginationEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            {}\\n                          );\\n\\n                        },\\n\\n                        afterHideOn: function(response, modalEl, modal, recordData) {\\n\\n                          SysAutomatorDestroyPaginationEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData\\n                          );\\n\\n                        }\\n                      }\\n                    );\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(52, 10, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Pagina\\u00e7\\u00e3o\",\"onclick\":\"AutomatorCreateViewModal(\\n                      {\\n                        view: \'system-pagination-editor\',\\n                        editorAction: \'edit\',\\n                        pageID: {id}\\n                      },\\n                      {\\n                        acao: \'get\',\\n                        id: {id},\\n                        pageID: {id},\\n                        editorAction: \'edit\',\\n                        size: \'fullscreen\',\\n                        backdrop: true,\\n                        keyboard: false,\\n                        scrollable: false,\\n                        keepLoaderUntilCallback: true,\\n\\n                        callback: function(response, modalEl, modal, recordData) {\\n\\n                          response.acao = \'edit\';\\n                          response.editorAction = \'edit\';\\n                          response.submitAction = \'edit\';\\n                          response.paginationID = {id};\\n                          response.pagination_id = {id};\\n                          response.tbl_sys_pagination_ID = {id};\\n                          response.pageID = {id};\\n\\n                          SysAutomatorConfigPaginationEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData\\n                          );\\n\\n                        },\\n\\n                        afterHideOn: function(response, modalEl, modal, recordData) {\\n\\n                          SysAutomatorDestroyPaginationEditor(\\n                            response,\\n                            modalEl,\\n                            modal,\\n                            recordData\\n                          );\\n\\n                        }\\n                      }\\n                    );\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Pagina\\u00e7\\u00e3o\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(53, 11, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(54, 11, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(55, 11, 'actions', '{\"get\":{\"route\":\"admin-api-shortcodes-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-shortcodes-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-shortcodes-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-shortcodes-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_shortcode_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(56, 11, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-shortcode\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Shortcode\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Novo Shortcode\', 12);\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(57, 11, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Shortcode\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Shortcode\', 12, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(58, 12, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(59, 12, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(60, 12, 'where', '[[\"tbl_user_ID\",\"==\",\"@SysFunctions(\'sysGetCurrentUserData\', [\'data\' => \'tbl_user_ID\'])\"]]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(61, 12, 'actions', '{\"get\":{\"route\":\"admin-api-notificacoes-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"edit\":{\"route\":\"admin-api-notificacoes-update\",\"params\":[],\"show\":true}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(62, 12, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-view\",\"class\":\"btn-primary\",\"icon\":\"eye\",\"text\":\"Visualizar Notifica\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-lg\', \'Visualizar Notifica\\u00e7\\u00e3o\', 15, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(63, 13, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(64, 13, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(65, 13, 'actions', '{\"get\":{\"route\":\"admin-api-galeria-uploads-types-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-galeria-uploads-types-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-galeria-uploads-types-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-galeria-uploads-types-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_uploads_type_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(66, 13, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-galeria-upload-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Tipo de m\\u00eddia\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Tipo de m\\u00eddia\', 16, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(67, 13, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-galeria-upload-type\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Tipo de m\\u00eddia\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Tipo de m\\u00eddia\', 16, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete-galeria-upload-type\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Tipo de m\\u00eddia\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(68, 14, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(69, 14, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(70, 14, 'actions', '{\"get\":{\"route\":\"admin-api-languages-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-languages-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-languages-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-languages-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_translation_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(71, 14, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-language\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Idioma\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Idioma\', 17, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(72, 14, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-language\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Idioma\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Idioma\', 17, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete-language\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Idioma\",\"onclick\":\"\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(73, 15, 'page_name', '@SysFunctions(\'sysGetCurrentRouteData\', [\'data\' => \'tbl_sys_route_name\'])', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(74, 15, 'per_page', '15', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(75, 15, 'actions', '{\"get\":{\"route\":\"admin-api-functions-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-functions-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-functions-update\",\"params\":[],\"show\":true}}', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(76, 15, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-function\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova Fun\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova Fun\\u00e7\\u00e3o\', 18, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(77, 15, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-function\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Fun\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Fun\\u00e7\\u00e3o\', 18, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"}]', '2026-07-25 03:40:03', '2026-07-25 03:40:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_paginations_cols`
--

CREATE TABLE `tbl_sys_paginations_cols` (
  `tbl_sys_paginations_col_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_pagination_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_paginations_col_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_paginations_col_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_paginations_col_header` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_paginations_col_body` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_paginations_col_props` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_paginations_col_attrs` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_paginations_col_search` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_paginations_col_sort` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_paginations_col_ordem` int NOT NULL,
  `tbl_sys_paginations_col_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_paginations_col_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_paginations_cols`
--

INSERT INTO `tbl_sys_paginations_cols` (`tbl_sys_paginations_col_ID`, `tbl_sys_pagination_ID`, `tbl_sys_field_type_ID`, `tbl_sys_paginations_col_name`, `tbl_sys_paginations_col_title`, `tbl_sys_paginations_col_header`, `tbl_sys_paginations_col_body`, `tbl_sys_paginations_col_props`, `tbl_sys_paginations_col_attrs`, `tbl_sys_paginations_col_search`, `tbl_sys_paginations_col_sort`, `tbl_sys_paginations_col_ordem`, `tbl_sys_paginations_col_created`, `tbl_sys_paginations_col_updated`) VALUES
(1, 1, 3, 'tbl_sys_nav_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(2, 1, 1, 'tbl_sys_nav_name', 'Nome', '', '', '', '', 1, 0, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(3, 1, 1, 'tbl_sys_nav_title', 'Titulo', '', '', '', '', 1, 0, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(4, 1, 18, 'tbl_sys_nav_ID', 'Menu', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '{\"type\":\"single\",\"mode\":\"revert\",\"table\":\"tbl_sys_menus\",\"column\":\"tbl_sys_nav_ID\",\"display\":\"tbl_sys_menu_title\",\"nullable\":true,\"empty\":\"- - -\"}', '', 0, 0, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(5, 2, 3, 'tbl_sys_route_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(6, 2, 1, 'tbl_sys_route_title', 'Titulo', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(7, 2, 1, 'tbl_sys_route_name', 'Nome', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(8, 2, 1, 'tbl_sys_route_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(9, 3, 3, 'tbl_sys_route_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(10, 3, 1, 'tbl_sys_route_title', 'Titulo', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(11, 3, 1, 'tbl_sys_route_name', 'Nome', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(12, 3, 1, 'tbl_sys_route_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(13, 4, 3, 'tbl_users_type_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(14, 4, 1, 'tbl_users_type_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(15, 4, 1, 'tbl_users_type_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(16, 5, 3, 'tbl_user_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(17, 5, 1, 'tbl_user_login', 'Usuário', '', '', '', '', 1, 0, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(18, 5, 1, 'tbl_user_name', 'Nome', '', '', '', '', 1, 0, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(19, 5, 1, 'tbl_user_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(20, 6, 3, 'tbl_sys_notification_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(21, 6, 18, 'tbl_user_ID', 'Usuário', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '{\"type\":\"single\",\"mode\":\"revert\",\"table\":\"tbl_users\",\"column\":\"tbl_user_ID\",\"display\":\"tbl_user_name\",\"nullable\":true,\"empty\":\"- - -\"}', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(22, 6, 1, 'tbl_sys_notification_created_at', 'Data envio', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '{\"format\":\"Y-m-d H:i:s\",\"display\":\"d\\/m\\/Y - H:i\"}', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(23, 7, 3, 'tbl_sys_field_type_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(24, 7, 1, 'tbl_sys_field_type_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(25, 7, 1, 'tbl_sys_field_type_title', 'Titulo', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(26, 8, 3, 'tbl_sys_modulo_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(27, 8, 1, 'tbl_sys_modulo_title', 'Titulo', '', '', '', '', 1, 0, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(28, 8, 1, 'tbl_sys_modulo_name', 'Nome', '', '', '', '', 1, 0, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(29, 8, 1, 'tbl_sys_modulo_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(30, 9, 3, 'tbl_sys_form_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(31, 9, 1, 'tbl_sys_form_name', 'Nome', '', '', '', '', 1, 0, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(32, 9, 1, 'tbl_sys_form_title', 'Titulo', '', '', '', '', 1, 0, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(33, 10, 3, 'tbl_sys_pagination_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(34, 10, 1, 'tbl_sys_pagination_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(35, 10, 1, 'tbl_sys_pagination_title', 'Titulo', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(36, 11, 3, 'tbl_sys_shortcode_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(37, 11, 1, 'tbl_sys_shortcode_code', 'Codigo', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(38, 11, 1, 'tbl_sys_shortcode_title', 'Nome', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(39, 12, 3, 'tbl_sys_notification_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(40, 12, 1, 'tbl_sys_notification_title', 'Titulo', '', '', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(41, 12, 1, 'tbl_sys_notification_opened', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":[\"<span class=\\\"badge text-bg-danger\\\">Fechada<\\/span>\",\"<span class=\\\"badge text-bg-success\\\">Aberta<\\/span>\"]}', 0, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(42, 13, 3, 'tbl_sys_uploads_type_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(43, 13, 36, 'tbl_sys_uploads_type_name', 'Type', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(44, 13, 1, 'tbl_sys_uploads_type_title', 'Nome', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(45, 14, 3, 'tbl_sys_translation_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(46, 14, 36, 'tbl_sys_translation_key', 'Key', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(47, 14, 1, 'tbl_sys_translation_name', 'Nome', '', '', '', '', 1, 1, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(48, 15, 3, 'tbl_sys_function_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(49, 15, 1, 'tbl_sys_function_type', 'Tipo', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 2, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(50, 15, 1, 'tbl_sys_function_name', 'Nome', '', '', '', '', 1, 0, 3, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(51, 15, 1, 'tbl_sys_function_fn', 'Função', '', '', '', '', 1, 0, 4, '2026-07-25 03:40:03', '2026-07-25 03:40:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_paginations_cols_access`
--

CREATE TABLE `tbl_sys_paginations_cols_access` (
  `tbl_sys_pagination_col_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_paginations_col_ID` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_paginations_cols_access`
--

INSERT INTO `tbl_sys_paginations_cols_access` (`tbl_sys_pagination_col_access_ID`, `tbl_users_type_ID`, `tbl_sys_paginations_col_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 2),
(5, 1, 3),
(6, 2, 3),
(7, 1, 4),
(8, 2, 4),
(9, 1, 5),
(10, 2, 5),
(11, 1, 6),
(12, 2, 6),
(13, 1, 7),
(14, 2, 7),
(15, 1, 8),
(16, 2, 8),
(17, 1, 9),
(18, 2, 9),
(19, 1, 10),
(20, 2, 10),
(21, 1, 11),
(22, 2, 11),
(23, 1, 12),
(24, 2, 12),
(25, 1, 13),
(26, 2, 13),
(27, 1, 14),
(28, 2, 14),
(29, 1, 15),
(30, 2, 15),
(31, 1, 16),
(32, 2, 16),
(33, 1, 17),
(34, 2, 17),
(35, 1, 18),
(36, 2, 18),
(37, 1, 19),
(38, 2, 19),
(39, 1, 20),
(40, 2, 20),
(41, 1, 21),
(42, 2, 21),
(43, 1, 22),
(44, 2, 22),
(45, 1, 23),
(46, 1, 24),
(47, 1, 25),
(48, 1, 26),
(49, 2, 26),
(50, 1, 27),
(51, 2, 27),
(52, 1, 28),
(53, 2, 28),
(54, 1, 29),
(55, 2, 29),
(56, 1, 30),
(57, 2, 30),
(58, 1, 31),
(59, 2, 31),
(60, 1, 32),
(61, 2, 32),
(62, 1, 33),
(63, 2, 33),
(64, 1, 34),
(65, 2, 34),
(66, 1, 35),
(67, 2, 35),
(68, 1, 36),
(69, 2, 36),
(70, 1, 37),
(71, 2, 37),
(72, 1, 38),
(73, 2, 38),
(74, 1, 39),
(75, 2, 39),
(76, 3, 39),
(77, 4, 39),
(78, 1, 40),
(79, 2, 40),
(80, 3, 40),
(81, 4, 40),
(82, 1, 41),
(83, 2, 41),
(84, 3, 41),
(85, 4, 41),
(86, 1, 42),
(87, 2, 42),
(88, 1, 43),
(89, 2, 43),
(90, 1, 44),
(91, 2, 44),
(92, 1, 45),
(93, 2, 45),
(94, 1, 46),
(95, 2, 46),
(96, 1, 47),
(97, 2, 47),
(98, 1, 48),
(99, 1, 49),
(100, 1, 50),
(101, 1, 51);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_routes`
--

CREATE TABLE `tbl_sys_routes` (
  `tbl_sys_route_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_route_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_route_permalink` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_route_api` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_route_admin` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_route_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_route_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GET',
  `tbl_sys_route_controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_route_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_route_args` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_route_content` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_route_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_route_area` enum('public','restrict') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `tbl_sys_route_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_sys_route_parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_route_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_route_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_routes`
--

INSERT INTO `tbl_sys_routes` (`tbl_sys_route_ID`, `tbl_sys_route_name`, `tbl_sys_route_title`, `tbl_sys_route_permalink`, `tbl_sys_route_api`, `tbl_sys_route_admin`, `tbl_sys_route_locked`, `tbl_sys_route_type`, `tbl_sys_route_controller`, `tbl_sys_route_method`, `tbl_sys_route_args`, `tbl_sys_route_content`, `tbl_sys_route_description`, `tbl_sys_route_area`, `tbl_sys_route_status`, `tbl_sys_route_parent_id`, `tbl_sys_route_created_at`, `tbl_sys_route_updated_at`) VALUES
(1, 'index', 'Home', '/', 0, 0, 1, 'GET', 'SiteController', 'index', '', '', NULL, 'public', 'ativo', '', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(2, 'admin-login', 'Login', NULL, 0, 1, 1, 'GET', 'SystemController', 'login', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(3, 'admin-api-login', 'API Login', NULL, 1, 1, 1, 'POST', 'SystemController', 'loginAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(4, 'admin-esqueci-minha-senha', 'Esqueci minha senha', NULL, 0, 1, 1, 'GET', 'SystemController', 'forgetPassword', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(5, 'admin-api-esqueci-minha-senha', 'API - Esqueci minha senha', NULL, 1, 1, 1, 'POST', 'SystemController', 'forgetPasswordAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(6, 'admin-recuperar-conta', 'Recuperar conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'recoverAccount', '{token}', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(7, 'admin-api-recuperar-conta', 'API - Recuperar conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'recoverAccountAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(8, 'admin-dashboard', 'Dashboard', NULL, 0, 1, 1, 'GET', 'SystemController', 'dashboard', '', '<code>[automator function=\"system-pages\" view=\"system.pages.dashboard\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(9, 'admin-notificacoes', 'Notificações', 'notificacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '{id?}', '<code>[automator function=\"pagination\" name=\"admin-user-notifications-pagination\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(10, 'admin-api-notificacoes-get', 'API - Notificações GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(11, 'admin-api-notificacoes-store', 'API - Notificações STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_notifications\" form=\"admin-notifications\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(12, 'admin-api-notificacoes-update', 'API - Notificações UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(13, 'admin-minha-conta', 'Minha Conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'myAccount', '', '<p>Utilize o formulário abaixo para atualizar os dados de sua conta. <br /><br /></p><code>[automator function=\"system-form\" form=\"admin-minha-conta\" vars=\"$currentUser\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(14, 'admin-api-minha-conta', 'API - Minha Conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'myAccountAPI', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(15, 'admin-galeria', 'Galeria', 'galeria', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '<code>[automator function=\"system-pages\" view=\"system.pages.automator-parent-pages\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(16, 'admin-galeria-uploads-types', 'Gerenciar Tipos de Midia', 'gerenciar-tipos-de-midia', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-galeria-uploads-types-pagination\"]</code>', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(17, 'admin-api-galeria-uploads-types-get', 'API - Tipos de Midia GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_uploads_types\" index=\"tbl_sys_uploads_type_ID\"]', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(18, 'admin-api-galeria-uploads-types-store', 'API - Tipos de Midia STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_uploads_types\" form=\"admin-galeria-uploads-types\"]', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(19, 'admin-api-galeria-uploads-types-update', 'API - Tipos de Midia UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '[automator function=\"update-data\" table=\"tbl_sys_uploads_types\" index=\"tbl_sys_uploads_type_ID\"]', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(20, 'admin-api-galeria-uploads-types-delete', 'API - Tipos de Midia DELETE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'deleteData', '', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(21, 'admin-galeria-uploads', 'Gerenciar Uploads', 'gerenciar-uploads', 0, 1, 1, 'GET', 'UploadsController', 'index', '', '<code>[automator function=\"system-pages\" view=\"system.pages.galeria\"]</code>', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(22, 'admin-api-galeria-uploads-load', 'API - Uploads LOAD', NULL, 1, 1, 1, 'POST', 'UploadsController', 'loadMore', '', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(23, 'admin-api-galeria-uploads-get', 'API - Uploads GET', NULL, 1, 1, 1, 'GET', 'UploadsController', 'getUpload', '{id?}', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(24, 'admin-api-galeria-uploads-store', 'API - Uploads STORE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'storeUpload', '', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(25, 'admin-api-galeria-uploads-update', 'API - Uploads UPDATE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'updateUpload', '', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(26, 'admin-api-galeria-uploads-delete', 'API - Uploads DELETE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'deleteUpload', '', '', NULL, 'restrict', 'ativo', '15', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(27, 'admin-administracao', 'Administração', 'administracao', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '<code>[automator function=\"system-pages\" view=\"system.pages.automator-parent-pages\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(28, 'admin-routes-apis', 'Gerenciar Rotas de API', 'gerenciar-rotas-apis', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-apis-pagination\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(29, 'admin-api-routes-apis-get', 'API - API\'s GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '<code>[automator function=\"get-data\" table=\"tbl_sys_routes\" index=\"tbl_sys_route_ID\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(30, 'admin-api-routes-apis-store', 'API - API\'s STORE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'storeRoute', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(31, 'admin-api-routes-apis-update', 'API - API\'s UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRoute', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(32, 'admin-api-routes-apis-delete', 'API - API\'s DELETE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'deleteRoute', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(33, 'admin-api-routes-apis-access', 'API - API\'s Permissões', NULL, 1, 1, 1, 'GET', 'RoutesController', 'getRouteAccess', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(34, 'admin-api-routes-apis-access-update', 'API - API\'s Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRouteAccess', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(35, 'admin-routes', 'Gerenciar Páginas', 'gerenciar-paginas', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-routes-pagination\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(36, 'admin-api-routes-get', 'API - Páginas GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_routes\" index=\"tbl_sys_route_ID\"]', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(37, 'admin-api-routes-store', 'API - Páginas STORE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'storeRoute', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(38, 'admin-api-routes-update', 'API - Páginas UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRoute', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(39, 'admin-api-routes-delete', 'API - Páginas DELETE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'deleteRoute', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(40, 'admin-api-routes-access', 'API - Páginas Permissões', NULL, 1, 1, 1, 'GET', 'RoutesController', 'getRouteAccess', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(41, 'admin-api-routes-access-update', 'API - Páginas Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRouteAccess', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(42, 'admin-navs', 'Gerenciar Navegação', 'gerenciar-navs', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-navs-pagination\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(43, 'admin-api-navs-get', 'API - Navs GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '<code>[automator function=\"get-data\" table=\"tbl_sys_navs\" index=\"tbl_sys_nav_ID\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(44, 'admin-api-navs-store', 'API - Navs STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_navs\" form=\"admin-navs\"]', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(45, 'admin-api-navs-update', 'API - Navs UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '<code>[automator function=\"update-data\" table=\"tbl_sys_navs\" index=\"tbl_sys_nav_ID\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(46, 'admin-api-navs-delete', 'API - Navs DELETE', NULL, 1, 1, 1, 'POST', 'NavsController', 'deleteNav', '{id?}', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(47, 'admin-menus', 'Gerenciar Menus', 'gerenciar-menus', 0, 1, 1, 'GET', 'MenusController', 'index', '', '<code>[automator function=\"system-pages\" view=\"system.pages.gerenciar-menu\" vars=\"$adminMenuPage\"]</code>', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(48, 'admin-api-menus-select', 'API - Menu SELECT', NULL, 1, 1, 1, 'POST', 'MenusController', 'selectMenu', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(49, 'admin-api-menus-store', 'API - Menu STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_menus\" form=\"admin-menus\"]', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(50, 'admin-api-menus-update', 'API - Menu UPDATE', NULL, 1, 1, 1, 'POST', 'MenusController', 'updateMenu', '', '', NULL, 'restrict', 'ativo', '27', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(51, 'admin-usuarios', 'Usuários', 'usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '<code>[automator function=\"system-pages\" view=\"system.pages.automator-parent-pages\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(52, 'admin-users-types', 'Gerenciar Tipos de Usuários', 'gerenciar-tipos-de-usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-users-types-pagination\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(53, 'admin-api-users-types-get', 'API - Tipo de Usuário GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '<code>[automator function=\"get-data\" table=\"tbl_users_types\" index=\"tbl_users_type_ID\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(54, 'admin-api-users-types-store', 'API - Tipo de Usuário STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_users_types\" form=\"admin-users-types\"]', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(55, 'admin-api-users-types-update', 'API - Tipo de Usuário UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '<code>[automator function=\"update-data\" table=\"tbl_users_types\" index=\"tbl_users_type_ID\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(56, 'admin-api-users-types-delete', 'API - Tipo de Usuário DELETE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'deleteUserType', '{id?}', '', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(57, 'admin-api-users-types-access', 'API - Tipo de Usuário Permissões', NULL, 1, 1, 1, 'GET', 'UsersTypesController', 'getUserTypeAccess', '{id?}', '', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(58, 'admin-api-users-types-access-update', 'API - Tipo de Usuário Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'updateUserTypeAccess', '', '', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(59, 'admin-users', 'Gerenciar Usuários', 'gerenciar-usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-users-pagination\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(60, 'admin-api-users-get', 'API - Usuário GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getDataByModel', '{id?}', '<code>[automator function=\"getDataByModel\" model=\"User\" with=\"UserGetTypes:ids\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(61, 'admin-api-users-store', 'API - Usuário STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '<code>[automator function=\"store-data\" table=\"tbl_users\" model=\"User\" form=\"admin-users\" with=\"UserGetTypes:ids\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(62, 'admin-api-users-update', 'API - Usuário UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '<code>[automator function=\"update-data\" table=\"tbl_users\" index=\"tbl_user_ID\" with=\"UserGetTypes:ids\"]</code>', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(63, 'admin-api-users-delete', 'API - Usuário DELETE', NULL, 1, 1, 1, 'POST', 'UsersController', 'deleteUser', '{id?}', '', NULL, 'restrict', 'ativo', '51', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(64, 'admin-notifications', 'Gerenciar Notificações', 'gerenciar-notificacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-notifications-pagination\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(65, 'admin-api-notifications-get', 'API - Gerenciar Notificações GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(66, 'admin-api-notifications-store', 'API - Gerenciar Notificações STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_notifications\" form=\"admin-notifications\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(67, 'admin-api-notifications-update', 'API - Gerenciar Notificações UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(68, 'admin-api-notifications-delete', 'API - Gerenciar Notificações DELETE', NULL, 1, 1, 1, 'POST', 'UsersController', 'deleteUser', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(69, 'admin-configs', 'Configurações', 'configuracoes', 0, 1, 1, 'GET', 'SystemController', 'configs', '', '<code>[automator function=\"system-pages\" view=\"system.pages.configs\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(70, 'admin-api-configs-update', 'API - Configurações UPDATE', NULL, 1, 1, 1, 'POST', 'SystemController', 'storeConfigs', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(71, 'admin-automator', 'Automator', 'automator', 0, 1, 1, 'GET', 'AutomatorController', 'index', '', '<code>[automator function=\"system-pages\" view=\"system.pages.automator-index\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(72, 'admin-fields', 'Gerenciar Campos', 'gerenciar-campos', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-fields-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(73, 'admin-api-fields-get', 'API - Campos GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_field_types\" index=\"tbl_sys_field_type_ID\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(74, 'admin-api-fields-store', 'API - Campos STORE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'storeField', '', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(75, 'admin-api-fields-update', 'API - Campos UPDATE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'updateField', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(76, 'admin-api-fields-delete', 'API - Campos DELETE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'deleteField', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(77, 'admin-modulos', 'Gerenciar Módulos', 'gerenciar-modulos', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-modulos-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(78, 'admin-api-modulos-get', 'API - Módulos GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '<code>[automator function=\"get-data\" table=\"tbl_sys_modulos\" index=\"tbl_sys_modulo_ID\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(79, 'admin-api-modulos-store', 'API - Módulos STORE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'storeModulo', '', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(80, 'admin-api-modulos-update', 'API - Módulos UPDATE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'updateModulo', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(81, 'admin-api-modulos-delete', 'API - Módulos DELETE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'deleteModulo', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(82, 'admin-forms', 'Gerenciar Formulários', 'gerenciar-formularios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-forms-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(83, 'admin-api-forms-get', 'API - Formulários GET', NULL, 1, 0, 1, 'GET', 'FormsController', 'getForm', '{id?}', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(84, 'admin-api-forms-editor-field', 'API - Editor Field POST', NULL, 1, 0, 1, 'POST', 'FormsController', 'getFormEditorField', '{id?}', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(85, 'admin-api-forms-store', 'API - Formulários STORE', NULL, 1, 1, 1, 'POST', 'FormsController', 'storeForm', '', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(86, 'admin-api-forms-update', 'API - Formulários UPDATE', NULL, 1, 1, 1, 'POST', 'FormsController', 'updateForm', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(87, 'admin-api-forms-delete', 'API - Formulários DELETE', NULL, 1, 1, 1, 'POST', 'FormsController', 'deleteForm', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(88, 'admin-api-forms-access', 'API - Formulários Permissões', NULL, 1, 1, 1, 'GET', 'FormsController', 'getFormAccess', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(89, 'admin-api-forms-access-update', 'API - Formulários Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'FormsController', 'updateFormAccess', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(90, 'admin-paginations', 'Gerenciar Paginações', 'gerenciar-paginacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-paginations-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(91, 'admin-api-paginations-get', 'API - Paginations GET', NULL, 1, 1, 1, 'GET', 'PaginationsController', 'getPagination', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(92, 'admin-api-paginations-store', 'API - Paginations STORE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'storePagination', '', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(93, 'admin-api-paginations-update', 'API - Paginations UPDATE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'updatePagination', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(94, 'admin-api-paginations-delete', 'API - Paginations DELETE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'deletePagination', '{id?}', '', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(95, 'admin-shortcodes', 'Gerenciar Shortcodes', 'gerenciar-shortcodes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-shortcodes-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(96, 'admin-api-shortcodes-get', 'API - Shortcodes GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_shortcodes\" index=\"tbl_sys_shortcode_ID\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(97, 'admin-api-shortcodes-store', 'API - Shortcodes STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '', '[automator function=\"store-data\" table=\"tbl_sys_shortcodes\" form=\"admin-shortcodes\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(98, 'admin-api-shortcodes-update', 'API - Shortcodes UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '{id?}', '<code>[automator function=\"update-data\" table=\"tbl_sys_shortcodes\" form=\"admin-shortcodes\" index=\"tbl_sys_shortcode_ID\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(99, 'admin-api-shortcodes-delete', 'API - Shortcodes DELETE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '{id?}', '<code>[automator function=\"delete-data\" table=\"tbl_sys_shortcodes\" index=\"tbl_sys_shortcode_ID\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(100, 'admin-functions', 'Gerenciar Funções', 'gerenciar-funcoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-functions-pagination\"]</code>', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(101, 'admin-api-functions-get', 'API - Functions GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_functions\" index=\"tbl_sys_function_ID\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(102, 'admin-api-functions-store', 'API - Functions STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_functions\" form=\"admin-functions\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(103, 'admin-api-functions-update', 'API - Functions UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_functions\" form=\"admin-functions\" index=\"tbl_sys_function_ID\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(104, 'admin-api-functions-delete', 'API - Functions DELETE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '{id?}', '[automator function=\"delete-data\" table=\"tbl_sys_functions\" index=\"tbl_sys_function_ID\"]', NULL, 'restrict', 'ativo', '71', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(105, 'admin-languages', 'Gerenciar Idiomas', NULL, 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '<code>[automator function=\"pagination\" name=\"admin-languages-pagination\"]</code>', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(106, 'admin-api-languages-get', 'API - Idiomas GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_translations\" index=\"tbl_sys_translation_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(107, 'admin-api-languages-store', 'API - Idiomas STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_translations\" form=\"admin-languages\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(108, 'admin-api-languages-update', 'API - Idiomas UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_translations\" index=\"tbl_sys_translation_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(109, 'admin-api-languages-delete', 'API - Idiomas DELETE', NULL, 1, 1, 1, 'POST', 'TranslationsController', 'deleteTranslation', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(110, 'admin-languages-words', 'Gerenciar Idiomas - Traduções', NULL, 0, 1, 1, 'GET', 'TranslationsWordsController', 'index', '{lang?}', '<code>[automator function=\"system-pages\" view=\"system.pages.pagination\"]</code>', NULL, 'restrict', 'ativo', '105', '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(111, 'admin-api-languages-words-get', 'API - Idiomas Traduções GET', NULL, 1, 1, 1, 'GET', 'TranslationsWordsController', 'getTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(112, 'admin-api-languages-words-store', 'API - Idiomas Traduções STORE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'storeTranslationWord', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(113, 'admin-api-languages-words-update', 'API - Idiomas Traduções UPDATE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'updateTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(114, 'admin-api-languages-words-delete', 'API - Idiomas Traduções DELETE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'deleteTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(115, 'admin-api-functions', 'API - Funções Admin', NULL, 1, 1, 1, 'POST', 'SystemController', 'adminFunctions', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(116, 'admin-api-view-get', 'API - Get Views', NULL, 1, 0, 1, 'POST', 'SystemController', 'adminGetView', '', '', NULL, 'public', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01'),
(117, 'admin-api-logout', 'API - Logout', NULL, 1, 1, 1, 'POST', 'SystemController', 'logout', '', '', NULL, 'restrict', 'ativo', NULL, '2026-07-25 03:40:01', '2026-07-25 03:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_routes_access`
--

CREATE TABLE `tbl_sys_routes_access` (
  `tbl_routes_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_route_ID` bigint UNSIGNED NOT NULL,
  `tbl_routes_access_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_routes_access`
--

INSERT INTO `tbl_sys_routes_access` (`tbl_routes_access_ID`, `tbl_users_type_ID`, `tbl_sys_route_ID`, `tbl_routes_access_created_at`) VALUES
(1, 1, 8, '2026-07-25 00:40:01'),
(2, 2, 8, '2026-07-25 00:40:01'),
(3, 3, 8, '2026-07-25 00:40:01'),
(4, 4, 8, '2026-07-25 00:40:01'),
(5, 1, 9, '2026-07-25 00:40:01'),
(6, 2, 9, '2026-07-25 00:40:01'),
(7, 3, 9, '2026-07-25 00:40:01'),
(8, 4, 9, '2026-07-25 00:40:01'),
(9, 1, 10, '2026-07-25 00:40:01'),
(10, 2, 10, '2026-07-25 00:40:01'),
(11, 3, 10, '2026-07-25 00:40:01'),
(12, 4, 10, '2026-07-25 00:40:01'),
(13, 1, 11, '2026-07-25 00:40:01'),
(14, 2, 11, '2026-07-25 00:40:01'),
(15, 3, 11, '2026-07-25 00:40:01'),
(16, 4, 11, '2026-07-25 00:40:01'),
(17, 1, 12, '2026-07-25 00:40:01'),
(18, 2, 12, '2026-07-25 00:40:01'),
(19, 3, 12, '2026-07-25 00:40:01'),
(20, 4, 12, '2026-07-25 00:40:01'),
(21, 1, 13, '2026-07-25 00:40:01'),
(22, 2, 13, '2026-07-25 00:40:01'),
(23, 3, 13, '2026-07-25 00:40:01'),
(24, 4, 13, '2026-07-25 00:40:01'),
(25, 1, 14, '2026-07-25 00:40:01'),
(26, 2, 14, '2026-07-25 00:40:01'),
(27, 3, 14, '2026-07-25 00:40:01'),
(28, 4, 14, '2026-07-25 00:40:01'),
(29, 1, 15, '2026-07-25 00:40:01'),
(30, 2, 15, '2026-07-25 00:40:01'),
(31, 1, 16, '2026-07-25 00:40:01'),
(32, 2, 16, '2026-07-25 00:40:01'),
(33, 1, 17, '2026-07-25 00:40:01'),
(34, 2, 17, '2026-07-25 00:40:01'),
(35, 1, 18, '2026-07-25 00:40:01'),
(36, 2, 18, '2026-07-25 00:40:01'),
(37, 1, 19, '2026-07-25 00:40:01'),
(38, 2, 19, '2026-07-25 00:40:01'),
(39, 1, 20, '2026-07-25 00:40:01'),
(40, 2, 20, '2026-07-25 00:40:01'),
(41, 1, 21, '2026-07-25 00:40:01'),
(42, 2, 21, '2026-07-25 00:40:01'),
(43, 1, 22, '2026-07-25 00:40:01'),
(44, 2, 22, '2026-07-25 00:40:01'),
(45, 1, 23, '2026-07-25 00:40:01'),
(46, 2, 23, '2026-07-25 00:40:01'),
(47, 1, 24, '2026-07-25 00:40:01'),
(48, 2, 24, '2026-07-25 00:40:01'),
(49, 1, 25, '2026-07-25 00:40:01'),
(50, 2, 25, '2026-07-25 00:40:01'),
(51, 1, 26, '2026-07-25 00:40:01'),
(52, 2, 26, '2026-07-25 00:40:01'),
(53, 1, 27, '2026-07-25 00:40:01'),
(54, 2, 27, '2026-07-25 00:40:01'),
(55, 1, 28, '2026-07-25 00:40:01'),
(56, 2, 28, '2026-07-25 00:40:01'),
(57, 1, 29, '2026-07-25 00:40:01'),
(58, 2, 29, '2026-07-25 00:40:01'),
(59, 1, 30, '2026-07-25 00:40:01'),
(60, 2, 30, '2026-07-25 00:40:01'),
(61, 1, 31, '2026-07-25 00:40:01'),
(62, 2, 31, '2026-07-25 00:40:01'),
(63, 1, 32, '2026-07-25 00:40:01'),
(64, 2, 32, '2026-07-25 00:40:01'),
(65, 1, 33, '2026-07-25 00:40:01'),
(66, 2, 33, '2026-07-25 00:40:01'),
(67, 1, 34, '2026-07-25 00:40:01'),
(68, 2, 34, '2026-07-25 00:40:01'),
(69, 1, 35, '2026-07-25 00:40:01'),
(70, 2, 35, '2026-07-25 00:40:01'),
(71, 1, 36, '2026-07-25 00:40:01'),
(72, 2, 36, '2026-07-25 00:40:01'),
(73, 1, 37, '2026-07-25 00:40:01'),
(74, 2, 37, '2026-07-25 00:40:01'),
(75, 1, 38, '2026-07-25 00:40:01'),
(76, 2, 38, '2026-07-25 00:40:01'),
(77, 1, 39, '2026-07-25 00:40:01'),
(78, 2, 39, '2026-07-25 00:40:01'),
(79, 1, 40, '2026-07-25 00:40:01'),
(80, 2, 40, '2026-07-25 00:40:01'),
(81, 1, 41, '2026-07-25 00:40:01'),
(82, 2, 41, '2026-07-25 00:40:01'),
(83, 1, 42, '2026-07-25 00:40:01'),
(84, 2, 42, '2026-07-25 00:40:01'),
(85, 1, 43, '2026-07-25 00:40:01'),
(86, 2, 43, '2026-07-25 00:40:01'),
(87, 1, 44, '2026-07-25 00:40:01'),
(88, 2, 44, '2026-07-25 00:40:01'),
(89, 1, 45, '2026-07-25 00:40:01'),
(90, 2, 45, '2026-07-25 00:40:01'),
(91, 1, 46, '2026-07-25 00:40:01'),
(92, 2, 46, '2026-07-25 00:40:01'),
(93, 1, 47, '2026-07-25 00:40:01'),
(94, 2, 47, '2026-07-25 00:40:01'),
(95, 1, 48, '2026-07-25 00:40:01'),
(96, 2, 48, '2026-07-25 00:40:01'),
(97, 1, 49, '2026-07-25 00:40:01'),
(98, 2, 49, '2026-07-25 00:40:01'),
(99, 1, 50, '2026-07-25 00:40:01'),
(100, 2, 50, '2026-07-25 00:40:01'),
(101, 1, 51, '2026-07-25 00:40:01'),
(102, 2, 51, '2026-07-25 00:40:01'),
(103, 1, 52, '2026-07-25 00:40:01'),
(104, 2, 52, '2026-07-25 00:40:01'),
(105, 1, 53, '2026-07-25 00:40:01'),
(106, 2, 53, '2026-07-25 00:40:01'),
(107, 1, 54, '2026-07-25 00:40:01'),
(108, 2, 54, '2026-07-25 00:40:01'),
(109, 1, 55, '2026-07-25 00:40:01'),
(110, 2, 55, '2026-07-25 00:40:01'),
(111, 1, 56, '2026-07-25 00:40:01'),
(112, 2, 56, '2026-07-25 00:40:01'),
(113, 1, 57, '2026-07-25 00:40:01'),
(114, 2, 57, '2026-07-25 00:40:01'),
(115, 1, 58, '2026-07-25 00:40:01'),
(116, 2, 58, '2026-07-25 00:40:01'),
(117, 1, 59, '2026-07-25 00:40:01'),
(118, 2, 59, '2026-07-25 00:40:01'),
(119, 1, 60, '2026-07-25 00:40:01'),
(120, 2, 60, '2026-07-25 00:40:01'),
(121, 1, 61, '2026-07-25 00:40:01'),
(122, 2, 61, '2026-07-25 00:40:01'),
(123, 1, 62, '2026-07-25 00:40:01'),
(124, 2, 62, '2026-07-25 00:40:01'),
(125, 1, 63, '2026-07-25 00:40:01'),
(126, 2, 63, '2026-07-25 00:40:01'),
(127, 1, 64, '2026-07-25 00:40:01'),
(128, 2, 64, '2026-07-25 00:40:01'),
(129, 1, 65, '2026-07-25 00:40:01'),
(130, 2, 65, '2026-07-25 00:40:01'),
(131, 1, 66, '2026-07-25 00:40:01'),
(132, 2, 66, '2026-07-25 00:40:01'),
(133, 1, 67, '2026-07-25 00:40:01'),
(134, 2, 67, '2026-07-25 00:40:01'),
(135, 1, 68, '2026-07-25 00:40:01'),
(136, 2, 68, '2026-07-25 00:40:01'),
(137, 1, 69, '2026-07-25 00:40:01'),
(138, 2, 69, '2026-07-25 00:40:01'),
(139, 1, 70, '2026-07-25 00:40:01'),
(140, 2, 70, '2026-07-25 00:40:01'),
(141, 1, 71, '2026-07-25 00:40:01'),
(142, 2, 71, '2026-07-25 00:40:01'),
(143, 1, 72, '2026-07-25 00:40:01'),
(144, 1, 73, '2026-07-25 00:40:01'),
(145, 1, 74, '2026-07-25 00:40:01'),
(146, 1, 75, '2026-07-25 00:40:01'),
(147, 1, 76, '2026-07-25 00:40:01'),
(148, 1, 77, '2026-07-25 00:40:01'),
(149, 2, 77, '2026-07-25 00:40:01'),
(150, 1, 78, '2026-07-25 00:40:01'),
(151, 2, 78, '2026-07-25 00:40:01'),
(152, 1, 79, '2026-07-25 00:40:01'),
(153, 2, 79, '2026-07-25 00:40:01'),
(154, 1, 80, '2026-07-25 00:40:01'),
(155, 2, 80, '2026-07-25 00:40:01'),
(156, 1, 81, '2026-07-25 00:40:01'),
(157, 2, 81, '2026-07-25 00:40:01'),
(158, 1, 82, '2026-07-25 00:40:01'),
(159, 2, 82, '2026-07-25 00:40:01'),
(160, 1, 85, '2026-07-25 00:40:01'),
(161, 2, 85, '2026-07-25 00:40:01'),
(162, 1, 86, '2026-07-25 00:40:01'),
(163, 2, 86, '2026-07-25 00:40:01'),
(164, 1, 87, '2026-07-25 00:40:01'),
(165, 2, 87, '2026-07-25 00:40:01'),
(166, 1, 88, '2026-07-25 00:40:01'),
(167, 2, 88, '2026-07-25 00:40:01'),
(168, 1, 89, '2026-07-25 00:40:01'),
(169, 2, 89, '2026-07-25 00:40:01'),
(170, 1, 90, '2026-07-25 00:40:01'),
(171, 2, 90, '2026-07-25 00:40:01'),
(172, 1, 91, '2026-07-25 00:40:01'),
(173, 2, 91, '2026-07-25 00:40:01'),
(174, 1, 92, '2026-07-25 00:40:01'),
(175, 2, 92, '2026-07-25 00:40:01'),
(176, 1, 93, '2026-07-25 00:40:01'),
(177, 2, 93, '2026-07-25 00:40:01'),
(178, 1, 94, '2026-07-25 00:40:01'),
(179, 2, 94, '2026-07-25 00:40:01'),
(180, 1, 95, '2026-07-25 00:40:01'),
(181, 2, 95, '2026-07-25 00:40:01'),
(182, 1, 96, '2026-07-25 00:40:01'),
(183, 2, 96, '2026-07-25 00:40:01'),
(184, 1, 97, '2026-07-25 00:40:01'),
(185, 2, 97, '2026-07-25 00:40:01'),
(186, 1, 98, '2026-07-25 00:40:01'),
(187, 2, 98, '2026-07-25 00:40:01'),
(188, 1, 99, '2026-07-25 00:40:01'),
(189, 2, 99, '2026-07-25 00:40:01'),
(190, 1, 100, '2026-07-25 00:40:01'),
(191, 1, 101, '2026-07-25 00:40:01'),
(192, 1, 102, '2026-07-25 00:40:01'),
(193, 1, 103, '2026-07-25 00:40:01'),
(194, 1, 104, '2026-07-25 00:40:01'),
(195, 1, 105, '2026-07-25 00:40:01'),
(196, 2, 105, '2026-07-25 00:40:01'),
(197, 1, 106, '2026-07-25 00:40:01'),
(198, 2, 106, '2026-07-25 00:40:01'),
(199, 1, 107, '2026-07-25 00:40:01'),
(200, 2, 107, '2026-07-25 00:40:01'),
(201, 1, 108, '2026-07-25 00:40:01'),
(202, 2, 108, '2026-07-25 00:40:01'),
(203, 1, 109, '2026-07-25 00:40:01'),
(204, 2, 109, '2026-07-25 00:40:01'),
(205, 1, 110, '2026-07-25 00:40:01'),
(206, 2, 110, '2026-07-25 00:40:01'),
(207, 1, 111, '2026-07-25 00:40:01'),
(208, 2, 111, '2026-07-25 00:40:01'),
(209, 1, 112, '2026-07-25 00:40:01'),
(210, 2, 112, '2026-07-25 00:40:01'),
(211, 1, 113, '2026-07-25 00:40:01'),
(212, 2, 113, '2026-07-25 00:40:01'),
(213, 1, 114, '2026-07-25 00:40:01'),
(214, 2, 114, '2026-07-25 00:40:01'),
(215, 1, 115, '2026-07-25 00:40:01'),
(216, 2, 115, '2026-07-25 00:40:01'),
(217, 3, 115, '2026-07-25 00:40:01'),
(218, 4, 115, '2026-07-25 00:40:01'),
(219, 1, 117, '2026-07-25 00:40:01'),
(220, 2, 117, '2026-07-25 00:40:01'),
(221, 3, 117, '2026-07-25 00:40:01'),
(222, 4, 117, '2026-07-25 00:40:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_shortcodes`
--

CREATE TABLE `tbl_sys_shortcodes` (
  `tbl_sys_shortcode_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_shortcode_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_shortcode_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_shortcode_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_shortcode_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_shortcode_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_shortcode_params` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_shortcode_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_shortcode_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_shortcode_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_shortcodes`
--

INSERT INTO `tbl_sys_shortcodes` (`tbl_sys_shortcode_ID`, `tbl_sys_shortcode_code`, `tbl_sys_shortcode_title`, `tbl_sys_shortcode_description`, `tbl_sys_shortcode_class`, `tbl_sys_shortcode_method`, `tbl_sys_shortcode_params`, `tbl_sys_shortcode_locked`, `tbl_sys_shortcode_created_at`, `tbl_sys_shortcode_updated_at`) VALUES
(1, 'automator', 'Automator', 'Função nativa do sistema para gerar e carregar de forma dinamica as ações do sistema.', 'AutomatorController', 'getFunction', '{\"function\":true,\"name\":false,\"form\":false,\"table\":false,\"index\":false}', 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(2, 'system-pages', 'Carregador de view', 'Função nativa do sistema para carregar de forma dinamica as views dentro do sistema.', 'SystemController', 'SystemLoadPageContent', '{\"view\":true,\"vars\":false,\"args\":false}', 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02'),
(3, 'system-form', 'Formulário do sistema', 'Função nativa do sistema para gerar e renderizar de forma dinamica os formulários registrados no sistema.', 'SysAutomator', 'SysAutomatorRenderFormByID', '{\"form\":{\"label\":\"Formul\\u00e1rio\",\"field\":\"select\",\"default\":\"\",\"required\":true,\"relation\":{\"table\":\"tbl_sys_forms\",\"index\":\"tbl_sys_form_name\",\"label\":\"tbl_sys_form_title\"}},\"vars\":{\"label\":\"Vari\\u00e1veis\",\"field\":\"textarea\",\"default\":\"\",\"required\":false}}', 1, '2026-07-25 03:40:02', '2026-07-25 03:40:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_translations`
--

CREATE TABLE `tbl_sys_translations` (
  `tbl_sys_translation_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_translation_key` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_translation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_translation_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_translation_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_translation_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_translation_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_translations`
--

INSERT INTO `tbl_sys_translations` (`tbl_sys_translation_ID`, `tbl_sys_translation_key`, `tbl_sys_translation_name`, `tbl_sys_translation_description`, `tbl_sys_translation_locked`, `tbl_sys_translation_created_at`, `tbl_sys_translation_updated_at`) VALUES
(1, 'pt-br', 'Português (Brasil)', 'Português do Brasil', 1, '2026-07-25 03:40:00', '2026-07-25 03:40:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_translations_words`
--

CREATE TABLE `tbl_sys_translations_words` (
  `tbl_translations_word_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_translation_ID` bigint UNSIGNED NOT NULL,
  `tbl_translations_word_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_translations_word_str` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_translations_word_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_translations_word_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_uploads`
--

CREATE TABLE `tbl_sys_uploads` (
  `tbl_sys_upload_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_uploads_type_ID` bigint UNSIGNED DEFAULT NULL,
  `tbl_sys_upload_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_upload_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_upload_directory` text COLLATE utf8mb4_unicode_ci,
  `tbl_user_ID` bigint UNSIGNED DEFAULT NULL,
  `tbl_sys_upload_access` enum('public','restrict') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `tbl_sys_upload_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_upload_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_uploads_access`
--

CREATE TABLE `tbl_sys_uploads_access` (
  `tbl_sys_uploads_access_ID` bigint UNSIGNED NOT NULL,
  `tbl_user_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_upload_ID` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_uploads_types`
--

CREATE TABLE `tbl_sys_uploads_types` (
  `tbl_sys_uploads_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_uploads_type_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'picture',
  `tbl_sys_uploads_type_mine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_uploads_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_uploads_type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_uploads_type_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_uploads_type_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_uploads_type_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_uploads_type_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_uploads_types`
--

INSERT INTO `tbl_sys_uploads_types` (`tbl_sys_uploads_type_ID`, `tbl_sys_uploads_type_icon`, `tbl_sys_uploads_type_mine`, `tbl_sys_uploads_type_name`, `tbl_sys_uploads_type_title`, `tbl_sys_uploads_type_description`, `tbl_sys_uploads_type_locked`, `tbl_sys_uploads_type_created_at`, `tbl_sys_uploads_type_updated_at`) VALUES
(1, 'file-image', 'image/png', 'png', 'Imagem PNG', 'Arquivo de imagem no formato PNG.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(2, 'file-image', 'image/jpeg', 'jpg', 'Imagem JPG', 'Arquivo de imagem no formato JPG.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(3, 'file-image', 'image/jpeg', 'jpeg', 'Imagem JPEG', 'Arquivo de imagem no formato JPEG.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(4, 'file-image', 'image/gif', 'gif', 'Imagem GIF', 'Arquivo de imagem no formato GIF.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(5, 'file-image', 'image/webp', 'webp', 'Imagem WEBP', 'Arquivo de imagem no formato WEBP.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(6, 'file-image', 'image/bmp', 'bmp', 'Imagem BMP', 'Arquivo de imagem Bitmap.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(7, 'file-image', 'image/svg+xml', 'svg', 'Imagem SVG', 'Imagem vetorial SVG.', 1, '2026-07-25 03:40:03', '2026-07-25 03:40:03'),
(8, 'file-pdf', 'application/pdf', 'pdf', 'Documento PDF', 'Documento Adobe PDF.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(9, 'file-word', 'application/msword', 'doc', 'Documento Word', 'Documento Microsoft Word.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(10, 'file-word', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'docx', 'Documento Word DOCX', 'Documento Microsoft Word OpenXML.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(11, 'file-excel', 'application/vnd.ms-excel', 'xls', 'Planilha Excel', 'Planilha Microsoft Excel.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(12, 'file-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'xlsx', 'Planilha Excel XLSX', 'Planilha Microsoft Excel OpenXML.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(13, 'file-csv', 'text/csv', 'csv', 'Arquivo CSV', 'Arquivo de valores separados por vírgula.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(14, 'file-powerpoint', 'application/vnd.ms-powerpoint', 'ppt', 'Apresentação PowerPoint', 'Apresentação Microsoft PowerPoint.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(15, 'file-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'pptx', 'Apresentação PowerPoint PPTX', 'Apresentação Microsoft PowerPoint OpenXML.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(16, 'file-zipper', 'application/zip', 'zip', 'Arquivo ZIP', 'Arquivo compactado ZIP.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(17, 'file-zipper', 'application/x-rar-compressed', 'rar', 'Arquivo RAR', 'Arquivo compactado RAR.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(18, 'file-zipper', 'application/x-7z-compressed', '7z', 'Arquivo 7Z', 'Arquivo compactado 7-Zip.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(19, 'file-lines', 'text/plain', 'txt', 'Arquivo TXT', 'Arquivo de texto simples.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(20, 'file-code', 'application/json', 'json', 'Arquivo JSON', 'Arquivo de dados JSON.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(21, 'file-code', 'application/xml', 'xml', 'Arquivo XML', 'Arquivo XML.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(22, 'file-audio', 'audio/mpeg', 'mp3', 'Áudio MP3', 'Arquivo de áudio MP3.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(23, 'file-audio', 'audio/wav', 'wav', 'Áudio WAV', 'Arquivo de áudio WAV.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(24, 'file-video', 'video/mp4', 'mp4', 'Vídeo MP4', 'Arquivo de vídeo MP4.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04'),
(25, 'file-video', 'video/webm', 'webm', 'Vídeo WEBM', 'Arquivo de vídeo WEBM.', 1, '2026-07-25 03:40:04', '2026-07-25 03:40:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_users`
--

CREATE TABLE `tbl_users` (
  `tbl_user_ID` bigint UNSIGNED NOT NULL,
  `tbl_user_login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_user_email_verified_at` timestamp NULL DEFAULT NULL,
  `tbl_user_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_user_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_user_actived` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_user_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_user_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tbl_user_deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_users`
--

INSERT INTO `tbl_users` (`tbl_user_ID`, `tbl_user_login`, `tbl_user_name`, `tbl_user_email`, `tbl_user_password`, `tbl_user_email_verified_at`, `tbl_user_status`, `tbl_user_blocked`, `tbl_user_actived`, `tbl_user_created_at`, `tbl_user_updated_at`, `tbl_user_deleted_at`, `remember_token`) VALUES
(1, 'developer', 'Desenvolvedor', 'dev@automator.test', '$2y$12$Eq73xiuoULIL0EzZ82wvAORnVpyydl1fRz0mNFjxUVEASyrlIE8sC', NULL, 'ativo', 0, 1, '2026-07-25 03:40:00', '2026-07-25 03:40:00', NULL, NULL),
(2, 'admin', 'Administrador', 'admin@automator.test', '$2y$12$FHKUQMTgy28V3sfWejsqGOCHBOFAOC8KsrROzUojg.XK7mpo4S1Ye', NULL, 'ativo', 0, 1, '2026-07-25 03:40:00', '2026-07-25 03:40:00', NULL, NULL),
(3, 'user', 'Usuário', 'user@automator.test', '$2y$12$ukI23hiuxalkvrtdLQ0e2OA.dMzie5eO6t0jxn8.HQgDAKkefWyR.', NULL, 'ativo', 0, 1, '2026-07-25 03:40:00', '2026-07-25 03:40:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_users_password_reset_tokens`
--

CREATE TABLE `tbl_users_password_reset_tokens` (
  `reset_token_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_token_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_users_password_reset_token_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_users_sessions`
--

CREATE TABLE `tbl_users_sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_users_sessions`
--

INSERT INTO `tbl_users_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ruPSuBX56EajRLc4TUDTCF5NHcZk8G94Qz4VBvpU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJQRUZrUFB2cmFMeE9UZ0JINGF3Z1ZWdG1WSURDd3ZhNWplWFFoSlhvIiwidXJsIjpbXSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9hZG1pbmlzdHJhY2FvXC9nZXJlbmNpYXItbWVudXMiLCJyb3V0ZSI6InBhZ2UuYWRtaW4tbWVudXMifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsImN1cnJlbnRNZW51IjoxfQ==', 1784940018);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_users_types`
--

CREATE TABLE `tbl_users_types` (
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_users_type_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_users_type_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_users_type_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_users_type_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_users_type_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_users_types`
--

INSERT INTO `tbl_users_types` (`tbl_users_type_ID`, `tbl_users_type_name`, `tbl_users_type_description`, `tbl_users_type_locked`, `tbl_users_type_status`, `tbl_users_type_created_at`, `tbl_users_type_updated_at`) VALUES
(1, 'Desenvolvedor', 'Usuário responsável por gerenciar e controlar todas as funcionalidades do sistema.', 1, 'ativo', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(2, 'Administrador', 'Usuário responsável por administrar todos os conteúdos e informações do sistema.', 1, 'ativo', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(3, 'Usuário', 'Usuário padrão do sistema com acesso as funcionalidades restritas do sistemas que contem acesso.', 1, 'ativo', '2026-07-25 03:40:00', '2026-07-25 03:40:00'),
(4, 'Novo', 'Usuario para testes de desenvolvimento.', 0, 'ativo', '2026-07-25 03:40:00', '2026-07-25 03:40:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_users_types_rels`
--

CREATE TABLE `tbl_users_types_rels` (
  `tbl_users_types_rel_ID` bigint UNSIGNED NOT NULL,
  `tbl_user_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_users_types_rel_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_users_types_rels`
--

INSERT INTO `tbl_users_types_rels` (`tbl_users_types_rel_ID`, `tbl_user_ID`, `tbl_users_type_ID`, `tbl_users_types_rel_created_at`) VALUES
(1, 1, 3, '2026-07-25 00:40:00'),
(2, 1, 1, '2026-07-25 00:40:00'),
(3, 2, 3, '2026-07-25 00:40:00'),
(4, 2, 2, '2026-07-25 00:40:00'),
(5, 3, 3, '2026-07-25 00:40:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_sys_configs`
--
ALTER TABLE `tbl_sys_configs`
  ADD PRIMARY KEY (`tbl_sys_config_ID`),
  ADD UNIQUE KEY `tbl_sys_configs_tbl_sys_config_name_unique` (`tbl_sys_config_name`);

--
-- Índices de tabela `tbl_sys_field_types`
--
ALTER TABLE `tbl_sys_field_types`
  ADD PRIMARY KEY (`tbl_sys_field_type_ID`),
  ADD UNIQUE KEY `tbl_sys_field_types_tbl_sys_field_type_name_unique` (`tbl_sys_field_type_name`),
  ADD KEY `tbl_sys_field_types_tbl_sys_field_type_group_id_foreign` (`tbl_sys_field_type_group_ID`);

--
-- Índices de tabela `tbl_sys_field_types_groups`
--
ALTER TABLE `tbl_sys_field_types_groups`
  ADD PRIMARY KEY (`tbl_sys_field_type_group_ID`),
  ADD UNIQUE KEY `tbl_sys_field_types_groups_tbl_sys_field_type_group_name_unique` (`tbl_sys_field_type_group_name`);

--
-- Índices de tabela `tbl_sys_forms`
--
ALTER TABLE `tbl_sys_forms`
  ADD PRIMARY KEY (`tbl_sys_form_ID`),
  ADD UNIQUE KEY `tbl_sys_forms_tbl_sys_form_name_unique` (`tbl_sys_form_name`);

--
-- Índices de tabela `tbl_sys_forms_access`
--
ALTER TABLE `tbl_sys_forms_access`
  ADD PRIMARY KEY (`tbl_sys_forms_access_ID`),
  ADD KEY `tbl_sys_forms_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `tbl_sys_forms_access_tbl_sys_form_id_foreign` (`tbl_sys_form_ID`);

--
-- Índices de tabela `tbl_sys_forms_fields`
--
ALTER TABLE `tbl_sys_forms_fields`
  ADD PRIMARY KEY (`tbl_sys_forms_field_ID`),
  ADD KEY `tbl_sys_forms_fields_tbl_sys_form_id_foreign` (`tbl_sys_form_ID`),
  ADD KEY `tbl_sys_forms_fields_tbl_sys_field_type_id_foreign` (`tbl_sys_field_type_ID`);

--
-- Índices de tabela `tbl_sys_forms_fields_access`
--
ALTER TABLE `tbl_sys_forms_fields_access`
  ADD PRIMARY KEY (`tbl_sys_forms_fields_access_ID`),
  ADD KEY `tbl_sys_forms_fields_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `tbl_sys_forms_fields_access_tbl_sys_forms_field_id_foreign` (`tbl_sys_forms_field_ID`);

--
-- Índices de tabela `tbl_sys_functions`
--
ALTER TABLE `tbl_sys_functions`
  ADD PRIMARY KEY (`tbl_sys_function_ID`),
  ADD UNIQUE KEY `tbl_sys_functions_tbl_sys_function_name_unique` (`tbl_sys_function_name`);

--
-- Índices de tabela `tbl_sys_menus`
--
ALTER TABLE `tbl_sys_menus`
  ADD PRIMARY KEY (`tbl_sys_menu_ID`);

--
-- Índices de tabela `tbl_sys_menus_access`
--
ALTER TABLE `tbl_sys_menus_access`
  ADD PRIMARY KEY (`tbl_menus_access_ID`),
  ADD KEY `tbl_sys_menus_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `tbl_sys_menus_access_tbl_sys_menu_item_id_foreign` (`tbl_sys_menu_item_ID`);

--
-- Índices de tabela `tbl_sys_menus_items`
--
ALTER TABLE `tbl_sys_menus_items`
  ADD PRIMARY KEY (`tbl_sys_menu_item_ID`),
  ADD KEY `tbl_sys_menus_items_tbl_sys_menu_id_foreign` (`tbl_sys_menu_ID`);

--
-- Índices de tabela `tbl_sys_menus_item_access`
--
ALTER TABLE `tbl_sys_menus_item_access`
  ADD PRIMARY KEY (`tbl_menus_item_access_ID`),
  ADD KEY `tbl_sys_menus_item_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `tbl_sys_menus_item_access_tbl_sys_menu_item_id_foreign` (`tbl_sys_menu_item_ID`);

--
-- Índices de tabela `tbl_sys_modulos`
--
ALTER TABLE `tbl_sys_modulos`
  ADD PRIMARY KEY (`tbl_sys_modulo_ID`),
  ADD UNIQUE KEY `tbl_sys_modulos_tbl_sys_modulo_name_unique` (`tbl_sys_modulo_name`);

--
-- Índices de tabela `tbl_sys_navs`
--
ALTER TABLE `tbl_sys_navs`
  ADD PRIMARY KEY (`tbl_sys_nav_ID`),
  ADD UNIQUE KEY `tbl_sys_navs_tbl_sys_nav_name_unique` (`tbl_sys_nav_name`);

--
-- Índices de tabela `tbl_sys_notifications`
--
ALTER TABLE `tbl_sys_notifications`
  ADD PRIMARY KEY (`tbl_sys_notification_ID`),
  ADD KEY `tbl_sys_notifications_tbl_user_id_foreign` (`tbl_user_ID`);

--
-- Índices de tabela `tbl_sys_paginations`
--
ALTER TABLE `tbl_sys_paginations`
  ADD PRIMARY KEY (`tbl_sys_pagination_ID`),
  ADD UNIQUE KEY `tbl_sys_paginations_tbl_sys_pagination_name_unique` (`tbl_sys_pagination_name`);

--
-- Índices de tabela `tbl_sys_paginations_args`
--
ALTER TABLE `tbl_sys_paginations_args`
  ADD PRIMARY KEY (`tbl_sys_paginations_arg_ID`),
  ADD KEY `tbl_sys_paginations_args_tbl_sys_pagination_id_foreign` (`tbl_sys_pagination_ID`);

--
-- Índices de tabela `tbl_sys_paginations_cols`
--
ALTER TABLE `tbl_sys_paginations_cols`
  ADD PRIMARY KEY (`tbl_sys_paginations_col_ID`),
  ADD KEY `tbl_sys_paginations_cols_tbl_sys_pagination_id_foreign` (`tbl_sys_pagination_ID`),
  ADD KEY `tbl_sys_paginations_cols_tbl_sys_field_type_id_foreign` (`tbl_sys_field_type_ID`);

--
-- Índices de tabela `tbl_sys_paginations_cols_access`
--
ALTER TABLE `tbl_sys_paginations_cols_access`
  ADD PRIMARY KEY (`tbl_sys_pagination_col_access_ID`),
  ADD KEY `tbl_sys_paginations_cols_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `fk_pag_cols_access_col` (`tbl_sys_paginations_col_ID`);

--
-- Índices de tabela `tbl_sys_routes`
--
ALTER TABLE `tbl_sys_routes`
  ADD PRIMARY KEY (`tbl_sys_route_ID`),
  ADD UNIQUE KEY `tbl_sys_routes_tbl_sys_route_name_unique` (`tbl_sys_route_name`);

--
-- Índices de tabela `tbl_sys_routes_access`
--
ALTER TABLE `tbl_sys_routes_access`
  ADD PRIMARY KEY (`tbl_routes_access_ID`),
  ADD KEY `tbl_sys_routes_access_tbl_users_type_id_foreign` (`tbl_users_type_ID`),
  ADD KEY `tbl_sys_routes_access_tbl_sys_route_id_foreign` (`tbl_sys_route_ID`);

--
-- Índices de tabela `tbl_sys_shortcodes`
--
ALTER TABLE `tbl_sys_shortcodes`
  ADD PRIMARY KEY (`tbl_sys_shortcode_ID`),
  ADD UNIQUE KEY `tbl_sys_shortcodes_tbl_sys_shortcode_code_unique` (`tbl_sys_shortcode_code`);

--
-- Índices de tabela `tbl_sys_translations`
--
ALTER TABLE `tbl_sys_translations`
  ADD PRIMARY KEY (`tbl_sys_translation_ID`),
  ADD UNIQUE KEY `tbl_sys_translations_tbl_sys_translation_key_unique` (`tbl_sys_translation_key`);

--
-- Índices de tabela `tbl_sys_translations_words`
--
ALTER TABLE `tbl_sys_translations_words`
  ADD PRIMARY KEY (`tbl_translations_word_ID`),
  ADD KEY `tbl_sys_translations_words_tbl_sys_translation_id_foreign` (`tbl_sys_translation_ID`);

--
-- Índices de tabela `tbl_sys_uploads`
--
ALTER TABLE `tbl_sys_uploads`
  ADD PRIMARY KEY (`tbl_sys_upload_ID`);

--
-- Índices de tabela `tbl_sys_uploads_access`
--
ALTER TABLE `tbl_sys_uploads_access`
  ADD PRIMARY KEY (`tbl_sys_uploads_access_ID`),
  ADD KEY `tbl_sys_uploads_access_tbl_user_id_foreign` (`tbl_user_ID`),
  ADD KEY `tbl_sys_uploads_access_tbl_sys_upload_id_foreign` (`tbl_sys_upload_ID`);

--
-- Índices de tabela `tbl_sys_uploads_types`
--
ALTER TABLE `tbl_sys_uploads_types`
  ADD PRIMARY KEY (`tbl_sys_uploads_type_ID`),
  ADD UNIQUE KEY `tbl_sys_uploads_types_tbl_sys_uploads_type_name_unique` (`tbl_sys_uploads_type_name`);

--
-- Índices de tabela `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`tbl_user_ID`),
  ADD UNIQUE KEY `tbl_users_tbl_user_login_unique` (`tbl_user_login`),
  ADD UNIQUE KEY `tbl_users_tbl_user_email_unique` (`tbl_user_email`),
  ADD KEY `tbl_users_tbl_user_deleted_at_index` (`tbl_user_deleted_at`);

--
-- Índices de tabela `tbl_users_password_reset_tokens`
--
ALTER TABLE `tbl_users_password_reset_tokens`
  ADD PRIMARY KEY (`reset_token_email`);

--
-- Índices de tabela `tbl_users_sessions`
--
ALTER TABLE `tbl_users_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_users_sessions_user_id_index` (`user_id`),
  ADD KEY `tbl_users_sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `tbl_users_types`
--
ALTER TABLE `tbl_users_types`
  ADD PRIMARY KEY (`tbl_users_type_ID`),
  ADD UNIQUE KEY `tbl_users_types_tbl_users_type_name_unique` (`tbl_users_type_name`);

--
-- Índices de tabela `tbl_users_types_rels`
--
ALTER TABLE `tbl_users_types_rels`
  ADD PRIMARY KEY (`tbl_users_types_rel_ID`),
  ADD KEY `tbl_users_types_rels_tbl_user_id_foreign` (`tbl_user_ID`),
  ADD KEY `tbl_users_types_rels_tbl_users_type_id_foreign` (`tbl_users_type_ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tbl_sys_configs`
--
ALTER TABLE `tbl_sys_configs`
  MODIFY `tbl_sys_config_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tbl_sys_field_types`
--
ALTER TABLE `tbl_sys_field_types`
  MODIFY `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `tbl_sys_field_types_groups`
--
ALTER TABLE `tbl_sys_field_types_groups`
  MODIFY `tbl_sys_field_type_group_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms`
--
ALTER TABLE `tbl_sys_forms`
  MODIFY `tbl_sys_form_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_access`
--
ALTER TABLE `tbl_sys_forms_access`
  MODIFY `tbl_sys_forms_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_fields`
--
ALTER TABLE `tbl_sys_forms_fields`
  MODIFY `tbl_sys_forms_field_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_fields_access`
--
ALTER TABLE `tbl_sys_forms_fields_access`
  MODIFY `tbl_sys_forms_fields_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT de tabela `tbl_sys_functions`
--
ALTER TABLE `tbl_sys_functions`
  MODIFY `tbl_sys_function_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus`
--
ALTER TABLE `tbl_sys_menus`
  MODIFY `tbl_sys_menu_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_access`
--
ALTER TABLE `tbl_sys_menus_access`
  MODIFY `tbl_menus_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_items`
--
ALTER TABLE `tbl_sys_menus_items`
  MODIFY `tbl_sys_menu_item_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_item_access`
--
ALTER TABLE `tbl_sys_menus_item_access`
  MODIFY `tbl_menus_item_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `tbl_sys_modulos`
--
ALTER TABLE `tbl_sys_modulos`
  MODIFY `tbl_sys_modulo_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_navs`
--
ALTER TABLE `tbl_sys_navs`
  MODIFY `tbl_sys_nav_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_sys_notifications`
--
ALTER TABLE `tbl_sys_notifications`
  MODIFY `tbl_sys_notification_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations`
--
ALTER TABLE `tbl_sys_paginations`
  MODIFY `tbl_sys_pagination_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_args`
--
ALTER TABLE `tbl_sys_paginations_args`
  MODIFY `tbl_sys_paginations_arg_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_cols`
--
ALTER TABLE `tbl_sys_paginations_cols`
  MODIFY `tbl_sys_paginations_col_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_cols_access`
--
ALTER TABLE `tbl_sys_paginations_cols_access`
  MODIFY `tbl_sys_pagination_col_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes`
--
ALTER TABLE `tbl_sys_routes`
  MODIFY `tbl_sys_route_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes_access`
--
ALTER TABLE `tbl_sys_routes_access`
  MODIFY `tbl_routes_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT de tabela `tbl_sys_shortcodes`
--
ALTER TABLE `tbl_sys_shortcodes`
  MODIFY `tbl_sys_shortcode_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_sys_translations`
--
ALTER TABLE `tbl_sys_translations`
  MODIFY `tbl_sys_translation_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_sys_translations_words`
--
ALTER TABLE `tbl_sys_translations_words`
  MODIFY `tbl_translations_word_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_uploads`
--
ALTER TABLE `tbl_sys_uploads`
  MODIFY `tbl_sys_upload_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_uploads_access`
--
ALTER TABLE `tbl_sys_uploads_access`
  MODIFY `tbl_sys_uploads_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_uploads_types`
--
ALTER TABLE `tbl_sys_uploads_types`
  MODIFY `tbl_sys_uploads_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `tbl_user_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_users_types`
--
ALTER TABLE `tbl_users_types`
  MODIFY `tbl_users_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_users_types_rels`
--
ALTER TABLE `tbl_users_types_rels`
  MODIFY `tbl_users_types_rel_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_sys_field_types`
--
ALTER TABLE `tbl_sys_field_types`
  ADD CONSTRAINT `tbl_sys_field_types_tbl_sys_field_type_group_id_foreign` FOREIGN KEY (`tbl_sys_field_type_group_ID`) REFERENCES `tbl_sys_field_types_groups` (`tbl_sys_field_type_group_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_forms_access`
--
ALTER TABLE `tbl_sys_forms_access`
  ADD CONSTRAINT `tbl_sys_forms_access_tbl_sys_form_id_foreign` FOREIGN KEY (`tbl_sys_form_ID`) REFERENCES `tbl_sys_forms` (`tbl_sys_form_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_forms_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_forms_fields`
--
ALTER TABLE `tbl_sys_forms_fields`
  ADD CONSTRAINT `tbl_sys_forms_fields_tbl_sys_field_type_id_foreign` FOREIGN KEY (`tbl_sys_field_type_ID`) REFERENCES `tbl_sys_field_types` (`tbl_sys_field_type_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_forms_fields_tbl_sys_form_id_foreign` FOREIGN KEY (`tbl_sys_form_ID`) REFERENCES `tbl_sys_forms` (`tbl_sys_form_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_forms_fields_access`
--
ALTER TABLE `tbl_sys_forms_fields_access`
  ADD CONSTRAINT `tbl_sys_forms_fields_access_tbl_sys_forms_field_id_foreign` FOREIGN KEY (`tbl_sys_forms_field_ID`) REFERENCES `tbl_sys_forms_fields` (`tbl_sys_forms_field_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_forms_fields_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_menus_access`
--
ALTER TABLE `tbl_sys_menus_access`
  ADD CONSTRAINT `tbl_sys_menus_access_tbl_sys_menu_item_id_foreign` FOREIGN KEY (`tbl_sys_menu_item_ID`) REFERENCES `tbl_sys_menus_items` (`tbl_sys_menu_item_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_menus_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_menus_items`
--
ALTER TABLE `tbl_sys_menus_items`
  ADD CONSTRAINT `tbl_sys_menus_items_tbl_sys_menu_id_foreign` FOREIGN KEY (`tbl_sys_menu_ID`) REFERENCES `tbl_sys_menus` (`tbl_sys_menu_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_menus_item_access`
--
ALTER TABLE `tbl_sys_menus_item_access`
  ADD CONSTRAINT `tbl_sys_menus_item_access_tbl_sys_menu_item_id_foreign` FOREIGN KEY (`tbl_sys_menu_item_ID`) REFERENCES `tbl_sys_menus_items` (`tbl_sys_menu_item_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_menus_item_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_notifications`
--
ALTER TABLE `tbl_sys_notifications`
  ADD CONSTRAINT `tbl_sys_notifications_tbl_user_id_foreign` FOREIGN KEY (`tbl_user_ID`) REFERENCES `tbl_users` (`tbl_user_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_paginations_args`
--
ALTER TABLE `tbl_sys_paginations_args`
  ADD CONSTRAINT `tbl_sys_paginations_args_tbl_sys_pagination_id_foreign` FOREIGN KEY (`tbl_sys_pagination_ID`) REFERENCES `tbl_sys_paginations` (`tbl_sys_pagination_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_paginations_cols`
--
ALTER TABLE `tbl_sys_paginations_cols`
  ADD CONSTRAINT `tbl_sys_paginations_cols_tbl_sys_field_type_id_foreign` FOREIGN KEY (`tbl_sys_field_type_ID`) REFERENCES `tbl_sys_field_types` (`tbl_sys_field_type_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_paginations_cols_tbl_sys_pagination_id_foreign` FOREIGN KEY (`tbl_sys_pagination_ID`) REFERENCES `tbl_sys_paginations` (`tbl_sys_pagination_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_paginations_cols_access`
--
ALTER TABLE `tbl_sys_paginations_cols_access`
  ADD CONSTRAINT `fk_pag_cols_access_col` FOREIGN KEY (`tbl_sys_paginations_col_ID`) REFERENCES `tbl_sys_paginations_cols` (`tbl_sys_paginations_col_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_paginations_cols_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_routes_access`
--
ALTER TABLE `tbl_sys_routes_access`
  ADD CONSTRAINT `tbl_sys_routes_access_tbl_sys_route_id_foreign` FOREIGN KEY (`tbl_sys_route_ID`) REFERENCES `tbl_sys_routes` (`tbl_sys_route_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_routes_access_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_translations_words`
--
ALTER TABLE `tbl_sys_translations_words`
  ADD CONSTRAINT `tbl_sys_translations_words_tbl_sys_translation_id_foreign` FOREIGN KEY (`tbl_sys_translation_ID`) REFERENCES `tbl_sys_translations` (`tbl_sys_translation_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_sys_uploads_access`
--
ALTER TABLE `tbl_sys_uploads_access`
  ADD CONSTRAINT `tbl_sys_uploads_access_tbl_sys_upload_id_foreign` FOREIGN KEY (`tbl_sys_upload_ID`) REFERENCES `tbl_sys_uploads` (`tbl_sys_upload_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_sys_uploads_access_tbl_user_id_foreign` FOREIGN KEY (`tbl_user_ID`) REFERENCES `tbl_users` (`tbl_user_ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbl_users_types_rels`
--
ALTER TABLE `tbl_users_types_rels`
  ADD CONSTRAINT `tbl_users_types_rels_tbl_user_id_foreign` FOREIGN KEY (`tbl_user_ID`) REFERENCES `tbl_users` (`tbl_user_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_users_types_rels_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
