# FishLog_CRUD
CRUD Web app that communicates with MySQL Database to log information related to fish catches

FishLog Web Application

Overview
-------------

FishLog is a web application that allows users to log details about their fish catches. The application supports creating, reading, updating, and deleting (CRUD) records of fish catches, including details like species, weight, length, date caught, and a picture of the catch.

Features :
Log fish catch details (species, weight, length, date caught, and picture).
View all logged catches.
Update existing catch records.
Delete catch records.

Technologies Used : 
PHP
MySQL
HTML
CSS
Bootstrap

Installation
------------

Prerequisites
XAMPP (or any other local server environment with PHP and MySQL support)

Steps
1. Clone the repository: git clone https://github.com/yourusername/FishLog.git
2. Move the project to the XAMPP htdocs directory: mv FishLog /path/to/xampp/htdocs/
3. Start Apache and MySQL in XAMPP:
Open XAMPP Control Panel and start the Apache and MySQL services.
4. Create the database and table using provided SQL script
5. Configure the database connection:
Open config.php and set your database credentials:
6. Access the application:
Open your web browser and navigate to http://localhost/FishLog/index.php


Troubleshooting
--------------
Ensure that the Apache and MySQL services are running in XAMPP.
Verify database credentials in config.php.
Check file upload permissions if image uploads are failing.
