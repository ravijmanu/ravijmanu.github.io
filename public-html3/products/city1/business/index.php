<?php
// Establish a connection to your MySQL database
$servername = "localhost"; // Change this to your server's hostname
$username = "root"; // Change this to your MySQL username
$password = "abcd1234"; // Change this to your MySQL password
$dbname = "businessdataset"; // Change this to the name of your MySQL database

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the cities in alphabetical order
$sql = "SELECT distinct CITY FROM new_table ORDER BY CITY";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $current_letter = '';
    $html_content = '';

    while ($row = $result->fetch_assoc()) {
        $city_name = $row["CITY"];
        $first_letter = strtoupper(substr($city_name, 0, 1));

        // Check if the first letter of the current city is different from the previous one
        if ($first_letter !== $current_letter) {
            // Display the header with the letter
            $html_content .= "<h1>{$first_letter}</h1>";
            $current_letter = $first_letter;
        }
        $url = strtolower(str_replace(' ', '-', $city_name));
        // Display the city name as a hyperlink
        $html_content .= "<a href=\"products/{$url}.html\">{$city_name}</a><br>";
    }
} else {
    $html_content = "No cities found in the database.";
}

$conn->close();

// Create the cities_list.html file and write the content
file_put_contents("cities_list.html", "<!DOCTYPE html>
<html>
<head>
    <title>List of Cities</title>
    
</head>
<body>
{$html_content}
</body>
</html>");
?>
