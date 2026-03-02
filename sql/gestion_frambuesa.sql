-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2026 a las 13:58:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_frambuesa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campanias`
--

CREATE TABLE `campanias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activa','finalizada','planificada') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_gastos`
--

CREATE TABLE `categorias_gastos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_agua`
--

CREATE TABLE `consumo_agua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cosecha_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `litros_consumidos` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cosechas`
--

CREATE TABLE `cosechas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plantacion_id` bigint(20) UNSIGNED NOT NULL,
  `campania_id` bigint(20) UNSIGNED NOT NULL,
  `numero_cosecha` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('en_crecimiento','en_recoleccion','en_poda','finalizada') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `cosecha_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `tipo_tiempo` enum('recoleccion','mantenimiento','ambos','n/a') NOT NULL,
  `horas_estimadas` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_08_224035_create_campanias_table', 1),
(5, '2026_02_08_224140_create_parcelas_table', 1),
(6, '2026_02_08_224257_create_variedades_table', 1),
(7, '2026_02_08_224447_create_plantaciones_table', 1),
(8, '2026_02_08_224458_create_cosechas_table', 1),
(9, '2026_02_08_225004_create_precios_semanales_table', 1),
(10, '2026_02_08_225110_create_recolecciones_table', 1),
(11, '2026_02_08_225117_create_ventas_diarias_table', 1),
(12, '2026_02_08_225336_create_categorias_gastos_table', 1),
(13, '2026_02_08_225340_create_gastos_table', 1),
(14, '2026_02_08_225344_create_consumo_agua_table', 1),
(15, '2026_02_09_000140_create_personal_access_tokens_table', 1),
(16, '2026_02_18_222645_add_username_to_users_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcelas`
--

CREATE TABLE `parcelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `superficie_hectareas` decimal(8,2) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` enum('activa','inactiva','mantenimiento') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantaciones`
--

CREATE TABLE `plantaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parcela_id` bigint(20) UNSIGNED NOT NULL,
  `variedad_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_siembra` date NOT NULL,
  `numero_plantas` int(11) NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('planificada','activa','finalizada') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_semanales`
--

CREATE TABLE `precios_semanales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variedad_id` bigint(20) UNSIGNED NOT NULL,
  `semana_inicio` date NOT NULL,
  `semana_fin` date NOT NULL,
  `precio_primera` decimal(8,2) NOT NULL,
  `precio_industria` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recolecciones`
--

CREATE TABLE `recolecciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cosecha_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `kilos_primera` decimal(8,2) NOT NULL DEFAULT 0.00,
  `kilos_industria` decimal(8,2) NOT NULL DEFAULT 0.00,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `rol` enum('administrador','encargado','recolector') NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `dni`, `telefono`, `rol`, `fecha_alta`, `fecha_baja`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin', 'admin@gmail.com', '2026-03-02 11:17:53', '$2y$12$0ijJ.UjkkP6s0Vb1OANJ1eMigHaUTNIOIE68PF7iIBZDT0VS8OQb2', '22636097A', '600000000', 'administrador', '2024-01-11', NULL, 'sVCvS25OZL7KPAlmYecb', NULL, NULL),
