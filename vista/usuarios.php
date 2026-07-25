<?php
require_once 'common.php';
$currentPage = 'usuarios';
$pageTitle = 'Usuarios';
$users = fetchRows($mysqli, 'SELECT idusuario, nomusuario, nombres, apellidos, email, estado FROM usuarios ORDER BY nomusuario');
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-cog me-1"></i>
                                Usuarios
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">La administración de usuarios se realiza directamente desde la tabla <strong>usuarios</strong>.</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Usuario</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?php echo safe($user['idusuario']); ?></td>
                                                    <td><?php echo safe($user['nomusuario']); ?></td>
                                                    <td><?php echo safe($user['nombres']); ?></td>
                                                    <td><?php echo safe($user['apellidos']); ?></td>
                                                    <td><?php echo safe($user['email']); ?></td>
                                                    <td><?php echo $user['estado'] === '1' ? 'Activo' : 'Inactivo'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
