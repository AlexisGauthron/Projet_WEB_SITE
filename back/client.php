<?php
echo '<meta charset="utf-8">';

function affichage($db_handle, $email){
			$sql = "SELECT ID_Consultation,Date,Heure,Commentaire,NomCoach,PrénomCoach,Specialité FROM Consultation,Client,Coach WHERE IDclient = ID_Client AND EmailClient = '$email' AND IDcoach = ID_Coach;";
			//echo"$sql";
			$result = mysqli_query($db_handle,$sql);
			if (mysqli_num_rows($result) > 0) {
				echo "<h1>Vos consultations sont :</h1>";
				echo "<table border=\"1\">";
				echo "<tr>";
				echo "<th>" . "Date" . "</th>";
				echo "<th>" . "Heure" . "</th>";
				echo "<th>" . "Commentaire" . "</th>";
				echo "<th>" . "Coach" . "</th>";
				echo "<th>" . "Activité" . "</th>";
				echo "</tr>";
				while ($data = mysqli_fetch_assoc($result)){
					echo "<tr>";
					echo "<td>" . $data['Date'] . "</td>";
					echo "<td>" . $data['Heure'] . "</td>";
					echo "<td>" . $data['Commentaire'] . "</td>";
					echo "<td>" . $data['NomCoach']." ".$data['PrénomCoach'] . "</td>";
					echo "<td>" . $data['Specialité']."</td>";
					echo '<form method="post" action ="">';
					echo '<input type="hidden" name="consultation" value='.$data["ID_Consultation"].'>';
					echo '<input type="hidden" name="Email" value='.$email.'>';
					echo '<td><input type="submit" name="supprimer" value="Annuler ce RDV"></td>';
					echo"</form";
					echo "</tr>";
				}
				echo "</table>";
			}else echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";
}

function connexion($db_handle,$email1,$mdp1) {
	$sql = "SELECT Mot_de_passe FROM Client WHERE EmailClient ='$email1' ";
		//echo "$sql";
		$result = mysqli_query($db_handle,$sql);
		$mot = mysqli_fetch_assoc($result);
		if ( $mot ==0){
			echo "Pas de compte avec cette adresse mail créez un compte ou réessayez";
			$erreur = true;
		}else{
			echo $mot['Mot_de_passe'];
			if ($mot['Mot_de_passe'] == $mdp1){
				echo "bon mdp";
			}else {
				echo "pas bon mdp";
				$erreur = true;
			}
		}
		if ($erreur == false){
			//echo " Bonjour ".$prenom." !";
			affichage($db_handle, $email1);
		}
}

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);


$nom = isset($_POST["Nom"])? $_POST["Nom"] : "";
$prenom = isset($_POST["Prénom"])? $_POST["Prénom"] : "";
$email2 = isset($_POST["Email1"])? $_POST["Email1"] : "";
$email1 = isset($_POST["Email2"])? $_POST["Email2"] : "";
$carte = isset($_POST["Carte"])? $_POST["Carte"] : "";
$paiement = isset($_POST["Paiement"])? $_POST["Paiement"] : "";
$adresse = isset($_POST["Adresse"])? $_POST["Adresse"] : "";
$mdp2 = isset($_POST["mdp1"])? $_POST["mdp1"] : "";
$mdp1 = isset($_POST["mdp2"])? $_POST["mdp2"] : "";
$tel = isset($_POST["tel"])? $_POST["tel"] : "";



$sql = "";

$errorMessage = "";


if ($db_found) {
	$erreur = false;
	if(isset($_POST['connexion'])) { 
		connexion($db_handle,$email1,$mdp1);
		
	}
	if(isset($_POST['creation'])) { 
		if ($nom == "" || $prenom == "" || $email2 == "" ||$carte == "" || $paiement == ""|| $adresse == ""||$mdp2 ==""){
			echo ("$nom $prenom $email $carte $paiement $adresse $mdp");
			echo("<p>"."Une valeur est nulle"."</p>");

		}else{
			$sql = "SELECT * FROM Client WHERE EmailClient = '$email'";
			echo "$sql";
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) > 0) {
				echo  "<p>Un compte avec cette adresse mail existe déjà.</p>";
			} else {
				$sql = "SELECT MAX(ID_Client) AS id_max FROM Client";
    			$result = mysqli_query($db_handle, $sql);
    			$row = mysqli_fetch_assoc($result);
    			$id_max = $row['id_max'];
    			$id_max = $id_max +1;
				$sql = "INSERT INTO Client(ID_Client,NomClient, PrénomClient, EmailClient, Carte_etudiante, Adresse,Téléphone, Mot_de_passe) VALUES($id_max,'$nom', '$prenom', '$email2', '$carte', '$adresse','$tel','$mdp2')";
				//echo($sql);
				$stmt = mysqli_prepare($db_handle, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssss', $nom, $prenom, $email2, $carte, $adresse, $tel, $mdp2);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Compte créé avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de la création du compte : " . mysqli_error($db_handle) . "</p>";
                }
			}

		}
	}
	if (isset($_POST['supprimer'])){

		$email1 = isset($_POST["Email"])? $_POST["Email"] : "";
		$consultation = isset($_POST["consultation"])? $_POST["consultation"] : "";
		$sql = "DELETE FROM Consultation WHERE ID_Consultation = '$consultation' ";
		$result = mysqli_query($db_handle, $sql);
		echo "<p>Votre rendez-vous a bien été supprimé</p><p>Voici vos prohaines consultations</p>";
		affichage($db_handle, $email1);
	}

}