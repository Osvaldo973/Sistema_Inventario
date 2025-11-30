<?php
require 'db.php';
include 'templates/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Inicializar variables y errores
$nombre = $email = $telefono = '';
$errores = [];

// Obtener los datos actuales del usuario
try {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit;
    }

    $nombre = $usuario['nombre'];
    $email = $usuario['email'];
    $telefono = $usuario['telefono'];
    
} catch (PDOException $e) {
    echo "Error al obtener el usuario: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar nombre
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } else {
        $nombre = trim($_POST['nombre']);
    }

    // Validar email
    if (empty($_POST['email'])) {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'El correo electrónico no es válido.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validar teléfono
    if (empty($_POST['telefono'])) {
        $errores['telefono'] = 'El teléfono es obligatorio.';
    } else {
        $telefono = trim($_POST['telefono']);
    }

    // Si no hay errores, actualizar en la base de datos
    if (empty($errores)) {
        try {
            $sql = 'UPDATE usuarios SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nombre' => $nombre,
                'email' => $email,
                'telefono' => $telefono,
                'id' => $id
            ]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $errores['email'] = 'El correo electrónico ya está registrado.';
            } else {
                echo "Error al actualizar el usuario: " . $e->getMessage();
            }
        }
    }
}
?>

<h2>Editar Usuario</h2>

<form method="POST" class="formulario">
    <label for="nombre">Nombre Completo:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
    <?php if (isset($errores['nombre'])): ?>
        <p class="error"><?php echo $errores['nombre']; ?></p>
    <?php endif; ?>

    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
    <?php if (isset($errores['email'])): ?>
        <p class="error"><?php echo $errores['email']; ?></p>
    <?php endif; ?>

    <label for="telefono">Teléfono:</label>
    <input type="tel" name="telefono" id="telefono" value="<?php echo htmlspecialchars($telefono); ?>">
    <?php if (isset($errores['telefono'])): ?>
        <p class="error"><?php echo $errores['telefono']; ?></p>
    <?php endif; ?>

    <button type="submit">Actualizar</button>
</form>

<?php include 'templates/footer.php'; ?>