<?php
// Script para generar una clave de aplicación Laravel y establecerla directamente en .env
// Sin depender del framework completo

// Generar una clave de 32 caracteres
function generateRandomKey() {
    return 'base64:' . base64_encode(random_bytes(32));
}

// Ruta al archivo .env
$envFilePath = dirname(__DIR__) . '/.env';

if (!file_exists($envFilePath)) {
    die("Archivo .env no encontrado en: $envFilePath\n");
}

// Leer el contenido del archivo .env
$envContent = file_get_contents($envFilePath);

// Generar una nueva clave
$newKey = generateRandomKey();
echo "Nueva clave generada: $newKey\n";

// Comprobar si APP_KEY ya existe en el archivo
if (preg_match('/^APP_KEY=.*/m', $envContent)) {
    // Reemplazar la clave existente
    $envContent = preg_replace('/^APP_KEY=.*/m', "APP_KEY=$newKey", $envContent);
    echo "Clave APP_KEY reemplazada en el archivo .env\n";
} else {
    // Añadir la clave si no existe
    $envContent .= "\nAPP_KEY=$newKey\n";
    echo "Clave APP_KEY añadida al archivo .env\n";
}

// Escribir el contenido actualizado de vuelta al archivo .env
if (file_put_contents($envFilePath, $envContent) !== false) {
    echo "Archivo .env actualizado exitosamente.\n";
} else {
    echo "Error al escribir en el archivo .env.\n";
}
