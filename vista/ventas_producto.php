<?php
require_once 'common.php';
$currentPage = 'ventas_producto';
$pageTitle = 'Ventas por producto';
$productId = trim($_GET['product'] ?? '');
$products = fetchRows($mysqli, 'SELECT idproducto, nomproducto FROM productos ORDER BY nomproducto');
$reportRows = [];
if ($productId !== '') {
    $reportRows = fetchRows($mysqli, 'SELECT f.idfactura, f.fecha, c.nomcliente, SUM(d.cant*d.preuni) AS total, SUM(d.cant) AS cantidad FROM facturas f LEFT JOIN clientes c ON f.idcliente = c.idcliente LEFT JOIN detallefactura d ON f.idfactura = d.idfactura WHERE d.idproducto = ? GROUP BY f.idfactura ORDER BY f.fecha DESC', 's', [$productId]);
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-box-open me-1"></i>
                                Ventas por producto
                            </div>
                            <div class="card-body">
                                <form method="get" action="ventas_producto.php">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Producto</label>
                                            <select class="form-select" name="product">
                                                <option value="">-- Seleccione --</option>
                                                <?php foreach ($products as $product): ?>
                                                    <option value="<?php echo safe($product['idproducto']); ?>" <?php echo $productId === $product['idproducto'] ? 'selected' : ''; ?>><?php echo safe($product['nomproducto']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 align-self-end">
                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                                <?php if ($productId !== ''): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>Factura</th>
                                                    <th>Fecha</th>
                                                    <th>Cliente</th>
                                                    <th>Cantidad</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($reportRows as $row): ?>
                                                    <tr>
                                                        <td><?php echo safe($row['idfactura']); ?></td>
                                                        <td><?php echo safe($row['fecha']); ?></td>
                                                        <td><?php echo safe($row['nomcliente']); ?></td>
                                                        <td><?php echo safe($row['cantidad']); ?></td>
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
