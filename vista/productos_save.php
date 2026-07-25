<?php
require_once 'common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: productos.php');
    exit;
}
$id = trim($_POST['idproducto'] ?? '');
$provider = trim($_POST['idproveedor'] ?? '');
$category = trim($_POST['idcategoria'] ?? '');
$name = trim($_POST['nomproducto'] ?? '');
$unit = trim($_POST['unimed'] ?? '');
$stock = (int) trim($_POST['stock'] ?? 0);
$cost = (float) trim($_POST['cosuni'] ?? 0);
$price = (float) trim($_POST['preuni'] ?? 0);
$state = trim($_POST['estado'] ?? '1');
if ($name === '') {
    header('Location: productos.php?error=' . urlencode('El nombre del producto es obligatorio.'));
    exit;
}
if ($id === '') {
    $id = uniqid('P');
    $stmt = $mysqli->prepare('INSERT INTO productos (idproducto, idproveedor, nomproducto, unimed, stock, cosuni, preuni, idcategoria, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssiddds', $id, $provider, $name, $unit, $stock, $cost, $price, $category, $state);
    $stmt->execute();
    $stmt->close();
    header('Location: productos.php?message=' . urlencode('Producto agregado correctamente.'));
    exit;
}
$stmt = $mysqli->prepare('UPDATE productos SET idproveedor = ?, nomproducto = ?, unimed = ?, stock = ?, cosuni = ?, preuni = ?, idcategoria = ?, estado = ? WHERE idproducto = ?');
$stmt->bind_param('sssiddsss', $provider, $name, $unit, $stock, $cost, $price, $category, $state, $id);
$stmt->execute();
$stmt->close();
header('Location: productos.php?message=' . urlencode('Producto actualizado correctamente.'));
exit;
