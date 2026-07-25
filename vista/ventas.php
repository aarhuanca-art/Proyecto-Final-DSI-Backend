<?php
require_once 'common.php';
$currentPage = 'ventas';
$pageTitle = 'Registrar Ventas';
$clients = fetchRows($mysqli, 'SELECT idcliente, nomcliente FROM clientes ORDER BY nomcliente');
$products = fetchRows($mysqli, 'SELECT idproducto, nomproducto, stock, preuni FROM productos ORDER BY nomproducto');
$conditions = fetchRows($mysqli, 'SELECT idcondicion, nomcondicion FROM condicionventa ORDER BY idcondicion');
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idcliente = trim($_POST['idcliente'] ?? '');
    $idcondicion = trim($_POST['idcondicion'] ?? '');
    $fecha = trim($_POST['fecha'] ?? date('Y-m-d'));
    $itemProducts = $_POST['idproducto'] ?? [];
    $itemQuantities = $_POST['cantidad'] ?? [];
    $items = [];
    foreach ($itemProducts as $index => $productId) {
        $qty = (int) trim($itemQuantities[$index] ?? 0);
        if ($productId !== '' && $qty > 0) {
            $items[] = ['idproducto' => $productId, 'cantidad' => $qty];
        }
    }
    if ($idcliente === '' || $idcondicion === '' || empty($items)) {
        $error = 'Seleccione cliente, condición y al menos un producto con cantidad válida.';
    } else {
        $productTotals = [];
        $totalValue = 0;
        $productsById = [];
        foreach ($items as $item) {
            if (!isset($productsById[$item['idproducto']])) {
                $product = fetchOne($mysqli, 'SELECT stock, preuni, cosuni FROM productos WHERE idproducto = ? LIMIT 1', 's', [$item['idproducto']]);
                if (!$product) {
                    $error = 'Producto no encontrado: ' . safe($item['idproducto']);
                    break;
                }
                $productsById[$item['idproducto']] = $product;
                $productTotals[$item['idproducto']] = 0;
            }
            $productTotals[$item['idproducto']] += $item['cantidad'];
        }
        if ($error === '') {
            foreach ($productTotals as $productId => $qty) {
                if ($productsById[$productId]['stock'] < $qty) {
                    $error = 'Stock insuficiente para el producto seleccionado.';
                    break;
                }
            }
        }
        if ($error === '') {
            foreach ($items as $item) {
                $totalValue += $productsById[$item['idproducto']]['preuni'] * $item['cantidad'];
            }
            $valorventa = round($totalValue, 4);
            $igv = round($valorventa * 0.18, 4);
            $fechareg = date('Y-m-d H:i:s');
            $mysqli->begin_transaction();
            try {
                $stmt = $mysqli->prepare('INSERT INTO facturas (fecha, idcliente, idusuario, fechareg, idcondicion, valorventa, igv) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssissdd', $fecha, $idcliente, $_SESSION['user']['id'], $fechareg, $idcondicion, $valorventa, $igv);
                $stmt->execute();
                $facturaId = $mysqli->insert_id;
                $stmt->close();
                $stmt = $mysqli->prepare('INSERT INTO detallefactura (idfactura, idproducto, cant, cosuni, preuni) VALUES (?, ?, ?, ?, ?)');
                foreach ($items as $item) {
                    $product = $productsById[$item['idproducto']];
                    $stmt->bind_param('isidd', $facturaId, $item['idproducto'], $item['cantidad'], $product['cosuni'], $product['preuni']);
                    $stmt->execute();
                }
                $stmt->close();
                $stmt = $mysqli->prepare('UPDATE productos SET stock = ? WHERE idproducto = ?');
                foreach ($productTotals as $productId => $qty) {
                    $newStock = $productsById[$productId]['stock'] - $qty;
                    $stmt->bind_param('is', $newStock, $productId);
                    $stmt->execute();
                }
                $stmt->close();
                $mysqli->commit();
                header('Location: ventas.php?message=' . urlencode('Venta registrada correctamente.'));
                exit;
            } catch (Exception $e) {
                $mysqli->rollback();
                $error = 'Error al registrar la venta.';
            }
        }
    }
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-cash-register me-1"></i>
                                Registrar Venta
                            </div>
                            <div class="card-body">
                                <?php if ($message): ?>
                                    <div class="alert alert-success"><?php echo safe($message); ?></div>
                                <?php endif; ?>
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo safe($error); ?></div>
                                <?php endif; ?>
                                <form method="post" action="ventas.php" id="ventaForm">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Cliente</label>
                                            <select class="form-select" name="idcliente">
                                                <option value="">-- Seleccione --</option>
                                                <?php foreach ($clients as $client): ?>
                                                    <option value="<?php echo safe($client['idcliente']); ?>"><?php echo safe($client['nomcliente']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Condición</label>
                                            <select class="form-select" name="idcondicion">
                                                <?php foreach ($conditions as $condition): ?>
                                                    <option value="<?php echo safe($condition['idcondicion']); ?>"><?php echo safe($condition['nomcondicion']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Fecha</label>
                                            <input class="form-control" type="date" name="fecha" value="<?php echo safe(date('Y-m-d')); ?>" />
                                        </div>
                                    </div>
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered" id="ventaItemsTable">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-select" name="idproducto[]">
                                                            <option value="">-- Seleccione --</option>
                                                            <?php foreach ($products as $product): ?>
                                                                <option value="<?php echo safe($product['idproducto']); ?>"><?php echo safe($product['nomproducto']); ?> (Stock: <?php echo safe($product['stock']); ?>)</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" type="number" min="1" name="cantidad[]" value="1" /></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary mb-3" id="addRow">Agregar producto</button>
                                    <br />
                                    <button class="btn btn-success" type="submit">Registrar Venta</button>
                                </form>
                                <template id="ventaRowTemplate">
                                    <tr>
                                        <td>
                                            <select class="form-select" name="idproducto[]">
                                                <option value="">-- Seleccione --</option>
                                                <?php foreach ($products as $product): ?>
                                                    <option value="<?php echo safe($product['idproducto']); ?>"><?php echo safe($product['nomproducto']); ?> (Stock: <?php echo safe($product['stock']); ?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><input class="form-control" type="number" min="1" name="cantidad[]" value="1" /></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
                                    </tr>
                                </template>
                            </div>
                        </div>
                        <script>
                            document.getElementById('addRow').addEventListener('click', function () {
                                const template = document.getElementById('ventaRowTemplate');
                                const clone = template.content.firstElementChild.cloneNode(true);
                                clone.querySelector('.remove-row').addEventListener('click', function () {
                                    clone.remove();
                                });
                                document.querySelector('#ventaItemsTable tbody').appendChild(clone);
                            });
                            document.querySelectorAll('.remove-row').forEach(function (button) {
                                button.addEventListener('click', function () {
                                    button.closest('tr').remove();
                                });
                            });
                        </script>
<?php require 'footer.php'; ?>
