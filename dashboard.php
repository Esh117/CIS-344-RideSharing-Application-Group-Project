<?php
require 'includes/auth.php';
require_login();
require 'includes/header.php';
require 'config/database.php';
?>
<h1>Hello, <?= htmlspecialchars($_SESSION['full_name']) ?></h1>
<?php if ($_SESSION['role'] === 'passenger'): ?>
    <p>Request a ride and review your ride history.</p>
    <a class="button" href="book_ride.php">Request a ride</a>
    <?php
    $stmt = $pdo->prepare(
        "SELECT r.ride_id, r.pickup_location, r.dropoff_location, r.distance_miles, r.fare, r.status, r.requested_at,
                duser.full_name AS driver_name, p.payment_status
         FROM rides r
         JOIN users passenger ON passenger.user_id = r.passenger_id
         LEFT JOIN drivers d ON d.driver_id = r.driver_id
         LEFT JOIN users duser ON duser.user_id = d.user_id
         LEFT JOIN payments p ON p.ride_id = r.ride_id
         WHERE r.passenger_id = ?
         ORDER BY r.requested_at DESC"
    );
    $stmt->execute([$_SESSION['user_id']]);
    $rides = $stmt->fetchAll();
    ?>
    <h2>Your rides</h2>
    <?php if (!$rides): ?><p>No rides yet.</p><?php else: ?>
    <div class="table-wrap"><table><tr><th>ID</th><th>Route</th><th>Distance</th><th>Fare</th><th>Status</th><th>Driver</th><th>Payment</th><th>Action</th></tr>
    <?php foreach ($rides as $ride): ?>
    <tr>
        <td><?= (int)$ride['ride_id'] ?></td>
        <td><?= htmlspecialchars($ride['pickup_location']) ?> → <?= htmlspecialchars($ride['dropoff_location']) ?></td>
        <td><?= htmlspecialchars($ride['distance_miles']) ?> mi</td>
        <td>$<?= number_format((float)$ride['fare'], 2) ?></td>
        <td><?= htmlspecialchars($ride['status']) ?></td>
        <td><?= htmlspecialchars($ride['driver_name'] ?? 'Not assigned') ?></td>
        <td><?= htmlspecialchars($ride['payment_status'] ?? 'Not created') ?></td>
        <td><?php if ($ride['status'] === 'completed' && ($ride['payment_status'] ?? '') === 'pending'): ?>
            <form method="post" action="pay.php"><input type="hidden" name="ride_id" value="<?= (int)$ride['ride_id'] ?>"><button class="button small" type="submit">Demo pay</button></form>
        <?php else: ?>—<?php endif; ?></td>
    </tr>
    <?php endforeach; ?></table></div>
    <?php endif; ?>
<?php else: ?>
    <?php
    $stmt = $pdo->prepare('SELECT driver_id, is_available FROM drivers WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $driver = $stmt->fetch();
    if (!$driver) {
        echo '<p>Driver profile not found. Please contact the project administrator.</p>';
    } else {
    ?>
    <p>Availability: <strong><?= $driver['is_available'] ? 'Available' : 'Unavailable' ?></strong></p>
    <form method="post" action="driver_availability.php">
        <input type="hidden" name="available" value="<?= $driver['is_available'] ? '0' : '1' ?>">
        <button class="button" type="submit"><?= $driver['is_available'] ? 'Go unavailable' : 'Go available' ?></button>
    </form>
    <?php
    $stmt = $pdo->query(
        "SELECT r.ride_id, r.pickup_location, r.dropoff_location, r.distance_miles, r.fare, r.status,
                u.full_name AS passenger_name
         FROM rides r JOIN users u ON u.user_id = r.passenger_id
         WHERE r.status = 'requested' OR r.driver_id = " . (int)$driver['driver_id'] . "
         ORDER BY r.requested_at DESC"
    );
    $rides = $stmt->fetchAll();
    ?>
    <h2>Available and assigned rides</h2>
    <?php if (!$rides): ?><p>No rides to show.</p><?php else: ?>
    <div class="table-wrap"><table><tr><th>ID</th><th>Passenger</th><th>Route</th><th>Distance</th><th>Fare</th><th>Status</th><th>Action</th></tr>
    <?php foreach ($rides as $ride): ?>
    <tr><td><?= (int)$ride['ride_id'] ?></td><td><?= htmlspecialchars($ride['passenger_name']) ?></td>
    <td><?= htmlspecialchars($ride['pickup_location']) ?> → <?= htmlspecialchars($ride['dropoff_location']) ?></td>
    <td><?= htmlspecialchars($ride['distance_miles']) ?> mi</td><td>$<?= number_format((float)$ride['fare'], 2) ?></td><td><?= htmlspecialchars($ride['status']) ?></td><td>
    <?php if ($ride['status'] === 'requested' && $driver['is_available']): ?>
        <form method="post" action="driver_ride_action.php"><input type="hidden" name="ride_id" value="<?= (int)$ride['ride_id'] ?>"><input type="hidden" name="action" value="accept"><button class="button small">Accept</button></form>
    <?php elseif ($ride['status'] === 'accepted' && (int)($ride['driver_id'] ?? 0) === (int)$driver['driver_id']): ?>
        <form method="post" action="driver_ride_action.php"><input type="hidden" name="ride_id" value="<?= (int)$ride['ride_id'] ?>"><input type="hidden" name="action" value="complete"><button class="button small">Complete</button></form>
    <?php else: ?>—<?php endif; ?></td></tr>
    <?php endforeach; ?></table></div>
    <?php endif; } ?>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
