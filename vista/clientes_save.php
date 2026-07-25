<?php
require_once 'common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: clientes.php');
    exit;
}
$id = trim($_POST['idcliente'] ?? '');
$nom = trim($_POST['nomcliente'] ?? '');
$ruc = trim($_POST['ruccliente'] ?? '');
$dir = trim($_POST['dircliente'] ?? '');
$tel = trim($_POST['telcliente'] ?? '');
$email = trim($_POST['emailcliente'] ?? '');
if ($nom === '') {
    header('Location: clientes.php?error=' . urlencode('El nombre del cliente es obligatorio.'));
    exit;
}
if ($id === '') {
    $id = uniqid('C');
    $stmt = $mysqli->prepare('INSERT INTO clientes (idcliente, nomcliente, ruccliente, dircliente, telcliente, emailcliente) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $id, $nom, $ruc, $dir, $tel, $email);
    $stmt->execute();
    $stmt->close();
    header('Location: clientes.php?message=' . urlencode('Cliente agregado correctamente.'));
    exit;
}
$stmt = $mysqli->prepare('UPDATE clientes SET nomcliente = ?, ruccliente = ?, dircliente = ?, telcliente = ?, emailcliente = ? WHERE idcliente = ?');
$stmt->bind_param('ssssss', $nom, $ruc, $dir, $tel, $email, $id);
$stmt->execute();
$stmt->close();
header('Location: clientes.php?message=' . urlencode('Cliente actualizado correctamente.'));
exit;
