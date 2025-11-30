<?php
// Configuración de la base de datos
$db_host = 'localhost';
$db_name = 'crud_formulario_db';
$db_user = 'root';
$db_pass = '';

// Opciones de PDO
$db_options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo de errores con excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Modo de obtención de resultados
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Emulación de consultas preparadas
);

try {
    // Crear instancia de PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass, $db_options);
} catch (PDOException $e) {
    // Manejo de errores de conexión
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit;
}
?>