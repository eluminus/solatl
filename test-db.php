<?php
// Database connection test
$connection = mysqli_connect('localhost', 'root', 'root', 'local');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

echo "<h2>Database Connection: SUCCESS</h2>";

// Check if tables exist
$result = mysqli_query($connection, "SHOW TABLES");
echo "<h3>Tables found: " . mysqli_num_rows($result) . "</h3>";

// Check wp_options
$options = mysqli_query($connection, "SELECT option_name, option_value FROM wp_options WHERE option_name IN ('siteurl', 'home') LIMIT 2");

if ($options) {
    echo "<h3>Site URLs:</h3>";
    while($row = mysqli_fetch_assoc($options)) {
        echo $row['option_name'] . ": " . $row['option_value'] . "<br>";
    }
} else {
    echo "<h3>ERROR: Cannot read wp_options table</h3>";
}

mysqli_close($connection);
?>