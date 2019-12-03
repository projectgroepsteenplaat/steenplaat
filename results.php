<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$query = $_POST['query'];
$error = False;
if (isset($_POST['iban'])){
	$iban = True;
	$iban_obtained = $_POST['iban'];
	if ($iban_obtained == ""){
		$iban = False;
	}
} else {
	$iban = False;
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
if ($iban == True){
	try {
		if (checkIBAN($iban_obtained) == False){
			echo "Er is iets mis met uw IBAN.</br>";
			$error = True;
		}
	} catch (exception $e){
		echo "Er is iets mis met uw IBAN.</br>";
	}
}
if ($error == False){
	$vuurwerk = array("cobra 1", "cobra 3", "cobra 5", "cobra 6", "cobra 7", "cobra 8");
	$prijs = array(2.50, 3.50, 4.50, 5.50, 6.50, 12.50);
	$voorraad = array("cobra 6", "cobra 7");
	if (in_array($query, $vuurwerk)){
		if (in_array($query, $voorraad)){
			echo $query." hebben we op voorraad!</br>";
			echo '<img src="'.$query.'.jpg" height="200"/></br>';
			echo "Van: €".($prijs[array_search($query, $vuurwerk)]+2.4)."0</br>";
			echo "Voor: €".$prijs[array_search($query, $vuurwerk)]."0";
		} else {
			echo $query." hebben we niet op voorraad!</br>";
			echo '<img src="'.$query.'.jpg" height="200"/></br>';
			echo "Prijs: €".$prijs[array_search($query, $vuurwerk)]."0";
		}
	} else {
		$best_index = 0;
		foreach($vuurwerk as $knal){
			if (similar_text($knal, $query) > similar_text($vuurwerk[$best_index], $querry)){
				$best_index = array_search($vuurwerk, array($knal));
			}
		}
		echo "Bedoelde u: ".$vuurwerk[$best_index]."?";
	}
} else {
	echo '<img src="BSOD.png"/>';
}
?>