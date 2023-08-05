<?php
// Assuming you have a database connection here
$servername = "localhost";
$username = "root";
$password = "abcd1234";
$dbname = "datasettest";

$output_directory = 'C:\wamp64\www\public_html1\products';


$connection = mysqli_connect($servername, $username, $password, $dbname);
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch data from the database
$query = "SELECT * FROM dataset";
$result = mysqli_query($connection, $query);

// Load the HTML template
$template = file_get_contents('index.html');

while ($person = mysqli_fetch_assoc($result)) {
    // Replace placeholders with person details
    $person_page = str_replace('{{LOCATION_ACCOUNT}}', $person['LOCATION_ACCOUNT'], $template);
    $person_page = str_replace('{{BUSINESS_NAME}}', $person['BUSINESS_NAME'], $person_page);
    $person_page = str_replace('{{STREET_ADDRESS}}', $person['STREET_ADDRESS'], $person_page);
    $person_page = str_replace('{{CITY}}', $person['CITY'], $person_page);
    $person_page = str_replace('{{ZIP_CODE}}', $person['ZIP_CODE'], $person_page);
    $person_page = str_replace('{{LOCATION_DESCRIPTION}}', $person['LOCATION_DESCRIPTION'], $person_page);
    $person_page = str_replace('{{MAILING_ADDRESS}}', $person['MAILING_ADDRESS'], $person_page);
    $person_page = str_replace('{{MAILING_CITY}}', $person['MAILING_CITY'], $person_page);
    $person_page = str_replace('{{MAILING_ZIP_CODE}}', $person['MAILING_ZIP_CODE'], $person_page);
    $person_page = str_replace('{{NAICS}}', $person['NAICS'], $person_page);
    $person_page = str_replace('{{PRIMARY_NAICS_DESCRIPTION}}', $person['PRIMARY_NAICS_DESCRIPTION'], $person_page);
    $person_page = str_replace('{{COUNCIL_DISTRICT}}', $person['COUNCIL_DISTRICT'], $person_page);
    $person_page = str_replace('{{LOCATION_START_DATE}}', $person['LOCATION_START_DATE'], $person_page);
    // $person_page = str_replace('{{LATITUDE}}', $person['latitude'], $template);
    // $person_page = str_replace('{{LONGITUDE}}', $person['longitude'], $template);


    // $person_page = str_replace('{{MOBILE}}', $person['mobile'], $person_page);
    // $person_page = str_replace('{{ADDRESS}}', $person['address'], $person_page);
    // Assuming your database has latitude and longitude columns for locations
    $person_page = str_replace('{{LATITUDE}}', $person['LATITUDE'], $person_page);
    $person_page = str_replace('{{LONGITUDE}}', $person['LONGITUDE'], $person_page);

    // Save each person's web page to a separate file
    $filename = strtolower(str_replace(' ', '-', $person['LOCATION_ACCOUNT'])) . ".html";
    //$filename = 'person_' . $person['id'] . '.html';
    file_put_contents($filename, $person_page);
}

mysqli_free_result($result);
mysqli_close($connection);

echo "Web pages generated successfully.";
?>
