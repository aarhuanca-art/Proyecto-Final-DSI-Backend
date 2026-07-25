<?php
require_once 'common.php';
$currentPage = 'clientes';
$pageTitle = 'Clientes';
$clients = fetchRows($mysqli, 'SELECT * FROM clientes ORDER BY nomcliente');
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-friends me-1"></i>
                                Mantenimiento de Clientes
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a class="btn btn-primary" href="clientes.php?new=1">Nuevo cliente</a>
                                </div>
                                <?php if (isset($_GET['new']) || isset($_GET['edit'])):
                                    $client = ['idcliente' => '', 'nomcliente' => '', 'ruccliente' => '', 'dircliente' => '', 'telcliente' => '', 'emailcliente' => ''];
                                    if (isset($_GET['edit'])) {
                                        $client = fetchOne($mysqli, 'SELECT * FROM clientes WHERE idcliente = ? LIMIT 1', 's', [$_GET['edit']]);
                                    }
                                ?>
                                    <form method="post" action="clientes_save.php">
                                        <input type="hidden" name="idcliente" value="<?php echo safe($client['idcliente']); ?>" />
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input class="form-control" name="nomcliente" value="<?php echo safe($client['nomcliente']); ?>" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">RUC</label>
                                                <input class="form-control" name="ruccliente" value="<?php echo safe($client['ruccliente']); ?>" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dirección</label>
                                                <input class="form-control" name="dircliente" value="<?php echo safe($client['dircliente']); ?>" />
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input class="form-control" name="telcliente" value="<?php echo safe($client['telcliente']); ?>" />
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" name="emailcliente" value="<?php echo safe($client['emailcliente']); ?>" />
                                            </div>
                                        </div>
                                        <button class="btn btn-success" type="submit">Guardar cliente</button>
                                        <a class="btn btn-secondary" href="clientes.php">Cancelar</a>
                                    </form>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Nombre</th>
                                                <th>RUC</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($clients as $client): ?>
                                                <tr>
                                                    <td><?php echo safe($client['idcliente']); ?></td>
                                                    <td><?php echo safe($client['nomcliente']); ?></td>
                                                    <td><?php echo safe($client['ruccliente']); ?></td>
                                                    <td><?php echo safe($client['dircliente']); ?></td>
                                                    <td><?php echo safe($client['telcliente']); ?></td>
                                                    <td><?php echo safe($client['emailcliente']); ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" href="clientes.php?edit=<?php echo urlencode($client['idcliente']); ?>">Editar</a>
                                                        <a class="btn btn-sm btn-danger" href="clientes_delete.php?id=<?php echo urlencode($client['idcliente']); ?>" onclick="return confirm('Eliminar cliente?');">Eliminar</a>
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
