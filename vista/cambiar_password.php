<?php
require_once 'common.php';
$currentPage = 'cambiar_password';
$pageTitle = 'Cambiar Password';
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = trim($_POST['current_password'] ?? '');
    $new = trim($_POST['new_password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');
    if ($current === '' || $new === '' || $confirm === '') {
        $error = 'Complete todos los campos.';
    } elseif ($new !== $confirm) {
        $error = 'La nueva contraseña no coincide.';
    } else {
        $user = fetchOne($mysqli, 'SELECT password FROM usuarios WHERE idusuario = ? LIMIT 1', 's', [$_SESSION['user']['id']]);
        if (!$user || !password_verify($current, $user['password'])) {
            $error = 'Contraseña actual incorrecta.';
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare('UPDATE usuarios SET password = ? WHERE idusuario = ?');
            $stmt->bind_param('ss', $hash, $_SESSION['user']['id']);
            if ($stmt->execute()) {
                $message = 'Contraseña actualizada correctamente.';
            } else {
                $error = 'Error al actualizar la contraseña.';
            }
            $stmt->close();
        }
    }
}
require 'header.php';
?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-key me-1"></i>
                                Cambiar contraseña
                            </div>
                            <div class="card-body">
                                <?php if ($message): ?>
                                    <div class="alert alert-success"><?php echo safe($message); ?></div>
                                <?php endif; ?>
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo safe($error); ?></div>
                                <?php endif; ?>
                                <form method="post" action="cambiar_password.php">
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña actual</label>
                                        <input class="form-control" type="password" name="current_password" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nueva contraseña</label>
                                        <input class="form-control" type="password" name="new_password" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirmar nueva contraseña</label>
                                        <input class="form-control" type="password" name="confirm_password" />
                                    </div>
                                    <button class="btn btn-primary" type="submit">Cambiar contraseña</button>
                                </form>
                            </div>
                        </div>
<?php require 'footer.php'; ?>