(2, 'Manuel García López', 'manugarcia', 'manuelgl94@gmail.com', '2026-03-02 11:17:54', '$2y$12$wBhWalAw1YpiBF7iJbe5vOGyzGx/29aDF6f2mAZxvdvLgHkhgtZsC', '80270811Y', '635184792', 'encargado', '2024-02-05', NULL, 'OOvTyLsbzcmDwEYUZTW1', NULL, NULL),
(3, 'Juan Pérez Martínez', 'juanperez', 'juanperez@gmail.com', '2026-03-02 11:17:54', '$2y$12$dEjPSgXM91Fg7L/OSikZruVlfovHVfLcLsOpZGyUz8Dm7jlvzdV.G', '78572852E', '634567890', 'recolector', '2024-02-21', NULL, 'NRvX9kXFDUJcRJ1uKl9v', NULL, NULL),
(4, 'Ana Martínez Fernández', 'anamartinez', 'anamarfer00@gmail.com', '2026-03-02 11:17:55', '$2y$12$189UMncZoJzo2n.Fmu5YKeu4xyS.8Wvnk0wTjcxYoZW7wfZkz9iGq', '80851996G', '645678901', 'recolector', '2024-04-05', '2025-01-20', 'UGfFfpVgvxGyayfQCbsR', NULL, NULL),
(5, 'Luis Fernández Gómez', 'luisfernandez', 'luisfernandez47@gmail.com', '2026-03-02 11:17:55', '$2y$12$oozZEFcwA4OrbO/iegAwruPaGLleQlPGyBvYU0Sp/NrmUhm/y3vRq', '12344458J', '659647012', 'recolector', '2024-06-18', NULL, 'Su8tzGDRIPLldpFkTFQ6', NULL, NULL),
(6, 'Laura Gómez Ruiz', 'lauragr', 'lauragomez@gmail.com', '2026-03-02 11:17:56', '$2y$12$7AFdwmGlUJADoWs7PjfIguCED9yxHVTt/nE1JRGB9i80NnsoRZCTq', '48873334J', '667890123', 'recolector', '2024-07-30', NULL, 'FK7IO0aPOdLVhZ4OeT1v', NULL, NULL),
(7, 'Daniel Sánchez Díaz', 'danisanchez', 'danielsanchez@gmail.com', '2026-03-02 11:17:56', '$2y$12$si4k5NvETLaUz/Nmp1h9TOy7D7HYTlrzd8RwDVvuAgLHJd7PLX4kC', '08337620M', '654871234', 'recolector', '2024-01-10', '2025-02-15', 'TxNxJNVJdnBy3Mrhz8b6', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variedades`
--

CREATE TABLE `variedades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` enum('remontante','no_remontante') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_diarias`
--

CREATE TABLE `ventas_diarias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `cosecha_id` bigint(20) UNSIGNED NOT NULL,
  `kilos_primera` decimal(10,2) NOT NULL,
  `precio_primera` decimal(8,2) NOT NULL,
  `kilos_industria` decimal(10,2) NOT NULL,
  `precio_industria` decimal(8,2) NOT NULL,
  `importe_total` decimal(12,2) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `campanias`
--
ALTER TABLE `campanias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias_gastos`
--
ALTER TABLE `categorias_gastos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_gastos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consumo_agua_cosecha_id_foreign` (`cosecha_id`);

--
-- Indices de la tabla `cosechas`
--
ALTER TABLE `cosechas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cosechas_plantacion_id_campania_id_numero_cosecha_unique` (`plantacion_id`,`campania_id`,`numero_cosecha`),
  ADD KEY `cosechas_campania_id_foreign` (`campania_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gastos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `gastos_cosecha_id_foreign` (`cosecha_id`),
  ADD KEY `gastos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parcelas`
--
ALTER TABLE `parcelas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantaciones_parcela_id_foreign` (`parcela_id`),
  ADD KEY `plantaciones_variedad_id_foreign` (`variedad_id`);

--
-- Indices de la tabla `precios_semanales`
--
ALTER TABLE `precios_semanales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `precios_semanales_variedad_id_semana_inicio_semana_fin_unique` (`variedad_id`,`semana_inicio`,`semana_fin`);

--
-- Indices de la tabla `recolecciones`
--
ALTER TABLE `recolecciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recolecciones_cosecha_id_foreign` (`cosecha_id`),
  ADD KEY `recolecciones_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_dni_unique` (`dni`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indices de la tabla `variedades`
--
ALTER TABLE `variedades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `variedades_nombre_unique` (`nombre`);

--
-- Indices de la tabla `ventas_diarias`
--
ALTER TABLE `ventas_diarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_diarias_cosecha_id_foreign` (`cosecha_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `campanias`
--
ALTER TABLE `campanias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_gastos`
--
ALTER TABLE `categorias_gastos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cosechas`
--
ALTER TABLE `cosechas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios_semanales`
--
ALTER TABLE `precios_semanales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recolecciones`
--
ALTER TABLE `recolecciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `variedades`
--
ALTER TABLE `variedades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_diarias`
--
ALTER TABLE `ventas_diarias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  ADD CONSTRAINT `consumo_agua_cosecha_id_foreign` FOREIGN KEY (`cosecha_id`) REFERENCES `cosechas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cosechas`
--
ALTER TABLE `cosechas`
  ADD CONSTRAINT `cosechas_campania_id_foreign` FOREIGN KEY (`campania_id`) REFERENCES `campanias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cosechas_plantacion_id_foreign` FOREIGN KEY (`plantacion_id`) REFERENCES `plantaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_gastos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gastos_cosecha_id_foreign` FOREIGN KEY (`cosecha_id`) REFERENCES `cosechas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gastos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `plantaciones`
--
ALTER TABLE `plantaciones`
  ADD CONSTRAINT `plantaciones_parcela_id_foreign` FOREIGN KEY (`parcela_id`) REFERENCES `parcelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plantaciones_variedad_id_foreign` FOREIGN KEY (`variedad_id`) REFERENCES `variedades` (`id`);

--
-- Filtros para la tabla `precios_semanales`
--
ALTER TABLE `precios_semanales`
  ADD CONSTRAINT `precios_semanales_variedad_id_foreign` FOREIGN KEY (`variedad_id`) REFERENCES `variedades` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recolecciones`
--
ALTER TABLE `recolecciones`
  ADD CONSTRAINT `recolecciones_cosecha_id_foreign` FOREIGN KEY (`cosecha_id`) REFERENCES `cosechas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recolecciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `ventas_diarias`
--
ALTER TABLE `ventas_diarias`
  ADD CONSTRAINT `ventas_diarias_cosecha_id_foreign` FOREIGN KEY (`cosecha_id`) REFERENCES `cosechas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
