<?php
require_once 'common.php';
$currentPage = 'proveedores';
$pageTitle = 'Proveedores';
$providers = fetchRows($mysqli, 'SELECT * FROM proveedores ORDER BY nomproveedor');
if (isset($_GET['edit'])) {
    $editProvider = fetchOne($mysqli, 'SELECT * FROM proveedores WHERE idproveedor = ? LIMIT 1', 's', [$_GET['edit']]);
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-truck me-1"></i>
                                Proveedores
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a class="btn btn-primary" href="proveedores.php?new=1">Nuevo proveedor</a>
                                </div>
                                <?php if (isset($_GET['new']) || isset($editProvider)):
                                    $provider = $editProvider ?? ['idproveedor' => '', 'nomproveedor' => '', 'rucproveedor' => '', 'dirproveedor' => '', 'telproveedor' => '', 'emailproveedor' => ''];
                                ?>
                                    <form method="post" action="proveedores_save.php">
                                        <input type="hidden" name="idproveedor" value="<?php echo safe($provider['idproveedor']); ?>" />
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Proveedor</label>
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
                                        <a class="btn btn-secondary" href="proveedores.php">Cancelar</a>
                                    </form>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Proveedor</th>
                                                <th>RUC</th>
                                                <th>Dirección</th>
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
                                                    <td><?php echo safe($provider['dirproveedor']); ?></td>
                                                    <td><?php echo safe($provider['telproveedor']); ?></td>
                                                    <td><?php echo safe($provider['emailproveedor']); ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" href="proveedores.php?edit=<?php echo urlencode($provider['idproveedor']); ?>">Editar</a>
                                                        <a class="btn btn-sm btn-danger" href="proveedores_delete.php?id=<?php echo urlencode($provider['idproveedor']); ?>" onclick="return confirm('Eliminar proveedor?');">Eliminar</a>
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
