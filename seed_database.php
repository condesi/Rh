<?php
// Script para poblar las tablas con datos de prueba

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
    
    // Inicializar Faker
    $faker = Faker\Factory::create('es_ES');
    
    // Desactivar temporalmente las restricciones de clave externa
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
    
    // Limpiar tablas antes de poblar
    echo "Limpiando tablas existentes...\n";
    $pdo->exec('TRUNCATE TABLE contratos');
    $pdo->exec('TRUNCATE TABLE asistencias');
    $pdo->exec('TRUNCATE TABLE planillas');
    $pdo->exec('TRUNCATE TABLE vacaciones');
    $pdo->exec('TRUNCATE TABLE empleados');
    $pdo->exec('TRUNCATE TABLE cargos');
    $pdo->exec('TRUNCATE TABLE departamentos');
    
    // Poblar tabla de departamentos
    echo "Poblando tabla 'departamentos'...\n";
    $departamentos = [
        'Recursos Humanos',
        'Tecnología de la Información',
        'Ventas y Marketing',
        'Operaciones',
        'Finanzas y Contabilidad'
    ];
    
    foreach ($departamentos as $nombre) {
        $stmt = $pdo->prepare("INSERT INTO departamentos (nombre, descripcion, created_at, updated_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $faker->sentence, now(), now()]);
    }
    
    // Obtener los IDs de los departamentos insertados
    $stmt = $pdo->query("SELECT id, nombre FROM departamentos");
    $departamentosData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    // Poblar tabla de cargos
    echo "Poblando tabla 'cargos'...\n";
    $cargosPorDepartamento = [
        'Recursos Humanos' => ['Gerente de RRHH', 'Analista de Reclutamiento', 'Coordinador de Capacitación'],
        'Tecnología de la Información' => ['Director de TI', 'Desarrollador de Software', 'Soporte Técnico'],
        'Ventas y Marketing' => ['Gerente de Ventas', 'Especialista en Marketing Digital', 'Ejecutivo de Cuentas'],
        'Operaciones' => ['Gerente de Operaciones', 'Supervisor de Logística', 'Analista de Calidad'],
        'Finanzas y Contabilidad' => ['Director Financiero', 'Contador Senior', 'Analista Financiero']
    ];
    
    foreach ($departamentosData as $deptId => $deptNombre) {
        if (isset($cargosPorDepartamento[$deptNombre])) {
            foreach ($cargosPorDepartamento[$deptNombre] as $cargoNombre) {
                $stmt = $pdo->prepare("INSERT INTO cargos (nombre, descripcion, departamento_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$cargoNombre, $faker->sentence, $deptId, now(), now()]);
            }
        }
    }
    
    // Obtener los IDs de los cargos insertados
    $stmt = $pdo->query("SELECT id, departamento_id FROM cargos");
    $cargoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Poblar tabla de empleados
    echo "Poblando tabla 'empleados'...\n";
    for ($i = 0; $i < 50; $i++) {
        $cargo = $faker->randomElement($cargoData);
        
        $stmt = $pdo->prepare("
            INSERT INTO empleados (nombres, apellidos, email, telefono, direccion, fecha_nacimiento, fecha_ingreso, cargo_id, departamento_id, salario, tipo_documento, numero_documento, estado, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $faker->firstName,
            $faker->lastName,
            $faker->unique()->safeEmail,
            $faker->phoneNumber,
            $faker->address,
            $faker->date('Y-m-d', '2000-01-01'),
            $faker->date('Y-m-d', '2022-01-01'),
            $cargo['id'],
            $cargo['departamento_id'],
            $faker->randomFloat(2, 2000, 8000),
            'DNI',
            $faker->unique()->numerify('########'),
            'activo',
            now(),
            now()
        ]);
    }
    
    // Reactivar las restricciones de clave externa
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "Todas las tablas han sido pobladas exitosamente.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "\n";
}

if (!function_exists('now')) {
    function now() {
        return date('Y-m-d H:i:s');
    }
}
