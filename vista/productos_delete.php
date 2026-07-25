<?php
require_once 'common.php';
$id = trim($_GET['id'] ?? '');
if ($id !== '') {
    $stmt = $mysqli->prepare('DELETE FROM productos WHERE idproducto = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}
header('Location: productos.php?message=' . urlencode('Producto eliminado.'));
exit;
