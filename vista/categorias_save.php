<?php
require_once 'common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: categorias.php');
    exit;
}
$id = trim($_POST['idcategoria'] ?? '');
$name = trim($_POST['nomcategoria'] ?? '');
if ($name === '') {
    header('Location: categorias.php?error=' . urlencode('El nombre de la categoría es obligatorio.'));
    exit;
}
if ($id === '') {
    $id = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 2));
    if ($id === '') {
        $id = uniqid('CA');
    }
    $stmt = $mysqli->prepare('INSERT INTO categorias (idcategoria, nomcategoria) VALUES (?, ?)');
    $stmt->bind_param('ss', $id, $name);
    $stmt->execute();
    $stmt->close();
    header('Location: categorias.php?message=' . urlencode('Categoría agregada correctamente.'));
    exit;
}
$stmt = $mysqli->prepare('UPDATE categorias SET nomcategoria = ? WHERE idcategoria = ?');
$stmt->bind_param('ss', $name, $id);
$stmt->execute();
$stmt->close();
header('Location: categorias.php?message=' . urlencode('Categoría actualizada correctamente.'));
exit;
