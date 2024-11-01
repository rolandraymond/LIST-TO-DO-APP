<?php
$conn = mysqli_connect('localhost', 'root', '');
if (!$conn) {
    die('connection failed' . mysqli_connect_error());
}

echo "<pre>";
var_dump($conn);

$mysql = "CREATE DATABASE IF NOT EXISTS DP_USERS";

mysqli_query($conn, $mysql);

mysqli_close($conn);

$conn = mysqli_connect('localhost', 'root', '', 'DP_USERS');



$sql_create = "CREATE TABLE IF NOT EXISTS DP_USERS( `ID` INT PRIMARY KEY AUTO_INCREMENT,
`User_Name` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL)";
mysqli_query($conn, $sql_create);

$sql_create_tasks = "CREATE TABLE IF NOT EXISTS TASKS (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES DP_USERS(ID) ON DELETE CASCADE
    status ENUM('complete', 'incomplete', 'pending') NOT NULL DEFAULT 'incomplete'
)";

mysqli_query($conn, $sql_create_tasks);

mysqli_close($conn);