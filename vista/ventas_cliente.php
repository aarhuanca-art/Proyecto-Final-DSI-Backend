<?php
require_once 'common.php';
$currentPage = 'ventas_cliente';
$pageTitle = 'Ventas por cliente';
$clientId = trim($_GET['client'] ?? '');
$clients = fetchRows($mysqli, 'SELECT idcliente, nomcliente FROM clientes ORDER BY nomcliente');
$reportRows = [];
if ($clientId !== '') {
    $reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, SUM(d.cant*d.preuni) AS total FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE f.idcliente = ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 's', [$clientId]);
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-friends me-1"></i>
                                Ventas por cliente
                            </div>
                            <div class="card-body">
                                <form method="get" action="ventas_cliente.php">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Cliente</label>
                                            <select class="form-select" name="client">
                                                <option value="">-- Seleccione --</option>
                                                <?php foreach ($clients as $client): ?>
                                                    <option value="<?php echo safe($client['idcliente']); ?>" <?php echo $clientId === $client['idcliente'] ? 'selected' : ''; ?>><?php echo safe($client['nomcliente']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 align-self-end">
                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                                <?php if ($clientId !== ''): ?>
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
                                <?php endif; ?>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
