<?php
require 'includes/header.php';
require 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT user_id, full_name, password_hash, role FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Email or password was not correct.';
}
?>
<h1>Log in</h1>
<?php if (isset($_GET['registered'])): ?><p class="success">Registration complete. You can log in.</p><?php endif; ?>
<?php if ($error): ?><p class="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
    <label>Email <input type="email" name="email" required></label>
    <label>Password <input type="password" name="password" required></label>
    <button class="button" type="submit">Log in</button>
</form>
<?php require 'includes/footer.php'; ?>
