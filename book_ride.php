<?php
require 'includes/auth.php';
require_role('passenger');
require 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config/database.php';
    $pickup = trim($_POST['pickup_location'] ?? '');
    $dropoff = trim($_POST['dropoff_location'] ?? '');
    $distance = filter_input(INPUT_POST, 'distance_miles', FILTER_VALIDATE_FLOAT);
    if ($pickup === '' || $dropoff === '' || $distance === false || $distance === null || $distance <= 0 || $distance > 1000) {
        $error = 'Enter pickup, drop-off, and a distance greater than 0 and no more than 1000 miles.';
    } else {
        // Example classroom fare: $3.00 base fare + $2.00 per mile.
        $fare = round(3 + (2 * $distance), 2);
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO rides (passenger_id, pickup_location, dropoff_location, distance_miles, fare) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $pickup, $dropoff, $distance, $fare]);
            $rideId = (int)$pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO payments (ride_id, amount, payment_method, payment_status) VALUES (?, ?, 'demo_card', 'pending')");
            $stmt->execute([$rideId, $fare]);
            $pdo->commit();
            header('Location: dashboard.php'); exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Could not save the ride. Please try again.';
        }
    }
}
?>
<h1>Request a ride</h1>
<p class="notice">Demo fare = $3.00 base fare + $2.00 per mile. This is a sample formula for the class project.</p>
<?php if ($error): ?><p class="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
    <label>Pickup location <input name="pickup_location" required maxlength="255"></label>
    <label>Drop-off location <input name="dropoff_location" required maxlength="255"></label>
    <label>Estimated distance in miles <input type="number" name="distance_miles" min="0.1" max="1000" step="0.1" required></label>
    <button class="button" type="submit">Submit ride request</button>
</form>
<?php require 'includes/footer.php'; ?>
