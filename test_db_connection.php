<?php
// Script personalizado para verificar la conexión a la base de datos sin usar artisan

try {
// Cargar el archivo de autoload de Composer
require_once dirname(__DIR__) . '/vendor/autoload.php';    // Cargar las variables de entorno desde el archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    // Establecer la conexión a la base de datos directamente usando PDO con MySQL
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_DATABASE') ?: 'rh_adesur';
    $username = getenv('DB_USERNAME') ?: 'laravel';
    $password = getenv('DB_PASSWORD') ?: 'laravel';
    
    echo "Intentando conectar a la base de datos MySQL:\n";
    echo "Host: $host\n";
    echo "Puerto: $port\n";
    echo "Base de datos: $database\n";
    echo "Usuario: $username\n";
    
    // Primero intentamos conectarnos a MySQL sin especificar la base de datos
    try {
        $tempDsn = "mysql:host=$host;port=$port";
        $tempPdo = new PDO($tempDsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
        // Verificar si la base de datos existe
        $stmt = $tempPdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
        if (!$stmt->fetch()) {
            echo "La base de datos '$database' no existe. Creando...\n";
            $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "Base de datos '$database' creada correctamente.\n";
        }
        
        $tempPdo = null;
    } catch (PDOException $e) {
        echo "Error al conectar a MySQL o crear la base de datos: " . $e->getMessage() . "\n";
        exit(1);
    }
    
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    
    echo "Conexión exitosa a la base de datos MySQL.\n";
    
    // Verificar tablas existentes
    $statement = $pdo->query("SHOW TABLES");
    $tables = $statement->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tablas encontradas: " . count($tables) . "\n";
    echo "Lista de tablas:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error general: " . $e->getMessage() . "\n";
}
