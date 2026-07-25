<?php
require_once 'common.php';
$id = trim($_GET['id'] ?? '');
if ($id !== '') {
    $stmt = $mysqli->prepare('DELETE FROM categorias WHERE idcategoria = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}
header('Location: categorias.php?message=' . urlencode('Categoría eliminada correctamente.'));
exit;
