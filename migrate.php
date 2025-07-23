<?php
// Script personalizado para ejecutar las migraciones sin usar artisan
// Esto evita el problema de recursión infinita en el componente Symfony Finder

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
    echo "Conexión exitosa.\n";
    
    // Crear la tabla de migraciones si no existe
    echo "Verificando si existe la tabla de migraciones...\n";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `migrations` (
            `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `migration` varchar(255) NOT NULL,
            `batch` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Obtener todas las migraciones ya ejecutadas
    $stmt = $pdo->query("SELECT migration FROM migrations");
    $existingMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Migraciones ya ejecutadas: " . count($existingMigrations) . "\n";
    
    // Obtener todas las migraciones disponibles
    $migrationsPath = __DIR__ . '/migrations';
    $migrationFiles = scandir($migrationsPath);
    $migrationFiles = array_filter($migrationFiles, function($file) {
        return !in_array($file, ['.', '..', 'backup']);
    });
    
    echo "Migraciones disponibles: " . count($migrationFiles) . "\n";
    
    // Ordenar las migraciones por nombre (lo que asegura el orden cronológico)
    sort($migrationFiles);
    
    // Obtener el último batch
    $stmt = $pdo->query("SELECT MAX(batch) as batch FROM migrations");
    $lastBatch = $stmt->fetch(PDO::FETCH_ASSOC)['batch'] ?? 0;
    $currentBatch = $lastBatch + 1;
    
    $migrationsRun = 0;
    
    // Ejecutar cada migración no ejecutada
    foreach ($migrationFiles as $file) {
        $migrationName = pathinfo($file, PATHINFO_FILENAME);
        
        if (in_array($migrationName, $existingMigrations)) {
            echo "Migración ya ejecutada: $migrationName\n";
            continue;
        }
        
        echo "Ejecutando migración: $migrationName\n";
        
        try {
            // Incluir el archivo de migración
            $migrationCode = file_get_contents("$migrationsPath/$file");
            
            // Verificar si es una migración con clase anónima
            if (strpos($migrationCode, 'return new class extends Migration') !== false) {
                echo "Detectada migración con clase anónima: $migrationName\n";
                
                // Crear una versión modificada del archivo de migración para poder ejecutarlo
                $tempFile = tempnam(sys_get_temp_dir(), 'mig_');
                $modifiedCode = str_replace(
                    'return new class extends Migration',
                    "class MigrationTemp extends Migration {}\nreturn new MigrationTemp",
                    $migrationCode
                );
                file_put_contents($tempFile, $modifiedCode);
                
                // Incluir el archivo modificado
                $migration = require $tempFile;
                
                // Limpiar el archivo temporal
                unlink($tempFile);
                
                // Ejecutar la migración
                if (method_exists($migration, 'up')) {
                    // Ejecutar el método up() de la migración
                    $migration->up();
                    
                    // Registrar la migración como ejecutada
                    $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
                    $stmt->execute([$migrationName, $currentBatch]);
                    
                    echo "Migración ejecutada correctamente: $migrationName\n";
                    $migrationsRun++;
                } else {
                    echo "Error: El método 'up()' no existe en la migración anónima para '$file'\n";
                }
            } else {
                // Método antiguo para clases con nombre
                require_once "$migrationsPath/$file";
                
                // Obtener la clase de migración a partir del nombre del archivo
                $className = studlyCase($migrationName);
                
                if (!class_exists($className)) {
                    echo "Error: No se encontró la clase '$className' en el archivo '$file'\n";
                    continue;
                }
                
                // Instanciar la clase y ejecutar la migración
                $migration = new $className();
                
                if (method_exists($migration, 'up')) {
                    // Ejecutar el método up() de la migración
                    $migration->up();
                    
                    // Registrar la migración como ejecutada
                    $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
                    $stmt->execute([$migrationName, $currentBatch]);
                    
                    echo "Migración ejecutada correctamente: $migrationName\n";
                    $migrationsRun++;
                } else {
                    echo "Error: El método 'up()' no existe en la clase '$className'\n";
                }
            }
        } catch (Exception $e) {
            echo "Error al ejecutar la migración '$migrationName': " . $e->getMessage() . "\n";
        }
    }
    
    echo "Migraciones ejecutadas: $migrationsRun\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "\n";
}

// Función para convertir un nombre de archivo en formato snake_case a StudlyCase
function studlyCase($value) {
    $value = ucwords(str_replace(['-', '_'], ' ', $value));
    return str_replace(' ', '', $value);
}
