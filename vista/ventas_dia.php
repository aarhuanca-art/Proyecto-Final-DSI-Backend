<?php
require_once 'common.php';
$currentPage = 'ventas_dia';
$pageTitle = 'Ventas por día';
$date = trim($_GET['date'] ?? date('Y-m-d'));
$reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, SUM(d.cant*d.preuni) AS total FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE DATE(f.fecha) = ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 's', [$date]);
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-calendar-day me-1"></i>
                                Ventas por día
                            </div>
                            <div class="card-body">
                                <form method="get" action="ventas_dia.php">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Fecha</label>
                                            <input class="form-control" type="date" name="date" value="<?php echo safe($date); ?>" />
                                        </div>
                                        <div class="col-md-3 align-self-end">
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
