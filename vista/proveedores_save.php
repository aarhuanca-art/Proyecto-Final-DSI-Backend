<?php
require_once 'common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: proveedores.php');
    exit;
}
$id = trim($_POST['idproveedor'] ?? '');
$name = trim($_POST['nomproveedor'] ?? '');
$ruc = trim($_POST['rucproveedor'] ?? '');
$dir = trim($_POST['dirproveedor'] ?? '');
$tel = trim($_POST['telproveedor'] ?? '');
$email = trim($_POST['emailproveedor'] ?? '');
if ($name === '') {
    header('Location: proveedores.php?error=' . urlencode('El nombre del proveedor es obligatorio.'));
    exit;
}
if ($id === '') {
    $id = uniqid('V');
    $stmt = $mysqli->prepare('INSERT INTO proveedores (idproveedor, nomproveedor, rucproveedor, dirproveedor, telproveedor, emailproveedor) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $id, $name, $ruc, $dir, $tel, $email);
    $stmt->execute();
    $stmt->close();
    header('Location: proveedores.php?message=' . urlencode('Proveedor agregado correctamente.'));
    exit;
}
$stmt = $mysqli->prepare('UPDATE proveedores SET nomproveedor = ?, rucproveedor = ?, dirproveedor = ?, telproveedor = ?, emailproveedor = ? WHERE idproveedor = ?');
$stmt->bind_param('ssssss', $name, $ruc, $dir, $tel, $email, $id);
$stmt->execute();
$stmt->close();
header('Location: proveedores.php?message=' . urlencode('Proveedor actualizado correctamente.'));
exit;
