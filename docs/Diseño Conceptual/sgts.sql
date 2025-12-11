-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2025 a las 22:27:17
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
-- Base de datos: `sgts`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_estado_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `id_estado_categoria`) VALUES
(1, 'Tecnologia', 'Tickets relacionados al area de sistemas, puede ser hardware o software.', 1),
(2, 'Limpieza', 'Tickets relacionados a servicios generales de la empresa.', 1),
(3, 'Finanzas', 'Tickets relacionados a inconvenientes de administración del dinero.', 1),
(5, 'Prueba', 'Este es una categoria de prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `fecha_comentario` datetime DEFAULT NULL,
  `observaciones` enum('true','false') DEFAULT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `mensaje`, `fecha_comentario`, `observaciones`, `id_ticket`, `id_usuario`) VALUES
(1, 'Se estudia la posibilidad.', '2025-11-18 12:16:39', 'true', 2, 52313194),
(2, 'Se aprueba el presupuesto.', '2025-11-18 12:17:29', 'true', 2, 52313194),
(6, 'Prueba', '2025-11-18 16:42:45', 'true', 12, 52313194),
(7, 'Se cierra ticket.', '2025-11-18 18:51:49', 'true', 2, 52313194),
(14, 'Hola, ya te lo comparto.', '2025-11-18 21:46:16', 'false', 2, 80067922),
(15, 'Ok perfecto, quedo al tanto.', '2025-11-18 21:46:43', 'false', 2, 52313194),
(16, 'Listo ya quedo adjuntado.', '2025-11-18 21:47:22', 'false', 2, 80067922),
(18, 'Prueba de avance.', '2025-11-19 10:11:32', 'true', 2, 52313194),
(19, 'Prueba de comentario', '2025-11-19 10:12:16', 'false', 2, 52313194),
(20, 'Responder.', '2025-11-19 10:12:46', 'false', 2, 80067922);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_categorias`
--

CREATE TABLE `estados_categorias` (
  `id_estado_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_categorias`
--

INSERT INTO `estados_categorias` (`id_estado_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Activo', 'Categoria Activa, lista para asociar a un ticket'),
(2, 'Inactiva', 'Categoria Inactica, no se puede asignar a un nuevo ticket');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_tickets`
--

CREATE TABLE `estados_tickets` (
  `id_estado_ticket` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_tickets`
--

