<?php
require_once 'common.php';
$currentPage = 'ventas_fecha';
$pageTitle = 'Ventas por fecha';
$from = trim($_GET['from'] ?? date('Y-m-01'));
$to = trim($_GET['to'] ?? date('Y-m-d'));
$reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, SUM(d.cant*d.preuni) AS total FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE DATE(f.fecha) BETWEEN ? AND ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 'ss', [$from, $to]);
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Ventas por fecha
                            </div>
                            <div class="card-body">
                                <form method="get" action="ventas_fecha.php">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Desde</label>
                                            <input class="form-control" type="date" name="from" value="<?php echo safe($from); ?>" />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Hasta</label>
                                            <input class="form-control" type="date" name="to" value="<?php echo safe($to); ?>" />
                                        </div>
                                        <div class="col-md-2 align-self-end">
                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Factura</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reportRows as $row): ?>
                                                <tr>
                                                    <td><?php echo safe($row['idfactura']); ?></td>
                                                    <td><?php echo safe($row['fecha']); ?></td>
                                                    <td><?php echo safe($row['nomcliente']); ?></td>
                                                    <td><?php echo number_format($row['total'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
