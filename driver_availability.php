<?php
require 'includes/auth.php';
require_role('driver');
require 'config/database.php';
$available = ($_POST['available'] ?? '') === '1' ? 1 : 0;
$stmt = $pdo->prepare('UPDATE drivers SET is_available = ? WHERE user_id = ?');
$stmt->execute([$available, $_SESSION['user_id']]);
header('Location: dashboard.php');
exit;
