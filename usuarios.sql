-- Elimina la tabla 'usuarios' si ya existe para evitar conflictos.
DROP TABLE IF EXISTS `usuarios`;

--
-- Estructura de tabla para la tabla `usuarios` (adaptada para login)
--
CREATE TABLE `usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
-- Inserta un usuario administrador con la contraseña 'admin123' ya encriptada.
--
INSERT INTO `usuarios` (`nombre`, `email`, `password`) VALUES
('Administrador', 'admin@krm.com', '$2y$10$I2jT4.V0.f2/iA/2b.eJ9eEC2TylsExh2wt2s20iGz5Etf.1dI9I6');