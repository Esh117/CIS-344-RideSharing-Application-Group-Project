# RideConnect — CIS 344 Project

RideConnect is my project created using PHP, MySQL, HTML, and CSS ride-sharing demo.

## The Features
- Passenger and driver registration and login
- Password hashing and PHP sessions
- Driver profile and availability
- Ride requests and example fare calculation ($3 base + $2 per mile)
- Drivers accept and complete rides
- Simulated payment status (no real card data)
- Ride history and SQL joins

## The Requirements
- PHP 8 or newer with PDO MySQL enabled
- MySQL 8 or compatible MariaDB
- XAMPP, MAMP, or another local PHP/MySQL environment
- Web browser

## Setting up using XAMPP
1. Install and open XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy the `RideConnect` folder into XAMPP's `htdocs` folder.
4. Open `http://localhost/phpmyadmin`.
5. Choose the **Import** tab and import `database/rideconnect.sql`.
6. Open `config/database.php` and set the MySQL username and password for your machine.
7. Visit `http://localhost/RideConnect/`.
8. Register a passenger account and log in.
9. Register a separate driver account; complete the driver profile form.
10. Log in as passenger, request a ride, then log in as driver in another browser/private window to accept and complete it.
11. Log back in as passenger and use **Demo pay** after the ride is completed.

## Fare formula
The demo uses a the notion where: fare = $3.00 + ($2.00 × distance in miles). This is just an assumption, not a real-world pricing.

## Database
Import `database/rideconnect.sql`. The main relationships are:
- `users` one-to-zero-or-one `drivers`
- `users` one-to-many `rides` as passengers
- `drivers` one-to-many `rides`
- `rides` one-to-zero-or-one `payments`

Additional join examples are in `database/joins_examples.sql`.

## Security notes
- Passwords are stored with `password_hash()` and checked with `password_verify()`.
- SQL values from forms use PDO prepared statements.
- Output displayed in HTML is escaped with `htmlspecialchars()`.
- Forms validate required fields and data types.
- Payment is simulated only. Do not enter real payment-card information.
- Before public or production use, add CSRF tokens, rate limiting, stronger logging, secure cookie settings, and a real payment provider integration.

## Suggested Git commits
- `Initial RideConnect project structure`
- `Add MySQL schema and join examples`
- `Add registration and login`
- `Add passenger ride booking and fare calculation`
- `Add driver availability and ride workflow`
- `Add styling and project documentation`

## Test checklist
- Register a passenger with a valid email and 8+ character password.
- Attempt to register the same email twice; it should be rejected.
- Log in with correct and incorrect passwords.
- Request a ride with a valid distance.
- Try a blank location or invalid distance.
- Log in as driver, mark available, accept a ride, and complete it.
- Confirm the ride and payment statuses update.
- Verify ride history shows passenger, driver, fare, and status.
- Run the queries in `database/joins_examples.sql` in phpMyAdmin.
