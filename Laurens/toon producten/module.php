<?php
function factorial($val){
	// Returns the factorial of val
	if ($val == 0){
		return 1;
	} else {
		return $val * factorial($val-1);
	}
}
function summation($list){
	// Returns the sum of all items in the array
	$sum = 0;
	
	for($i=0;$i<count($list);$i++){
		$sum = $sum + $list[$i];
	}
	
	return $sum;
}
function average($list){
	// Returns the average of the items in an array
	return sum($list) / count($list);
}
function reverse($list){
	// Returns the reverse of an array
	$len = count($list);
	$list2 = array();
    
	for($i=0;$i<$len;$i++){
		$list2 = array_merge($list2, array($list[$len-$i-1]));
	}
	
    return $list2;
}
function highest($list){
	// Returns the highest value in an array
	$high = $list[0];
	
	for ($i=1;$i<count($list);$i++){
		if ($list[$i]>$high){
			$high = $list[$i];
		}
	}
	
	return $high;
}
function lowest($list){
	// Returns the lowest value in an array
	$low = $list[0];
	
	for ($i=1;$i<count($list);$i++){
		if ($list[$i]<$low){
			$low = $list[$i];
		}
	}
	
	return $low;
}
function sum_numbers($n){
	// Finds the sum of the numbers up to n
	return($n+1)*$n/2;
}
function inserter($cols, $args, $tname, $servername, $dbname, $username, $password){
	// inserts arguments into a new record of tname (tablename) at cols (columns)
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
function sorter($list){
	// Returns a sorted list
	if(count($list) == 0){
		return $list;
	}
	$list1 = array();
	$list2 = array();
	foreach ($list as $i){
		if($i < $list[0]){
			$list1 = array_merge($list1, array($i));
			$list1 = sorter($list1);
		}
		else{
			$list2 = array_merge($list2, array($i));
			$list2 = sorter($list2);
		}
	}
	return array_merge($list1, $list2);
}
function checkIBAN($iban){
	$iban = strtolower(str_replace(' ','',$iban));
	$Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
	$Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

	if(strlen($iban) == $Countries[substr($iban,0,2)]){

		$MovedChar = substr($iban, 4).substr($iban,0,4);
		$MovedCharArray = str_split($MovedChar);
		$NewString = "";

		foreach($MovedCharArray AS $key => $value){
			if(!is_numeric($MovedCharArray[$key])){
				$MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
			}
			$NewString .= $MovedCharArray[$key];
		}

		if(bcmod($NewString, '97') == 1){
			return True;
		}
	}
	return False;
}


function connect(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$servername = "localhost";
	$username = "user";
	$password = "";
	$dbname = "klas1g";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	return $conn;
}

function ToonProducten($rows){
	echo "<div class='container' align='center'>";
	foreach($rows as $row){
		echo "<div id='product'>";
		echo "<h1>$row[naam]</h1>";
		echo "<img src='$row[url_afbeelding]' width='300' height='250'><br><br>";
		echo "Vooraad: $row[voorraad] </div>";
		echo "Prijs:€ $row[prijs]";
		echo "<p><button>Add to Cart</button></p>";
	}
	echo "</div>";
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
?>