INSERT INTO `estados_tickets` (`id_estado_ticket`, `nombre`, `descripcion`) VALUES
(1, 'Abierto', 'Tickets abiertos, es decir recien creados y aun no asignados a nadie'),
(2, 'En Proceso', 'Tickets en proceso, es decir asignados a un técnico pero aún sin resolver.'),
(3, 'Resuelto', 'Tickets resueltos, es decir solucionados por un técnico.'),
(4, 'Cerrado', 'Tickets cerrados, es decir se finalizo el proceso y el administrador lo cerró.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_usuario`
--

CREATE TABLE `estados_usuario` (
  `id_estado_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_usuario`
--

INSERT INTO `estados_usuario` (`id_estado_usuario`, `nombre`, `descripcion`) VALUES
(1, 'Activo', 'Usuario Activo'),
(2, 'Inactivo', 'Usuario Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha_accion` datetime DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_historial`, `accion`, `fecha_accion`, `id_ticket`, `id_usuario`) VALUES
(76, 'Cambio de Estado', '2025-12-02 21:47:31', 17, 1030533364),
(77, 'Cambio de Estado', '2025-12-02 21:48:01', 12, 1030533364),
(78, 'Cambio de Estado', '2025-12-02 21:48:21', 17, 1030533364),
(79, 'Asignación de Técnico', '2025-12-02 21:49:03', 12, 1030533364),
(80, 'Cambio de Estado', '2025-12-02 22:18:56', 2, 1030533364),
(81, 'Cambio de Estado', '2025-12-02 22:19:05', 2, 1030533364),
(82, 'Cambio de Estado', '2025-12-02 22:19:49', 2, 1030533364),
(85, 'Cambio de Estado', '2025-12-10 21:49:45', 17, 1030533364),
(86, 'Cambio de Estado', '2025-12-10 21:49:55', 17, 1030533364);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario_destino` int(11) DEFAULT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario_destino`, `titulo`, `mensaje`, `enlace`, `leido`, `created_at`) VALUES
(36, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #17 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 21:47:31'),
(37, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #12 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 21:48:01'),
(38, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #17 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 21:48:21'),
(39, 52313194, 'Ticket asignado', 'Se le ha asignado el ticket #12.', 'http://localhost:8080/index.php/tecnico/dashboard', 1, '2025-12-02 21:49:03'),
(40, 1234567890, 'Ticket reasignado', 'El ticket #12 fue reasignado a otro técnico.', 'http://localhost:8080/index.php/tecnico/dashboard', 0, '2025-12-02 21:49:03'),
(41, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #2 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 22:18:56'),
(42, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #2 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 22:19:05'),
(43, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #2 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 1, '2025-12-02 22:19:49'),
(44, 1030533364, 'Nuevo Ticket Creado', 'Se ha creado el ticket #18.', 'http://localhost:8080/index.php/admin/tickets', 1, '2025-12-02 22:35:11'),
(45, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #17 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 0, '2025-12-10 21:49:45'),
(46, 80067922, 'Cambio de estado en tu ticket', 'El estado del ticket #17 ha cambiado.', 'http://localhost:8080/index.php/cliente/dashboard', 0, '2025-12-10 21:49:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad_tickets`
--

CREATE TABLE `prioridad_tickets` (
  `id_prioridad_ticket` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prioridad_tickets`
--

INSERT INTO `prioridad_tickets` (`id_prioridad_ticket`, `nombre`, `descripcion`) VALUES
(1, 'Alta', 'Prioridad alta, es decir resolver inmediatamente'),
(2, 'Media', 'Prioridad media, es decir resolver en el transcurso de maximo 2 semanas'),
(3, 'Baja', 'Prioridad baja, es decir resolver en el momento que sea posible hacerlo, siempre y cuando no haya tickets con mayor prioridad por delante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', 'Rol encargado de supervisar, asignas tickets y controlar el proceso general..\r\n'),
(2, 'Técnico', 'Rol encargado de atender, registrar avances y observaciones, y resolver los tickets que le son asignados.'),
(3, 'Cliente', 'Rol encargado de reportar incidentes y puede dar seguimiento a sus propias solicitudes.\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `asunto` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `id_usuario_cliente` int(11) DEFAULT NULL,
  `id_usuario_tecnico` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_estado_ticket` int(11) DEFAULT NULL,
  `id_prioridad_ticket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `asunto`, `descripcion`, `fecha_creacion`, `fecha_cierre`, `id_usuario_cliente`, `id_usuario_tecnico`, `id_categoria`, `id_estado_ticket`, `id_prioridad_ticket`) VALUES
(1, 'Computadora no Enciende', 'Buen día, requiero de su ayuda debido a que mi computadora no enciende y necesito urgente de su ayuda para poder trabajar.', '2025-11-04 22:25:17', NULL, 80067922, NULL, 1, 1, 1),
(2, 'Habilitacion de mas Presupuesto', 'Buen día, requiero de su ayuda para que me sea habilitado un aumento del presupuesto, esto con el fin de aquirir unos materiales de infraestructura.', '2025-11-04 22:25:59', NULL, 80067922, 1234567890, 3, 2, 2),
(12, 'Prueba', 'Este es un ticket de prueba', '2025-11-05 10:39:26', NULL, 80067922, 52313194, 1, 1, 1),
(17, 'Limpieza Piso 3', 'Por favor solicito limpiea del piso 3', '2025-11-25 23:01:40', '2025-12-10 21:49:55', 80067922, 52313194, 2, 4, 1);

--
-- Disparadores `tickets`
--
DELIMITER $$
CREATE TRIGGER `after_insert_tickets` AFTER INSERT ON `tickets` FOR EACH ROW BEGIN
  INSERT INTO historial(accion, fecha_accion, id_ticket, id_usuario)
  VALUES('Creación Ticket', NOW(), NEW.id_ticket, NEW.id_usuario_cliente);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_tickets` BEFORE INSERT ON `tickets` FOR EACH ROW BEGIN
SET NEW.fecha_creacion = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_fecha_cierre` BEFORE UPDATE ON `tickets` FOR EACH ROW BEGIN
    -- Si el ticket pasa a estado cerrado
    IF NEW.id_estado_ticket = 4 AND OLD.id_estado_ticket != 4 THEN
        SET NEW.fecha_cierre = NOW();
    END IF;
    
    -- Opcional: Si reabre el ticket, limpiar la fecha
    IF NEW.id_estado_ticket != 4 AND OLD.id_estado_ticket = 4 THEN
        SET NEW.fecha_cierre = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `nombre`) VALUES
(2, 'Cedula de Ciudadania'),
(3, 'Cedula de Extranjeria'),
(1, 'Tarjeta de Identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `id_estado_usuario` int(11) NOT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `email`, `password`, `fecha_registro`, `id_rol`, `id_estado_usuario`, `id_tipo_documento`) VALUES
(52313194, 'Marcela', 'Salazar', 'marcela94sg@gmail.com', '$2y$10$QUTEKSduGIzv98zFfX.pvebghNKwJM9/ZHOTBAaRj0IDEYF6H0e9S', '2025-10-14 12:46:11', 2, 1, 2),
(80067922, 'Jorge ', 'Garcia', 'enriquegarciar2015@gmail.com', '$2y$10$07fqAHQHD2/RSstEVwDnU.IYTw.6rh0utycA2aI0Qb.jXcy5GmFF.', '2025-11-12 12:46:35', 3, 1, 2),
(1030533364, 'Johan', 'Garcia', 'fgfernan2508@gmail.com', '$2y$10$5kyIdg81J1YybI5E70WA4uwdP8JrXA2JnZwY5oCp1BVFHr3T0KPYW', '2025-10-23 12:47:12', 1, 1, 2),
(1234567890, 'Carlos', 'Castro', 'carlos.castro@dicocolombia.com', '$2y$10$j/om7F98BxBE1PmmuIMZ.ufYBLoyYHcGDNDCuqYg7rb0sKYQ.GPI6', '2025-11-13 12:47:18', 2, 1, 2);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `TRG_Before_Insert` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN
SET NEW.fecha_registro = NOW();
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`),
  ADD KEY `FK_categorias_estado` (`id_estado_categoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `FK_comentario_ticket` (`id_ticket`),
  ADD KEY `FK_comentario_usuario` (`id_usuario`);

--
-- Indices de la tabla `estados_categorias`
--
ALTER TABLE `estados_categorias`
  ADD PRIMARY KEY (`id_estado_categoria`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`);

--
-- Indices de la tabla `estados_tickets`
--
ALTER TABLE `estados_tickets`
  ADD PRIMARY KEY (`id_estado_ticket`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`),
  ADD KEY `id_estado_ticket` (`id_estado_ticket`);

--
-- Indices de la tabla `estados_usuario`
--
ALTER TABLE `estados_usuario`
  ADD PRIMARY KEY (`id_estado_usuario`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `FK_historial_ticket` (`id_ticket`),
  ADD KEY `FK_historial_usuario` (`id_usuario`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `FK_notificacion_usuario` (`id_usuario_destino`);

--
-- Indices de la tabla `prioridad_tickets`
--
ALTER TABLE `prioridad_tickets`
  ADD PRIMARY KEY (`id_prioridad_ticket`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`),
  ADD KEY `id_prioridad_ticket` (`id_prioridad_ticket`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `FK_ticket_usuario_cliente` (`id_usuario_cliente`),
  ADD KEY `FK_ticket_categoria` (`id_categoria`),
  ADD KEY `FK_ticket_estado` (`id_estado_ticket`),
  ADD KEY `FK_ticket_prioridad` (`id_prioridad_ticket`),
  ADD KEY `FK_ticket_usuario_tecnico` (`id_usuario_tecnico`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`),
  ADD UNIQUE KEY `UNIQUE` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `UNIQUE` (`email`),
  ADD KEY `FK_usuario_rol` (`id_rol`),
  ADD KEY `FK_usuario_estado` (`id_estado_usuario`),
  ADD KEY `FK_usuario_tipo_documento` (`id_tipo_documento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `estados_categorias`
--
ALTER TABLE `estados_categorias`
  MODIFY `id_estado_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados_tickets`
--
ALTER TABLE `estados_tickets`
  MODIFY `id_estado_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_usuario`
--
ALTER TABLE `estados_usuario`
  MODIFY `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `prioridad_tickets`
--
ALTER TABLE `prioridad_tickets`
  MODIFY `id_prioridad_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `FK_categorias_estado` FOREIGN KEY (`id_estado_categoria`) REFERENCES `estados_categorias` (`id_estado_categoria`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_comentario_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `FK_historial_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `FK_notificacion_usuario` FOREIGN KEY (`id_usuario_destino`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_ticket_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ticket_estado` FOREIGN KEY (`id_estado_ticket`) REFERENCES `estados_tickets` (`id_estado_ticket`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ticket_prioridad` FOREIGN KEY (`id_prioridad_ticket`) REFERENCES `prioridad_tickets` (`id_prioridad_ticket`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ticket_usuario_cliente` FOREIGN KEY (`id_usuario_cliente`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ticket_usuario_tecnico` FOREIGN KEY (`id_usuario_tecnico`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuario_estado` FOREIGN KEY (`id_estado_usuario`) REFERENCES `estados_usuario` (`id_estado_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_usuario_tipo_documento` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
