<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    $stmt->execute(['id' => $id]);
    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    echo "Error al eliminar el usuario: " . $e->getMessage();
}
?>