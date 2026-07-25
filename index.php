<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? 'dashboard';
$message = '';
$error = '';
$userId = $_SESSION['user']['id'];
$userName = $_SESSION['user']['fullname'] ?: $_SESSION['user']['username'];

function getValue($name, $default = '') {
    return trim($_POST[$name] ?? $default);
}

function safe($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'save_client') {
        $id = getValue('idcliente');
        $nom = getValue('nomcliente');
        $ruc = getValue('ruccliente');
        $dir = getValue('dircliente');
        $tel = getValue('telcliente');
        $email = getValue('emailcliente');

        if ($nom === '') {
            $error = 'El nombre del cliente es obligatorio.';
        } else {
            if ($id === '') {
                $stmt = $mysqli->prepare('INSERT INTO clientes (idcliente, nomcliente, ruccliente, dircliente, telcliente, emailcliente) VALUES (?, ?, ?, ?, ?, ?)');
                $id = uniqid('C');
                $stmt->bind_param('ssssss', $id, $nom, $ruc, $dir, $tel, $email);
                $stmt->execute();
                $stmt->close();
                $message = 'Cliente agregado correctamente.';
            } else {
                $stmt = $mysqli->prepare('UPDATE clientes SET nomcliente = ?, ruccliente = ?, dircliente = ?, telcliente = ?, emailcliente = ? WHERE idcliente = ?');
                $stmt->bind_param('ssssss', $nom, $ruc, $dir, $tel, $email, $id);
                $stmt->execute();
                $stmt->close();
                $message = 'Cliente actualizado correctamente.';
            }
            header('Location: index.php?action=clientes&message=' . urlencode($message));
            exit;
        }
    }

    if ($formType === 'delete_client') {
        $id = getValue('idcliente');
        if ($id !== '') {
            $stmt = $mysqli->prepare('DELETE FROM clientes WHERE idcliente = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Cliente eliminado.';
        }
        header('Location: index.php?action=clientes&message=' . urlencode($message));
        exit;
    }

    if ($formType === 'save_product') {
        $id = getValue('idproducto');
        $provider = getValue('idproveedor');
        $name = getValue('nomproducto');
        $unit = getValue('unimed');
        $stock = (int) getValue('stock');
        $cost = (float) getValue('cosuni');
        $price = (float) getValue('preuni');
        $category = getValue('idcategoria');
        $state = getValue('estado') ?: '1';

        if ($name === '') {
            $error = 'El nombre del producto es obligatorio.';
        } else {
            if ($id === '') {
                $stmt = $mysqli->prepare('INSERT INTO productos (idproducto, idproveedor, nomproducto, unimed, stock, cosuni, preuni, idcategoria, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $id = uniqid('P');
                $stmt->bind_param('ssssiddds', $id, $provider, $name, $unit, $stock, $cost, $price, $category, $state);
                $stmt->execute();
                $stmt->close();
                $message = 'Producto agregado correctamente.';
            } else {
                $stmt = $mysqli->prepare('UPDATE productos SET idproveedor = ?, nomproducto = ?, unimed = ?, stock = ?, cosuni = ?, preuni = ?, idcategoria = ?, estado = ? WHERE idproducto = ?');
                $stmt->bind_param('sssiddsss', $provider, $name, $unit, $stock, $cost, $price, $category, $state, $id);
                $stmt->execute();
                $stmt->close();
                $message = 'Producto actualizado correctamente.';
            }
            header('Location: index.php?action=productos&message=' . urlencode($message));
            exit;
        }
    }

    if ($formType === 'delete_product') {
        $id = getValue('idproducto');
        if ($id !== '') {
            $stmt = $mysqli->prepare('DELETE FROM productos WHERE idproducto = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Producto eliminado.';
        }
        header('Location: index.php?action=productos&message=' . urlencode($message));
        exit;
    }

    if ($formType === 'save_category') {
        $id = getValue('idcategoria');
        $name = getValue('nomcategoria');
        if ($name === '') {
            $error = 'El nombre de la categoría es obligatorio.';
        } else {
            if ($id === '') {
                $id = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 2));
                if ($id === '') {
                    $id = uniqid('CA');
                }
                $stmt = $mysqli->prepare('INSERT INTO categorias (idcategoria, nomcategoria) VALUES (?, ?)');
                $stmt->bind_param('ss', $id, $name);
                $stmt->execute();
                $stmt->close();
                $message = 'Categoría agregada.';
            } else {
                $stmt = $mysqli->prepare('UPDATE categorias SET nomcategoria = ? WHERE idcategoria = ?');
                $stmt->bind_param('ss', $name, $id);
                $stmt->execute();
                $stmt->close();
                $message = 'Categoría actualizada.';
            }
            header('Location: index.php?action=categorias&message=' . urlencode($message));
            exit;
        }
    }

    if ($formType === 'delete_category') {
        $id = getValue('idcategoria');
        if ($id !== '') {
            $stmt = $mysqli->prepare('DELETE FROM categorias WHERE idcategoria = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Categoría eliminada.';
        }
        header('Location: index.php?action=categorias&message=' . urlencode($message));
        exit;
    }

    if ($formType === 'save_provider') {
        $id = getValue('idproveedor');
        $name = getValue('nomproveedor');
        $ruc = getValue('rucproveedor');
        $dir = getValue('dirproveedor');
        $tel = getValue('telproveedor');
        $email = getValue('emailproveedor');
        if ($name === '') {
            $error = 'El nombre del proveedor es obligatorio.';
        } else {
            if ($id === '') {
                $id = uniqid('V');
                $stmt = $mysqli->prepare('INSERT INTO proveedores (idproveedor, nomproveedor, rucproveedor, dirproveedor, telproveedor, emailproveedor) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssss', $id, $name, $ruc, $dir, $tel, $email);
                $stmt->execute();
                $stmt->close();
                $message = 'Proveedor agregado.';
            } else {
                $stmt = $mysqli->prepare('UPDATE proveedores SET nomproveedor = ?, rucproveedor = ?, dirproveedor = ?, telproveedor = ?, emailproveedor = ? WHERE idproveedor = ?');
                $stmt->bind_param('ssssss', $name, $ruc, $dir, $tel, $email, $id);
                $stmt->execute();
                $stmt->close();
                $message = 'Proveedor actualizado.';
            }
            header('Location: index.php?action=proveedores&message=' . urlencode($message));
            exit;
        }
    }

    if ($formType === 'delete_provider') {
        $id = getValue('idproveedor');
        if ($id !== '') {
            $stmt = $mysqli->prepare('DELETE FROM proveedores WHERE idproveedor = ?');
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->close();
            $message = 'Proveedor eliminado.';
        }
        header('Location: index.php?action=proveedores&message=' . urlencode($message));
        exit;
    }

    if ($formType === 'save_sale') {
        $idcliente = getValue('idcliente');
        $idproducto = getValue('idproducto');
        $cantidad = (int) getValue('cantidad');
        $idcondicion = getValue('idcondicion');
        $fecha = getValue('fecha') ?: date('Y-m-d');

        if ($idcliente === '' || $idproducto === '' || $cantidad <= 0) {
            $error = 'Seleccione cliente, producto y cantidad.';
        } else {
            $productoStmt = $mysqli->prepare('SELECT stock, preuni, cosuni FROM productos WHERE idproducto = ? LIMIT 1');
            $productoStmt->bind_param('s', $idproducto);
            $productoStmt->execute();
            $productoResult = $productoStmt->get_result();
            $producto = $productoResult->fetch_assoc();
            $productoStmt->close();

            if (!$producto) {
                $error = 'Producto no encontrado.';
            } elseif ($producto['stock'] < $cantidad) {
                $error = 'Stock insuficiente para la venta.';
            } else {
                $valorventa = round($producto['preuni'] * $cantidad, 4);
                $igv = round($valorventa * 0.18, 4);
                $fechareg = date('Y-m-d H:i:s');
                $newStock = $producto['stock'] - $cantidad;
                $facturaId = null;

                $mysqli->begin_transaction();
                try {
                    $stmt = $mysqli->prepare('INSERT INTO facturas (fecha, idcliente, idusuario, fechareg, idcondicion, valorventa, igv) VALUES (?, ?, ?, ?, ?, ?, ?)');
                    $stmt->bind_param('ssissdd', $fecha, $idcliente, $userId, $fechareg, $idcondicion, $valorventa, $igv);
                    $stmt->execute();
                    $facturaId = $mysqli->insert_id;
                    $stmt->close();

                    $stmt = $mysqli->prepare('INSERT INTO detallefactura (idfactura, idproducto, cant, cosuni, preuni) VALUES (?, ?, ?, ?, ?)');
                    $stmt->bind_param('isidd', $facturaId, $idproducto, $cantidad, $producto['cosuni'], $producto['preuni']);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $mysqli->prepare('UPDATE productos SET stock = ? WHERE idproducto = ?');
                    $stmt->bind_param('is', $newStock, $idproducto);
                    $stmt->execute();
                    $stmt->close();

                    $mysqli->commit();
                    $message = 'Venta registrada correctamente.';
                    header('Location: index.php?action=ventas&message=' . urlencode($message));
                    exit;
                } catch (Exception $e) {
                    $mysqli->rollback();
                    $error = 'Error al registrar la venta: ' . $e->getMessage();
                }
            }
        }
    }

    if ($formType === 'change_password') {
        $current = getValue('current_password');
        $newpass = getValue('new_password');
        $confirm = getValue('confirm_password');

        if ($current === '' || $newpass === '' || $confirm === '') {
            $error = 'Complete todos los campos.';
        } elseif ($newpass !== $confirm) {
            $error = 'La nueva contraseña no coincide.';
        } else {
            $stmt = $mysqli->prepare('SELECT password FROM usuarios WHERE idusuario = ? LIMIT 1');
            $stmt->bind_param('s', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if (!$row || (!password_verify($current, $row['password']) && $current !== $row['password'])) {
                $error = 'Contraseña actual incorrecta.';
            } else {
                $hash = password_hash($newpass, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare('UPDATE usuarios SET password = ? WHERE idusuario = ?');
                $stmt->bind_param('ss', $hash, $userId);
                $stmt->execute();
                $stmt->close();
                $message = 'Contraseña actualizada.';
                header('Location: index.php?action=cambiar_password&message=' . urlencode($message));
                exit;
            }
        }
    }
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

function getCounts($mysqli) {
    $tables = ['clientes', 'productos', 'categorias', 'proveedores', 'facturas'];
    $counts = [];
    foreach ($tables as $table) {
        $result = $mysqli->query("SELECT COUNT(*) AS total FROM {$table}");
        $counts[$table] = $result->fetch_assoc()['total'] ?? 0;
    }
    return $counts;
}

$counts = getCounts($mysqli);

function fetchRows($mysqli, $sql, $types = '', $params = []) {
    $stmt = $mysqli->prepare($sql);
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

function actionLink($name) {
    return 'index.php?action=' . $name;
}

$clients = fetchRows($mysqli, 'SELECT * FROM clientes ORDER BY nomcliente');
$providers = fetchRows($mysqli, 'SELECT * FROM proveedores ORDER BY nomproveedor');
$categories = fetchRows($mysqli, 'SELECT * FROM categorias ORDER BY nomcategoria');
$products = fetchRows($mysqli, 'SELECT p.*, c.nomproveedor, cat.nomcategoria FROM productos p LEFT JOIN proveedores c ON p.idproveedor = c.idproveedor LEFT JOIN categorias cat ON p.idcategoria = cat.idcategoria ORDER BY p.nomproducto');
$conditions = fetchRows($mysqli, 'SELECT * FROM condicionventa ORDER BY idcondicion');

if ($action === 'clientes' && isset($_GET['edit'])) {
    $editClient = fetchOne($mysqli, 'SELECT * FROM clientes WHERE idcliente = ? LIMIT 1', 's', [$_GET['edit']]);
}

if ($action === 'productos' && isset($_GET['edit'])) {
    $editProduct = fetchOne($mysqli, 'SELECT * FROM productos WHERE idproducto = ? LIMIT 1', 's', [$_GET['edit']]);
}

if ($action === 'categorias' && isset($_GET['edit'])) {
    $editCategory = fetchOne($mysqli, 'SELECT * FROM categorias WHERE idcategoria = ? LIMIT 1', 's', [$_GET['edit']]);
}

if ($action === 'proveedores' && isset($_GET['edit'])) {
    $editProvider = fetchOne($mysqli, 'SELECT * FROM proveedores WHERE idproveedor = ? LIMIT 1', 's', [$_GET['edit']]);
}

if ($action === 'ventas') {
    $salesToday = fetchRows($mysqli, "SELECT f.idfactura, f.fecha, c.nomcliente, u.nomusuario, f.valorventa, f.igv FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN usuarios u ON f.idusuario = u.idusuario ORDER BY f.fecha DESC LIMIT 10");
}

if ($action === 'stock') {
    $stockRows = fetchRows($mysqli, 'SELECT p.idproducto, p.nomproducto, p.unimed, p.stock, p.preuni, cat.nomcategoria FROM productos p LEFT JOIN categorias cat ON p.idcategoria = cat.idcategoria ORDER BY p.stock ASC');
}

if ($action === 'ventas_fecha' || $action === 'ventas_cliente' || $action === 'ventas_producto' || $action === 'ranking' || $action === 'ventas_dia') {
    $from = getValue('from_date', date('Y-m-01'));
    $to = getValue('to_date', date('Y-m-d'));
    if ($action === 'ventas_dia') {
        $from = $to = date('Y-m-d');
    }
    if ($action === 'ventas_fecha') {
        $reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, u.nomusuario, SUM(d.cant*d.preuni) AS total FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN usuarios u ON f.idusuario = u.idusuario LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE f.fecha BETWEEN ? AND ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 'ss', [$from, $to]);
    }
    if ($action === 'ventas_cliente') {
        $selectedClient = getValue('idcliente');
        $reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, SUM(d.cant*d.preuni) AS total FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE c.idcliente = ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 's', [$selectedClient]);
    }
    if ($action === 'ventas_producto') {
        $selectedProduct = getValue('idproducto');
        $reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, p.nomproducto, SUM(d.cant*d.preuni) AS total, SUM(d.cant) AS quantity FROM detallefactura d LEFT JOIN facturas f ON d.idfactura = f.idfactura LEFT JOIN productos p ON d.idproducto = p.idproducto WHERE p.idproducto = ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 's', [$selectedProduct]);
    }
    if ($action === 'ranking') {
        $reportRows = fetchRows($mysqli, 'SELECT p.nomproducto, SUM(d.cant*d.preuni) AS total, SUM(d.cant) AS cantidad FROM detallefactura d LEFT JOIN productos p ON d.idproducto = p.idproducto GROUP BY d.idproducto ORDER BY total DESC LIMIT 10');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de Facturación y Control de Stocks" />
        <meta name="author" content="Proyecto Final" />
        <title>Sistema de Facturación</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Facturación</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="index.php?action=cambiar_password">Cambiar contraseña</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Archivos</div>
                            <a class="nav-link" href="index.php?action=productos">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Productos
                            </a>
                            <a class="nav-link" href="index.php?action=clientes">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Clientes
                            </a>
                            <a class="nav-link" href="index.php?action=proveedores">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Proveedores
                            </a>
                            <a class="nav-link" href="index.php?action=categorias">
                                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                Categorías
                            </a>
                            <a class="nav-link" href="index.php?action=usuarios">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Usuarios
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Terminar
                            </a>
                            <div class="sb-sidenav-menu-heading">Procesos</div>
                            <a class="nav-link" href="index.php?action=ventas">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Registrar Ventas
                            </a>
                            <div class="sb-sidenav-menu-heading">Consultas</div>
                            <a class="nav-link" href="index.php?action=stock">
                                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                                Stock productos
                            </a>
                            <a class="nav-link" href="index.php?action=ventas_dia">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
                                Ventas por día
                            </a>
                            <a class="nav-link" href="index.php?action=ventas_fecha">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                                Ventas por fecha
                            </a>
                            <a class="nav-link" href="index.php?action=ventas_cliente">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Venta por cliente
                            </a>
                            <a class="nav-link" href="index.php?action=ventas_producto">
                                <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                                Venta por producto
                            </a>
                            <a class="nav-link" href="index.php?action=ranking">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Ranking ventas
                            </a>
                            <div class="sb-sidenav-menu-heading">Herramientas</div>
                            <a class="nav-link" href="index.php?action=cambiar_password">
                                <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                                Cambiar Password
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Conectado como:</div>
                        <?php echo safe($userName); ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?php echo $action === 'dashboard' ? 'Dashboard' : ucfirst(str_replace('_', ' ', $action)); ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $action === 'dashboard' ? 'Resumen general' : ucfirst(str_replace('_', ' ', $action)); ?></li>
                        </ol>

                        <?php if ($message): ?>
                            <div class="alert alert-success"><?php echo safe($message); ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo safe($error); ?></div>
                        <?php endif; ?>

                        <?php if ($action === 'dashboard'): ?>
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary text-white mb-4">
                                        <div class="card-body">Clientes: <?php echo $counts['clientes']; ?></div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php?action=clientes">Ver clientes</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-warning text-white mb-4">
                                        <div class="card-body">Productos: <?php echo $counts['productos']; ?></div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php?action=productos">Ver productos</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body">Facturas: <?php echo $counts['facturas']; ?></div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php?action=ventas">Ver ventas</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">Proveedores: <?php echo $counts['proveedores']; ?></div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php?action=proveedores">Ver proveedores</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($action === 'clientes'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user-friends me-1"></i>
                                    Mantenimiento de Clientes
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a class="btn btn-primary" href="index.php?action=clientes&new=1">Nuevo cliente</a>
                                    </div>
                                    <?php if (isset($_GET['new']) || isset($editClient)): ?>
                                        <?php $client = $editClient ?? ['idcliente' => '', 'nomcliente' => '', 'ruccliente' => '', 'dircliente' => '', 'telcliente' => '', 'emailcliente' => '']; ?>
                                        <form method="post" action="index.php?action=clientes">
                                            <input type="hidden" name="form_type" value="save_client" />
                                            <input type="hidden" name="idcliente" value="<?php echo safe($client['idcliente']); ?>" />
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input class="form-control" name="nomcliente" value="<?php echo safe($client['nomcliente']); ?>" />
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">RUC</label>
                                                    <input class="form-control" name="ruccliente" value="<?php echo safe($client['ruccliente']); ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dirección</label>
                                                    <input class="form-control" name="dircliente" value="<?php echo safe($client['dircliente']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Teléfono</label>
                                                    <input class="form-control" name="telcliente" value="<?php echo safe($client['telcliente']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" name="emailcliente" value="<?php echo safe($client['emailcliente']); ?>" />
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="submit">Guardar cliente</button>
                                            <a class="btn btn-secondary" href="index.php?action=clientes">Cancelar</a>
                                        </form>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>Cod</th>
                                                        <th>Nombre</th>
                                                        <th>RUC</th>
                                                        <th>Dirección</th>
                                                        <th>Teléfono</th>
                                                        <th>Email</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($clients as $client): ?>
                                                        <tr>
                                                            <td><?php echo safe($client['idcliente']); ?></td>
                                                            <td><?php echo safe($client['nomcliente']); ?></td>
                                                            <td><?php echo safe($client['ruccliente']); ?></td>
                                                            <td><?php echo safe($client['dircliente']); ?></td>
                                                            <td><?php echo safe($client['telcliente']); ?></td>
                                                            <td><?php echo safe($client['emailcliente']); ?></td>
                                                            <td>
                                                                <a class="btn btn-sm btn-primary" href="index.php?action=clientes&edit=<?php echo urlencode($client['idcliente']); ?>">Editar</a>
                                                                <form class="d-inline" method="post" action="index.php?action=clientes" onsubmit="return confirm('Eliminar cliente?');">
                                                                    <input type="hidden" name="form_type" value="delete_client" />
                                                                    <input type="hidden" name="idcliente" value="<?php echo safe($client['idcliente']); ?>" />
                                                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'productos'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-boxes me-1"></i>
                                    Mantenimiento de Productos
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a class="btn btn-primary" href="index.php?action=productos&new=1">Nuevo producto</a>
                                    </div>
                                    <?php if (isset($_GET['new']) || isset($editProduct)): ?>
                                        <?php $product = $editProduct ?? ['idproducto' => '', 'idproveedor' => '', 'nomproducto' => '', 'unimed' => '', 'stock' => 0, 'cosuni' => 0, 'preuni' => 0, 'idcategoria' => '', 'estado' => '1']; ?>
                                        <form method="post" action="index.php?action=productos">
                                            <input type="hidden" name="form_type" value="save_product" />
                                            <input type="hidden" name="idproducto" value="<?php echo safe($product['idproducto']); ?>" />
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Producto</label>
                                                    <input class="form-control" name="nomproducto" value="<?php echo safe($product['nomproducto']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Proveedor</label>
                                                    <select class="form-select" name="idproveedor">
                                                        <option value="">-- Seleccione --</option>
                                                        <?php foreach ($providers as $provider): ?>
                                                            <option value="<?php echo safe($provider['idproveedor']); ?>" <?php if ($provider['idproveedor'] === $product['idproveedor']) echo 'selected'; ?>><?php echo safe($provider['nomproveedor']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Categoría</label>
                                                    <select class="form-select" name="idcategoria">
                                                        <option value="">-- Seleccione --</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo safe($category['idcategoria']); ?>" <?php if ($category['idcategoria'] === $product['idcategoria']) echo 'selected'; ?>><?php echo safe($category['nomcategoria']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Unidad</label>
                                                    <input class="form-control" name="unimed" value="<?php echo safe($product['unimed']); ?>" />
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Stock</label>
                                                    <input class="form-control" type="number" name="stock" value="<?php echo safe($product['stock']); ?>" />
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Costo</label>
                                                    <input class="form-control" type="number" step="0.01" name="cosuni" value="<?php echo safe($product['cosuni']); ?>" />
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Precio</label>
                                                    <input class="form-control" type="number" step="0.01" name="preuni" value="<?php echo safe($product['preuni']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Estado</label>
                                                    <select class="form-select" name="estado">
                                                        <option value="1" <?php if ($product['estado'] === '1') echo 'selected'; ?>>Activo</option>
                                                        <option value="0" <?php if ($product['estado'] !== '1') echo 'selected'; ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="submit">Guardar producto</button>
                                            <a class="btn btn-secondary" href="index.php?action=productos">Cancelar</a>
                                        </form>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Nombre</th>
                                                        <th>Proveedor</th>
                                                        <th>Categoría</th>
                                                        <th>Unidad</th>
                                                        <th>Stock</th>
                                                        <th>Precio</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($products as $product): ?>
                                                        <tr>
                                                            <td><?php echo safe($product['idproducto']); ?></td>
                                                            <td><?php echo safe($product['nomproducto']); ?></td>
                                                            <td><?php echo safe($product['nomproveedor']); ?></td>
                                                            <td><?php echo safe($product['nomcategoria']); ?></td>
                                                            <td><?php echo safe($product['unimed']); ?></td>
                                                            <td><?php echo safe($product['stock']); ?></td>
                                                            <td><?php echo safe($product['preuni']); ?></td>
                                                            <td><?php echo $product['estado'] === '1' ? 'Activo' : 'Inactivo'; ?></td>
                                                            <td>
                                                                <a class="btn btn-sm btn-primary" href="index.php?action=productos&edit=<?php echo urlencode($product['idproducto']); ?>">Editar</a>
                                                                <form class="d-inline" method="post" action="index.php?action=productos" onsubmit="return confirm('Eliminar producto?');">
                                                                    <input type="hidden" name="form_type" value="delete_product" />
                                                                    <input type="hidden" name="idproducto" value="<?php echo safe($product['idproducto']); ?>" />
                                                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'categorias'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-tags me-1"></i>
                                    Categorías
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a class="btn btn-primary" href="index.php?action=categorias&new=1">Nueva categoría</a>
                                    </div>
                                    <?php if (isset($_GET['new']) || isset($editCategory)): ?>
                                        <?php $category = $editCategory ?? ['idcategoria' => '', 'nomcategoria' => '']; ?>
                                        <form method="post" action="index.php?action=categorias">
                                            <input type="hidden" name="form_type" value="save_category" />
                                            <input type="hidden" name="idcategoria" value="<?php echo safe($category['idcategoria']); ?>" />
                                            <div class="mb-3">
                                                <label class="form-label">Categoría</label>
                                                <input class="form-control" name="nomcategoria" value="<?php echo safe($category['nomcategoria']); ?>" />
                                            </div>
                                            <button class="btn btn-success" type="submit">Guardar categoría</button>
                                            <a class="btn btn-secondary" href="index.php?action=categorias">Cancelar</a>
                                        </form>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Categoría</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($categories as $category): ?>
                                                        <tr>
                                                            <td><?php echo safe($category['idcategoria']); ?></td>
                                                            <td><?php echo safe($category['nomcategoria']); ?></td>
                                                            <td>
                                                                <a class="btn btn-sm btn-primary" href="index.php?action=categorias&edit=<?php echo urlencode($category['idcategoria']); ?>">Editar</a>
                                                                <form class="d-inline" method="post" action="index.php?action=categorias" onsubmit="return confirm('Eliminar categoría?');">
                                                                    <input type="hidden" name="form_type" value="delete_category" />
                                                                    <input type="hidden" name="idcategoria" value="<?php echo safe($category['idcategoria']); ?>" />
                                                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'proveedores'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-truck me-1"></i>
                                    Proveedores
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a class="btn btn-primary" href="index.php?action=proveedores&new=1">Nuevo proveedor</a>
                                    </div>
                                    <?php if (isset($_GET['new']) || isset($editProvider)): ?>
                                        <?php $provider = $editProvider ?? ['idproveedor' => '', 'nomproveedor' => '', 'rucproveedor' => '', 'dirproveedor' => '', 'telproveedor' => '', 'emailproveedor' => '']; ?>
                                        <form method="post" action="index.php?action=proveedores">
                                            <input type="hidden" name="form_type" value="save_provider" />
                                            <input type="hidden" name="idproveedor" value="<?php echo safe($provider['idproveedor']); ?>" />
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input class="form-control" name="nomproveedor" value="<?php echo safe($provider['nomproveedor']); ?>" />
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">RUC</label>
                                                    <input class="form-control" name="rucproveedor" value="<?php echo safe($provider['rucproveedor']); ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dirección</label>
                                                    <input class="form-control" name="dirproveedor" value="<?php echo safe($provider['dirproveedor']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Teléfono</label>
                                                    <input class="form-control" name="telproveedor" value="<?php echo safe($provider['telproveedor']); ?>" />
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" name="emailproveedor" value="<?php echo safe($provider['emailproveedor']); ?>" />
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="submit">Guardar proveedor</button>
                                            <a class="btn btn-secondary" href="index.php?action=proveedores">Cancelar</a>
                                        </form>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="datatablesSimple">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Proveedor</th>
                                                        <th>RUC</th>
                                                        <th>Teléfono</th>
                                                        <th>Email</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($providers as $provider): ?>
                                                        <tr>
                                                            <td><?php echo safe($provider['idproveedor']); ?></td>
                                                            <td><?php echo safe($provider['nomproveedor']); ?></td>
                                                            <td><?php echo safe($provider['rucproveedor']); ?></td>
                                                            <td><?php echo safe($provider['telproveedor']); ?></td>
                                                            <td><?php echo safe($provider['emailproveedor']); ?></td>
                                                            <td>
                                                                <a class="btn btn-sm btn-primary" href="index.php?action=proveedores&edit=<?php echo urlencode($provider['idproveedor']); ?>">Editar</a>
                                                                <form class="d-inline" method="post" action="index.php?action=proveedores" onsubmit="return confirm('Eliminar proveedor?');">
                                                                    <input type="hidden" name="form_type" value="delete_provider" />
                                                                    <input type="hidden" name="idproveedor" value="<?php echo safe($provider['idproveedor']); ?>" />
                                                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'usuarios'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user-cog me-1"></i>
                                    Usuarios
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">Los usuarios se almacenan en la tabla <strong>usuarios</strong>. Aquí puedes ver los nombres y el email registrados.</div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Usuario</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Email</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (fetchRows($mysqli, 'SELECT idusuario, nomusuario, nombres, apellidos, email, estado FROM usuarios ORDER BY nomusuario') as $userRow): ?>
                                                    <tr>
                                                        <td><?php echo safe($userRow['idusuario']); ?></td>
                                                        <td><?php echo safe($userRow['nomusuario']); ?></td>
                                                        <td><?php echo safe($userRow['nombres']); ?></td>
                                                        <td><?php echo safe($userRow['apellidos']); ?></td>
                                                        <td><?php echo safe($userRow['email']); ?></td>
                                                        <td><?php echo $userRow['estado'] === '1' ? 'Activo' : 'Inactivo'; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($action === 'ventas'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-cash-register me-1"></i>
                                    Registrar Venta
                                </div>
                                <div class="card-body">
                                    <form method="post" action="index.php?action=ventas">
                                        <input type="hidden" name="form_type" value="save_sale" />
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Cliente</label>
                                                <select class="form-select" name="idcliente">
                                                    <option value="">-- Seleccione --</option>
                                                    <?php foreach ($clients as $client): ?>
                                                        <option value="<?php echo safe($client['idcliente']); ?>"><?php echo safe($client['nomcliente']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Producto</label>
                                                <select class="form-select" name="idproducto">
                                                    <option value="">-- Seleccione --</option>
                                                    <?php foreach ($products as $product): ?>
                                                        <option value="<?php echo safe($product['idproducto']); ?>"><?php echo safe($product['nomproducto']); ?> (Stock: <?php echo safe($product['stock']); ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">Cantidad</label>
                                                <input class="form-control" type="number" name="cantidad" min="1" value="1" />
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">Condición</label>
                                                <select class="form-select" name="idcondicion">
                                                    <?php foreach ($conditions as $condition): ?>
                                                        <option value="<?php echo safe($condition['idcondicion']); ?>"><?php echo safe($condition['nomcondicion']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Fecha</label>
                                                <input class="form-control" type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>
                                        <button class="btn btn-success" type="submit">Registrar Venta</button>
                                    </form>
                                    <?php if (!empty($salesToday)): ?>
                                        <hr />
                                        <h5>Últimas ventas</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Factura</th>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Usuario</th>
                                                        <th>Total</th>
                                                        <th>IGV</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($salesToday as $sale): ?>
                                                        <tr>
                                                            <td><?php echo safe($sale['idfactura']); ?></td>
                                                            <td><?php echo safe($sale['fecha']); ?></td>
                                                            <td><?php echo safe($sale['nomcliente']); ?></td>
                                                            <td><?php echo safe($sale['nomusuario']); ?></td>
                                                            <td><?php echo number_format($sale['valorventa'], 2); ?></td>
                                                            <td><?php echo number_format($sale['igv'], 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'stock'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-warehouse me-1"></i>
                                    Stock de Productos
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Producto</th>
                                                    <th>Categoría</th>
                                                    <th>Unidad</th>
                                                    <th>Stock</th>
                                                    <th>Precio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stockRows as $product): ?>
                                                    <tr>
                                                        <td><?php echo safe($product['idproducto']); ?></td>
                                                        <td><?php echo safe($product['nomproducto']); ?></td>
                                                        <td><?php echo safe($product['nomcategoria']); ?></td>
                                                        <td><?php echo safe($product['unimed']); ?></td>
                                                        <td><?php echo safe($product['stock']); ?></td>
                                                        <td><?php echo number_format($product['preuni'], 2); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($action === 'ventas_fecha' || $action === 'ventas_cliente' || $action === 'ventas_producto' || $action === 'ventas_dia' || $action === 'ranking'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-line me-1"></i>
                                    Consultas y reportes
                                </div>
                                <div class="card-body">
                                    <?php if ($action === 'ventas_fecha' || $action === 'ventas_cliente' || $action === 'ventas_producto' || $action === 'ventas_dia'): ?>
                                        <form method="post" action="index.php?action=<?php echo $action; ?>">
                                            <input type="hidden" name="form_type" value="search_report" />
                                            <?php if ($action !== 'ventas_dia'): ?>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Desde</label>
                                                        <input class="form-control" type="date" name="from_date" value="<?php echo safe($from); ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Hasta</label>
                                                        <input class="form-control" type="date" name="to_date" value="<?php echo safe($to); ?>" />
                                                    </div>
                                                    <?php if ($action === 'ventas_cliente'): ?>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Cliente</label>
                                                            <select class="form-select" name="idcliente">
                                                                <option value="">-- Seleccione --</option>
                                                                <?php foreach ($clients as $client): ?>
                                                                    <option value="<?php echo safe($client['idcliente']); ?>" <?php if (($selectedClient ?? '') === $client['idcliente']) echo 'selected'; ?>><?php echo safe($client['nomcliente']); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    <?php elseif ($action === 'ventas_producto'): ?>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Producto</label>
                                                            <select class="form-select" name="idproducto">
                                                                <option value="">-- Seleccione --</option>
                                                                <?php foreach ($products as $product): ?>
                                                                    <option value="<?php echo safe($product['idproducto']); ?>" <?php if (($selectedProduct ?? '') === $product['idproducto']) echo 'selected'; ?>><?php echo safe($product['nomproducto']); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($action !== 'ventas_dia'): ?>
                                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </form>
                                        <?php if (!empty($reportRows)): ?>
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered" id="datatablesSimple">
                                                    <thead>
                                                        <tr>
                                                            <?php if ($action === 'ventas_fecha'): ?>
                                                                <th>Factura</th><th>Fecha</th><th>Cliente</th><th>Usuario</th><th>Total</th>
                                                            <?php elseif ($action === 'ventas_cliente'): ?>
                                                                <th>Factura</th><th>Fecha</th><th>Cliente</th><th>Total</th>
                                                            <?php elseif ($action === 'ventas_producto'): ?>
                                                                <th>Factura</th><th>Fecha</th><th>Producto</th><th>Cantidad</th><th>Total</th>
                                                            <?php elseif ($action === 'ventas_dia'): ?>
                                                                <th>Factura</th><th>Fecha</th><th>Cliente</th><th>Total</th>
                                                            <?php elseif ($action === 'ranking'): ?>
                                                                <th>Producto</th><th>Cantidad</th><th>Total</th>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($reportRows as $row): ?>
                                                            <tr>
                                                                <?php if ($action === 'ventas_fecha'): ?>
                                                                    <td><?php echo safe($row['idfactura']); ?></td>
                                                                    <td><?php echo safe($row['fecha']); ?></td>
                                                                    <td><?php echo safe($row['nomcliente']); ?></td>
                                                                    <td><?php echo safe($row['nomusuario']); ?></td>
                                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                                <?php elseif ($action === 'ventas_cliente'): ?>
                                                                    <td><?php echo safe($row['idfactura']); ?></td>
                                                                    <td><?php echo safe($row['fecha']); ?></td>
                                                                    <td><?php echo safe($row['nomcliente']); ?></td>
                                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                                <?php elseif ($action === 'ventas_producto'): ?>
                                                                    <td><?php echo safe($row['idfactura']); ?></td>
                                                                    <td><?php echo safe($row['fecha']); ?></td>
                                                                    <td><?php echo safe($row['nomproducto']); ?></td>
                                                                    <td><?php echo safe($row['quantity']); ?></td>
                                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                                <?php elseif ($action === 'ventas_dia'): ?>
                                                                    <td><?php echo safe($row['idfactura']); ?></td>
                                                                    <td><?php echo safe($row['fecha']); ?></td>
                                                                    <td><?php echo safe($row['nomcliente']); ?></td>
                                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                                <?php elseif ($action === 'ranking'): ?>
                                                                    <td><?php echo safe($row['nomproducto']); ?></td>
                                                                    <td><?php echo safe($row['cantidad']); ?></td>
                                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php elseif ($action === 'cambiar_password'): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-key me-1"></i>
                                    Cambiar contraseña
                                </div>
                                <div class="card-body">
                                    <form method="post" action="index.php?action=cambiar_password">
                                        <input type="hidden" name="form_type" value="change_password" />
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña actual</label>
                                            <input class="form-control" type="password" name="current_password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nueva contraseña</label>
                                            <input class="form-control" type="password" name="new_password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirmar nueva contraseña</label>
                                            <input class="form-control" type="password" name="confirm_password" />
                                        </div>
                                        <button class="btn btn-primary" type="submit">Actualizar contraseña</button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card mb-4">
                                <div class="card-body">Seleccione una opción del menú izquierdo para comenzar.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Sistema de Facturación 2026</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
