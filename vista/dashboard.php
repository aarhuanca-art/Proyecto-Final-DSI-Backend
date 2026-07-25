<?php
require_once 'common.php';
$currentPage = 'dashboard';
$pageTitle = 'Dashboard';
require 'header.php';
?>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2>Archivos</h2>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="productos.php">
                                    <div class="card border-primary h-100">
                                        <div class="card-body text-primary text-center">
                                            <i class="fas fa-boxes fa-2x mb-3"></i>
                                            <div>Productos</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="clientes.php">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-success text-center">
                                            <i class="fas fa-users fa-2x mb-3"></i>
                                            <div>Clientes</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="proveedores.php">
                                    <div class="card border-warning h-100">
                                        <div class="card-body text-warning text-center">
                                            <i class="fas fa-truck fa-2x mb-3"></i>
                                            <div>Proveedores</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="categorias.php">
                                    <div class="card border-info h-100">
                                        <div class="card-body text-info text-center">
                                            <i class="fas fa-tags fa-2x mb-3"></i>
                                            <div>Categorías</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="usuarios.php">
                                    <div class="card border-secondary h-100">
                                        <div class="card-body text-secondary text-center">
                                            <i class="fas fa-user-cog fa-2x mb-3"></i>
                                            <div>Usuarios</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="../logout.php">
                                    <div class="card border-danger h-100">
                                        <div class="card-body text-danger text-center">
                                            <i class="fas fa-sign-out-alt fa-2x mb-3"></i>
                                            <div>Terminar</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2>Procesos</h2>
                            </div>
                            <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ventas.php">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-success text-center">
                                            <i class="fas fa-cash-register fa-2x mb-3"></i>
                                            <div>Registrar Ventas</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2>Consultas</h2>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="stock.php">
                                    <div class="card border-primary h-100">
                                        <div class="card-body text-primary text-center">
                                            <i class="fas fa-warehouse fa-2x mb-3"></i>
                                            <div>Stock productos</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ventas_dia.php">
                                    <div class="card border-info h-100">
                                        <div class="card-body text-info text-center">
                                            <i class="fas fa-calendar-day fa-2x mb-3"></i>
                                            <div>Ventas por día</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ventas_fecha.php">
                                    <div class="card border-warning h-100">
                                        <div class="card-body text-warning text-center">
                                            <i class="fas fa-calendar-alt fa-2x mb-3"></i>
                                            <div>Ventas por fecha</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ventas_cliente.php">
                                    <div class="card border-secondary h-100">
                                        <div class="card-body text-secondary text-center">
                                            <i class="fas fa-user fa-2x mb-3"></i>
                                            <div>Venta por cliente</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ventas_producto.php">
                                    <div class="card border-dark h-100">
                                        <div class="card-body text-dark text-center">
                                            <i class="fas fa-box-open fa-2x mb-3"></i>
                                            <div>Venta por producto</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="ranking.php">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-success text-center">
                                            <i class="fas fa-chart-line fa-2x mb-3"></i>
                                            <div>Ranking ventas</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2>Herramientas</h2>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                                <a class="text-decoration-none" href="cambiar_password.php">
                                    <div class="card border-secondary h-100">
                                        <div class="card-body text-secondary text-center">
                                            <i class="fas fa-key fa-2x mb-3"></i>
                                            <div>Cambiar Password</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
<?php
require 'footer.php';
