<?php
if (!isset($currentPage)) {
    $currentPage = 'dashboard';
}
if (!isset($pageTitle)) {
    $pageTitle = ucfirst(str_replace('_', ' ', $currentPage));
}
function menuActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de Facturación" />
        <meta name="author" content="Proyecto Final" />
        <title><?php echo safe($pageTitle); ?> - Sistema de Facturación</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="dashboard.php">Facturación</a>
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
                        <li><a class="dropdown-item" href="cambiar_password.php">Cambiar contraseña</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../logout.php">Cerrar sesión</a></li>
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
                            <a class="nav-link <?php echo menuActive('productos'); ?>" href="productos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Productos
                            </a>
                            <a class="nav-link <?php echo menuActive('clientes'); ?>" href="clientes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Clientes
                            </a>
                            <a class="nav-link <?php echo menuActive('proveedores'); ?>" href="proveedores.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Proveedores
                            </a>
                            <a class="nav-link <?php echo menuActive('categorias'); ?>" href="categorias.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                Categorías
                            </a>
                            <a class="nav-link <?php echo menuActive('usuarios'); ?>" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Usuarios
                            </a>
                            <a class="nav-link" href="../logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Terminar
                            </a>
                            <div class="sb-sidenav-menu-heading">Procesos</div>
                            <a class="nav-link <?php echo menuActive('ventas'); ?>" href="ventas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Registrar Ventas
                            </a>
                            <div class="sb-sidenav-menu-heading">Consultas</div>
                            <a class="nav-link <?php echo menuActive('stock'); ?>" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                                Stock productos
                            </a>
                            <a class="nav-link <?php echo menuActive('ventas_dia'); ?>" href="ventas_dia.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-day"></i></div>
                                Ventas por día
                            </a>
                            <a class="nav-link <?php echo menuActive('ventas_fecha'); ?>" href="ventas_fecha.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                                Ventas por fecha
                            </a>
                            <a class="nav-link <?php echo menuActive('ventas_cliente'); ?>" href="ventas_cliente.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Venta por cliente
                            </a>
                            <a class="nav-link <?php echo menuActive('ventas_producto'); ?>" href="ventas_producto.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                                Venta por producto
                            </a>
                            <a class="nav-link <?php echo menuActive('ranking'); ?>" href="ranking.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Ranking ventas
                            </a>
                            <div class="sb-sidenav-menu-heading">Herramientas</div>
                            <a class="nav-link <?php echo menuActive('cambiar_password'); ?>" href="cambiar_password.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                                Cambiar Password
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Conectado como:</div>
                        <?php echo safe($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']); ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?php echo safe($pageTitle); ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo safe($pageTitle); ?></li>
                        </ol>
