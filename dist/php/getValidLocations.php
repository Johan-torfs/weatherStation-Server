<?php
$db = new SQLite3('../WeatherStation.db');

$result = $db->query('SELECT Location FROM BMP280_Temperature_Data GROUP BY Location');
$json = "{\"locations\":[";
$first = true;
while ($row = $result->fetchArray()) {
    if (!$first) {
        $json .= ", ";
    }
    $json .= "\"" . $row['Location'] . "\"";
    $first = false;
}
$json .= "]}";
echo $json;
?>