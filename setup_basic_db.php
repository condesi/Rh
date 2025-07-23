<?php
// Script para configurar la base de datos básica sin depender de las migraciones de Laravel

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
    $tempDsn = "mysql:host=$host;port=$port";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    // Conectar sin seleccionar una base de datos
    $tempPdo = new PDO($tempDsn, $username, $password, $options);
    
    // Verificar si la base de datos existe
    $stmt = $tempPdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
    if (!$stmt->fetch()) {
        echo "La base de datos '$database' no existe. Creando...\n";
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base de datos '$database' creada correctamente.\n";
    } else {
        echo "Base de datos '$database' ya existe.\n";
    }
    
    // Conectar a la base de datos específica
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Conexión exitosa a la base de datos '$database'.\n";
    
    // Crear tabla de usuarios si no existe
    echo "Creando tabla 'users' si no existe...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `email_verified_at` timestamp NULL DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `remember_token` varchar(100) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Verificar si hay usuarios
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM `users`");
    $userCount = $stmt->fetch()['count'];
    
    if ($userCount == 0) {
        // Crear un usuario administrador por defecto
        echo "Creando usuario administrador...\n";
        $name = 'Admin';
        $email = 'admin@adesur.com';
        // Generar hash de la contraseña 'admin123'
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');
        
        $stmt = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $now, $now]);
        echo "Usuario administrador creado correctamente.\n";
    } else {
        echo "Ya existen usuarios en la base de datos. No se creará un nuevo usuario administrador.\n";
    }
    
    // Crear tabla de configuracion_planillas si no existe
    echo "Creando tabla 'configuracion_planillas' si no existe...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `configuracion_planillas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `clave` varchar(255) NOT NULL,
            `valor` varchar(255) NOT NULL,
            `descripcion` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `configuracion_planillas_clave_unique` (`clave`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Verificar si la tabla de configuración está vacía
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM `configuracion_planillas`");
    $configCount = $stmt->fetch()['count'];

    if ($configCount == 0) {
        echo "Poblando la tabla 'configuracion_planillas' con valores por defecto...\n";
        $configuraciones = [
            ['UIT', 5150.00, 'Unidad Impositiva Tributaria (Anual)'],
            ['RMV', 1025.00, 'Remuneración Mínima Vital (Mensual)'],
            ['ASIGNACION_FAMILIAR_PORCENTAJE', 10, 'Porcentaje de la RMV para Asignación Familiar'],
            ['ESSALUD_PORCENTAJE', 9, 'Aporte a EsSalud por parte del empleador (%)'],
            ['SCTR_PENSION_TASA', 0.53, 'Tasa de SCTR Pensión (puede variar)'],
            ['SCTR_SALUD_TASA', 0.53, 'Tasa de SCTR Salud (puede variar)'],
            ['SENATI_PORCENTAJE', 0.75, 'Aporte al SENATI por parte del empleador (%)'],
            ['AFP_INTEGRA_APORTE_OBLIGATORIO', 10.00, 'Aporte obligatorio a AFP Integra (%)'],
            ['AFP_INTEGRA_PRIMA_SEGURO', 1.84, 'Prima de seguro de AFP Integra (%)'],
            ['AFP_INTEGRA_COMISION_FLUJO', 0.00, 'Comisión sobre el flujo de AFP Integra (%)'],
            ['AFP_PRIMA_APORTE_OBLIGATORIO', 10.00, 'Aporte obligatorio a AFP Prima (%)'],
            ['AFP_PRIMA_PRIMA_SEGURO', 1.84, 'Prima de seguro de AFP Prima (%)'],
            ['AFP_PRIMA_COMISION_FLUJO', 0.00, 'Comisión sobre el flujo de AFP Prima (%)'],
            ['AFP_PROFUTURO_APORTE_OBLIGATORIO', 10.00, 'Aporte obligatorio a AFP Profuturo (%)'],
            ['AFP_PROFUTURO_PRIMA_SEGURO', 1.84, 'Prima de seguro de AFP Profuturo (%)'],
            ['AFP_PROFUTURO_COMISION_FLUJO', 0.00, 'Comisión sobre el flujo de AFP Profuturo (%)'],
            ['AFP_HABITAT_APORTE_OBLIGATORIO', 10.00, 'Aporte obligatorio a AFP Habitat (%)'],
            ['AFP_HABITAT_PRIMA_SEGURO', 1.84, 'Prima de seguro de AFP Habitat (%)'],
            ['AFP_HABITAT_COMISION_FLUJO', 0.00, 'Comisión sobre el flujo de AFP Habitat (%)'],
            ['ONP_TASA', 13.00, 'Tasa de aporte a la ONP (%)'],
            ['RENTA_5TA_TRAMO_1_HASTA_UIT', 5, 'Límite del Tramo 1 para Renta de 5ta (en UITs)'],
            ['RENTA_5TA_TRAMO_1_TASA', 8, 'Tasa del Tramo 1 para Renta de 5ta (%)'],
            ['RENTA_5TA_TRAMO_2_HASTA_UIT', 20, 'Límite del Tramo 2 para Renta de 5ta (en UITs)'],
            ['RENTA_5TA_TRAMO_2_TASA', 14, 'Tasa del Tramo 2 para Renta de 5ta (%)'],
            ['RENTA_5TA_TRAMO_3_HASTA_UIT', 35, 'Límite del Tramo 3 para Renta de 5ta (en UITs)'],
            ['RENTA_5TA_TRAMO_3_TASA', 17, 'Tasa del Tramo 3 para Renta de 5ta (%)'],
            ['RENTA_5TA_TRAMO_4_HASTA_UIT', 45, 'Límite del Tramo 4 para Renta de 5ta (en UITs)'],
            ['RENTA_5TA_TRAMO_4_TASA', 20, 'Tasa del Tramo 4 para Renta de 5ta (%)'],
            ['RENTA_5TA_TRAMO_5_MAS_DE_UIT', 45, 'Límite del Tramo 5 para Renta de 5ta (en UITs)'],
            ['RENTA_5TA_TRAMO_5_TASA', 30, 'Tasa del Tramo 5 para Renta de 5ta (%)'],
            ['RENTA_5TA_DEDUCCION_UIT', 7, 'Deducción anual para Renta de 5ta (en UITs)'],
        ];

        $now = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("INSERT INTO `configuracion_planillas` (`clave`, `valor`, `descripcion`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($configuraciones as $config) {
            $stmt->execute([$config[0], $config[1], $config[2], $now, $now]);
        }
        echo "Tabla 'configuracion_planillas' poblada correctamente.\n";
    } else {
        echo "La tabla 'configuracion_planillas' ya contiene datos. No se agregarán valores por defecto.\n";
    }
    
    echo "Configuración básica de la base de datos completada.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "\n";
}
