# RideConnect — Ride-Sharing Application

## Project Overview

RideConnect is my project ride-sharing application developed for the Ride-Sharing Application Group Project. The system allows passengers to register, log in, request rides, and view their ride information. Drivers can manage their driver information and respond to ride requests.

The project demonstrates how a PHP application connects to a relational database using MySQL/MariaDB.

## Technologies Used

- PHP — server-side processing
- HTML — application structure
- CSS — styling and page layout
- JavaScript — client-side functionality, where used
- MySQL/MariaDB — database management
- XAMPP — local development environment
- MySQL Workbench — database modeling and ER diagram

## Main Features

- User registration and login
- Passenger and driver roles
- Ride requests
- Driver profiles and ride assignment
- Ride status management
- Payment status demonstration
- Database queries using SQL JOIN operations

Only describe features that are actually implemented and working in your application.

## Database Design

The database is named `rideconnect` and contains these tables:

- `users` — stores user account information and roles
- `drivers` — stores driver and vehicle information
- `rides` — stores passenger ride requests, assigned drivers, and ride statuses
- `payments` — stores payment records and payment statuses

The SQL scripts are located in the `database/` folder.

## Project Folder Structure

- `assets/` — CSS, JavaScript, and other front-end assets
- `config/` — database configuration
- `database/` — database creation and query scripts
- `docs/` — ER diagrams, report, and user guide
- `includes/` — reusable PHP components
- Root PHP files — application pages and functionality

## Installation and Setup

1. Install XAMPP.
2. Start Apache and MySQL/MariaDB from the XAMPP Control Panel.
3. Copy the RideConnect project folder into `C:\xampp\htdocs\`.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Create or import the `rideconnect` database using `database/rideconnect_schema.sql`.
6. Configure your local database connection using `config/database.example.php` as a reference.
7. Open the application at `http://localhost/RideConnect/`.

## Testing the Application

1. Register a passenger account.
2. Log in as the passenger.
3. Submit a ride request.
4. Register or configure a driver account.
5. Log in as the driver and test the ride-assignment workflow.
6. Test the ride status and payment demonstration, if implemented.
7. Review the database records and execute the SQL JOIN examples.

## Security

The application should validate and sanitize user input and use prepared statements for database queries to help prevent SQL injection. Do not upload passwords or private credentials to this public repository.

## Project Documentation

The `docs/` folder contains the project report, Chen-style ER diagram, UML-style ER diagram, and user guide.

## Demonstration Video

[Insert the link to the RideConnect demonstration video here.]

## Course Information

**Course:** CIS 344  
**Semester:** Fall 2026  
**Project:** RideConnect — Ride-Sharing Application  
**Instructor:** Prof. Yanilda Peralta Ramos

## Author

Eshwar Basdeo
