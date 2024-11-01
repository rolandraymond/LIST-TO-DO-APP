# To-Do List Application

This is a simple PHP-based to-do list application that allows users to create, delete, and update tasks- The application uses a MySQL database for storing tasks, and the front-end interaction is managed using JavaScript with the Fetch API for AJAX requests-

## Features

- Create Read Update Delete (CRUD) tasks
- Add new tasks
- Mark tasks as complete or incomplete
- Delete tasks
- Dynamic list rendering without page reloads
- Progress bar to track completion percentage

## Technologies Used

- HTML/CSS: Frontend structure and styling
- JavaScript (Fetch API): AJAX requests for seamless user interaction
- PHP: Backend and database handling
- MySQL: Database for storing tasks

## Setup and Installation

- PHP (version 7.0 or later)
- MySQL
- Web server (XAMPP, Apache, Nginx)
  -Composer (optional, for dependency management)

## Database Setup

- Create a MySQL Database:

- Create a new database named `DP_USERS`.
- Inside _file_ **Database_migration/migration_USERS.php** this database, create a table named `tasks`.

## Configure Database Connection:

- Modify the database connection parameters in tasks.php:

```php
    Copy code
    $conn = new mysqli('localhost', 'root', '', 'DP_USERS');
```

## File structure

- **index.html**: Login page by _HTML_
- **JS/index.js** : JavaScript file with AJAX functions to interact with the backend
- **JS/checkpass.php**: PHP file that handles API requests for _reading_ user from database
- **CSS/style.css**: Stylesheet for application styling.
- **Create_Account.html**: Create Account page by _HTML_
- **JS/CreateAccount.js**: JavaScript file with AJAX functions to interact with the backend.
- **handlers.php** PHP file handles API requests for _creating_ users in Database

- **tasks.php**: PHP file handles API requests creating, reading, updating, and deleting tasks.

# License

- This project is open-source and free to use for learning purposes.
