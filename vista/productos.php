<?php
require_once 'common.php';
$currentPage = 'productos';
$pageTitle = 'Productos';
$providers = fetchRows($mysqli, 'SELECT idproveedor, nomproveedor FROM proveedores ORDER BY nomproveedor');
$categories = fetchRows($mysqli, 'SELECT idcategoria, nomcategoria FROM categorias ORDER BY nomcategoria');
$products = fetchRows($mysqli, 'SELECT p.*, pr.nomproveedor, c.nomcategoria FROM productos p LEFT JOIN proveedores pr ON p.idproveedor = pr.idproveedor LEFT JOIN categorias c ON p.idcategoria = c.idcategoria ORDER BY p.nomproducto');
if (isset($_GET['edit'])) {
    $editProduct = fetchOne($mysqli, 'SELECT * FROM productos WHERE idproducto = ? LIMIT 1', 's', [$_GET['edit']]);
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-boxes me-1"></i>
                                Mantenimiento de Productos
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a class="btn btn-primary" href="productos.php?new=1">Nuevo producto</a>
                                </div>
                                <?php if (isset($_GET['new']) || isset($editProduct)):
                                    $product = $editProduct ?? ['idproducto' => '', 'idproveedor' => '', 'idcategoria' => '', 'nomproducto' => '', 'unimed' => '', 'stock' => 0, 'cosuni' => 0, 'preuni' => 0, 'estado' => '1'];
                                ?>
                                    <form method="post" action="productos_save.php">
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
                                            <div class="col-md-2 mb-3">
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
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">Estado</label>
                                                <select class="form-select" name="estado">
                                                    <option value="1" <?php if ($product['estado'] === '1') echo 'selected'; ?>>Activo</option>
                                                    <option value="0" <?php if ($product['estado'] !== '1') echo 'selected'; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-success" type="submit">Guardar producto</button>
                                        <a class="btn btn-secondary" href="productos.php">Cancelar</a>
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
                                                        <a class="btn btn-sm btn-primary" href="productos.php?edit=<?php echo urlencode($product['idproducto']); ?>">Editar</a>
                                                        <a class="btn btn-sm btn-danger" href="productos_delete.php?id=<?php echo urlencode($product['idproducto']); ?>" onclick="return confirm('Eliminar producto?');">Eliminar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
