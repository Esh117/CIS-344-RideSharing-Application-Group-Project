<?php
require 'includes/header.php';
require 'config/database.php';
if (empty($_SESSION['pending_driver_user'])) {
    echo '<p>Please register a driver account first.</p>';
    require 'includes/footer.php'; exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int)$_SESSION['pending_driver_user'];
    $license = trim($_POST['license_number'] ?? '');
    $make = trim($_POST['vehicle_make'] ?? '');
    $model = trim($_POST['vehicle_model'] ?? '');
    $color = trim($_POST['vehicle_color'] ?? '');
    $plate = trim($_POST['plate_number'] ?? '');
    if ($license === '' || $make === '' || $model === '' || $color === '' || $plate === '') {
        $error = 'Complete every field.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO drivers (user_id, license_number, vehicle_make, vehicle_model, vehicle_color, plate_number) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userId, $license, $make, $model, $color, $plate]);
            unset($_SESSION['pending_driver_user']);
            header('Location: login.php?registered=1'); exit;
        } catch (PDOException $e) {
            $error = 'Some driver information is already in use. Check the license and plate number.';
        }
    }
}
?>
<h1>Driver details</h1>
<p>Finish setting up your driver profile.</p>
<?php if ($error): ?><p class="alert"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post" class="form-card">
    <label>License number <input name="license_number" required></label>
    <label>Vehicle make <input name="vehicle_make" required></label>
    <label>Vehicle model <input name="vehicle_model" required></label>
    <label>Vehicle color <input name="vehicle_color" required></label>
    <label>License plate <input name="plate_number" required></label>
    <button class="button" type="submit">Save driver profile</button>
</form>
<?php require 'includes/footer.php'; ?>
