<?php
$db = new SQLite3('../WeatherStation.db');

$pageNumber = 1;
$amountPerPage = 100;
if (isset($_GET['pageNumber'])) $pageNumber = $_GET['pageNumber'];
if (isset($_GET['amountPerPage'])) $amountPerPage = $_GET['amountPerPage'];

$json = "{";
$result = $db->query('SELECT count(*) as maxTemp FROM BMP280_Temperature_Data;');
$row = $result->fetchArray();
$maxTemp = $row['maxTemp'];

$result = $db->query('SELECT count(*) as maxPress FROM BMP280_Pressure_Data;');
$row = $result->fetchArray();
$maxPress = $row['maxPress'];

$result = $db->query('SELECT count(*) as maxLight FROM BH1750_Light_Data;');
$row = $result->fetchArray();
$maxLight = $row['maxLight'];

$maxPageNumber = ceil(max($maxTemp, $maxPress, $maxLight)/$amountPerPage);
$json .= "\"maxPageNumber\":" . $maxPageNumber;

$result = $db->query('SELECT * FROM BMP280_Temperature_Data ORDER BY Date desc, Time desc LIMIT ' . $amountPerPage . ' OFFSET ' . ($amountPerPage * ($pageNumber-1)) . ';');
$json .= ", \"temperature\": [";
$first = true;
while ($row = $result->fetchArray()) {
    if (!$first) {
        $json .= ", ";
    }
    $json .= "{";
    $json .= "\"date\":\"" . $row['Date'] . "\"";
    $json .= ", \"time\":\"" . $row['Time'] . "\"";
    $json .= ", \"location\":\"" . $row['Location'] . "\"";
    $json .= ", \"value\":" . $row['Temperature'];
    $json .= "}";
    $first = false;
}
$json .= "]";

$result = $db->query('SELECT * FROM BMP280_Pressure_Data ORDER BY Date desc, Time desc LIMIT ' . $amountPerPage . ' OFFSET ' . ($amountPerPage * ($pageNumber-1)) . ';');
$json .= ", \"pressure\": [";
$first = true;
while ($row = $result->fetchArray()) {
    if (!$first) {
        $json .= ", ";
    }
    $json .= "{";
    $json .= "\"date\":\"" . $row['Date'] . "\"";
    $json .= ", \"time\":\"" . $row['Time'] . "\"";
    $json .= ", \"location\":\"" . $row['Location'] . "\"";
    $json .= ", \"value\":" . $row['Pressure'];
    $json .= "}";
    $first = false;
}
$json .= "]";

$result = $db->query('SELECT * FROM BH1750_Light_Data ORDER BY Date desc, Time desc LIMIT ' . $amountPerPage . ' OFFSET ' . ($amountPerPage * ($pageNumber-1)) . ';');
$json .= ", \"lightlevel\": [";
$first = true;
while ($row = $result->fetchArray()) {
    if (!$first) {
        $json .= ", ";
    }
    $json .= "{";
    $json .= "\"date\":\"" . $row['Date'] . "\"";
    $json .= ", \"time\":\"" . $row['Time'] . "\"";
    $json .= ", \"location\":\"" . $row['Location'] . "\"";
    $json .= ", \"value\":" . $row['Light_Level'];
    $json .= "}";
    $first = false;
}
$json .= "]}";
echo $json;
?>