<?php
require_once 'common.php';
$currentPage = 'ranking';
$pageTitle = 'Ranking ventas';
$topRows = fetchRows($mysqli, 'SELECT p.idproducto, p.nomproducto, SUM(d.cant) AS total_cantidad, SUM(d.cant*d.preuni) AS total_venta FROM detallefactura d LEFT JOIN productos p ON d.idproducto = p.idproducto GROUP BY p.idproducto ORDER BY total_venta DESC LIMIT 20');
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-line me-1"></i>
                                Ranking de Ventas por Producto
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad vendida</th>
                                                <th>Total venta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($topRows as $row): ?>
                                                <tr>
                                                    <td><?php echo safe($row['nomproducto']); ?></td>
                                                    <td><?php echo safe($row['total_cantidad']); ?></td>
                                                    <td><?php echo number_format($row['total_venta'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
