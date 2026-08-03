-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 30/06/2026 às 02:02
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
(1, 'system-default-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Idioma do sistema\"]', 'pt-br', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 'system-multi-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Habilitar seleção de Idiomas\"]', 'false', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(3, 'site-home', '[sysfunction return=\"string\" fn=\"translate\" params=\"Página inicial do site\"]', '/', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(4, 'system-admin', '[sysfunction return=\"string\" fn=\"translate\" params=\"URL de administração\"]', '/admin/', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(5, 'site-title', '[sysfunction return=\"string\" fn=\"translate\" params=\"Título do site\"]', 'Automator v2', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(6, 'site-description', '[sysfunction return=\"string\" fn=\"translate\" params=\"Descrição do site\"]', 'Sistema de gerenciamento de informações automatizado.', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(7, 'site-favicon', '[sysfunction return=\"string\" fn=\"translate\" params=\"Ícone do site\"]', '', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(8, 'site-logo', '[sysfunction return=\"string\" fn=\"translate\" params=\"Logo do site\"]', '', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(9, 'system-enable-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Registro público liberado\"]', 'false', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(10, 'site-default-user-type-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Tipo de usuário padrão de cadastro\"]', '3', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(11, 'system-enable-date-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de datas do sistema\"]', '{\'j \\d F \\d Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"j \\d\\e F \\d\\e Y\";\"sysconfig(system-default-language)\"]\', \'Y-m-d\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"Y-m-d\";\"sysconfig(system-default-language)\"]\', \'m/d/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"m/d/Y\";\"sysconfig(system-default-language)\"]\', \'d/m/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d/m/Y\";\"sysconfig(system-default-language)\"]\', \'d.m.Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d.m.Y\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(12, 'system-default-date-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de data\"]', 'Y-m-d', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(13, 'system-enable-time-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de horas do sistema\"]', '{\'H:i\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"H:i\"]\', \'g:i A\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"g:i A\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(14, 'system-default-time-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de hora\"]', 'H:i', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(15, 'system-week-days-name', '[sysfunction return=\"string\" fn=\"translate\" params=\"Nome dos dias da semana\"]', '{\'1\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"segunda-feira\"]\', \'2\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"terça-feira\"]\', \'3\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quarta-feira\"]\', \'4\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quinta-feira\"]\', \'5\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sexta-feira\"]\', \'6\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sábado\"]\', \'7\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"domingo\"]\'}', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(16, 'system-default-week-day-start', '[sysfunction return=\"string\" fn=\"translate\" params=\"Dia de inicio da semana\"]', '1', '2026-06-06 12:57:20', '2026-06-06 12:57:20');

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
  `tbl_sys_field_type_layout` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_field_type_configs` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_locked` tinyint(1) NOT NULL DEFAULT '0',
  `tbl_sys_field_type_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_field_type_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_field_types`
--

INSERT INTO `tbl_sys_field_types` (`tbl_sys_field_type_ID`, `tbl_sys_field_type_group_ID`, `tbl_sys_field_type_name`, `tbl_sys_field_type_class`, `tbl_sys_field_type_icon`, `tbl_sys_field_type_title`, `tbl_sys_field_type_description`, `tbl_sys_field_type_params`, `tbl_sys_field_type_layout`, `tbl_sys_field_type_configs`, `tbl_sys_field_type_locked`, `tbl_sys_field_type_created_at`, `tbl_sys_field_type_updated_at`) VALUES
(1, 1, 'text', 'AutomatorFieldText', 'font', 'Texto', 'Uma entrada de texto básica, útil para armazenar valores de texto únicos.', '{\"minlenght\":{\"name\":\"Min\\u00edmo de caracteres\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"0\",\"description\":\"Valor min\\u00edmo de caracteres necess\\u00e1rio.\",\"default\":\"\"},\"maxlenght\":{\"name\":\"M\\u00e1ximo de caracteres\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"100\",\"description\":\"Valor m\\u00e1ximo de caracteres permitido.\",\"default\":\"\"},\"mask\":{\"name\":\"M\\u00e1scara\",\"type\":\"input[type=\'text\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Mascara de caracteres permitidos.\",\"default\":\"\"}}', 0, '', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 1, 'textarea', 'AutomatorFieldTextArea', 'paragraph', 'Área de texto', 'Uma entrada de área de texto básica para armazenar parágrafos de texto.', '{\"minlenght\":{\"name\":\"Min\\u00edmo de caracteres\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"0\",\"description\":\"Valor min\\u00edmo de caracteres necess\\u00e1rio.\",\"default\":\"\"},\"maxlenght\":{\"name\":\"M\\u00e1ximo de caracteres\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"100\",\"description\":\"Valor m\\u00e1ximo de caracteres permitido.\",\"default\":\"\"},\"rows\":{\"name\":\"Linhas\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"8\",\"description\":\"N\\u00famero de linhas do campo.\",\"default\":\"4\"}}', 0, '', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(3, 1, 'number', 'AutomatorFieldNumber', 'hashtag', 'Número', 'Uma entrada limitada a valores numéricos.', '{\"type\":{\"name\":\"Tipo\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Tipo de valor num\\u00e9rico.\",\"default\":\"int\",\"values\":{\"int\":\"Inteiro\",\"float\":\"Flutuante\"}},\"min\":{\"name\":\"Min\\u00edmo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"0\",\"description\":\"Valor min\\u00edmo necess\\u00e1rio.\",\"default\":\"\"},\"max\":{\"name\":\"M\\u00e1ximo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"100\",\"description\":\"Valor m\\u00e1ximo permitido.\",\"default\":\"\"},\"mask\":{\"name\":\"M\\u00e1scara\",\"type\":\"input[type=\'tel\']\",\"nullable\":\"true\",\"placeholder\":\"(99) 99999-9999\",\"description\":\"\",\"default\":\"\"},\"escala\":{\"name\":\"Tamanho da escala\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Tamanho da escala.\",\"default\":\"\"}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(4, 1, 'interval', 'AutomatorFieldInterval', 'sliders-h', 'Invervalo', 'Uma entrada para selecionar um valor numérico dentro de um intervalo especificado usando um elemento deslizante de intervalo.', '{\"min\":{\"name\":\"Min\\u00edmo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"0\",\"description\":\"Valor min\\u00edmo permitido.\",\"default\":\"0\"},\"max\":{\"name\":\"M\\u00e1ximo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"100\",\"description\":\"Valor m\\u00e1ximo permitido.\",\"default\":\"\"},\"escala\":{\"name\":\"Tamanho da escala\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Tamanho da escala.\",\"default\":\"\"}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(5, 1, 'email', 'AutomatorFieldEmail', 'email', 'E-Mail', 'Uma entrada de texto projetada especificamente para armazenar endereços de e-mail.', '', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(6, 1, 'url', 'AutomatorFieldURL', 'globe', 'URL', 'Uma entrada de texto projetada especificamente para armazenar endereços da web.', '', 0, '', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(7, 1, 'password', 'AutomatorFieldPassword', 'key', 'Senha', 'Uma entrada para fornecer uma senha usando um campo mascarado.', '{\"minlenght\":{\"name\":\"Min\\u00edmo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"8\",\"description\":\"Valor min\\u00edmo necess\\u00e1rio.\",\"default\":\"\"},\"maxlenght\":{\"name\":\"M\\u00e1ximo\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"100\",\"description\":\"Valor m\\u00e1ximo permitido.\",\"default\":\"\"},\"view\":{\"name\":\"Bot\\u00e3o de visuliza\\u00e7\\u00e3o\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Exibir bot\\u00e3o de visualiza\\u00e7\\u00e3o ao lado do campo.\",\"default\":\"false\",\"values\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(8, 2, 'image', 'AutomatorFieldImage', 'image', 'Imagem', 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher imagens.', '{\"type\":{\"name\":\"Tipo(s) de arquivo\",\"type\":\"checkbox\",\"nullable\":\"true\",\"description\":\"Tipo de imagem permitida do campo.\",\"default\":\"png\",\"values\":{\"png\":\"PNG\",\"gif\":\"GIF\",\"psd\":\"PSD\",\"jpg\":\"JPG\",\"jpeg\":\"JPEG\"}},\"multiple\":{\"name\":\"Multiplo\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Permitir selecionar varios arquivos para upload.\",\"default\":\"false\",\"values\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}}', 1, '{\"code\":{\"prefix\":\"<[$tag$] src=\\\"[$image$]\\\" class=\\\"[$class$]\\\"\",\"sufix\":\" \\/>\",\"tag\":\"img\",\"rendered\":true,\"editor\":false,\"has_child\":false},\"block\":{\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Galeria\",\"onclick\":\"SysAutomatorEditor.OpenGalery(this)\",\"label\":\"<i class=\\\"fa fa-image\\\"><\\/i>\"}]}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(9, 2, 'file', 'AutomatorFieldFile', 'file', 'Arquivo', 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher arquivos.', '{\"type\":{\"name\":\"Tipo(s) de arquivo\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Tipos de arquivos que podem ser enviados.\",\"default\":\"\"},\"multiple\":{\"name\":\"Multiplo\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Permitir selecionar varios arquivos para upload.\",\"default\":\"false\",\"values\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}}', 0, '', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(10, 2, 'editor', 'AutomatorFieldEditor', 'pencil', 'Editor', 'Exibe o editor Visual WYSIWYG como visto em areas de conteudo, permitindo uma rica experiência de edição de texto que também permite conteúdo multimídia.', '', 0, '', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(11, 3, 'select', 'AutomatorFieldSelect', 'check', 'Seleção', 'Uma lista suspensa com uma seleção de escolhas que você especifica.', '{\"choices\":{\"name\":\"Escolhas\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"Digite cada escolha em uma nova linha.<br \\/>Para mais controle, voc\\u00ea pode especificar tanto os valores quanto os r\\u00f3tulos, como nos exemplos:<br \\/>vermelho : Vermelho\",\"default\":\"\"}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(12, 3, 'checkbox', 'AutomatorFieldCheckbox', 'checkbox', 'Checkbox', 'Uma lista com botões de escolhas que você especifica.', '{\"choices\":{\"name\":\"Escolhas\",\"type\":\"dynamic-list\",\"nullable\":\"true\",\"placeholder\":\"\",\"description\":\"\",\"default\":\"\"}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(13, 3, 'dynamic-list', 'AutomatorFieldDynamicList', 'list', 'Lista Dinamica', 'Um campo para carregar um lista dinamica através da seleção de um campo atualizado.', '', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(14, 4, 'relation', 'AutomatorFieldRelation', 'clip', 'Relacional', 'Uma interface interativa e personalizável para escolher um ou vários itens, páginas ou itens com a opção de pesquisa da relação criada para o campo.', '{\"type\":{\"name\":\"Tipo de sele\\u00e7\\u00e3o\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"\",\"default\":\"select\",\"values\":{\"select\":\"Caixa de sele\\u00e7\\u00e3o\",\"checkbox\":\"Bot\\u00f5es de sele\\u00e7\\u00e3o\",\"radio\":\"Lista de sele\\u00e7\\u00e3o\"}},\"max-selection\":{\"name\":\"M\\u00e1ximo de escolhas\",\"type\":\"input[type=\'number\']\",\"nullable\":\"true\",\"placeholder\":\"N\\u00famero m\\u00e1ximo de escolhas via checkbox da rela\\u00e7\\u00e3o.\",\"description\":\"\",\"default\":\"\"}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(15, 5, 'breakline', 'AutomatorFieldBreakLine', 'arrows-left-right', 'Quebra de Linha', 'Um elemento HTML para adicionar uma quebra de linha.', '', 1, '{\"code\":{\"prefix\":\"<[$tag$]\",\"sufix\":\" \\/>\",\"tag\":\"hr\"},\"block\":[],\"toolbar\":[]}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(16, 5, 'container', 'AutomatorFieldContainer', 'square', 'Container', 'Um elemento HTML para adicionar um container para inserir linhas e colunas.', '', 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"container\",\"has_child\":true},\"block\":{\"fluid\":{\"label\":\"Fluid\",\"fields\":{\"type\":{\"label\":\"Tipo\",\"field\":\"select\",\"default\":\"container\",\"choices\":{\"container\":\"Container\",\"container-fluid\":\"Container Fluid\"}}}},\"margin\":{\"label\":\"Margens\",\"fields\":{\"margin\":{\"label\":\"Margem\",\"field\":\"select\",\"default\":\"mb-2\",\"choices\":{\"mb-0\":\"Nenhuma\",\"mb-2\":\"Pequena\",\"mb-4\":\"M\\u00e9dia\",\"mb-5\":\"Grande\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"class\":{\"label\":\"Classes Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(17, 5, 'row', 'AutomatorFieldRow', 'ruler-horizontal', 'Linha (Row)', 'Um elemento HTML para adicionar uma linha com uma ou várias colunas.', '', 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"row\",\"has_child\":true},\"block\":{\"options\":{\"label\":\"Op\\u00e7\\u00f5es da linha\",\"fields\":{\"horizontal\":{\"label\":\"Margens Horizontais\",\"field\":\"select\",\"default\":\"gx-4\",\"choices\":{\"gx-4\":\"M\\u00e9dia (Padr\\u00e3o)\",\"gx-0\":\"Nenhuma\",\"gx-3\":\"Pequena\",\"gx-5\":\"Grande\"}},\"vertical\":{\"label\":\"Margens Verticais\",\"field\":\"select\",\"default\":\"gy-0\",\"choices\":{\"gy-0\":\"Nenhuma (Padr\\u00e3o)\",\"gy-3\":\"Pequena\",\"gy-4\":\"M\\u00e9dia\",\"gy-5\":\"Grande\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da linha\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(18, 5, 'col', 'AutomatorFieldCol', 'ruler-vertical', 'Coluna (Col)', 'Um elemento HTML para adicionar uma coluna dentro de uma linha.', '', 1, '{\"code\":{\"prefix\":\"<[$tag$] class=\\\"[$class$]\\\">\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"div\",\"class\":\"col\",\"has_child\":true,\"data\":{\"col\":12,\"col-sm\":12,\"col-md\":6,\"col-lg\":6,\"col-xl\":6,\"col-xxl\":6},\"onload\":[\"SysAutomator.getCurrentResolutionSize()\"]},\"block\":{\"size\":{\"label\":\"Tamanho da coluna\",\"fields\":{\"column-xs\":{\"label\":\"Tamanho XS\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-\')\"},\"column-sm\":{\"label\":\"Tamanho SM\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":12,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-sm-\')\"},\"column-md\":{\"label\":\"Tamanho MD\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-md-\')\"},\"column-lg\":{\"label\":\"Tamanho LG\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-lg-\')\"},\"column-xl\":{\"label\":\"Tamanho XL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-xl-\')\"},\"column-xxl\":{\"label\":\"Tamanho XXL\",\"field\":\"range\",\"minval\":1,\"maxval\":12,\"default\":6,\"oninput\":\"SysAutomatorEditor.changeColClassSize(this, \'col-xxl-\')\"}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"radio-color-class\",\"default\":\"none\",\"custom\":true,\"choices\":{\"none\":\"Transparente\",\"bg-primary\":\"primary\",\"bg-secondary\":\"secondary\",\"bg-danger\":\"danger\",\"bg-info\":\"info\",\"bg-warning\":\"warning\",\"bg-white\":\"white\",\"bg-black\":\"black\",\"custom\":\"Personalizado\"}},\"color\":{\"label\":\"Cor do texto\",\"field\":\"radio-color-class\",\"default\":\"text-black\",\"custom\":true,\"choices\":{\"text-black\":\"black\",\"text-primary\":\"primary\",\"text-secondary\":\"secondary\",\"text-danger\":\"danger\",\"text-info\":\"info\",\"text-warning\":\"warning\",\"text-white\":\"white\",\"custom\":\"Personalizado\",\"none\":\"Transparente\"}}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da coluna\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(19, 5, 'title', 'AutomatorFieldTitle', 'heading', 'Titulo', 'Um elemento HTML para adicionar um titulo.', '', 1, '{\"code\":{\"default\":\"h1\",\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"has_child\":false,\"editor\":true,\"tag\":[\"h1\",\"h2\",\"h3\",\"h4\",\"h5\",\"h6\"]},\"block\":{\"tipograph\":{\"label\":\"Tipografia\",\"fields\":{\"type\":{\"label\":\"Tipo do titulo\",\"field\":\"radio-buttons\",\"default\":\"h1\",\"choices\":{\"h1\":\"H1\",\"h2\":\"H2\",\"h3\":\"H3\",\"h4\":\"H4\",\"h5\":\"H5\",\"h6\":\"H6\"}},\"size\":{\"label\":\"Tamanho da fonte\",\"field\":\"radio-buttons\",\"default\":\"medium\",\"custom\":true,\"choices\":{\"small\":\"P\",\"medium\":\"M\",\"large\":\"G\",\"extra-large\":\"GG\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da coluna\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[]}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(20, 5, 'paragraph', 'AutomatorFieldParagraph', 'font', 'Paragrafo', 'Um elemento HTML para adicionar um paragrafo.', '', 1, '{\"code\":{\"prefix\":\"<[$tag$]>\",\"sufix\":\"<\\/[$tag$]>\",\"tag\":\"p\",\"editor\":true,\"has_child\":false},\"block\":{\"tipograph\":{\"label\":\"Tipografia\",\"fields\":{\"size\":{\"label\":\"Tamanho da fonte\",\"field\":\"radio-buttons\",\"default\":\"medium\",\"custom\":true,\"choices\":{\"small\":\"P\",\"medium\":\"M\",\"large\":\"G\",\"extra-large\":\"GG\"}}}},\"colors\":{\"label\":\"Cores\",\"fields\":{\"background\":{\"label\":\"Cor de fundo\",\"field\":\"color-picker\",\"default\":\"none\"},\"color\":{\"label\":\"Cor do texto\",\"field\":\"color-picker\",\"default\":\"#000000\"}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da coluna\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}},\"toolbar\":[{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Negrito\",\"onclick\":\"SysAutomatorEditor.formatButton(this, \'bold\')\",\"label\":\"<i class=\\\"fa fa-bold\\\"><\\/i>\"},{\"type\":\"button\",\"class\":\"btn btn-xs btn-light border\",\"title\":\"Italico\",\"onclick\":\"SysAutomatorEditor.formatButton(this, \'italic\')\",\"label\":\"<i class=\\\"fa fa-italic\\\"><\\/i>\"}]}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(21, 6, 'hidden', 'AutomatorFieldHidden', 'secret', 'Hidden (Invisível)', 'Um campo sem aparencia visual para enviar ou armazenar valores.', '{\"type\":{\"name\":\"Tipo\",\"type\":\"select\",\"nullable\":\"false\",\"description\":\"Tipo de valor do campo.\",\"default\":\"string\",\"values\":{\"string\":\"Texto\",\"int\":\"Inteiro\",\"float\":\"Flutuante\"}}}', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(22, 6, 'json', 'AutomatorFieldJson', 'code', 'JSON', 'Um campo para armazenar valores em forma de json dentro do banco de dados.', '', 0, NULL, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(23, 7, 'pagination', 'AutomatorFieldPagination', 'list', 'Paginação', 'Um elemento que inclui uma paginação de resultados gerada pelo sistema.', '', 1, '{\"code\":{\"prefix\":\"<div><code>[automator function=\\\"pagination\\\" name=\\\"${name}\\\"\",\"sufix\":\"]<\\/code><\\/div>\",\"tag\":\"<code>\",\"has_child\":false,\"vars\":{\"name\":{\"type\":\"relation\",\"table\":\"tbl_sys_paginations\",\"index\":\"tbl_sys_pagination_ID\",\"label\":\"tbl_sys_pagination_title\"}}},\"block\":{\"config\":{\"label\":\"Configura\\u00e7\\u00f5es\",\"fields\":{\"type\":{\"label\":\"Pagina\\u00e7\\u00e3o\",\"field\":\"select\",\"default\":\"\",\"choices\":[]}}},\"advanced\":{\"label\":\"Avan\\u00e7ado\",\"fields\":{\"id\":{\"label\":\"ID da coluna\",\"field\":\"text\",\"default\":\"\"},\"class\":{\"label\":\"Classes CSS Adicionais\",\"field\":\"text\",\"default\":\"\"},\"style\":{\"label\":\"Estilo CSS adicional\",\"field\":\"textarea\",\"class\":\"textarea-css-editor\",\"default\":\"\"}}}}}', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20');

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
(1, 'basic', 'Básico', 1, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 'content', 'Conteúdo', 1, 2, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(3, 'choose', 'Escolha', 1, 3, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(4, 'relations', 'Relacional', 1, 4, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(5, 'layout', 'Layout', 1, 5, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(6, 'advanced', 'Avançado', 1, 6, '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(7, 'automator', 'Automator', 1, 7, '2026-06-06 12:57:20', '2026-06-06 12:57:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_forms`
--

CREATE TABLE `tbl_sys_forms` (
  `tbl_sys_form_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_form_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_form_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_form_cancel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cancelar',
  `tbl_sys_form_submit` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Salvar',
  `tbl_sys_form_method` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'POST',
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
(1, 'admin-minha-conta', 'Minha Conta', 'Cancelar', 'Salvar', 'POST', 'admin-api-minha-conta', 0, 1, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(2, 'admin-routes-apis', 'API\'s', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(3, 'admin-routes-apis-access', 'Permissões das Rotas de API', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(4, 'admin-routes', 'Páginas', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(5, 'admin-navs', 'Áreas de navegação', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(6, 'admin-users-types', 'Tipos de usuários', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(7, 'admin-users-types-access', 'Permissões dos tipos de usuários', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(8, 'admin-users', 'Usuários', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(9, 'admin-shortcodes', 'Shortcodes', 'Cancelar', 'Salvar', 'POST', NULL, 1, 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(1, 1, 1, '2026-06-06 09:57:21'),
(2, 2, 1, '2026-06-06 09:57:21'),
(3, 3, 1, '2026-06-06 09:57:21'),
(4, 4, 1, '2026-06-06 09:57:21'),
(5, 1, 2, '2026-06-06 09:57:21'),
(6, 2, 2, '2026-06-06 09:57:21'),
(7, 1, 3, '2026-06-06 09:57:22'),
(8, 2, 3, '2026-06-06 09:57:22'),
(9, 1, 4, '2026-06-06 09:57:22'),
(10, 2, 4, '2026-06-06 09:57:22'),
(11, 1, 5, '2026-06-06 09:57:22'),
(12, 2, 5, '2026-06-06 09:57:22'),
(13, 1, 6, '2026-06-06 09:57:22'),
(14, 2, 6, '2026-06-06 09:57:22'),
(15, 1, 7, '2026-06-06 09:57:22'),
(16, 2, 7, '2026-06-06 09:57:22'),
(17, 1, 8, '2026-06-06 09:57:22'),
(18, 2, 8, '2026-06-06 09:57:22'),
(19, 1, 9, '2026-06-06 09:57:22');

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
(1, 1, 21, 'ID', 'tbl_user_ID', 'id', '', '', '{\"type\":\"int\"}', '', 1, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(2, 1, 1, 'Nome', 'tbl_user_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_name\"}}', '', 1, 1, 2, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(3, 1, 5, 'E-mail', 'tbl_user_email', 'email', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":12,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_email\"}}', '', 1, 1, 3, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(4, 1, 7, 'Nova senha', 'tbl_user_password', 'new_password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true}', '', 0, 1, 4, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(5, 1, 7, 'Confirmar Nova senha', 'tbl_user_confirm_password', 'confirm_password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true}', '', 0, 1, 5, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(6, 2, 21, 'ID', 'tbl_sys_route_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(7, 2, 1, 'Nome', 'tbl_sys_route_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_sys_routes\",\"column\":\"tbl_sys_route_name\"}}', '', 1, 1, 2, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(8, 2, 1, 'Titulo', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8}', '', 1, 1, 3, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(9, 2, 1, 'Link Permanente', 'tbl_sys_route_permalink', 'permalink', '', '', '', '', 0, 1, 4, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(10, 2, 2, 'Descrição', 'tbl_sys_route_description', 'description', '', '', '{\"rows\":4}', '', 0, 1, 5, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(11, 2, 11, 'Ponto de API', 'tbl_sys_route_api', 'api', '', '1', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\"}}', '', 1, 1, 6, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(12, 2, 11, 'Página Administrativa', 'tbl_sys_route_admin', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 7, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(13, 2, 11, 'Bloqueado', 'tbl_sys_route_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(14, 2, 11, 'Tipo', 'tbl_sys_route_type', 'type', '', 'GET', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"GET\":\"GET\",\"POST\":\"POST\"}}', '', 1, 1, 9, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(15, 2, 1, 'Método', 'tbl_sys_route_method', 'mathod', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 10, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(16, 2, 1, 'Controller', 'tbl_sys_route_controller', 'controller', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 11, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(17, 2, 1, 'Argumentos', 'tbl_sys_route_args', 'args', '', '', '', '', 0, 1, 12, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(18, 2, 10, 'Conteúdo', 'tbl_sys_route_content', 'content', '', '', '{\"rows\":6}', '', 0, 1, 13, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(19, 2, 11, 'Status', 'tbl_sys_route_area', 'area', '', 'public', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"public\":\"Publica\",\"restrict\":\"Restrita\"}}', '', 1, 1, 14, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(20, 2, 11, 'Status', 'tbl_sys_route_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 15, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(21, 3, 21, 'ID da Rota', 'tbl_sys_route_ID', 'id', '', '', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(22, 3, 1, 'Nome da rota', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(23, 3, 14, 'Permissões da Rota', 'tbl_users_type_ID', 'access', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"label\":{\"table\":\"tbl_users_types\",\"value\":\"tbl_users_type_ID\",\"display\":\"tbl_users_type_name\"},\"filters\":{\"tbl_users_type_status\":{\"inativo\":{\"class\":\"disabled\",\"tooltip\":\"Tipo de usu\\u00e1rio inativo\"}}}}}', '', 0, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(24, 4, 21, 'ID', 'tbl_sys_route_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(25, 4, 1, 'Nome', 'tbl_sys_route_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_sys_routes\",\"column\":\"tbl_sys_route_name\"}}', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(26, 4, 1, 'Titulo', 'tbl_sys_route_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8}', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(27, 4, 1, 'Link Permanente', 'tbl_sys_route_permalink', 'permalink', '', '', '', '', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(28, 4, 2, 'Descrição', 'tbl_sys_route_description', 'description', '', '', '{\"rows\":4}', '', 0, 1, 5, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(29, 4, 11, 'Ponto de API', 'tbl_sys_route_api', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(30, 4, 11, 'Página Administrativa', 'tbl_sys_route_admin', 'api', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 7, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(31, 4, 11, 'Bloqueado', 'tbl_sys_route_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(32, 4, 11, 'Tipo', 'tbl_sys_route_type', 'type', '', 'GET', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"GET\":\"GET\",\"POST\":\"POST\",\"PUT\":\"PUT\",\"DELETE\":\"DELETE\"}}', '', 1, 1, 9, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(33, 4, 1, 'Método', 'tbl_sys_route_method', 'mathod', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 10, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(34, 4, 1, 'Controller', 'tbl_sys_route_controller', 'controller', '', '', '{\"wrapper_class\":\"col-12 col-md-6\"}', '', 0, 1, 11, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(35, 4, 1, 'Argumentos', 'tbl_sys_route_args', 'args', '', '', '', '', 0, 1, 12, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(36, 4, 10, 'Conteúdo', 'tbl_sys_route_content', 'content', '', '', '{\"rows\":6}', '', 0, 1, 13, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(37, 4, 11, 'Status', 'tbl_sys_route_area', 'area', '', 'public', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"public\":\"Publica\",\"restrict\":\"Restrita\"}}', '', 1, 1, 14, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(38, 4, 11, 'Status', 'tbl_sys_route_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 15, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(39, 5, 21, 'ID', 'tbl_sys_nav_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(40, 5, 1, 'Nome', 'tbl_sys_nav_name', 'name', '', '', '{\"wrapper_class\":\"col-12 col-md-5\",\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_sys_navs\",\"column\":\"tbl_sys_nav_name\"}}', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(41, 5, 1, 'Titulo', 'tbl_sys_nav_title', 'title', '', '', '{\"wrapper_class\":\"col-12 col-md-7\",\"maxlenght\":255,\"minlenght\":8}', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(42, 5, 11, 'Bloqueado', 'tbl_sys_nav_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(43, 5, 11, 'Administrativo', 'tbl_sys_nav_admin', 'admin', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 5, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(44, 6, 21, 'ID', 'tbl_users_type_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(45, 6, 1, 'Nome', 'tbl_users_type_name', 'name', '', '', '{\"maxlenght\":255,\"minlenght\":8,\"unique\":{\"table\":\"tbl_users_types\",\"column\":\"tbl_users_type_name\"}}', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(46, 6, 2, 'Descrição', 'tbl_users_type_description', 'description', '', '', '{\"rows\":4}', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(47, 6, 11, 'Bloqueado', 'tbl_users_type_locked', 'locked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(48, 6, 11, 'Status', 'tbl_users_type_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 5, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(49, 7, 21, 'Tipo de usuário', 'tbl_users_type_ID', 'id', '', '', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(50, 7, 1, 'Tipo de usuário', 'tbl_users_type_name', 'name', '', '', '{\"wrapper_class\":\"col-12\",\"readonly\":true,\"disabled\":true}', '', 0, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(51, 7, 14, 'Permissões concedidas', 'tbl_sys_route_ID', 'access', '', '', '{\"wrapper_class\":\"col-12\",\"type\":\"checkbox\",\"container\":{\"element\":\"div\",\"class\":\"\"},\"relation\":{\"table\":\"tbl_sys_routes\",\"value\":\"tbl_sys_route_ID\",\"label\":\"tbl_sys_route_title\",\"filters\":{\"tbl_sys_route_area\":{\"public\":{\"class\":\"disabled \",\"tooltip\":\"Somente p\\u00e1ginas restritas podem ter as permiss\\u00f5es de acesso alteradas.\",\"disabled\":true,\"remove\":false},\"restrict\":{\"class\":\"\",\"disabled\":false,\"remove\":false}},\"tbl_sys_route_status\":{\"ativo\":{\"class\":\"\",\"disabled\":false,\"remove\":false},\"inativo\":{\"class\":\"disabled\",\"tooltip\":\"Somente p\\u00e1ginas ativas podem ter as permiss\\u00f5es de acesso alteradas.\",\"disabled\":true,\"remove\":false}}}}}', '', 0, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(52, 8, 21, 'ID', 'tbl_user_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(53, 8, 1, 'Usuário', 'tbl_user_login', 'login', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":12,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_login\"}}', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(54, 8, 5, 'E-mail', 'tbl_user_email', 'email', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":12,\"unique\":{\"table\":\"tbl_users\",\"column\":\"tbl_user_email\"}}', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(55, 8, 1, 'Nome', 'tbl_user_name', 'name', '', '', '{\"wrapper_class\":\"col-12\",\"maxlenght\":255,\"minlenght\":12}', '', 1, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(56, 8, 7, 'Senha', 'tbl_user_password', 'password', '', '', '{\"wrapper_class\":\"col-12 col-md-6\",\"maxlenght\":255,\"minlenght\":8,\"hasButton\":true}', '', 0, 1, 5, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(57, 8, 11, 'Bloqueado', 'tbl_user_blocked', 'blocked', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}', '', 1, 1, 6, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(58, 8, 15, 'Quebra de linha', 'quebra', '', '', '0', '', '', 1, 1, 7, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(59, 8, 11, 'Cadastro ativo', 'tbl_user_actived', 'actived', '', '0', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"true\":\"Sim\",\"false\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(60, 8, 11, 'Status', 'tbl_user_status', 'status', '', 'ativo', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"ativo\":\"Ativo\",\"inativo\":\"Inativo\"}}', '', 1, 1, 9, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(61, 9, 21, 'ID', 'tbl_sys_shortcode_ID', 'id', '', '', '{\"type\":\"int\"}', '', 0, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(62, 9, 1, 'Código', 'tbl_sys_shortcode_code', 'code', '', '', '{\"maxlenght\":255}', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(63, 9, 1, 'Titulo', 'tbl_sys_shortcode_title', 'title', '', '', '{\"maxlenght\":255}', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(64, 9, 2, 'Descrição', 'tbl_sys_shortcode_description', 'description', '', '', '', '', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(65, 9, 1, 'Class/Classe', 'tbl_sys_shortcode_class', 'class', '', '', '{\"maxlenght\":255}', '', 1, 1, 5, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(66, 9, 1, 'Metodo/Função', 'tbl_sys_shortcode_method', 'method', '', '', '{\"maxlenght\":255}', '', 1, 1, 6, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(67, 9, 2, 'Parametros', 'tbl_sys_shortcode_params', 'params', '', '', '', '', 0, 1, 7, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(68, 9, 11, 'Bloqueado', 'tbl_sys_shortcode_locked', 'locked', '', 'false', '{\"wrapper_class\":\"col-12 col-md-6\",\"choices\":{\"1\":\"Sim\",\"0\":\"N\\u00e3o\"}}', '', 1, 1, 8, '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(92, 1, 43),
(93, 2, 43),
(94, 1, 44),
(95, 2, 44),
(96, 1, 45),
(97, 2, 45),
(98, 1, 46),
(99, 2, 46),
(100, 1, 47),
(101, 1, 48),
(102, 2, 48),
(103, 1, 49),
(104, 2, 49),
(105, 1, 50),
(106, 2, 50),
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
(119, 3, 56),
(120, 4, 56),
(121, 1, 57),
(122, 1, 58),
(123, 2, 58),
(124, 1, 59),
(125, 1, 60),
(126, 2, 60),
(127, 1, 61),
(128, 1, 62),
(129, 1, 63),
(130, 1, 64),
(131, 1, 65),
(132, 1, 66),
(133, 1, 67),
(134, 1, 68);

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
  `tbl_sys_function_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_function_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_functions`
--

INSERT INTO `tbl_sys_functions` (`tbl_sys_function_ID`, `tbl_sys_function_type`, `tbl_sys_function_name`, `tbl_sys_function_fn`, `tbl_sys_function_params`, `tbl_sys_function_created_at`, `tbl_sys_function_updated_at`) VALUES
(1, 'custom', 'translate', 'AutomatorTranslate', '{\'word\': true, \'lang\': false}', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 'custom', 'sysDateFormat', 'AutomatorDateFormat', '{\'date\': true, \'translate\': false}', '2026-06-06 12:57:20', '2026-06-06 12:57:20');

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
(1, 1, 'Sidebar Menu Painel Administrativo', '', 'app-sidebar-menu', 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(2, 2, 'Header Menu Painel Administrativo', '', 'dropdown-menu dropdown-menu-end shadow', 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21');

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
(1, 1, 1, '2026-06-06 09:57:21'),
(2, 2, 1, '2026-06-06 09:57:21'),
(3, 3, 1, '2026-06-06 09:57:21'),
(4, 4, 1, '2026-06-06 09:57:21'),
(5, 1, 2, '2026-06-06 09:57:21'),
(6, 2, 2, '2026-06-06 09:57:21'),
(7, 3, 2, '2026-06-06 09:57:21'),
(8, 4, 2, '2026-06-06 09:57:21'),
(9, 1, 3, '2026-06-06 09:57:21'),
(10, 2, 3, '2026-06-06 09:57:21'),
(11, 3, 3, '2026-06-06 09:57:21'),
(12, 4, 3, '2026-06-06 09:57:21'),
(13, 1, 4, '2026-06-06 09:57:21'),
(14, 2, 4, '2026-06-06 09:57:21'),
(15, 1, 5, '2026-06-06 09:57:21'),
(16, 2, 5, '2026-06-06 09:57:21'),
(17, 1, 6, '2026-06-06 09:57:21'),
(18, 2, 6, '2026-06-06 09:57:21'),
(19, 1, 7, '2026-06-06 09:57:21'),
(20, 2, 7, '2026-06-06 09:57:21'),
(21, 1, 8, '2026-06-06 09:57:21'),
(22, 2, 8, '2026-06-06 09:57:21'),
(23, 1, 9, '2026-06-06 09:57:21'),
(24, 2, 9, '2026-06-06 09:57:21'),
(25, 1, 10, '2026-06-06 09:57:21'),
(26, 2, 10, '2026-06-06 09:57:21'),
(27, 1, 11, '2026-06-06 09:57:21'),
(28, 2, 11, '2026-06-06 09:57:21'),
(29, 1, 12, '2026-06-06 09:57:21'),
(30, 2, 12, '2026-06-06 09:57:21'),
(31, 1, 13, '2026-06-06 09:57:21'),
(32, 2, 13, '2026-06-06 09:57:21'),
(33, 1, 14, '2026-06-06 09:57:21'),
(34, 2, 14, '2026-06-06 09:57:21'),
(35, 1, 15, '2026-06-06 09:57:21'),
(36, 2, 15, '2026-06-06 09:57:21'),
(37, 1, 16, '2026-06-06 09:57:21'),
(38, 2, 16, '2026-06-06 09:57:21'),
(39, 1, 17, '2026-06-06 09:57:21'),
(40, 2, 17, '2026-06-06 09:57:21'),
(41, 1, 18, '2026-06-06 09:57:21'),
(42, 2, 18, '2026-06-06 09:57:21'),
(43, 1, 19, '2026-06-06 09:57:21'),
(44, 2, 19, '2026-06-06 09:57:21'),
(45, 1, 20, '2026-06-06 09:57:21'),
(46, 1, 21, '2026-06-06 09:57:21'),
(47, 2, 21, '2026-06-06 09:57:21'),
(48, 1, 22, '2026-06-06 09:57:21'),
(49, 2, 22, '2026-06-06 09:57:21'),
(50, 1, 23, '2026-06-06 09:57:21'),
(51, 2, 23, '2026-06-06 09:57:21'),
(52, 1, 24, '2026-06-06 09:57:21'),
(53, 1, 25, '2026-06-06 09:57:21'),
(54, 2, 25, '2026-06-06 09:57:21'),
(55, 1, 26, '2026-06-06 09:57:21'),
(56, 2, 26, '2026-06-06 09:57:21'),
(57, 3, 26, '2026-06-06 09:57:21'),
(58, 4, 26, '2026-06-06 09:57:21'),
(59, 1, 27, '2026-06-06 09:57:21'),
(60, 2, 27, '2026-06-06 09:57:21'),
(61, 3, 27, '2026-06-06 09:57:21'),
(62, 4, 27, '2026-06-06 09:57:21'),
(63, 1, 28, '2026-06-06 09:57:21'),
(64, 2, 28, '2026-06-06 09:57:21'),
(65, 3, 28, '2026-06-06 09:57:21'),
(66, 4, 28, '2026-06-06 09:57:21'),
(67, 1, 29, '2026-06-06 09:57:21'),
(68, 2, 29, '2026-06-06 09:57:21'),
(69, 3, 29, '2026-06-06 09:57:21'),
(70, 4, 29, '2026-06-06 09:57:21');

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
(1, 1, '', 'gauge', 'sidebar-link', 'Dashboard', 'route', 8, '', '{\"data-sidebar-title\":\"Dashboard\"}', 'ativo', '0', 1, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(2, 1, '', 'bell', 'sidebar-link', 'Notificações', 'route', 9, '', '{\"data-sidebar-title\":\"Notifica\\u00e7\\u00f5es\"}', 'ativo', '0', 1, 1, 2, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(3, 1, '', 'user', 'sidebar-link', 'Minha Conta', 'route', 12, '', '{\"data-sidebar-title\":\"Minha Conta\"}', 'ativo', '0', 1, 1, 3, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(4, 1, '', 'image', 'sidebar-link', 'Galeria', 'button', NULL, '', '{\"data-sidebar-title\":\"Galeria\"}', 'ativo', '0', 1, 1, 4, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(5, 1, '', '', 'sidebar-submenu-link', 'Tipos de Midia', 'route', 15, '', '', 'ativo', '4', 1, 1, 5, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(6, 1, '', '', 'sidebar-submenu-link', 'Uploads', 'route', 20, '', '', 'ativo', '4', 1, 1, 6, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(7, 1, '', 'shield-halved', 'sidebar-link', 'Administração', 'button', NULL, '', '{\"data-sidebar-title\":\"Administra\\u00e7\\u00e3o\"}', 'ativo', '0', 1, 1, 7, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(8, 1, '', '', 'sidebar-submenu-link', 'Rotas de API', 'route', 26, '', '', 'ativo', '7', 1, 1, 8, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(9, 1, '', '', 'sidebar-submenu-link', 'Páginas', 'route', 33, '', '', 'ativo', '7', 1, 1, 9, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(10, 1, '', '', 'sidebar-submenu-link', 'Navegação', 'route', 40, '', '', 'ativo', '7', 1, 1, 10, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(11, 1, '', '', 'sidebar-submenu-link', 'Menus', 'route', 45, '', '', 'ativo', '7', 1, 1, 11, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(12, 1, '', 'users', 'sidebar-link', 'Usuários', 'button', NULL, '', '{\"data-sidebar-title\":\"Usu\\u00e1rios\"}', 'ativo', '0', 1, 1, 12, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(13, 1, '', '', 'sidebar-submenu-link', 'Tipos de Usuários', 'route', 49, '', '', 'ativo', '12', 1, 1, 13, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(14, 1, '', '', 'sidebar-submenu-link', 'Usuários', 'route', 56, '', '', 'ativo', '12', 1, 1, 14, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(15, 1, '', '', 'sidebar-submenu-link', 'Notificações', 'route', 61, '', '', 'ativo', '12', 1, 1, 15, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(16, 1, '', 'language', 'sidebar-link', 'Idiomas', 'button', NULL, '', '{\"data-sidebar-title\":\"Idiomas\"}', 'ativo', '0', 1, 1, 16, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(17, 1, '', '', 'sidebar-submenu-link', 'Idiomas', 'route', 97, '', '', 'ativo', '16', 1, 1, 17, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(18, 1, '', '', 'sidebar-submenu-link', 'Traduções', 'route', 102, '', '', 'ativo', '16', 1, 1, 18, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(19, 1, '', 'layer-group', 'sidebar-link', 'Automator', 'route', 68, '', '{\"data-sidebar-title\":\"Automator\"}', 'ativo', '0', 1, 1, 19, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(20, 1, '', '', 'sidebar-submenu-link', 'Campos', 'route', 69, '', '', 'ativo', '19', 1, 1, 20, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(21, 1, '', '', 'sidebar-submenu-link', 'Módulos', 'route', 74, '', '', 'ativo', '19', 1, 1, 21, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(22, 1, '', '', 'sidebar-submenu-link', 'Formulários', 'route', 79, '', '', 'ativo', '19', 1, 1, 22, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(23, 1, '', '', 'sidebar-submenu-link', 'Paginações', 'route', 87, '', '', 'ativo', '19', 1, 1, 23, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(24, 1, '', '', 'sidebar-submenu-link', 'Shortcodes', 'route', 92, '', '', 'ativo', '19', 1, 1, 24, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(25, 1, '', 'cog', 'sidebar-link', 'Configurações', 'route', 66, '', '{\"data-sidebar-title\":\"Configura\\u00e7\\u00f5es\"}', 'ativo', '0', 1, 1, 25, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(26, 1, '', 'right-from-bracket', 'sidebar-btn', 'Sair', 'button', NULL, '', '{\"class\": \"btn-logout-system sidebar-link\", \"data-sidebar-title\": \"Sair\"}', 'ativo', '0', 1, 1, 26, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(27, 2, '', '', 'dropdown-item py-2', 'Minha Conta', 'route', 12, '', '', 'ativo', '0', 1, 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(28, 2, '', '', '', 'Divisor', 'divider', NULL, '', '', 'ativo', '0', 0, 0, 2, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(29, 2, '', '', 'dropdown-item p-0', 'Sair', 'button', NULL, '', '{\"class\": \"btn-logout-system btn-header-painel p-2\"}', 'ativo', '0', 1, 1, 3, '2026-06-06 12:57:21', '2026-06-06 12:57:21');

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
(1, 1, 1, '2026-06-06 09:57:21'),
(2, 1, 2, '2026-06-06 09:57:21'),
(3, 2, 2, '2026-06-06 09:57:21'),
(4, 1, 3, '2026-06-06 09:57:21'),
(5, 2, 3, '2026-06-06 09:57:21'),
(6, 1, 4, '2026-06-06 09:57:21'),
(7, 1, 5, '2026-06-06 09:57:21'),
(8, 1, 6, '2026-06-06 09:57:21'),
(9, 1, 7, '2026-06-06 09:57:21'),
(10, 1, 8, '2026-06-06 09:57:21'),
(11, 1, 9, '2026-06-06 09:57:21'),
(12, 1, 10, '2026-06-06 09:57:21'),
(13, 1, 11, '2026-06-06 09:57:21'),
(14, 1, 12, '2026-06-06 09:57:21'),
(15, 1, 13, '2026-06-06 09:57:21'),
(16, 1, 14, '2026-06-06 09:57:21'),
(17, 1, 15, '2026-06-06 09:57:21'),
(18, 1, 16, '2026-06-06 09:57:21'),
(19, 1, 17, '2026-06-06 09:57:21'),
(20, 1, 18, '2026-06-06 09:57:21'),
(21, 1, 19, '2026-06-06 09:57:21'),
(22, 1, 20, '2026-06-06 09:57:21'),
(23, 1, 21, '2026-06-06 09:57:21'),
(24, 1, 22, '2026-06-06 09:57:21'),
(25, 1, 23, '2026-06-06 09:57:21'),
(26, 1, 24, '2026-06-06 09:57:21'),
(27, 1, 25, '2026-06-06 09:57:21'),
(28, 1, 26, '2026-06-06 09:57:21'),
(29, 2, 26, '2026-06-06 09:57:21'),
(30, 1, 27, '2026-06-06 09:57:21'),
(31, 2, 27, '2026-06-06 09:57:21'),
(32, 1, 28, '2026-06-06 09:57:21'),
(33, 2, 28, '2026-06-06 09:57:21'),
(34, 1, 29, '2026-06-06 09:57:21');

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
(1, 'admin-sidebar', 'Sidebar Painel Administrativo', 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(2, 'admin-header', 'Header Menu Painel Administrativo', 1, 1, '2026-06-06 12:57:21', '2026-06-06 12:57:21');

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
(1, 'admin-navs-pagination', 'admin-navs', 'Paginação posições de menus de navegação.', 'tbl_sys_navs', 'tbl_sys_nav_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(2, 'admin-apis-pagination', 'admin-apis', 'Paginação de Rotas de API do sistema', 'tbl_sys_routes', 'tbl_sys_route_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(3, 'admin-routes-pagination', 'admin-routes', 'Paginação de Rotas/Páginas do sistema', 'tbl_sys_routes', 'tbl_sys_route_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(4, 'admin-users-types-pagination', 'admin-users-types', 'Paginação tipos de usuários', 'tbl_users_types', 'tbl_users_type_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(5, 'admin-users-pagination', 'admin-users', 'Paginação de usuários', 'tbl_users', 'tbl_user_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(6, 'admin-fields-pagination', 'admin-fields', 'Paginação de tipos de campos', 'tbl_sys_field_types', 'tbl_sys_field_type_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(7, 'admin-modulos-pagination', 'admin-modulos', 'Paginação de módulos', 'tbl_sys_modulos', 'tbl_sys_modulo_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(8, 'admin-forms-pagination', 'admin-forms', 'Paginação de formulários', 'tbl_sys_forms', 'tbl_sys_form_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(9, 'admin-paginations-pagination', 'admin-paginations', 'Paginações', 'tbl_sys_paginations', 'tbl_sys_pagination_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(10, 'admin-shortcodes-pagination', 'admin-shortcodes', 'Shortcodes do sistema', 'tbl_sys_shortcodes', 'tbl_sys_shortcode_ID', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(1, 1, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(2, 1, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(3, 1, 'actions', '{\"get\":{\"route\":\"admin-api-navs-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-navs-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-navs-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-navs-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_nav_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(4, 1, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-nav\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova \\u00c1rea de navega\\u00e7\\u00e3o\', 5);\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(5, 1, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar \\u00c1rea de navega\\u00e7\\u00e3o\', 5, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir \\u00c1rea de navega\\u00e7\\u00e3o\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(6, 2, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(7, 2, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(8, 2, 'where', '[[\"tbl_sys_route_api\",\">=\",1]]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(9, 2, 'actions', '{\"access\":{\"route\":\"admin-api-routes-apis-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-routes-apis-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-routes-apis-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-routes-apis-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-routes-apis-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-routes-apis-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_route_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(10, 2, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-route-apis\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Nova API\', 2);\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(11, 2, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit-routes-apis\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar API\', 2, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es da Rota de API\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Permiss\\u00f5es da API\', 3, \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete-routes-apis\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir P\\u00e1gina\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(12, 3, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(13, 3, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(14, 3, 'where', '[[\"tbl_sys_route_api\",\"<=\",0]]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(15, 3, 'actions', '{\"access\":{\"route\":\"admin-api-routes-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-routes-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-routes-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-routes-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-routes-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-routes-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_route_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(16, 3, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-route\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova P\\u00e1gina\",\"onclick\":\"AutomatorCreateViewModal({ view: \'system-page-editor\' }, { size: \'fullscreen\', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); }});\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(17, 3, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar P\\u00e1gina\",\"onclick\":\"AutomatorCreateViewModal({ view: \'system-page-editor\', pageID: \'{id}\' }, { size: \'fullscreen\', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorEditor.destroy(); }});\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es da P\\u00e1gina\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Permiss\\u00f5es da P\\u00e1gina\', , \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir P\\u00e1gina\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(18, 4, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(19, 4, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(20, 4, 'actions', '{\"access\":{\"route\":\"admin-api-users-types-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-users-types-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-users-types-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-users-types-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-users-types-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-users-types-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_users_type_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(21, 4, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-user-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Tipo de usu\\u00e1rio\', 6, \'\', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'add\' }]); });\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(22, 4, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Tipo de usu\\u00e1rio\', 6, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"access\",\"id\":\"btn-access\",\"class\":\"btn-warning text-white\",\"icon\":\"lock\",\"text\":\"Permiss\\u00f5es do Tipo de usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Permiss\\u00f5es do Tipo de usu\\u00e1rio\', 7, \'access\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'accessEdit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Tipo de usu\\u00e1rio\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(23, 5, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(24, 5, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(25, 5, 'actions', '{\"get\":{\"route\":\"admin-api-users-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-users-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-users-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-users-delete\",\"params\":[],\"show\":false}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(26, 5, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-user\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Usu\\u00e1rio\', 8);\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(27, 5, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Usu\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Usu\\u00e1rio\', 8, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Usu\\u00e1rio\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(28, 6, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(29, 6, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(30, 6, 'actions', '{\"get\":{\"route\":\"admin-api-fields-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-fields-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-fields-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-fields-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_field_type_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(31, 6, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-field-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Tipo de campo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Novo Tipo de campo\', );\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(32, 6, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Tipo de campo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Tipo de campo\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Tipo de campo\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(33, 7, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(34, 7, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(35, 7, 'actions', '{\"get\":{\"route\":\"admin-api-modulos-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-modulos-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-modulos-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-modulos-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_modulo_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(36, 7, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-modulo\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Adicionar M\\u00f3dulo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\',\'Adicionar M\\u00f3dulo\', );\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(37, 7, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar M\\u00f3dulo\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar M\\u00f3dulo\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir M\\u00f3dulo\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(38, 8, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(39, 8, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(40, 8, 'actions', '{\"access\":{\"route\":\"admin-api-forms-access\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"accessEdit\":{\"route\":\"admin-api-forms-access-update\",\"params\":[],\"show\":true},\"get\":{\"route\":\"admin-api-forms-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-forms-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-forms-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-forms-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_form_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(41, 8, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-form\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Formul\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-fullscreen\',\'Novo Formul\\u00e1rio\', );\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(42, 8, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Formul\\u00e1rio\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-fullscreen\', \'Editar Formul\\u00e1rio\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Formul\\u00e1rio\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(43, 9, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(44, 9, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(45, 9, 'actions', '{\"get\":{\"route\":\"admin-api-paginations-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-paginations-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-paginations-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-paginations-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_pagination_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(46, 9, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-user-type\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Nova Pagina\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-fullscreen\', \'Nova Pagina\\u00e7\\u00e3o\', );\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(47, 9, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Pagina\\u00e7\\u00e3o\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-fullscreen\', \'Editar Pagina\\u00e7\\u00e3o\', , \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"},{\"type\":\"button\",\"action\":\"delete\",\"id\":\"btn-delete\",\"class\":\"btn-danger\",\"icon\":\"trash\",\"text\":\"Excluir Pagina\\u00e7\\u00e3o\",\"onclick\":\"\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(48, 10, 'page_name', '@replace($route[\"tbl_sys_route_name\"])', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(49, 10, 'per_page', '15', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(50, 10, 'actions', '{\"get\":{\"route\":\"admin-api-shortcodes-get\",\"params\":{\"id\":\"#ID#\"},\"show\":true},\"add\":{\"route\":\"admin-api-shortcodes-store\",\"params\":[],\"show\":true},\"edit\":{\"route\":\"admin-api-shortcodes-update\",\"params\":[],\"show\":true},\"delete\":{\"route\":\"admin-api-shortcodes-delete\",\"params\":[],\"show\":false,\"roles\":[{\"key\":\"tbl_sys_shortcode_locked\",\"compare\":\"==\",\"value\":false}]}}', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(51, 10, 'header_actions', '[{\"type\":\"button\",\"action\":\"add\",\"id\":\"btn-add-shortcode\",\"class\":\"btn btn-success\",\"icon\":\"plus\",\"text\":\"Novo Shortcode\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Novo Shortcode\', 9);\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(52, 10, 'list_actions', '[{\"type\":\"button\",\"action\":\"edit\",\"id\":\"btn-edit\",\"class\":\"btn-primary\",\"icon\":\"pencil\",\"text\":\"Editar Shortcode\",\"onclick\":\"AutomatorPaginationCreateModalForm(\'modal-md\', \'Editar Shortcode\', 9, \'get\', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: \'POST\', action: \'edit\' }]); });\"}]', '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(1, 1, 3, 'tbl_sys_nav_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(2, 1, 1, 'tbl_sys_nav_name', 'Nome', '', '', '', '', 1, 0, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(3, 1, 1, 'tbl_sys_nav_title', 'Titulo', '', '', '', '', 1, 0, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(4, 1, 14, 'tbl_sys_nav_ID', 'Menu', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '{\"type\":\"single\",\"mode\":\"revert\",\"table\":\"tbl_sys_menus\",\"column\":\"tbl_sys_nav_ID\",\"display\":\"tbl_sys_menu_title\",\"nullable\":true,\"empty\":\"- - -\"}', '', 0, 0, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(5, 2, 3, 'tbl_sys_route_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(6, 2, 1, 'tbl_sys_route_title', 'Titulo', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(7, 2, 1, 'tbl_sys_route_name', 'Nome', '', '', '', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(8, 2, 1, 'tbl_sys_route_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(9, 3, 3, 'tbl_sys_route_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(10, 3, 1, 'tbl_sys_route_title', 'Titulo', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(11, 3, 1, 'tbl_sys_route_name', 'Nome', '', '', '', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(12, 3, 1, 'tbl_sys_route_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(13, 4, 3, 'tbl_users_type_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(14, 4, 1, 'tbl_users_type_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(15, 4, 1, 'tbl_users_type_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(16, 5, 3, 'tbl_user_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(17, 5, 1, 'tbl_user_login', 'Usuário', '', '', '', '', 1, 0, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(18, 5, 1, 'tbl_user_name', 'Nome', '', '', '', '', 1, 0, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(19, 5, 1, 'tbl_user_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(20, 6, 3, 'tbl_sys_field_type_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(21, 6, 1, 'tbl_sys_field_type_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(22, 6, 1, 'tbl_sys_field_type_title', 'Titulo', '', '', '', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(23, 7, 3, 'tbl_sys_modulo_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(24, 7, 1, 'tbl_sys_modulo_title', 'Titulo', '', '', '', '', 1, 0, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(25, 7, 1, 'tbl_sys_modulo_name', 'Nome', '', '', '', '', 1, 0, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(26, 7, 1, 'tbl_sys_modulo_status', 'Status', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '{\"replaced\":{\"ativo\":\"<span class=\\\"badge text-bg-success\\\">Ativo<\\/span>\",\"inativo\":\"<span class=\\\"badge text-bg-danger\\\">Inativo<\\/span>\"}}', 0, 1, 4, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(27, 8, 3, 'tbl_sys_form_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(28, 8, 1, 'tbl_sys_form_name', 'Nome', '', '', '', '', 1, 0, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(29, 8, 1, 'tbl_sys_form_title', 'Titulo', '', '', '', '', 1, 0, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(30, 9, 3, 'tbl_sys_pagination_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(31, 9, 1, 'tbl_sys_pagination_name', 'Nome', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(32, 9, 1, 'tbl_sys_pagination_title', 'Titulo', '', '', '', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(33, 10, 3, 'tbl_sys_shortcode_ID', 'ID', '{\"class\":\"text-center\"}', '{\"class\":\"text-center\"}', '', '', 1, 1, 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(34, 10, 1, 'tbl_sys_shortcode_code', 'Codigo', '', '', '', '', 1, 1, 2, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(35, 10, 1, 'tbl_sys_shortcode_title', 'Nome', '', '', '', '', 1, 1, 3, '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(40, 1, 21),
(41, 1, 22),
(42, 1, 23),
(43, 2, 23),
(44, 1, 24),
(45, 2, 24),
(46, 1, 25),
(47, 2, 25),
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
(67, 2, 35);

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
(1, 'index', 'Home', '/', 0, 0, 1, 'GET', 'SiteController', 'index', '', '', NULL, 'public', 'ativo', '', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 'admin-login', 'Login', NULL, 0, 1, 1, 'GET', 'SystemController', 'login', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(3, 'admin-api-login', 'API Login', NULL, 1, 1, 1, 'POST', 'SystemController', 'loginAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(4, 'admin-esqueci-minha-senha', 'Esqueci minha senha', NULL, 0, 1, 1, 'GET', 'SystemController', 'forgetPassword', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(5, 'admin-api-esqueci-minha-senha', 'API - Esqueci minha senha', NULL, 1, 1, 1, 'POST', 'SystemController', 'forgetPasswordAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(6, 'admin-recuperar-conta', 'Recuperar conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'recoverAccount', '{token}', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(7, 'admin-api-recuperar-conta', 'API - Recuperar conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'recoverAccountAPI', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(8, 'admin-dashboard', 'Dashboard', NULL, 0, 1, 1, 'GET', 'SystemController', 'dashboard', '', '[system-pages view=\"system.pages.dashboard\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(9, 'admin-notificacoes', 'Notificações', 'notificacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '{id?}', '[automator function=\"pagination\" name=\"admin-notificacoes-pagination\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(10, 'admin-api-notificacoes', 'API - Notificações GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(11, 'admin-api-notificacoes-update', 'API - Notificações UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_notifications\" index=\"tbl_sys_notification_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(12, 'admin-minha-conta', 'Minha Conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'myAccount', '', 'Utilize o formulário abaixo para atualizar os dados de sua conta. <br /><br />[system-form form=\"admin-minha-conta\" vars=\"$currentUser\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(13, 'admin-api-minha-conta', 'API - Minha Conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'myAccountAPI', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(14, 'admin-galeria', 'Galeria', 'galeria', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '[system-pages view=\"system.pages.automator-parent-pages\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(15, 'admin-galeria-uploads-types', 'Gerenciar Tipos de Midia', 'gerenciar-tipos-de-midia', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-midia-types-pagination\"]', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(16, 'admin-api-galeria-uploads-types-get', 'API - Tipos de Midia GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_field_types\" index=\"tbl_sys_field_type_ID\"]', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(17, 'admin-api-galeria-uploads-types-store', 'API - Tipos de Midia STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_sys_uploads_types\" form=\"admin-midia-types\"]', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(18, 'admin-api-galeria-uploads-types-update', 'API - Tipos de Midia UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '[automator function=\"update-data\" table=\"tbl_sys_uploads_types\" index=\"tbl_sys_uploads_type_ID\"]', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(19, 'admin-api-galeria-uploads-types-delete', 'API - Tipos de Midia DELETE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'deleteData', '', '', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(20, 'admin-galeria-uploads', 'Gerenciar Uploads', 'gerenciar-uplodas', 0, 1, 1, 'GET', 'UploadsController', 'index', '', '', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(21, 'admin-api-galeria-uploads-get', 'API - Uploads GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_field_types\" index=\"tbl_sys_field_type_ID\"]', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(22, 'admin-api-galeria-uploads-store', 'API - Uploads STORE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'storeUpload', '', '', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(23, 'admin-api-galeria-uploads-update', 'API - Uploads UPDATE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'updateUpload', '', '', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(24, 'admin-api-galeria-uploads-delete', 'API - Uploads DELETE', NULL, 1, 1, 1, 'POST', 'UploadsController', 'deleteUpload', '', '', NULL, 'restrict', 'ativo', '14', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(25, 'admin-administracao', 'Administração', 'administracao', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '[system-pages view=\"system.pages.automator-parent-pages\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(26, 'admin-routes-apis', 'Gerenciar Rotas de API', 'gerenciar-rotas-apis', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-apis-pagination\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(27, 'admin-api-routes-apis-get', 'API - API\'s GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_routes\" index=\"tbl_sys_route_ID\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(28, 'admin-api-routes-apis-store', 'API - API\'s STORE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'storeRoute', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(29, 'admin-api-routes-apis-update', 'API - API\'s UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRoute', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(30, 'admin-api-routes-apis-delete', 'API - API\'s DELETE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'deleteRoute', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(31, 'admin-api-routes-apis-access', 'API - API\'s Permissões', NULL, 1, 1, 1, 'GET', 'RoutesController', 'getRouteAccess', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(32, 'admin-api-routes-apis-access-update', 'API - API\'s Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRouteAccess', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(33, 'admin-routes', 'Gerenciar Páginas', 'gerenciar-paginas', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-routes-pagination\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(34, 'admin-api-routes-get', 'API - Páginas GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_routes\" index=\"tbl_sys_route_ID\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(35, 'admin-api-routes-store', 'API - Páginas STORE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'storeRoute', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(36, 'admin-api-routes-update', 'API - Páginas UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRoute', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(37, 'admin-api-routes-delete', 'API - Páginas DELETE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'deleteRoute', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(38, 'admin-api-routes-access', 'API - Páginas Permissões', NULL, 1, 1, 1, 'GET', 'RoutesController', 'getRouteAccess', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(39, 'admin-api-routes-access-update', 'API - Páginas Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRouteAccess', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(40, 'admin-navs', 'Gerenciar Navegação', 'gerenciar-navs', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-navs-pagination\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(41, 'admin-api-navs-get', 'API - Navs GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_navs\" index=\"tbl_sys_nav_ID\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(42, 'admin-api-navs-store', 'API - Navs STORE', NULL, 1, 1, 1, 'POST', 'NavsController', 'storeNav', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(43, 'admin-api-navs-update', 'API - Navs UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '[automator function=\"update-data\" table=\"tbl_sys_navs\" index=\"tbl_sys_nav_ID\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(44, 'admin-api-navs-delete', 'API - Navs DELETE', NULL, 1, 1, 1, 'POST', 'NavsController', 'deleteNav', '{id?}', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(45, 'admin-menus', 'Gerenciar Menus', 'gerenciar-menus', 0, 1, 1, 'GET', 'MenusController', 'index', '', '[system-pages view=\"system.pages.gerenciar-menu\" vars=\"$adminMenuPage\"]', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(46, 'admin-api-menus-select', 'API - Menu SELECT', NULL, 1, 1, 1, 'POST', 'MenusController', 'selectMenu', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(47, 'admin-api-menus-update', 'API - Menu UPDATE', NULL, 1, 1, 1, 'POST', 'MenusController', 'updateMenu', '', '', NULL, 'restrict', 'ativo', '25', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(48, 'admin-usuarios', 'Usuários', 'usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'parentPage', '', '[system-pages view=\"system.pages.automator-parent-pages\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(49, 'admin-users-types', 'Gerenciar Tipos de Usuários', 'gerenciar-tipos-de-usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-users-types-pagination\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(50, 'admin-api-users-types-get', 'API - Tipo de Usuário GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_users_types\" index=\"tbl_users_type_ID\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(51, 'admin-api-users-types-store', 'API - Tipo de Usuário STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'storeData', '', '[automator function=\"store-data\" table=\"tbl_users_types\" form=\"admin-users-types\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(52, 'admin-api-users-types-update', 'API - Tipo de Usuário UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'updateData', '', '[automator function=\"update-data\" table=\"tbl_users_types\" index=\"tbl_users_type_ID\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(53, 'admin-api-users-types-delete', 'API - Tipo de Usuário DELETE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'deleteUserType', '{id?}', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(54, 'admin-api-users-types-access', 'API - Tipo de Usuário Permissões', NULL, 1, 1, 1, 'GET', 'UsersTypesController', 'getUserTypeAccess', '{id?}', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(55, 'admin-api-users-types-access-update', 'API - Tipo de Usuário Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'updateUserTypeAccess', '', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(56, 'admin-users', 'Gerenciar Usuários', 'gerenciar-usuarios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-users-pagination\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(57, 'admin-api-users-get', 'API - Usuário GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getDataByModel', '{id?}', '[automator function=\"getDataByModel\" model=\"User\"]', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(58, 'admin-api-users-store', 'API - Usuário STORE', NULL, 1, 1, 1, 'POST', 'UsersController', 'storeUser', '', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(59, 'admin-api-users-update', 'API - Usuário UPDATE', NULL, 1, 1, 1, 'POST', 'UsersController', 'updateUser', '{id?}', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(60, 'admin-api-users-delete', 'API - Usuário DELETE', NULL, 1, 1, 1, 'POST', 'UsersController', 'deleteUser', '{id?}', '', NULL, 'restrict', 'ativo', '48', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(61, 'admin-notifications', 'Gerenciar Notificações', 'gerenciar-notificacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-notifications-pagination\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(62, 'admin-api-notifications-get', 'API - Gerenciar Notificações GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_users\" index=\"tbl_user_ID\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(63, 'admin-api-notifications-store', 'API - Gerenciar Notificações STORE', NULL, 1, 1, 1, 'POST', 'UsersController', 'storeUser', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(64, 'admin-api-notifications-update', 'API - Gerenciar Notificações UPDATE', NULL, 1, 1, 1, 'POST', 'UsersController', 'updateUser', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(65, 'admin-api-notifications-delete', 'API - Gerenciar Notificações DELETE', NULL, 1, 1, 1, 'POST', 'UsersController', 'deleteUser', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(66, 'admin-configs', 'Configurações', 'configuracoes', 0, 1, 1, 'GET', 'SystemController', 'configs', '', '[system-pages view=\"system.pages.configs\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(67, 'admin-api-configs-update', 'API - Configurações UPDATE', NULL, 1, 1, 1, 'POST', 'SystemController', 'storeConfigs', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(68, 'admin-automator', 'Automator', 'automator', 0, 1, 1, 'GET', 'AutomatorController', 'index', '', '[system-pages view=\"system.pages.automator-index\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(69, 'admin-fields', 'Gerenciar Campos', 'gerenciar-campos', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-fields-pagination\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(70, 'admin-api-fields-get', 'API - Campos GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_field_types\" index=\"tbl_sys_field_type_ID\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(71, 'admin-api-fields-store', 'API - Campos STORE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'storeField', '', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(72, 'admin-api-fields-update', 'API - Campos UPDATE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'updateField', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(73, 'admin-api-fields-delete', 'API - Campos DELETE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'deleteField', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(74, 'admin-modulos', 'Gerenciar Módulos', 'gerenciar-modulos', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-modulos-pagination\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(75, 'admin-api-modulos-get', 'API - Módulos GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_modulos\" index=\"tbl_sys_modulo_ID\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(76, 'admin-api-modulos-store', 'API - Módulos STORE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'storeModulo', '', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(77, 'admin-api-modulos-update', 'API - Módulos UPDATE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'updateModulo', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(78, 'admin-api-modulos-delete', 'API - Módulos DELETE', NULL, 1, 1, 1, 'POST', 'ModulosController', 'deleteModulo', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(79, 'admin-forms', 'Gerenciar Formulários', 'gerenciar-formularios', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-forms-pagination\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(80, 'admin-api-forms-get', 'API - Formulários GET', NULL, 1, 0, 1, 'GET', 'FormsController', 'getForm', '{id?}', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(81, 'admin-api-forms-editor-field', 'API - Editor Field POST', NULL, 1, 0, 1, 'POST', 'FormsController', 'getFormEditorField', '{id?}', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(82, 'admin-api-forms-store', 'API - Formulários STORE', NULL, 1, 1, 1, 'POST', 'FormsController', 'storeForm', '', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(83, 'admin-api-forms-update', 'API - Formulários UPDATE', NULL, 1, 1, 1, 'POST', 'FormsController', 'updateForm', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(84, 'admin-api-forms-delete', 'API - Formulários DELETE', NULL, 1, 1, 1, 'POST', 'FormsController', 'deleteForm', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(85, 'admin-api-forms-access', 'API - Formulários Permissões', NULL, 1, 1, 1, 'GET', 'FormsController', 'getFormAccess', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(86, 'admin-api-forms-access-update', 'API - Formulários Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'FormsController', 'updateFormAccess', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(87, 'admin-paginations', 'Gerenciar Paginações', 'gerenciar-paginacoes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-paginations-pagination\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(88, 'admin-api-paginations-get', 'API - Paginations GET', NULL, 1, 1, 1, 'GET', 'PaginationsController', 'getPagination', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(89, 'admin-api-paginations-store', 'API - Paginations STORE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'storePagination', '', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(90, 'admin-api-paginations-update', 'API - Paginations UPDATE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'updatePagination', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(91, 'admin-api-paginations-delete', 'API - Paginations DELETE', NULL, 1, 1, 1, 'POST', 'PaginationsController', 'deletePagination', '{id?}', '', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(92, 'admin-shortcodes', 'Gerenciar Shortcodes', 'gerenciar-shortcodes', 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-shortcodes-pagination\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(93, 'admin-api-shortcodes-get', 'API - Shortcodes GET', NULL, 1, 1, 1, 'GET', 'AutomatorController', 'getData', '{id?}', '[automator function=\"get-data\" table=\"tbl_sys_shortcodes\" index=\"tbl_sys_shortcode_ID\"]', NULL, 'restrict', 'ativo', '', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(94, 'admin-api-shortcodes-store', 'API - Shortcodes STORE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '', '[automator function=\"store-data\" table=\"tbl_sys_shortcodes\" form=\"admin-shortcodes\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(95, 'admin-api-shortcodes-update', 'API - Shortcodes UPDATE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '{id?}', '[automator function=\"update-data\" table=\"tbl_sys_shortcodes\" form=\"admin-shortcodes\" index=\"tbl_sys_shortcode_ID\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(96, 'admin-api-shortcodes-delete', 'API - Shortcodes DELETE', NULL, 1, 1, 1, 'POST', 'AutomatorController', 'getFunction', '{id?}', '[automator function=\"delete-data\" table=\"tbl_sys_shortcodes\" index=\"tbl_sys_shortcode_ID\"]', NULL, 'restrict', 'ativo', '68', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(97, 'admin-languages', 'Gerenciar Idiomas', NULL, 0, 1, 1, 'GET', 'AutomatorController', 'getFunction', '', '[automator function=\"pagination\" name=\"admin-languages-pagination\"]', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(98, 'admin-api-languages-get', 'API - Idiomas GET', NULL, 1, 1, 1, 'GET', 'TranslationsController', 'getTranslation', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(99, 'admin-api-languages-store', 'API - Idiomas STORE', NULL, 1, 1, 1, 'POST', 'TranslationsController', 'storeTranslation', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(100, 'admin-api-languages-update', 'API - Idiomas UPDATE', NULL, 1, 1, 1, 'POST', 'TranslationsController', 'updateTranslation', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(101, 'admin-api-languages-delete', 'API - Idiomas DELETE', NULL, 1, 1, 1, 'POST', 'TranslationsController', 'deleteTranslation', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(102, 'admin-languages-words', 'Gerenciar Idiomas - Traduções', NULL, 0, 1, 1, 'GET', 'TranslationsWordsController', 'index', '{lang?}', '[system-pages view=\"system.pages.pagination\"]', NULL, 'restrict', 'ativo', '97', '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(103, 'admin-api-languages-words-get', 'API - Idiomas Traduções GET', NULL, 1, 1, 1, 'GET', 'TranslationsWordsController', 'getTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(104, 'admin-api-languages-words-store', 'API - Idiomas Traduções STORE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'storeTranslationWord', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(105, 'admin-api-languages-words-update', 'API - Idiomas Traduções UPDATE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'updateTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(106, 'admin-api-languages-words-delete', 'API - Idiomas Traduções DELETE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'deleteTranslationWord', '{id?}', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(107, 'admin-api-functions', 'API - Funções Admin', NULL, 1, 1, 1, 'POST', 'SystemController', 'adminFunctions', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(108, 'admin-api-view-get', 'API - Get Views', NULL, 1, 0, 1, 'POST', 'SystemController', 'adminGetView', '', '', NULL, 'public', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21'),
(109, 'admin-api-logout', 'API - Logout', NULL, 1, 1, 1, 'POST', 'SystemController', 'logout', '', '', NULL, 'restrict', 'ativo', NULL, '2026-06-06 12:57:21', '2026-06-06 12:57:21');

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
(1, 1, 8, '2026-06-06 09:57:21'),
(2, 2, 8, '2026-06-06 09:57:21'),
(3, 3, 8, '2026-06-06 09:57:21'),
(4, 4, 8, '2026-06-06 09:57:21'),
(5, 1, 9, '2026-06-06 09:57:21'),
(6, 2, 9, '2026-06-06 09:57:21'),
(7, 3, 9, '2026-06-06 09:57:21'),
(8, 4, 9, '2026-06-06 09:57:21'),
(9, 1, 10, '2026-06-06 09:57:21'),
(10, 2, 10, '2026-06-06 09:57:21'),
(11, 3, 10, '2026-06-06 09:57:21'),
(12, 4, 10, '2026-06-06 09:57:21'),
(13, 1, 11, '2026-06-06 09:57:21'),
(14, 2, 11, '2026-06-06 09:57:21'),
(15, 3, 11, '2026-06-06 09:57:21'),
(16, 4, 11, '2026-06-06 09:57:21'),
(17, 1, 12, '2026-06-06 09:57:21'),
(18, 2, 12, '2026-06-06 09:57:21'),
(19, 3, 12, '2026-06-06 09:57:21'),
(20, 4, 12, '2026-06-06 09:57:21'),
(21, 1, 13, '2026-06-06 09:57:21'),
(22, 2, 13, '2026-06-06 09:57:21'),
(23, 3, 13, '2026-06-06 09:57:21'),
(24, 4, 13, '2026-06-06 09:57:21'),
(25, 1, 14, '2026-06-06 09:57:21'),
(26, 2, 14, '2026-06-06 09:57:21'),
(27, 1, 15, '2026-06-06 09:57:21'),
(28, 2, 15, '2026-06-06 09:57:21'),
(29, 1, 16, '2026-06-06 09:57:21'),
(30, 2, 16, '2026-06-06 09:57:21'),
(31, 1, 17, '2026-06-06 09:57:21'),
(32, 2, 17, '2026-06-06 09:57:21'),
(33, 1, 18, '2026-06-06 09:57:21'),
(34, 2, 18, '2026-06-06 09:57:21'),
(35, 1, 19, '2026-06-06 09:57:21'),
(36, 2, 19, '2026-06-06 09:57:21'),
(37, 1, 20, '2026-06-06 09:57:21'),
(38, 2, 20, '2026-06-06 09:57:21'),
(39, 1, 21, '2026-06-06 09:57:21'),
(40, 2, 21, '2026-06-06 09:57:21'),
(41, 1, 22, '2026-06-06 09:57:21'),
(42, 2, 22, '2026-06-06 09:57:21'),
(43, 1, 23, '2026-06-06 09:57:21'),
(44, 2, 23, '2026-06-06 09:57:21'),
(45, 1, 24, '2026-06-06 09:57:21'),
(46, 2, 24, '2026-06-06 09:57:21'),
(47, 1, 25, '2026-06-06 09:57:21'),
(48, 2, 25, '2026-06-06 09:57:21'),
(49, 1, 26, '2026-06-06 09:57:21'),
(50, 2, 26, '2026-06-06 09:57:21'),
(51, 1, 27, '2026-06-06 09:57:21'),
(52, 2, 27, '2026-06-06 09:57:21'),
(53, 1, 28, '2026-06-06 09:57:21'),
(54, 2, 28, '2026-06-06 09:57:21'),
(55, 1, 29, '2026-06-06 09:57:21'),
(56, 2, 29, '2026-06-06 09:57:21'),
(57, 1, 30, '2026-06-06 09:57:21'),
(58, 2, 30, '2026-06-06 09:57:21'),
(59, 1, 31, '2026-06-06 09:57:21'),
(60, 2, 31, '2026-06-06 09:57:21'),
(61, 1, 32, '2026-06-06 09:57:21'),
(62, 2, 32, '2026-06-06 09:57:21'),
(63, 1, 33, '2026-06-06 09:57:21'),
(64, 2, 33, '2026-06-06 09:57:21'),
(65, 1, 34, '2026-06-06 09:57:21'),
(66, 2, 34, '2026-06-06 09:57:21'),
(67, 1, 35, '2026-06-06 09:57:21'),
(68, 2, 35, '2026-06-06 09:57:21'),
(69, 1, 36, '2026-06-06 09:57:21'),
(70, 2, 36, '2026-06-06 09:57:21'),
(71, 1, 37, '2026-06-06 09:57:21'),
(72, 2, 37, '2026-06-06 09:57:21'),
(73, 1, 38, '2026-06-06 09:57:21'),
(74, 2, 38, '2026-06-06 09:57:21'),
(75, 1, 39, '2026-06-06 09:57:21'),
(76, 2, 39, '2026-06-06 09:57:21'),
(77, 1, 40, '2026-06-06 09:57:21'),
(78, 2, 40, '2026-06-06 09:57:21'),
(79, 1, 41, '2026-06-06 09:57:21'),
(80, 2, 41, '2026-06-06 09:57:21'),
(81, 1, 42, '2026-06-06 09:57:21'),
(82, 2, 42, '2026-06-06 09:57:21'),
(83, 1, 43, '2026-06-06 09:57:21'),
(84, 2, 43, '2026-06-06 09:57:21'),
(85, 1, 44, '2026-06-06 09:57:21'),
(86, 2, 44, '2026-06-06 09:57:21'),
(87, 1, 45, '2026-06-06 09:57:21'),
(88, 2, 45, '2026-06-06 09:57:21'),
(89, 1, 46, '2026-06-06 09:57:21'),
(90, 2, 46, '2026-06-06 09:57:21'),
(91, 1, 47, '2026-06-06 09:57:21'),
(92, 2, 47, '2026-06-06 09:57:21'),
(93, 1, 48, '2026-06-06 09:57:21'),
(94, 2, 48, '2026-06-06 09:57:21'),
(95, 1, 49, '2026-06-06 09:57:21'),
(96, 2, 49, '2026-06-06 09:57:21'),
(97, 1, 50, '2026-06-06 09:57:21'),
(98, 2, 50, '2026-06-06 09:57:21'),
(99, 1, 51, '2026-06-06 09:57:21'),
(100, 2, 51, '2026-06-06 09:57:21'),
(101, 1, 52, '2026-06-06 09:57:21'),
(102, 2, 52, '2026-06-06 09:57:21'),
(103, 1, 53, '2026-06-06 09:57:21'),
(104, 2, 53, '2026-06-06 09:57:21'),
(105, 1, 54, '2026-06-06 09:57:21'),
(106, 2, 54, '2026-06-06 09:57:21'),
(107, 1, 55, '2026-06-06 09:57:21'),
(108, 2, 55, '2026-06-06 09:57:21'),
(109, 1, 56, '2026-06-06 09:57:21'),
(110, 2, 56, '2026-06-06 09:57:21'),
(111, 1, 57, '2026-06-06 09:57:21'),
(112, 2, 57, '2026-06-06 09:57:21'),
(113, 1, 58, '2026-06-06 09:57:21'),
(114, 2, 58, '2026-06-06 09:57:21'),
(115, 1, 59, '2026-06-06 09:57:21'),
(116, 2, 59, '2026-06-06 09:57:21'),
(117, 1, 60, '2026-06-06 09:57:21'),
(118, 2, 60, '2026-06-06 09:57:21'),
(119, 1, 61, '2026-06-06 09:57:21'),
(120, 2, 61, '2026-06-06 09:57:21'),
(121, 1, 62, '2026-06-06 09:57:21'),
(122, 2, 62, '2026-06-06 09:57:21'),
(123, 1, 63, '2026-06-06 09:57:21'),
(124, 2, 63, '2026-06-06 09:57:21'),
(125, 1, 64, '2026-06-06 09:57:21'),
(126, 2, 64, '2026-06-06 09:57:21'),
(127, 1, 65, '2026-06-06 09:57:21'),
(128, 2, 65, '2026-06-06 09:57:21'),
(129, 1, 66, '2026-06-06 09:57:21'),
(130, 2, 66, '2026-06-06 09:57:21'),
(131, 1, 67, '2026-06-06 09:57:21'),
(132, 2, 67, '2026-06-06 09:57:21'),
(133, 1, 68, '2026-06-06 09:57:21'),
(134, 2, 68, '2026-06-06 09:57:21'),
(135, 1, 69, '2026-06-06 09:57:21'),
(136, 1, 70, '2026-06-06 09:57:21'),
(137, 1, 71, '2026-06-06 09:57:21'),
(138, 1, 72, '2026-06-06 09:57:21'),
(139, 1, 73, '2026-06-06 09:57:21'),
(140, 1, 74, '2026-06-06 09:57:21'),
(141, 2, 74, '2026-06-06 09:57:21'),
(142, 1, 75, '2026-06-06 09:57:21'),
(143, 2, 75, '2026-06-06 09:57:21'),
(144, 1, 76, '2026-06-06 09:57:21'),
(145, 2, 76, '2026-06-06 09:57:21'),
(146, 1, 77, '2026-06-06 09:57:21'),
(147, 2, 77, '2026-06-06 09:57:21'),
(148, 1, 78, '2026-06-06 09:57:21'),
(149, 2, 78, '2026-06-06 09:57:21'),
(150, 1, 79, '2026-06-06 09:57:21'),
(151, 2, 79, '2026-06-06 09:57:21'),
(152, 1, 82, '2026-06-06 09:57:21'),
(153, 2, 82, '2026-06-06 09:57:21'),
(154, 1, 83, '2026-06-06 09:57:21'),
(155, 2, 83, '2026-06-06 09:57:21'),
(156, 1, 84, '2026-06-06 09:57:21'),
(157, 2, 84, '2026-06-06 09:57:21'),
(158, 1, 85, '2026-06-06 09:57:21'),
(159, 2, 85, '2026-06-06 09:57:21'),
(160, 1, 86, '2026-06-06 09:57:21'),
(161, 2, 86, '2026-06-06 09:57:21'),
(162, 1, 87, '2026-06-06 09:57:21'),
(163, 2, 87, '2026-06-06 09:57:21'),
(164, 1, 88, '2026-06-06 09:57:21'),
(165, 2, 88, '2026-06-06 09:57:21'),
(166, 1, 89, '2026-06-06 09:57:21'),
(167, 2, 89, '2026-06-06 09:57:21'),
(168, 1, 90, '2026-06-06 09:57:21'),
(169, 2, 90, '2026-06-06 09:57:21'),
(170, 1, 91, '2026-06-06 09:57:21'),
(171, 2, 91, '2026-06-06 09:57:21'),
(172, 1, 92, '2026-06-06 09:57:21'),
(173, 1, 93, '2026-06-06 09:57:21'),
(174, 1, 94, '2026-06-06 09:57:21'),
(175, 1, 95, '2026-06-06 09:57:21'),
(176, 1, 96, '2026-06-06 09:57:21'),
(177, 2, 96, '2026-06-06 09:57:21'),
(178, 1, 97, '2026-06-06 09:57:21'),
(179, 2, 97, '2026-06-06 09:57:21'),
(180, 1, 98, '2026-06-06 09:57:21'),
(181, 2, 98, '2026-06-06 09:57:21'),
(182, 1, 99, '2026-06-06 09:57:21'),
(183, 2, 99, '2026-06-06 09:57:21'),
(184, 1, 100, '2026-06-06 09:57:21'),
(185, 2, 100, '2026-06-06 09:57:21'),
(186, 1, 101, '2026-06-06 09:57:21'),
(187, 2, 101, '2026-06-06 09:57:21'),
(188, 1, 102, '2026-06-06 09:57:21'),
(189, 2, 102, '2026-06-06 09:57:21'),
(190, 1, 103, '2026-06-06 09:57:21'),
(191, 2, 103, '2026-06-06 09:57:21'),
(192, 1, 104, '2026-06-06 09:57:21'),
(193, 2, 104, '2026-06-06 09:57:21'),
(194, 1, 105, '2026-06-06 09:57:21'),
(195, 2, 105, '2026-06-06 09:57:21'),
(196, 1, 106, '2026-06-06 09:57:21'),
(197, 2, 106, '2026-06-06 09:57:21'),
(198, 1, 107, '2026-06-06 09:57:21'),
(199, 2, 107, '2026-06-06 09:57:21'),
(200, 3, 107, '2026-06-06 09:57:21'),
(201, 4, 107, '2026-06-06 09:57:21'),
(202, 1, 109, '2026-06-06 09:57:21'),
(203, 2, 109, '2026-06-06 09:57:21'),
(204, 3, 109, '2026-06-06 09:57:21'),
(205, 4, 109, '2026-06-06 09:57:21');

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
(1, 'automator', 'Automator', 'Função nativa do sistema para gerar e carregar de forma dinamica as ações do sistema.', 'AutomatorController', 'getFunction', '{\"function\":true,\"name\":false,\"form\":false,\"table\":false,\"index\":false}', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(2, 'system-pages', 'Carregador de view', 'Função nativa do sistema para carregar de forma dinamica as views dentro do sistema.', 'SystemController', 'SystemLoadPageContent', '{\"view\":true,\"vars\":false,\"args\":false}', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22'),
(3, 'system-form', 'Formulário do sistema', 'Função nativa do sistema para gerar e renderizar de forma dinamica os formulários registrados no sistema.', 'SysAutomator', 'SysAutomatorRenderFormByID', '{\"form\":true,\"vars\":false}', 1, '2026-06-06 12:57:22', '2026-06-06 12:57:22');

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
(1, 'pt-br', 'Português (Brasil)', 'Português do Brasil', 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20');

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
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_uploads_access`
--

CREATE TABLE `tbl_sys_uploads_access` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_uploads_types`
--

CREATE TABLE `tbl_sys_uploads_types` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'developer', 'Desenvolvedor', 'dev@automator.test', '$2y$12$gXfcvPNfOR.zXaHFp2Es0.vg8Qi3c6QIUo2yNVOGCGeGh7eCBT2Da', NULL, 'ativo', 0, 1, '2026-06-06 12:57:20', '2026-06-29 17:08:30', NULL, 'YB5RGznj2mRIUtFVHva8U8CuoZgtzVZqkdw9LS66LLDHsMApQZSyoacvimiP'),
(2, 'admin', 'Administrador', 'admin@automator.test', '$2y$12$PUHxB2lWxCq2g83vVkPzlOC9wrEELafPtCLiai7I0mjU10axrnyh6', NULL, 'ativo', 0, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20', NULL, NULL),
(3, 'user', 'Usuário', 'user@automator.test', '$2y$12$HDmhMxIQXZ2N6nMynLqd5uti5hCfDQiZhs5W4JOVySJhVMoHSlok6', NULL, 'ativo', 0, 1, '2026-06-06 12:57:20', '2026-06-06 12:57:20', NULL, NULL);

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
('sWBdCGUYtTD4QqtiVR35vJhnJjJ6NOE1TYcl70aj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJBZEIzQXJGaDc2UFJ6SmJtUmFoeU92V1I3YlZzVlBTcUZLVml4WjVjIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwczpcL1wvYXV0b21hdG9ydjIudGVzdFwvYWRtaW5cL2Rhc2hib2FyZCIsInJvdXRlIjoicGFnZS5hZG1pbi1kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1782784340);

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
(1, 'Desenvolvedor', 'Usuário responsável por gerenciar e controlar todas as funcionalidades do sistema.', 1, 'ativo', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(2, 'Administrador', 'Usuário responsável por administrar todos os conteúdos e informações do sistema.', 1, 'ativo', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(3, 'Usuário', 'Usuário padrão do sistema com acesso as funcionalidades restritas do sistemas que contem acesso.', 1, 'ativo', '2026-06-06 12:57:20', '2026-06-06 12:57:20'),
(4, 'Novo', 'Usuario para testes de desenvolvimento.', 0, 'ativo', '2026-06-06 12:57:20', '2026-06-06 12:57:20');

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
(1, 1, 3, '2026-06-06 09:57:20'),
(2, 1, 1, '2026-06-06 09:57:20'),
(3, 2, 3, '2026-06-06 09:57:20'),
(4, 2, 2, '2026-06-06 09:57:20'),
(5, 3, 3, '2026-06-06 09:57:20');

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
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_sys_uploads_access`
--
ALTER TABLE `tbl_sys_uploads_access`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_sys_uploads_types`
--
ALTER TABLE `tbl_sys_uploads_types`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `tbl_sys_config_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tbl_sys_field_types`
--
ALTER TABLE `tbl_sys_field_types`
  MODIFY `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `tbl_sys_field_types_groups`
--
ALTER TABLE `tbl_sys_field_types_groups`
  MODIFY `tbl_sys_field_type_group_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms`
--
ALTER TABLE `tbl_sys_forms`
  MODIFY `tbl_sys_form_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_access`
--
ALTER TABLE `tbl_sys_forms_access`
  MODIFY `tbl_sys_forms_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_fields`
--
ALTER TABLE `tbl_sys_forms_fields`
  MODIFY `tbl_sys_forms_field_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `tbl_sys_forms_fields_access`
--
ALTER TABLE `tbl_sys_forms_fields_access`
  MODIFY `tbl_sys_forms_fields_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de tabela `tbl_sys_functions`
--
ALTER TABLE `tbl_sys_functions`
  MODIFY `tbl_sys_function_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus`
--
ALTER TABLE `tbl_sys_menus`
  MODIFY `tbl_sys_menu_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_access`
--
ALTER TABLE `tbl_sys_menus_access`
  MODIFY `tbl_menus_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_items`
--
ALTER TABLE `tbl_sys_menus_items`
  MODIFY `tbl_sys_menu_item_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `tbl_sys_menus_item_access`
--
ALTER TABLE `tbl_sys_menus_item_access`
  MODIFY `tbl_menus_item_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `tbl_sys_pagination_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_args`
--
ALTER TABLE `tbl_sys_paginations_args`
  MODIFY `tbl_sys_paginations_arg_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_cols`
--
ALTER TABLE `tbl_sys_paginations_cols`
  MODIFY `tbl_sys_paginations_col_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `tbl_sys_paginations_cols_access`
--
ALTER TABLE `tbl_sys_paginations_cols_access`
  MODIFY `tbl_sys_pagination_col_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes`
--
ALTER TABLE `tbl_sys_routes`
  MODIFY `tbl_sys_route_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes_access`
--
ALTER TABLE `tbl_sys_routes_access`
  MODIFY `tbl_routes_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_uploads_access`
--
ALTER TABLE `tbl_sys_uploads_access`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_uploads_types`
--
ALTER TABLE `tbl_sys_uploads_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Restrições para tabelas `tbl_users_types_rels`
--
ALTER TABLE `tbl_users_types_rels`
  ADD CONSTRAINT `tbl_users_types_rels_tbl_user_id_foreign` FOREIGN KEY (`tbl_user_ID`) REFERENCES `tbl_users` (`tbl_user_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_users_types_rels_tbl_users_type_id_foreign` FOREIGN KEY (`tbl_users_type_ID`) REFERENCES `tbl_users_types` (`tbl_users_type_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
