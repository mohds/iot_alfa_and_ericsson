<?php

	header('Content-Type: application/json');
	
	define('DB_HOST', '127.0.0.1');
	define('DB_USERNAME', 'iot');
	define('DB_PASSWORD', 'iot');
	define('DB_NAME', 'iot');
	
	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
	if(!$mysqli) {
		die("Connection failed: " . $mysqli->error);
	}
	
	$query = sprintf("SELECT GROUP_CONCAT(IF(appliances.name='TV', records.value, NULL)) AS TV, GROUP_CONCAT(IF(appliances.name='Heater', records.value, NULL)) AS Heater, GROUP_CONCAT(IF(appliances.name='Computer', records.value, NULL)) AS Computer, GROUP_CONCAT(IF(appliances.name='Bulb', records.value, NULL)) AS Bulb, records.date, records.time FROM records LEFT JOIN appliances ON records.appliance_id_fk = appliances.id GROUP BY time, date");
	
	$result = $mysqli->query($query);
	
	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}
	
	$result->close();
	$mysqli->close();
	
	print json_encode($data);
	
?>