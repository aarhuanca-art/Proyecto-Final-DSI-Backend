<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
require_once __DIR__ . '/../conexion.php';

function safe($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function fetchRows($mysqli, $sql, $types = '', $params = []) {
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        return [];
    }
    if ($types !== '') {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

function fetchOne($mysqli, $sql, $types = '', $params = []) {
    $rows = fetchRows($mysqli, $sql, $types, $params);
    return $rows[0] ?? null;
}
