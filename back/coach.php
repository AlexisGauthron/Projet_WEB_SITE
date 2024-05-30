<?php
echo '<meta charset="utf-8">';

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);


$nom = isset($_POST["Nom"])? $_POST["Nom"] : "";
$prenom = isset($_POST["Prénom"])? $_POST["Prénom"] : "";
$email = isset($_POST["Courriel"])? $_POST["Courriel"] : "";

$sql = "";
//CHAT ROOM À RAJOUTER
if ($db_found) {

	if(isset($_POST['connexion'])) { 
		$sql = "SELECT * FROM Coach WHERE NomCoach = '$nom' AND PrénomCoach = '$prenom' AND EmailCoach = '$email'";
		//echo "$sql";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_fetch_assoc($result) !=0){
			echo "Bonjour ".$prenom." !";
			$sql = "SELECT ID_Consultation,Date,Heure,NomClient,PrénomClient FROM Consultation,Client,Coach WHERE IDclient = ID_Client AND EmailCoach = '$email'AND  IDcoach = ID_Coach";
			//echo"$sql";
			$result = mysqli_query($db_handle,$sql);
			if (mysqli_num_rows($result) > 0) {
				echo "<h1>Vos consultations sont :</h1>";
				echo "<table border=\"1\">";
				echo "<tr>";
				echo "<th>" . "Date" . "</th>";
				echo "<th>" . "Heure" . "</th>";
				echo "<th>" . "Nom et Prénom du client" . "</th>";
				echo "</tr>";
				while ($data = mysqli_fetch_assoc($result)){
					echo "<tr>";
					echo "<td>" . $data['Date'] . "</td>";
					echo "<td>" . $data['Heure'] . "</td>";
					echo "<td>" . $data['NomClient']." ".$data['PrénomClient'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}else echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";
		} else echo "<p>Pas de coach avec cet identifiant</p>";
	}

}
