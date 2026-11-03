<?php
require 'includes/auth.php';
require_role('driver');
require 'config/database.php';
$rideId = filter_input(INPUT_POST, 'ride_id', FILTER_VALIDATE_INT);
$action = $_POST['action'] ?? '';
$stmt = $pdo->prepare('SELECT driver_id, is_available FROM drivers WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$driver = $stmt->fetch();
if (!$driver || !$rideId) { header('Location: dashboard.php'); exit; }

if ($action === 'accept' && (int)$driver['is_available'] === 1) {
    // Conditional update prevents two drivers from claiming the same requested ride.
    $stmt = $pdo->prepare("UPDATE rides SET driver_id = ?, status = 'accepted' WHERE ride_id = ? AND status = 'requested' AND driver_id IS NULL");
    $stmt->execute([$driver['driver_id'], $rideId]);
    if ($stmt->rowCount() === 1) {
        $pdo->prepare('UPDATE drivers SET is_available = 0 WHERE driver_id = ?')->execute([$driver['driver_id']]);
    }
} elseif ($action === 'complete') {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE rides SET status = 'completed', completed_at = CURRENT_TIMESTAMP WHERE ride_id = ? AND driver_id = ? AND status = 'accepted'");
        $stmt->execute([$rideId, $driver['driver_id']]);
        if ($stmt->rowCount() === 1) {
            $pdo->prepare("UPDATE payments SET payment_status = 'pending' WHERE ride_id = ?")->execute([$rideId]);
            $pdo->prepare('UPDATE drivers SET is_available = 1 WHERE driver_id = ?')->execute([$driver['driver_id']]);
        }
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
    }
}
header('Location: dashboard.php');
exit;
