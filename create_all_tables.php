a<?php
// Script para crear todas las tablas necesarias para el proyecto ADESUR

try {
    // Cargar el autoloader de Composer
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    // Cargar las variables de entorno
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    // Configuración de la base de datos
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_DATABASE') ?: 'rh_adesur';
    $username = getenv('DB_USERNAME') ?: 'laravel';
    $password = getenv('DB_PASSWORD') ?: 'laravel';
    
    echo "Conectando a la base de datos MySQL...\n";
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Conexión exitosa a la base de datos '$database'.\n";
    
    // Desactivar temporalmente las restricciones de clave externa
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');

    // Tabla de centros de costo
    echo "Creando tabla 'centros_costo'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `centros_costo` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `codigo` varchar(50) DEFAULT NULL,
            `descripcion` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `centros_costo_codigo_unique` (`codigo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de horarios de trabajo
    echo "Creando tabla 'horarios_trabajo'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `horarios_trabajo` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `hora_inicio` time NOT NULL,
            `hora_fin` time NOT NULL,
            `dias_laborables` varchar(255) NOT NULL COMMENT 'Ej: L,M,W,J,V',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de bancos
    echo "Creando tabla 'bancos'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `bancos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `codigo_sbs` varchar(10) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Crear las tablas en un orden que respete las dependencias
    
    // Tabla de departamentos
    echo "Creando tabla 'departamentos'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `departamentos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `descripcion` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Tabla de cargos
    echo "Creando tabla 'cargos'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `cargos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `descripcion` text DEFAULT NULL,
            `departamento_id` bigint(20) UNSIGNED NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `cargos_departamento_id_foreign` (`departamento_id`),
            CONSTRAINT `cargos_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Tabla de empleados
    echo "Creando tabla 'empleados'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `empleados` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            
            -- Datos Personales
            `nombres` varchar(100) NOT NULL,
            `apellido_paterno` varchar(50) NOT NULL,
            `apellido_materno` varchar(50) NOT NULL,
            `tipo_documento` enum('DNI','CE','Pasaporte') NOT NULL DEFAULT 'DNI',
            `numero_documento` varchar(15) NOT NULL,
            `sexo` enum('Masculino','Femenino','Otro') DEFAULT NULL,
            `fecha_nacimiento` date NOT NULL,
            `nacionalidad` varchar(50) NOT NULL DEFAULT 'Peruana',
            `estado_civil` enum('Soltero(a)','Casado(a)','Conviviente','Divorciado(a)','Viudo(a)') DEFAULT NULL,
            `direccion` varchar(255) DEFAULT NULL,
            `ubigeo` varchar(6) DEFAULT NULL,
            `telefono_personal` varchar(20) DEFAULT NULL,
            `telefono_emergencia` varchar(20) DEFAULT NULL,
            `contacto_emergencia` varchar(100) DEFAULT NULL,
            `email_personal` varchar(100) DEFAULT NULL,
            `email_corporativo` varchar(100) NOT NULL,

            -- Datos Laborales
            `fecha_ingreso` date NOT NULL,
            `fecha_cese` date DEFAULT NULL,
            `fecha_inicio_periodo_prueba` date DEFAULT NULL,
            `fecha_fin_periodo_prueba` date DEFAULT NULL,
            `departamento_id` bigint(20) UNSIGNED NOT NULL,
            `cargo_id` bigint(20) UNSIGNED NOT NULL,
            `jefe_directo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `centro_costo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `regimen_laboral` enum('D.L. 728','D.L. 1057 (CAS)','Microempresa','Pequeña Empresa','General') NOT NULL,
            `tipo_jornada` enum('Tiempo Completo','Tiempo Parcial') NOT NULL,
            `horario_trabajo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `estado` enum('Activo','Inactivo','De Vacaciones','Con Descanso Médico','Cesado') NOT NULL DEFAULT 'Activo',

            -- Datos de Remuneración
            `sueldo_base` decimal(10,2) NOT NULL,
            `asignacion_familiar` tinyint(1) NOT NULL DEFAULT 0,
            
            -- Datos de Seguridad Social y Tributarios
            `regimen_pensionario` enum('ONP','AFP') NOT NULL,
            `afp_nombre` varchar(50) DEFAULT NULL,
            `afp_cuispp` varchar(20) DEFAULT NULL,
            `afp_tipo_comision` enum('Flujo','Mixta') DEFAULT NULL,
            `essalud_vida` tinyint(1) NOT NULL DEFAULT 0,
            `retencion_quinta_categoria` tinyint(1) NOT NULL DEFAULT 0,

            -- Información Bancaria
            `banco_sueldo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `cuenta_sueldo` varchar(50) DEFAULT NULL,
            `banco_cts_id` bigint(20) UNSIGNED DEFAULT NULL,
            `cuenta_cts` varchar(50) DEFAULT NULL,

            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            
            PRIMARY KEY (`id`),
            UNIQUE KEY `empleados_numero_documento_unique` (`numero_documento`),
            UNIQUE KEY `empleados_email_corporativo_unique` (`email_corporativo`),
            KEY `empleados_departamento_id_foreign` (`departamento_id`),
            KEY `empleados_cargo_id_foreign` (`cargo_id`),
            KEY `empleados_jefe_directo_id_foreign` (`jefe_directo_id`),
            KEY `empleados_centro_costo_id_foreign` (`centro_costo_id`),
            KEY `empleados_horario_trabajo_id_foreign` (`horario_trabajo_id`),
            KEY `empleados_banco_sueldo_id_foreign` (`banco_sueldo_id`),
            KEY `empleados_banco_cts_id_foreign` (`banco_cts_id`),
            CONSTRAINT `empleados_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`),
            CONSTRAINT `empleados_cargo_id_foreign` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`),
            CONSTRAINT `empleados_jefe_directo_id_foreign` FOREIGN KEY (`jefe_directo_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL,
            CONSTRAINT `empleados_centro_costo_id_foreign` FOREIGN KEY (`centro_costo_id`) REFERENCES `centros_costo` (`id`),
            CONSTRAINT `empleados_horario_trabajo_id_foreign` FOREIGN KEY (`horario_trabajo_id`) REFERENCES `horarios_trabajo` (`id`),
            CONSTRAINT `empleados_banco_sueldo_id_foreign` FOREIGN KEY (`banco_sueldo_id`) REFERENCES `bancos` (`id`),
            CONSTRAINT `empleados_banco_cts_id_foreign` FOREIGN KEY (`banco_cts_id`) REFERENCES `bancos` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de familiares de empleados
    echo "Creando tabla 'familiares_empleado'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `familiares_empleado` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `parentesco` enum('Hijo(a)','Cónyuge','Padre','Madre') NOT NULL,
            `nombres` varchar(100) NOT NULL,
            `apellidos` varchar(100) NOT NULL,
            `fecha_nacimiento` date NOT NULL,
            `tipo_documento` enum('DNI','CE','Pasaporte') NOT NULL,
            `numero_documento` varchar(15) NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `familiares_empleado_empleado_id_foreign` (`empleado_id`),
            CONSTRAINT `familiares_empleado_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de historial laboral
    echo "Creando tabla 'historial_laboral'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `historial_laboral` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `fecha_evento` date NOT NULL,
            `tipo_evento` enum('Contratación','Cambio de Puesto','Aumento Salarial','Reasignación','Suspensión','Cese') NOT NULL,
            `descripcion` text NOT NULL,
            `cargo_anterior_id` bigint(20) UNSIGNED DEFAULT NULL,
            `cargo_nuevo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `salario_anterior` decimal(10,2) DEFAULT NULL,
            `salario_nuevo` decimal(10,2) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `historial_laboral_empleado_id_foreign` (`empleado_id`),
            CONSTRAINT `historial_laboral_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Tabla de contratos
    echo "Creando tabla 'contratos'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `contratos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `tipo_contrato` enum('Indefinido','Plazo Fijo - Inicio de Actividad','Plazo Fijo - Necesidad de Mercado','Plazo Fijo - Reconversión Empresarial','Intermitente','Temporada','Obra o Servicio Específico','CAS') NOT NULL,
            `fecha_inicio` date NOT NULL,
            `fecha_fin` date DEFAULT NULL,
            `periodo_prueba_dias` int(11) DEFAULT 90,
            `salario` decimal(10,2) NOT NULL,
            `bonificaciones_fijas` decimal(10,2) DEFAULT 0.00,
            `comisiones_promedio` decimal(10,2) DEFAULT 0.00,
            `otras_remuneraciones` decimal(10,2) DEFAULT 0.00,
            `estado` varchar(50) NOT NULL DEFAULT 'activo',
            `path_documento` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `contratos_empleado_id_foreign` (`empleado_id`),
            CONSTRAINT `contratos_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de liquidaciones
    echo "Creando tabla 'liquidaciones'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `liquidaciones` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `contrato_id` bigint(20) UNSIGNED NOT NULL,
            `fecha_cese` date NOT NULL,
            `motivo_cese` varchar(255) NOT NULL,
            `total_beneficios_sociales` decimal(12,2) NOT NULL,
            `detalle_calculo` json NOT NULL,
            `path_documento` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `liquidaciones_empleado_id_foreign` (`empleado_id`),
            KEY `liquidaciones_contrato_id_foreign` (`contrato_id`),
            CONSTRAINT `liquidaciones_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE,
            CONSTRAINT `liquidaciones_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Tabla de asistencias
    echo "Creando tabla 'asistencias'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `asistencias` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `fecha` date NOT NULL,
            `hora_entrada` time DEFAULT NULL,
            `hora_salida` time DEFAULT NULL,
            `estado` varchar(50) NOT NULL,
            `observaciones` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `asistencias_empleado_id_foreign` (`empleado_id`),
            CONSTRAINT `asistencias_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Tabla de políticas de vacaciones
    echo "Creando tabla 'politicas_vacaciones'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `politicas_vacaciones` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre_politica` varchar(255) NOT NULL,
            `dias_por_anio` int(11) NOT NULL DEFAULT 30,
            `dias_max_acumulables` int(11) DEFAULT 60,
            `anticipacion_minima_solicitud_dias` int(11) DEFAULT 15,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de periodos de vacaciones (Derecho a vacaciones)
    echo "Creando tabla 'vacaciones_periodos'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `vacaciones_periodos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `politica_id` bigint(20) UNSIGNED NOT NULL,
            `fecha_inicio_periodo` date NOT NULL,
            `fecha_fin_periodo` date NOT NULL,
            `dias_derecho` int(11) NOT NULL COMMENT 'Total de días a los que tiene derecho en el periodo',
            `dias_tomados` int(11) NOT NULL DEFAULT 0,
            `dias_disponibles` int(11) GENERATED ALWAYS AS (`dias_derecho` - `dias_tomados`) STORED,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `vacaciones_periodos_empleado_inicio_fin_unique` (`empleado_id`, `fecha_inicio_periodo`, `fecha_fin_periodo`),
            KEY `vacaciones_periodos_empleado_id_foreign` (`empleado_id`),
            KEY `vacaciones_periodos_politica_id_foreign` (`politica_id`),
            CONSTRAINT `vacaciones_periodos_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE,
            CONSTRAINT `vacaciones_periodos_politica_id_foreign` FOREIGN KEY (`politica_id`) REFERENCES `politicas_vacaciones` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de solicitudes de vacaciones
    echo "Creando tabla 'solicitudes_vacaciones'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `solicitudes_vacaciones` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `periodo_id` bigint(20) UNSIGNED NOT NULL,
            `fecha_inicio` date NOT NULL,
            `fecha_fin` date NOT NULL,
            `dias_solicitados` int(11) NOT NULL,
            `estado` enum('Pendiente','Aprobado','Rechazado','Cancelado') NOT NULL DEFAULT 'Pendiente',
            `comentarios_solicitante` text DEFAULT NULL,
            `aprobado_por_id` bigint(20) UNSIGNED DEFAULT NULL,
            `fecha_aprobacion` datetime DEFAULT NULL,
            `comentarios_aprobador` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `solicitudes_vacaciones_empleado_id_foreign` (`empleado_id`),
            KEY `solicitudes_vacaciones_periodo_id_foreign` (`periodo_id`),
            KEY `solicitudes_vacaciones_aprobado_por_id_foreign` (`aprobado_por_id`),
            CONSTRAINT `solicitudes_vacaciones_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE,
            CONSTRAINT `solicitudes_vacaciones_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `vacaciones_periodos` (`id`) ON DELETE CASCADE,
            CONSTRAINT `solicitudes_vacaciones_aprobado_por_id_foreign` FOREIGN KEY (`aprobado_por_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de configuración de planillas
    echo "Creando tabla 'configuracion_planillas'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `configuracion_planillas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `clave` varchar(100) NOT NULL,
            `valor` text NOT NULL,
            `descripcion` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `configuracion_planillas_clave_unique` (`clave`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Almacena configuraciones maestras para el cálculo de planillas (UIT, tasas AFP, etc.)';
    ");

    // Tabla de conceptos de planilla (remuneraciones, descuentos, aportes)
    echo "Creando tabla 'conceptos_planillas'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `conceptos_planillas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `codigo` varchar(50) NOT NULL,
            `descripcion` varchar(255) NOT NULL,
            `tipo` enum('INGRESO','DESCUENTO','APORTE_TRABAJADOR','APORTE_EMPLEADOR') NOT NULL,
            `es_fijo` tinyint(1) NOT NULL DEFAULT 0,
            `es_calculado` tinyint(1) NOT NULL DEFAULT 1,
            `formula` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `conceptos_planillas_codigo_unique` (`codigo`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de Planillas (cabecera)
    echo "Creando tabla 'planillas'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `planillas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `mes` int(11) NOT NULL,
            `anio` int(11) NOT NULL,
            `tipo_planilla` enum('MENSUAL', 'GRATIFICACION', 'CTS', 'LIQUIDACION') NOT NULL DEFAULT 'MENSUAL',
            `estado` enum('BORRADOR','GENERADA','CERRADA','PAGADA') NOT NULL DEFAULT 'BORRADOR',
            `fecha_generacion` datetime DEFAULT NULL,
            `fecha_cierre` datetime DEFAULT NULL,
            `total_ingresos` decimal(12,2) DEFAULT 0.00,
            `total_descuentos` decimal(12,2) DEFAULT 0.00,
            `total_neto` decimal(12,2) DEFAULT 0.00,
            `total_aportes_empleador` decimal(12,2) DEFAULT 0.00,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `planillas_mes_anio_tipo_unique` (`mes`, `anio`, `tipo_planilla`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de Planilla Detalles (líneas de la planilla por empleado y concepto)
    echo "Creando tabla 'planilla_detalles'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `planilla_detalles` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `planilla_id` bigint(20) UNSIGNED NOT NULL,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `concepto_id` bigint(20) UNSIGNED NOT NULL,
            `monto` decimal(12,2) NOT NULL,
            `base_calculo` decimal(12,2) DEFAULT NULL,
            `observacion` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `planilla_detalles_planilla_id_foreign` (`planilla_id`),
            KEY `planilla_detalles_empleado_id_foreign` (`empleado_id`),
            KEY `planilla_detalles_concepto_id_foreign` (`concepto_id`),
            CONSTRAINT `planilla_detalles_planilla_id_foreign` FOREIGN KEY (`planilla_id`) REFERENCES `planillas` (`id`) ON DELETE CASCADE,
            CONSTRAINT `planilla_detalles_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE,
            CONSTRAINT `planilla_detalles_concepto_id_foreign` FOREIGN KEY (`concepto_id`) REFERENCES `conceptos_planillas` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Tabla de Beneficios Sociales (CTS, Gratificaciones)
    echo "Creando tabla 'beneficios_sociales'...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `beneficios_sociales` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `empleado_id` bigint(20) UNSIGNED NOT NULL,
            `tipo_beneficio` enum('CTS','GRATIFICACION') NOT NULL,
            `periodo_anio` int(11) NOT NULL,
            `periodo_semestre` int(11) NOT NULL COMMENT '1 para Ene-Jun/May-Oct, 2 para Jul-Dic/Nov-Abr',
            `remuneracion_computable` decimal(12,2) NOT NULL,
            `meses_computables` int(11) NOT NULL,
            `dias_computables` int(11) NOT NULL,
            `monto_total` decimal(12,2) NOT NULL,
            `monto_bonificacion_extra` decimal(12,2) DEFAULT NULL COMMENT 'Para bonificación de Essalud en gratificaciones',
            `fecha_calculo` date NOT NULL,
            `fecha_deposito` date DEFAULT NULL,
            `planilla_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID de la planilla de grati/cts si aplica',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `beneficios_sociales_empleado_id_foreign` (`empleado_id`),
            KEY `beneficios_sociales_planilla_id_foreign` (`planilla_id`),
            CONSTRAINT `beneficios_sociales_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE,
            CONSTRAINT `beneficios_sociales_planilla_id_foreign` FOREIGN KEY (`planilla_id`) REFERENCES `planillas` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Reactivar las restricciones de clave externa
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "Todas las tablas han sido creadas exitosamente.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "\n";
}
