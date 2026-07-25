<?php
require_once 'common.php';
$currentPage = 'stock';
$pageTitle = 'Stock productos';
$stockRows = fetchRows($mysqli, 'SELECT p.idproducto, p.nomproducto, p.unimed, p.stock, p.preuni, c.nomcategoria FROM productos p LEFT JOIN categorias c ON p.idcategoria = c.idcategoria ORDER BY p.stock ASC');
require 'header.php';
?>
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
<?php require 'footer.php'; ?>
