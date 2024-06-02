<?php
echo '<meta charset="utf-8">';

function joursemaine ($jour){
	$sortie = "numéro de jour incorrect";
	if ($jour == 1){
		$sortie = "Lundi";
	}
	if ($jour == 2){
		$sortie = "Mardi";
	}
	if ($jour == 3){
		$sortie = "Mercredi";
	}
	if ($jour == 4){
		$sortie = "Jeudi";
	}
	if ($jour == 5){
		$sortie = "Vendredi";
	}
	if ($jour == 6){
		$sortie = "Samedi";
	}
	if ($jour == 7){
		$sortie = "Dimanche";
	}
	return $sortie;
}

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);


$nom = isset($_POST["Nom"])? $_POST["Nom"] : ""; //informations du coach
$prenom = isset($_POST["Prénom"])? $_POST["Prénom"] : "";
$email = isset($_POST["Email"])? $_POST["Email"] : "";


$sql = "";
//CHAT ROOM À RAJOUTER
if ($db_found) {

	if(isset($_POST['rdv'])) { 
		$sql = "SELECT * FROM Coach WHERE NomCoach = '$nom' AND PrénomCoach = '$prenom' AND EmailCoach = '$email'";
		//echo "$sql";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_fetch_assoc($result) !=0){
			//echo "Bonjour ".$prenom." !";
			//$sql = "SELECT ID_Consultation,Date,Heure,NomClient,PrénomClient FROM Consultation,Client,Coach WHERE IDclient = ID_Client AND EmailCoach = '$email'AND  IDcoach = ID_Coach";
			$sql = "SELECT Date,Heure FROM Coach,Consultation WHERE EmailCoach = '$email' AND IDcoach = ID_Coach";
			//echo"$sql";
			$result = mysqli_query($db_handle,$sql);
			$nbresult = mysqli_num_rows($result);
			$dates =array();
			$heures = array();
			for ($i = 0;$i<$nbresult;$i++){
				$data = mysqli_fetch_assoc($result);
				$dates[$i] = $data['Date'];
				$heures[$i] = $data['Heure'];
			}
			for ($i = 0;$i<$nbresult;$i++){
				echo "date$i $dates[$i]<br>";
				echo "heure$i $heures[$i]<br>";
			}
	        echo "$nbresult";
			if (mysqli_num_rows($result) > 0) {
				echo "<h1>Vos consultations sont :</h1>";
				echo "<table border=\"1\">";
				echo "<tr>";
				echo "<th>" . "Date" . "</th>";
				echo "<th>" . "Heure" . "</th>";
				//echo "<th>" . "Nom et Prénom du client" . "</th>";
				echo "</tr>";

				while ($data = mysqli_fetch_assoc($result)){
					$jour = date('w',$data['Date']);
					$jour = joursemaine ($jour);
					echo "<tr>";
					//echo "<td>" . $data['Date'] . "</td>";
					echo "<td>" . $jour . "</td>";
					echo "<td>" . $data['Heure'] . "</td>";
					//echo "<td>" . $data['NomClient']." ".$data['PrénomClient'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}else echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";
		} else echo "<p>Pas de coach avec cet identifiant</p>";
	}

}else echo "pas trouvé";
