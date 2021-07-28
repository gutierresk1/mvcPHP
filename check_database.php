<?php

/**
 * Check the database if the details of the connection are okay!
 * 
 * This is a temporary script. not for deployment.
 * 
 */

/**
 * Database connection data
 */

$host = "localhost";
$db_name = "mvc";
$user = "root";
$password = "";

/**
 * Create a connection
 */
$conn = new mysqli($host, $user, $password, $db_name);

/**
 * Check the connection
 */
if ($conn->connect_error) {
    echo "communication failed: " . $conn->connect_error;
} else {
    echo "connected successfully! ";
}
