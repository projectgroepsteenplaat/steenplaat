<?php
// Code by Laurens Frensen

function inserter($cols, $args, $tname, $password){
	// inserts arguments into a new record of tname (tablename) at cols (columns)
	// Function by Laurens
	$username = "steenplaat";
	$dbnaam = "steenplaat";
	$servername = "localhost";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	$colstr = $cols[0];
	for($i=1; $i<count($cols); $i++){
		$colstr = $colstr.", ".$cols[$i];
	}
	$argstr = $args[0];
	for($i=1; $i<count($args); $i++){
		$argstr = $argstr.", ".$args[$i];
	}
	$sql = 'INSERT INTO '.$tname.'('.$colstr.') VALUES ('.$argstr.')';
	$result = $conn->query($sql);
	$result = $result->fetchAll();
}

function printer($data){
	// echo data
	// Function by Laurens Frensen
	if (gettype($data) == "array"){
		echo "<table>";
		foreach($data as $i){
			$k = 1;
			if (gettype($i) == "array"){
				echo "<tr>";
				foreach($i as $j){
					if ($k % 2 == 1){
						echo "<td>".$j."</td>";
					}
					$k++;
				}
				echo "</tr>";
			}else{
				echo $i;
				echo "</br>";
			}
		}
		echo "</table>";
	} else if (gettype($data) == "boolean"){
		if ($data == True){
			echo "True";
		} else {
			echo "False";
		}
	} else {
		echo $data;
	}
	echo "</br>";
}
$servername = "localhost";
$username = "steenplaat";
$password = "";
$dbname = "steenplaat";

// main
try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
catch(PDOException $e){
	echo "Connection failed: " . $e->getMessage();
}
$sql = "SELECT * FROM afspraken";
$result = $conn->query($sql);
$result = $result->fetchAll();
printer($result);



?>
