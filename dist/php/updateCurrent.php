<?php
$db = new SQLite3('../WeatherStation.db');

$result_temp = $db->query('SELECT * FROM BMP280_Temperature_Data WHERE Time = (SELECT max(Time) FROM BMP280_Temperature_Data WHERE Date = (SELECT max(Date) FROM BMP280_Temperature_Data));');
$row_temp = $result_temp->fetchArray();
$date = $row_temp['Date'];
$time = $row_temp['Time'];
$location = $row_temp['Location'];

$temperature = $row_temp['Temperature'];

$result_pres = $db->query('SELECT * FROM BMP280_Pressure_Data WHERE Time = (SELECT max(Time) FROM BMP280_Pressure_Data WHERE Date = (SELECT max(Date) FROM BMP280_Temperature_Data));');
$row_pres = $result_pres->fetchArray();

$pressure = $row_pres['Pressure'];

$result_light = $db->query('SELECT * FROM BH1750_Light_Data WHERE Time = (SELECT max(Time) FROM BH1750_Light_Data WHERE Date = (SELECT max(Date) FROM BMP280_Temperature_Data));');
$row_light = $result_light->fetchArray();

$lightlvl = $row_light['Light_Level'];

$json = "{";
$json .= "\"date\":\"" . $date . "\"";
$json .= ", \"time\":\"" . $time . "\"";
$json .= ", \"location\":\"" . $location . "\"";
$json .= ", \"temperature\":\"" . $temperature . "\"";
$json .= ", \"pressure\":\"" . $pressure . "\"";
$json .= ", \"lightlevel\":\"" . $lightlvl . "\"";
$json .= "}";
echo $json;
?>