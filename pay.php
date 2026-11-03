<?php
require 'includes/auth.php';
require_role('passenger');
require 'config/database.php';
$rideId = filter_input(INPUT_POST, 'ride_id', FILTER_VALIDATE_INT);
if ($rideId) {
    // Simulated payment only: no real card data is collected or processed.
    $stmt = $pdo->prepare(
        "UPDATE payments p JOIN rides r ON r.ride_id = p.ride_id
         SET p.payment_status = 'paid', p.paid_at = CURRENT_TIMESTAMP
         WHERE p.ride_id = ? AND r.passenger_id = ? AND r.status = 'completed' AND p.payment_status = 'pending'"
    );
    $stmt->execute([$rideId, $_SESSION['user_id']]);
}
header('Location: dashboard.php');
exit;
