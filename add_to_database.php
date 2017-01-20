<?php

echo "This is the add to database service";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  
	// $name = test_input($_POST["name"]); // ref
	
	$appliances = get_all_appliances();
	
	for( $i = 0 ; $i < sizeof($appliances) ; $i++){
		$tester = $_GET[$appliances[$i]];
		if(!empty($tester)){
			$appliance_id = get_appliance_id($appliances[$i]);
			insert_record($appliance_id, $_GET[$appliances[$i]]);
		}
	}
	
}

function get_appliance_id($appliance){
	$conn = connect_to_db();
	$sql = "SELECT appliances.id FROM appliances WHERE appliances.name = '" . $appliance . "' ";
	$result = $conn->query($sql);
	
	$id = array();
	
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
			$id = $row["id"];
		}
	} 
	else {
		echo "0 results";
	}
	$conn->close();
	return $id;
}

function get_all_appliances(){
	$conn = connect_to_db();
	$sql = "SELECT appliances.name FROM appliances";
	$result = $conn->query($sql);
	
	$appliances = array();
	
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
			$appliances[] = $row["name"];
		}
	} 
	else {
		echo "0 results";
	}
	$conn->close();
	return $appliances;
}

function insert_record($appliance_id, $value){
	$conn = connect_to_db();
	
	$date = date("Y-m-d");
	$time = date("h:i:s");
	
	$sql = "INSERT INTO records (appliance_id_fk, value, date, time)
	VALUES ('" . $appliance_id . "', '" . $value . "', '" . $date . "', '" . $time . "')";

	if ($conn->query($sql) === TRUE) {
		// echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();
}

function connect_to_db(){
	$servername = "localhost";
	$username = "iot";
	$password = "iot";
	$dbname = "iot";
	// Create connection
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	// echo "Connection successful.";
	return $conn;
}

?>