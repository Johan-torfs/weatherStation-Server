<?php
    $db = new SQLite3('../WeatherStation.db');

    $location = $_GET['location'];
    $json = "{";
    $result = $db->query('SELECT * FROM BMP280_Temperature_Data WHERE Location = "' . $location . '" ORDER BY Date desc, Time desc LIMIT 20');
    $json .= "\"temperature\": [";
    $first = true;
    while ($row = $result->fetchArray()) {
        if (!$first) {
            $json .= ", ";
        }
        $json .= "{";
        $json .= "\"date\":\"" . $row['Date'] . "\"";
        $json .= ", \"time\":\"" . $row['Time'] . "\"";
        $json .= ", \"value\":" . $row['Temperature'];
        $json .= "}";
        $first = false;
    }
    $json .= "]";

    $result = $db->query('SELECT * FROM BMP280_Pressure_Data WHERE Location = "' . $location . '" ORDER BY Date desc, Time desc LIMIT 20');
    $json .= ", \"pressure\": [";
    $first = true;
    while ($row = $result->fetchArray()) {
        if (!$first) {
            $json .= ", ";
        }
        $json .= "{";
        $json .= "\"date\":\"" . $row['Date'] . "\"";
        $json .= ", \"time\":\"" . $row['Time'] . "\"";
        $json .= ", \"value\":" . $row['Pressure'];
        $json .= "}";
        $first = false;
    }
    $json .= "]";

    $result = $db->query('SELECT * FROM BH1750_Light_Data WHERE Location = "' . $location . '" ORDER BY Date desc, Time desc LIMIT 20');
    $json .= ", \"lightlevel\": [";
    $first = true;
    while ($row = $result->fetchArray()) {
        if (!$first) {
            $json .= ", ";
        }
        $json .= "{";
        $json .= "\"date\":\"" . $row['Date'] . "\"";
        $json .= ", \"time\":\"" . $row['Time'] . "\"";
        $json .= ", \"value\":" . $row['Light_Level'];
        $json .= "}";
        $first = false;
    }
    $json .= "]}";
    echo $json;
?>