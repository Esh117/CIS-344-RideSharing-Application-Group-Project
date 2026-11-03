<?php
require 'includes/header.php';
require 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'passenger';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 8 || !in_array($role, ['passenger', 'driver'], true)) {
        $error = 'Enter a name, valid email, password of at least 8 characters, and role.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
            $userId = (int)$pdo->lastInsertId();

            if ($role === 'driver') {
                $_SESSION['pending_driver_user'] = $userId;
                header('Location: driver_setup.php');
                exit;
            }
            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $e) {
            $error = 'That email may already be registered. Try logging in or use another email.';
        }
    }
}
?>
<h1>Create account</h1>
<?php if ($error): ?><p class="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
    <label>Full name <input name="full_name" required maxlength="100"></label>
    <label>Email <input type="email" name="email" required></label>
    <label>Password (at least 8 characters) <input type="password" name="password" minlength="8" required></label>
    <label>Account type
        <select name="role"><option value="passenger">Passenger</option><option value="driver">Driver</option></select>
    </label>
    <button class="button" type="submit">Register</button>
</form>
<?php require 'includes/footer.php'; ?>
