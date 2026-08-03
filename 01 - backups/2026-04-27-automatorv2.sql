-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 27/04/2026 às 19:04
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
(8, '2026_04_24_140111_create_sys_functions_table', 1),
(9, '2026_04_24_142449_create_sys_translations_table', 1),
(10, '2026_04_24_142519_create_sys_translations_words_table', 1),
(11, '2026_04_24_172334_create_sys_field_types_table', 1),
(12, '2026_04_24_175130_create_sys_routes_access_table', 1);

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
(1, 'system-default-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Idioma do sistema\"]', 'pt-br', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(2, 'system-multi-language', '[sysfunction return=\"string\" fn=\"translate\" params=\"Habilitar seleção de Idiomas\"]', 'false', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(3, 'site-home', '[sysfunction return=\"string\" fn=\"translate\" params=\"Página inicial do site\"]', '/', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(4, 'system-admin', '[sysfunction return=\"string\" fn=\"translate\" params=\"URL de administração\"]', '/admin/', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(5, 'site-title', '[sysfunction return=\"string\" fn=\"translate\" params=\"Título do site\"]', 'Automator v2', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(6, 'site-description', '[sysfunction return=\"string\" fn=\"translate\" params=\"Descrição do site\"]', 'Sistema de gerenciamento de informações automatizado.', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(7, 'site-favicon', '[sysfunction return=\"string\" fn=\"translate\" params=\"Ícone do site\"]', '', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(8, 'site-logo', '[sysfunction return=\"string\" fn=\"translate\" params=\"Logo do site\"]', '', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(9, 'system-enable-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Registro público liberado\"]', 'false', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(10, 'site-default-user-type-register', '[sysfunction return=\"string\" fn=\"translate\" params=\"Tipo de usuário padrão de cadastro\"]', '3', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(11, 'system-enable-date-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de datas do sistema\"]', '{\'j \\d F \\d Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"j \\d\\e F \\d\\e Y\";\"sysconfig(system-default-language)\"]\', \'Y-m-d\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"Y-m-d\";\"sysconfig(system-default-language)\"]\', \'m/d/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"m/d/Y\";\"sysconfig(system-default-language)\"]\', \'d/m/Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d/m/Y\";\"sysconfig(system-default-language)\"]\', \'d.m.Y\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"d.m.Y\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(12, 'system-default-date-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de data\"]', 'Y-m-d', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(13, 'system-enable-time-formats', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de horas do sistema\"]', '{\'H:i\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"H:i\"]\', \'g:i A\': \'[sysfunction return=\"string\" fn=\"sysDateFormat\" params=\"g:i A\";\"sysconfig(system-default-language)\"]\', \'custom\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"Personalizado\"]\'}', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(14, 'system-default-time-format', '[sysfunction return=\"string\" fn=\"translate\" params=\"Formato de hora\"]', 'H:i', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(15, 'system-week-days-name', '[sysfunction return=\"string\" fn=\"translate\" params=\"Nome dos dias da semana\"]', '{\'1\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"segunda-feira\"]\', \'2\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"terça-feira\"]\', \'3\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quarta-feira\"]\', \'4\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"quinta-feira\"]\', \'5\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sexta-feira\"]\', \'6\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"sábado\"]\', \'7\': \'[sysfunction return=\"string\" fn=\"translate\" params=\"domingo\"]\'}', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(16, 'system-default-week-day-start', '[sysfunction return=\"string\" fn=\"translate\" params=\"Dia de inicio da semana\"]', '1', '2026-04-27 04:01:48', '2026-04-27 04:01:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_sys_field_types`
--

CREATE TABLE `tbl_sys_field_types` (
  `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL,
  `tbl_sys_field_type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_sys_field_type_classe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_field_type_description` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_params` text COLLATE utf8mb4_unicode_ci,
  `tbl_sys_field_type_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_field_type_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'custom', 'translate', 'AutomatorTranslate', '{\'word\': true, \'lang\': false}', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(2, 'custom', 'sysDateFormat', 'AutomatorDateFormat', '{\'date\': true, \'translate\': false}', '2026-04-27 04:01:48', '2026-04-27 04:01:48');

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
  `tbl_sys_route_area` enum('public','restrict') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `tbl_sys_route_status` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ativo',
  `tbl_sys_route_parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tbl_sys_route_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tbl_sys_route_updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tbl_sys_routes`
--

INSERT INTO `tbl_sys_routes` (`tbl_sys_route_ID`, `tbl_sys_route_name`, `tbl_sys_route_title`, `tbl_sys_route_permalink`, `tbl_sys_route_api`, `tbl_sys_route_admin`, `tbl_sys_route_locked`, `tbl_sys_route_type`, `tbl_sys_route_controller`, `tbl_sys_route_method`, `tbl_sys_route_args`, `tbl_sys_route_content`, `tbl_sys_route_area`, `tbl_sys_route_status`, `tbl_sys_route_parent_id`, `tbl_sys_route_created_at`, `tbl_sys_route_updated_at`) VALUES
(1, 'index', 'Home', '/', 0, 0, 1, 'GET', 'SiteController', 'index', '', '', 'public', 'ativo', '', '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(2, 'admin-login', 'Login', NULL, 0, 1, 1, 'GET', 'SystemController', 'login', '', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(3, 'admin-api-login', 'API Login', NULL, 1, 1, 1, 'POST', 'SystemController', 'loginAPI', '', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(4, 'admin-esqueci-minha-senha', 'Esqueci minha senha', NULL, 0, 1, 1, 'GET', 'SystemController', 'forgetPassword', '', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(5, 'admin-api-esqueci-minha-senha', 'API - Esqueci minha senha', NULL, 1, 1, 1, 'POST', 'SystemController', 'forgetPasswordAPI', '', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(6, 'admin-recuperar-conta', 'Recuperar conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'recoverAccount', '{token}', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(7, 'admin-api-recuperar-conta', 'API - Recuperar conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'recoverAccountAPI', '', '', 'public', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(8, 'admin-dashboard', 'Dashboard', NULL, 0, 1, 1, 'GET', 'SystemController', 'dashboard', '', '[system-page view=\"system.pages.dashboard\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(9, 'admin-minha-conta', 'Minha Conta', NULL, 0, 1, 1, 'GET', 'SystemController', 'myAccount', '', '[system-pages view=\"system.pages.minha-conta\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(10, 'admin-api-minha-conta', 'API - Minha Conta', NULL, 1, 1, 1, 'POST', 'SystemController', 'myAccountAPI', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(11, 'admin-routes', 'Gerenciar Páginas', 'gerenciar-paginas', 0, 1, 1, 'GET', 'RoutesController', 'index', '', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(12, 'admin-routes-get', 'API - Páginas GET', NULL, 1, 1, 1, 'GET', 'RoutesController', 'getRoute', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(13, 'admin-routes-store', 'API - Páginas STORE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'storeRoute', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(14, 'admin-routes-update', 'API - Páginas UPDATE', NULL, 1, 1, 1, 'PUT', 'RoutesController', 'updateRoute', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(15, 'routes-delete', 'API - Páginas DELETE', NULL, 1, 1, 1, 'DELETE', 'RoutesController', 'deleteRoute', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(16, 'admin-routes-access', 'API - Páginas Permissões', NULL, 1, 1, 1, 'GET', 'RoutesController', 'geRouteAccess', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(17, 'admin-routes-access-update', 'API - Páginas Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'RoutesController', 'updateRouteAccess', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(18, 'admin-users-types', 'Gerenciar Tipos de Usuários', 'gerenciar-tipos-de-usuarios', 0, 1, 1, 'GET', 'UsersTypesController', 'index', '', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(19, 'admin-users-types-get', 'API - Tipo de Usuário GET', NULL, 1, 1, 1, 'GET', 'UsersTypesController', 'getUserType', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(20, 'admin-users-types-store', 'API - Tipo de Usuário STORE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'storeUserType', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(21, 'admin-users-types-update', 'API - Tipo de Usuário UPDATE', NULL, 1, 1, 1, 'PUT', 'UsersTypesController', 'updateUserType', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(22, 'admin-users-types-delete', 'API - Tipo de Usuário DELETE', NULL, 1, 1, 1, 'DELETE', 'UsersTypesController', 'deleteUserType', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(23, 'admin-users-types-access', 'API - Tipo de Usuário Permissões', NULL, 1, 1, 1, 'GET', 'UsersTypesController', 'getUserTypeAccess', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(24, 'admin-users-types-access-update', 'API - Tipo de Usuário Permissões UPDATE', NULL, 1, 1, 1, 'POST', 'UsersTypesController', 'updateUserTypeAccess', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(25, 'admin-users', 'Gerenciar Usuários', 'gerenciar-usuarios', 0, 1, 1, 'GET', 'UsersController', 'index', '', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(26, 'admin-users-get', 'API - Usuário GET', NULL, 1, 1, 1, 'GET', 'UsersController', 'getUser', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(27, 'admin-users-store', 'API - Usuário STORE', NULL, 1, 1, 1, 'POST', 'UsersController', 'storeUser', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(28, 'admin-users-update', 'API - Usuário UPDATE', NULL, 1, 1, 1, 'PUT', 'UsersController', 'updateUser', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(29, 'admin-users-delete', 'API - Usuário DELETE', NULL, 1, 1, 1, 'DELETE', 'UsersController', 'deleteUser', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(30, 'admin-configs', 'Configurações', 'configuracoes', 0, 1, 1, 'GET', 'SystemController', 'configs', '', '[system-pages view=\"system.pages.configs\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(31, 'admin-configs-update', 'API - Configurações UPDATE', NULL, 1, 1, 1, 'POST', 'SystemController', 'storeConfigs', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(32, 'admin-automator', 'Automator', NULL, 0, 1, 1, 'GET', 'AutomatorController', 'index', '', '[system-pages view=\"system.pages.automator-index\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(33, 'admin-languages', 'Gerenciar Idiomas', NULL, 0, 1, 1, 'GET', 'TranslationsController', 'index', '', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(34, 'admin-languages-get', 'API - Idiomas GET', NULL, 1, 1, 1, 'GET', 'TranslationsController', 'getTranslation', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(35, 'admin-languages-store', 'API - Idiomas STORE', NULL, 1, 1, 1, 'POST', 'TranslationsController', 'storeTranslation', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(36, 'admin-languages-update', 'API - Idiomas UPDATE', NULL, 1, 1, 1, 'PUT', 'TranslationsController', 'updateTranslation', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(37, 'admin-languages-delete', 'API - Idiomas DELETE', NULL, 1, 1, 1, 'DELETE', 'TranslationsController', 'deleteTranslation', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(38, 'admin-languages-words', 'Gerenciar Idiomas - Traduções', NULL, 0, 1, 1, 'GET', 'TranslationsWordsController', 'index', '{lang?}', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(39, 'admin-languages-words-get', 'API - Idiomas Traduções GET', NULL, 1, 1, 1, 'GET', 'TranslationsWordsController', 'getTranslationWord', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(40, 'admin-languages-words-store', 'API - Idiomas Traduções STORE', NULL, 1, 1, 1, 'POST', 'TranslationsWordsController', 'storeTranslationWord', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(41, 'admin-languages-words-update', 'API - Idiomas Traduções UPDATE', NULL, 1, 1, 1, 'PUT', 'TranslationsWordsController', 'updateTranslationWord', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(42, 'admin-languages-words-delete', 'API - Idiomas Traduções DELETE', NULL, 1, 1, 1, 'DELETE', 'TranslationsWordsController', 'deleteTranslationWord', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(43, 'admin-fields', 'Gerenciar Campos', 'gerenciar-campos', 0, 1, 1, 'GET', 'FieldsTypesController', 'index', '', '[system-pages view=\"system.pages.pagination\"]', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(44, 'admin-fields-get', 'API - Campos GET', NULL, 1, 1, 1, 'GET', 'FieldsTypesController', 'getField', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(45, 'admin-fields-store', 'API - Campos STORE', NULL, 1, 1, 1, 'POST', 'FieldsTypesController', 'storeField', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(46, 'admin-fields-update', 'API - Campos UPDATE', NULL, 1, 1, 1, 'PUT', 'FieldsTypesController', 'updateField', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(47, 'admin-fields-delete', 'API - Campos DELETE', NULL, 1, 1, 1, 'DELETE', 'FieldsTypesController', 'deleteField', '{id?}', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 04:01:49'),
(48, 'admin-api-logout', 'API - Logout', NULL, 1, 1, 1, 'POST', 'SystemController', 'logout', '', '', 'restrict', 'ativo', NULL, '2026-04-27 04:01:49', '2026-04-27 17:48:16');

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
(1, 1, 8, '2026-04-27 01:01:49'),
(2, 1, 9, '2026-04-27 01:01:49'),
(3, 1, 10, '2026-04-27 01:01:49'),
(4, 1, 11, '2026-04-27 01:01:49'),
(5, 1, 12, '2026-04-27 01:01:49'),
(6, 1, 13, '2026-04-27 01:01:49'),
(7, 1, 14, '2026-04-27 01:01:49'),
(8, 1, 15, '2026-04-27 01:01:49'),
(9, 1, 16, '2026-04-27 01:01:49'),
(10, 1, 17, '2026-04-27 01:01:49'),
(11, 1, 18, '2026-04-27 01:01:49'),
(12, 1, 19, '2026-04-27 01:01:49'),
(13, 1, 20, '2026-04-27 01:01:49'),
(14, 1, 21, '2026-04-27 01:01:49'),
(15, 1, 22, '2026-04-27 01:01:49'),
(16, 1, 23, '2026-04-27 01:01:49'),
(17, 1, 24, '2026-04-27 01:01:49'),
(18, 1, 25, '2026-04-27 01:01:49'),
(19, 1, 26, '2026-04-27 01:01:49'),
(20, 1, 27, '2026-04-27 01:01:49'),
(21, 1, 28, '2026-04-27 01:01:49'),
(22, 1, 29, '2026-04-27 01:01:49'),
(23, 1, 30, '2026-04-27 01:01:49'),
(24, 1, 31, '2026-04-27 01:01:49'),
(25, 1, 32, '2026-04-27 01:01:49'),
(26, 1, 33, '2026-04-27 01:01:49'),
(27, 1, 34, '2026-04-27 01:01:49'),
(28, 1, 35, '2026-04-27 01:01:49'),
(29, 1, 36, '2026-04-27 01:01:49'),
(30, 1, 37, '2026-04-27 01:01:49'),
(31, 1, 38, '2026-04-27 01:01:49'),
(32, 1, 39, '2026-04-27 01:01:49'),
(33, 1, 40, '2026-04-27 01:01:49'),
(34, 1, 41, '2026-04-27 01:01:49'),
(35, 1, 42, '2026-04-27 01:01:49'),
(36, 1, 43, '2026-04-27 01:01:49'),
(37, 1, 44, '2026-04-27 01:01:49'),
(38, 1, 45, '2026-04-27 01:01:49'),
(39, 1, 46, '2026-04-27 01:01:49'),
(40, 1, 47, '2026-04-27 01:01:49'),
(41, 1, 48, '2026-04-27 01:01:49');

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
(1, 'pt-br', 'Português (Brasil)', 'Português do Brasil', 1, '2026-04-27 04:01:48', '2026-04-27 04:01:48');

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
(1, 'developer', 'Desenvolvedor', 'dev@automator.test', '$2y$12$3k2yWs6cRqeewomhhpzufOsxmbM0KHdE6dg.8GsTdr2ekRpSktsC.', NULL, 'ativo', 0, 1, '2026-04-27 04:01:48', '2026-04-27 04:01:48', NULL, NULL),
(2, 'admin', 'Administrador', 'admin@automator.test', '$2y$12$S2aznZpfliTdfL5OyDPkS.VmpaS31MxGjYx3N9tOtoIaTkB/aOk/i', NULL, 'ativo', 0, 1, '2026-04-27 04:01:49', '2026-04-27 04:01:49', NULL, NULL),
(3, 'user', 'Usuário', 'user@automator.test', '$2y$12$mKVw3qUHo3ZdxGSl/vVloOzQkfLhYMp54vey37HaN.pRuhV86bViG', NULL, 'ativo', 0, 1, '2026-04-27 04:01:49', '2026-04-27 04:01:49', NULL, NULL);

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
('4BdBoHAmhqlMZKm8lfRezIZL5cP97ei90UtmhLKw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJudm9GcUE1RHRjU2lSbklYNVUxOGVPbFN6c21SQ0l5TDdaT0VBVUpIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoicGFnZS5hZG1pbi1sb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1777269267),
('65m4TdfqCBUDDuSZcTUl9FOJBW67sNfyfaAHEVww', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJCMHZoTkE3WDAzc2wwQ2gzWE4yVjVUVldFSVNQbnNvc1B3aTcxTnRsIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269261),
('a5W1cG0Hf0Rsy4wjAMTY6v1BL1byel4Dl7BLHidm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIwNEtnaEZSNElSMWRscUFDWjc4eTRvWTNJYmdtUk51djJIUzZURHBrIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cHM6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9kYXNoYm9hcmQiLCJyb3V0ZSI6InBhZ2UuYWRtaW4tZGFzaGJvYXJkIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1777312601),
('bu9XdkYQqhUxVv7EmenUqvnspScadHrri68X6d9C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJWUHdFalk2YWxISlRUMzBnZTE0dmVUeVNuOURPV1FSS2VDcGx1OXh5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269264),
('FMmZAYywobau52yKzStuzYj2lmIYCwE9ZmKh5i7E', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ3WnR0bXFZemRkOXMyQWs0ZTViYjFodFNQQXd3akJWVWFLR2tQVEVOIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269435),
('JEB4kJ0leG1fUDdVBTDdt41bN0ejhC6kXPiR0rce', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJxd0Zwc3Exa0g5NEQyWTFVQXVaVDFrTEdqSFVXaWhYejBraGF2bzR4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269281),
('KIOw0Q0htD1tYtOwhmGIigiVy0Y53yt77i6rO2Qw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIyaU1FZGtWdVJsNXU2VXl4clpjT3UxMWE1cWlYRnVINmU4ZnhPSEJZIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269287),
('lfgPNtYeqbNFkCrqc54SYrdOhRkMbzFzoLRT0ePL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ1WXR0aTV4RlJuRXRnbktTclA4YzFwNVhpRHZvaDYxOERZSlQwV0JjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoicGFnZS5hZG1pbi1sb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1777269253),
('OTL8OwQ409PUj1SOCYHevbb39RqnqhncKWZJLgoz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJvME1nVHltYlBuc29DZU9melh2N09oVW5INnE5MVB2b0o0QTJwek9RIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoicGFnZS5hZG1pbi1sb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1777269428),
('QaGp5FRvwRNODTipwNl1Oga7GXFifa3x2k4YDRhr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJBRmV6WFgweUdzb2ZvTGh5UjR4b0lnYkpFNWJXV1ZPYldndUluY0w4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hdXRvbWF0b3J2Mi50ZXN0XC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJwYWdlLmFkbWluLWRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1777270019),
('TjIeT2cQ5rdlONC0wbM0alLuaWB63zKOACZ8r6R6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJma1I5WmlxTW1qMHliSXBWTWZiNmlBbTNFZHZHOHF5MWJLZDFmYTlqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9sb2dpbiIsInJvdXRlIjoicGFnZS5hZG1pbi1sb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1777269275),
('UiZ4TUe1Ew9TRwKhi0hZi9QtBXL9mpoDKGsKk7qY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJmOGgxVGdaTDdXSTlQak1pczV0SlNhc1R6ZXhPR2tocVRIajhjeDhnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9hdXRvbWF0b3J2Mi50ZXN0XC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJwYWdlLmFkbWluLWRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1777251718),
('xTmbkZfhUJH3Mrcjoci5776ExAA5eERwyHPIgpDM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXbWJhaXBLcXB5ck82YWVHbzBFM2xmU25VN3UxZFlqTTlqazZtYWJaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2F1dG9tYXRvcnYyLnRlc3RcL2FkbWluXC9kYXNoYm9hcmQiLCJyb3V0ZSI6InBhZ2UuYWRtaW4tZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1777269253),
('yalaHdbpBY7uXlqfyM4vcYBYwBLHZ5k3J7rHQjIX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJpS0FRNE42ZzhGOWJvVm1Fbmt4ODlCSEdMU1I4Mm5ZbGswYTVINEhyIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777269272);

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
(1, 'Desenvolvedor', '', 1, 'ativo', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(2, 'Administrador', '', 1, 'ativo', '2026-04-27 04:01:48', '2026-04-27 04:01:48'),
(3, 'Usuário', '', 1, 'ativo', '2026-04-27 04:01:48', '2026-04-27 04:01:48');

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
(1, 1, 3, '2026-04-27 01:01:49'),
(2, 1, 1, '2026-04-27 01:01:49'),
(3, 2, 3, '2026-04-27 01:01:49'),
(4, 2, 2, '2026-04-27 01:01:49'),
(5, 3, 3, '2026-04-27 01:01:49');

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
  ADD UNIQUE KEY `tbl_sys_field_types_tbl_sys_field_type_name_unique` (`tbl_sys_field_type_name`);

--
-- Índices de tabela `tbl_sys_functions`
--
ALTER TABLE `tbl_sys_functions`
  ADD PRIMARY KEY (`tbl_sys_function_ID`),
  ADD UNIQUE KEY `tbl_sys_functions_tbl_sys_function_name_unique` (`tbl_sys_function_name`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tbl_sys_configs`
--
ALTER TABLE `tbl_sys_configs`
  MODIFY `tbl_sys_config_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tbl_sys_field_types`
--
ALTER TABLE `tbl_sys_field_types`
  MODIFY `tbl_sys_field_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_sys_functions`
--
ALTER TABLE `tbl_sys_functions`
  MODIFY `tbl_sys_function_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes`
--
ALTER TABLE `tbl_sys_routes`
  MODIFY `tbl_sys_route_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `tbl_sys_routes_access`
--
ALTER TABLE `tbl_sys_routes_access`
  MODIFY `tbl_routes_access_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
-- AUTO_INCREMENT de tabela `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `tbl_user_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_users_types`
--
ALTER TABLE `tbl_users_types`
  MODIFY `tbl_users_type_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_users_types_rels`
--
ALTER TABLE `tbl_users_types_rels`
  MODIFY `tbl_users_types_rel_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

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
