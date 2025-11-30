<?php
require 'db.php';
include 'templates/header.php';

// Obtener lista de usuarios
try {
    $stmt = $pdo->query('SELECT * FROM usuarios ORDER BY id ASC');
    $usuarios = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error al obtener usuarios: " . $e->getMessage();
}
?>

<h1>Lista de Usuarios</h1>
<a href="create.php"><button>Agregar Usuario</button></a>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php if ($usuarios): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $usuario['id']; ?>"><button>Editar</button></a>
                        <a href="delete.php?id=<?php echo $usuario['id']; ?>"><button>Eliminar</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay usuarios registrados.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<?php include 'templates/footer.php'; ?>