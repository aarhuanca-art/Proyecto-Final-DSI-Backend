<?php
require_once 'common.php';
$currentPage = 'categorias';
$pageTitle = 'Categorías';
$categories = fetchRows($mysqli, 'SELECT * FROM categorias ORDER BY nomcategoria');
if (isset($_GET['edit'])) {
    $editCategory = fetchOne($mysqli, 'SELECT * FROM categorias WHERE idcategoria = ? LIMIT 1', 's', [$_GET['edit']]);
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-tags me-1"></i>
                                Categorías
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a class="btn btn-primary" href="categorias.php?new=1">Nueva categoría</a>
                                </div>
                                <?php if (isset($_GET['new']) || isset($editCategory)):
                                    $category = $editCategory ?? ['idcategoria' => '', 'nomcategoria' => ''];
                                ?>
                                    <form method="post" action="categorias_save.php">
                                        <input type="hidden" name="idcategoria" value="<?php echo safe($category['idcategoria']); ?>" />
                                        <div class="mb-3">
                                            <label class="form-label">Categoría</label>
                                            <input class="form-control" name="nomcategoria" value="<?php echo safe($category['nomcategoria']); ?>" />
                                        </div>
                                        <button class="btn btn-success" type="submit">Guardar categoría</button>
                                        <a class="btn btn-secondary" href="categorias.php">Cancelar</a>
                                    </form>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Categoría</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?php echo safe($category['idcategoria']); ?></td>
                                                    <td><?php echo safe($category['nomcategoria']); ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" href="categorias.php?edit=<?php echo urlencode($category['idcategoria']); ?>">Editar</a>
                                                        <a class="btn btn-sm btn-danger" href="categorias_delete.php?id=<?php echo urlencode($category['idcategoria']); ?>" onclick="return confirm('Eliminar categoría?');">Eliminar</a>
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
