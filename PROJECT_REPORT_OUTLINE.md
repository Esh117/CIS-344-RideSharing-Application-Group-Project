# RideConnect Project Report

## 1. Project Plan
**Project name:** RideConnect — Ride-Sharing Application

**Problem and scope:** This project shows a small ride-sharing workflow that connects passengers and drivers. It provides account registration, ride requests, driver availability, ride assignment, fare calculation, and simulated payment records. This project will demonstrate how PHP can communicate with MySQL, MariaDB database to store the information and manage the payments.

**Objectives**
1. Store users and roles securely.
2. Allow passengers to request rides.
3. Allow drivers to set availability and process requests.
4. Calculate a sample fare consistently.
5. Retrieve related records using SQL joins.
6. Demonstrate validation and basic security practices.

## 2. Technical Details
The following technologies were used or selected to develop RideConnect:

PHP: Used for server-side processing, handling user requests, and communicating with the database.
HTML: Used to create the structure of the application's web pages.
CSS: Used to style the application and organize the layout.
JavaScript: Used where client-side interaction is needed.
MySQL/MariaDB: Used to store application information.
XAMPP: Used as the local development environment to run Apache and MariaDB.
MySQL Workbench: Used for database modeling and creating the database relationship diagram.
phpMyAdmin: Used to view and manage database tables.

The application is accessed locally through a web browser using a localhost address

## 3. Database Design

The RideConnect mini world was chosen because ride-sharing services provide a practical example of how multiple entities interact within a database system.

The requirements were determined by examining the basic activities involved in a ride-sharing service and identifying what information the system would need to store.

The following activities were identified: 

1. A passenger creates an account.
2. A passenger logs into the application.
3. A passenger enters pickup and drop-off locations.
4. The system stores the ride request.
5. A driver profile contains information about the driver and their vehicle.
6. A ride can be assigned to a driver.
7. The ride status can change as the ride progresses.
8. A payment record can be associated with a ride.

 From these activities, four main database entities were identified: USER, DRIVER, RIDE, and PAYMENT. The design was kept relatively simple so that the project could demonstrate the main database relationships without becoming unnecessarily complicated. The requirements were developed through project analysis and examination of the selected mini world. No personal interview or survey results are claimed in this report.

User Table:

The users table stores account information. Its main columns include:

- user_id – uniquely identifies each user.
- full_name – stores the user's name.
- email – stores the user's email address.
- password_hash – stores the hashed password.
- role – identifies whether the account is a passenger or driver.
- created_at – records when the account was created.
- The user_id column is the primary key. Email addresses are required to be unique.

Drivers Table:

The drivers table stores information about users who have driver profiles. Its main columns include:

- driver_id – uniquely identifies each driver profile.
- user_id – connects the driver profile to a user account.
- license_number – stores the driver's license number.
- vehicle_make – stores the vehicle manufacturer.
- vehicle_model – stores the vehicle model.
- vehicle_color – stores the vehicle color.
- plate_number – stores the vehicle license plate.
- is_available – indicates driver availability.
- The driver_id column is the primary key, while user_id connects the driver to the users table.

Rides Table:

The rides table stores passenger ride requests and their information. Its main columns include:

- ride_id – uniquely identifies each ride.
- passenger_id – identifies the passenger who requested the ride.
- driver_id – identifies the assigned driver, if one exists.
- pickup_location – stores the pickup address.
- dropoff_location – stores the destination.
- distance_miles – stores the estimated distance.
- fare – stores the ride fare.
- status – stores the current ride status.
- requested_at – records when the ride was requested.
- completed_at – records when the ride was completed.
- The driver_id column can be empty when a ride has not yet been assigned to a driver.

Payments Table:

The payments table stores payment information associated with rides. Its main columns include:

- payment_id – uniquely identifies each payment.
- ride_id – identifies the associated ride.
- amount – stores the payment amount.
- payment_method – identifies the payment method.
- payment_status – stores the payment status.
- created_at – records when the payment record was created.
- paid_at – records when the payment was completed.
- The payment_status column supports statuses such as pending, paid, failed, and refunded.

## 4. Challenges
Several challenges can occur when developing a PHP application connected to a database. One challenge encountered during development involved configuring the database connection. The application needed to connect to the correct MySQL/MariaDB service and use the correct database credentials.

Another challenge involved organizing the PHP files and making sure that required configuration files were included using the correct file paths. Database relationships also required careful planning. For example, a ride needs to reference the passenger who requested it, but a driver may not be assigned immediately. This was handled by allowing the driver_id column in the rides table to be NULL.

The project also required understanding how JOIN operations work so that information from multiple tables could be retrieved together.

These challenges helped demonstrate the importance of database relationships, file organization, and testing during application development.

## 5. Testing
Testing was performed during development to check the application's pages and database operations.

The following test cases were identified:

1. Register a new passenger account.
2. Log into the application using the registered account.
3. Open the passenger dashboard.
4. Submit a ride request.
5. Check whether the ride request is stored in the rides table.
6. Verify that the ride has the correct passenger ID and ride status.
7. Test the driver profile and ride assignment process.
8. Check payment records and payment statuses.
9. Execute SQL JOIN queries to retrieve related passenger, driver, ride, and payment information.

The registration and ride-request workflow was exercised during development. Additional testing should confirm that driver assignment, ride completion, and payment status changes work correctly

## 6. References

- CIS 344 Fall 2026 Individual Project Guidelines and Project Grading Rubric, Prof. Yanilda Peralta Ramos.
- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- MySQL Workbench Documentation: https://dev.mysql.com/doc/workbench/en/
- Apache Friends – XAMPP: https://www.apachefriends.org/
