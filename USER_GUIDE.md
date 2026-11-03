# RideConnect User Guide

## Passenger
1. Open the RideConnect homepage.
2. Select **Register** and choose **Passenger**.
3. Enter your name, email, and password of at least eight characters.
4. Log in.
5. Select **Request a ride**.
6. Enter pickup location, drop-off location, and estimated miles.
7. Submit. The sample fare is $3.00 + $2.00 per mile.
8. On Dashboard, check ride status, assigned driver, fare, and payment status.
9. After a driver completes the ride, select **Demo pay**. This only updates the demonstration database; it does not charge money.

## Driver
1. Register and choose **Driver**.
2. Complete the vehicle and license details.
3. Log in and open Dashboard.
4. Select **Go available** to make the driver available.
5. Select **Accept** for a requested ride.
6. Select **Complete** when the sample ride is finished.
7. Set yourself unavailable when you do not want new ride requests.

## Troubleshooting
- If the database connection fails, confirm MySQL is running and check `config/database.php`.
- If the site cannot be found, confirm the folder is inside XAMPP `htdocs` and Apache is running.
- If a driver cannot log in, complete the driver registration form first.
- Do not enter real payment details. Payments are simulated.
