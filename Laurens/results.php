<!DOCTYPE html>
<html>
	<form action="results.php?cat=knal#here" href="results.php" method="post">
		<textarea name="findtype" hidden>knal</textarea>
		<button type="submit" id="t">knal</button>
	</form>
	<form action="results.php?cat=sier#here" href="results.php" method="post">
		<textarea name="findtype" hidden>sier</textarea>
		<button type="submit" id="t">sier</button>
	</form>
	<form action="results.php?cat=compleet#here" href="results.php" method="post">
		<textarea name="findtype" hidden>compleet</textarea>
		<button type="submit" id="t">compleet</button>
	</form>
	<form action="results.php#here" href="results.php" method="post">
		<head>
			<link rel="stylesheet" type="text/css" href="stylesheet.css"></link>
		</head>
		<body>
			<textarea name="zoekbalk" id="zoekbalk" placeholder="Naam vuurwerk"></textarea>
			<button type="submit" id="s">search</button></br>
			<img src="vuurwerk.jpg" id="image"/>
		</body>
	</form>
	<form action="results.php" href="results.php" method="post">
		<head>
			<link rel="stylesheet" type="text/css" href="stylesheet.css"></link>
		</head>
		<body>
			<textarea name="findtype" id="findtype" placeholder="Type vuurwerk" hidden></textarea>
			<button type="submit" id="s" hidden>search</button></br>
		</body>
	</form>
</html>
<?php
// functions
function connect(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$servername = "localhost";
	$username = "user";
	$password = "";
	$dbname = "klas1g";
	echo $_GET['cat'];
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
	}
	return $conn;
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
function GetData($cat){
	// Get data
	$conn = connect();
	if ($cat == "1"){
		$sql = "SELECT naam FROM product";
	} else if ($cat == "2"){
		$sql = "SELECT prijs FROM product";
	} else if ($cat == "3"){
		$sql = "SELECT naam FROM product WHERE Voorraad > 0";
	} else {
		$sql = "SELECT * FROM product WHERE categorie = '".$cat."'";
	}
	$result = $conn->query($sql);
	$result = $result->fetchAll();
	return $result;
}
// main
echo '<img src="winkelwagen.jpg" class="c2" width="50"/></br>';
// Als cat is gegeven (dat is zo wanneer u op een van de knoppen heeft gedrukt) wordt dit uitgevoerd.
if (isset($_GET['cat']) or isset($_POST['zoekbalk'])){
	// Connect met de database
	$conn = connect();
	$query = $_POST['findtype'];
	$zoekopdracht = 'find-type';
	if($query == ""){
		$query = $_POST['zoekbalk'];
		$zoekopdracht = 'find-name';
	}
	$result = GetData("1");
	$vuurwerk = array();
	foreach($result as $i){
		array_push($vuurwerk, $i);
	}
	$lijstje = array();
	foreach($vuurwerk as $a){
		if(gettype($a) == "array"){
			foreach($a as $b){
				if(gettype($b) == "array"){
					foreach($b as $c){
						array_push($lijstje, $c);
					}
				}else{
					array_push($lijstje, $b);
				}
			}
		}else{
			array_push($lijstje, $a);
		}
	}
	$vuurwerk = $lijstje;
	$result = GetData("2");
	$prijs = array();
	foreach($result as $a){
		foreach($a as $i){
			array_push($prijs, $i);
		}
	}
	$voorraad = array();
	$result = GetData("3");
	foreach($result as $i){
		foreach($i as $j){
			array_push($voorraad, $j);
		}
	}

	if ($query == "cobra"){
		foreach($vuurwerk as $query){
			echo '<img class="centre" src="'.$query.'.jpg" height="200"/></br>';
			echo '<p class="centre">Prijs: €'.$prijs[array_search($query, $vuurwerk)]."</p>";
		}
	} else if ($error == False){
		if (in_array($query, $vuurwerk)){
			if (in_array($query, $voorraad)){
				echo '<p class="centre">'.$query." hebben we op voorraad!</p>";
				echo '<img class="centre" id="here" src="'.$query.'.jpg" height="200"/></br>';
				echo '<p class="centre">Prijs: €'.$prijs[array_search($query, $vuurwerk)].'</p>';
			} else {
				echo '<p class="centre"'.$query." hebben we niet op voorraad!</p>";
				echo '<img class="centre" id="here" src="'.$query.'.jpg" height="200"></img></br>';
				echo '<div><p class="centre">Prijs: €'.$prijs[array_search($query, $vuurwerk)].'</p></div>';
			}
		} else {
			$best_index = 0;
			$temp = $vuurwerk;
			$vuurwerk = array();
			foreach($temp as $i){
				if(in_array($i, $vuurwerk)){
					echo "";
				}else{
					array_push($vuurwerk, $i);
				}
			}
			$lijstje = array();
			foreach($vuurwerk as $a){
				if(gettype($a) == "array"){
					foreach($a as $b){
						if(gettype($b) == "array"){
							foreach($b as $c){
								array_push($lijstje, $c);
							}
						}else{
							array_push($lijstje, $b);
						}
					}
				}else{
					array_push($lijstje, $a);
				}
			}
			foreach($lijstje as $i){
				if(similar_text($i, $query) > similar_text($lijstje[$best_index], $query)){
					$best_index = array_search($i, $lijstje);
				}
			}
			if ($zoekopdracht == 'find-name'){
				echo "Bedoelde u: ".$lijstje[$best_index]."?";
			} else {
				if ($query == "compleet"){
					$result = GetData("1");
				} else {
					$result = GetData($query);
				}
				$vuurwerk = array();
				$y = 0;
				foreach($result as $i){
					array_push($vuurwerk, $i);
					$x = 1;
					$y++;
					foreach($i as $j){
						if ($x == 1){
							echo '<image width="100" id="here" src='.'"'.$j.".jpg".'" class="centre" alt="'.$j.'"/>';
							$sql2 = "SELECT prijs FROM product WHERE naam = '".$j."'";
							$result2 = $conn->query($sql2);
							$result2 = $result2->fetchAll();
							$x = 0;
							foreach($result2 as $temp1){
								foreach($temp1 as $temp2){
									if ($x == 0){
										echo '<div><p class="centre">'.$temp2.'</p></div>';
										$x = 1;
									}
								}
							}
							echo '<div><p class="centre">'.$j."</p></div>";
							$x = 2;
						}
					}
					if ($y == 5){
						$y = 0;
						echo "</br>";
					}
				}
			}
		}
	} else {
		echo '<img src="BSOD.png"/>';
	}
	echo "<style>.centre {display: block; margin-left: auto; margin-right: auto; width: 300; color: white; text-align: centre;}";
	echo "div {text-align: centre; position: relative; left: 46vw;}";
	echo '.c2 {position: relative; left: 80vw; color: white;}</style>';
}

?>