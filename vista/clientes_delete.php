<?php
require_once 'common.php';
$id = trim($_GET['id'] ?? '');
if ($id !== '') {
    $stmt = $mysqli->prepare('DELETE FROM clientes WHERE idcliente = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}
header('Location: clientes.php?message=' . urlencode('Cliente eliminado.'));
exit;
