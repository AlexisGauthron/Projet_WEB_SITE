<?php
echo '<meta charset="utf-8">';

function affichage($db_handle, $email){

			$sql = "SELECT ID_Consultation,Date,Heure,Commentaire,NomCoach,PrénomCoach,Specialité FROM Consultation,Client,Coach WHERE IDclient = ID_Client AND Email = '$email' AND IDcoach = ID_Coach;";
			echo"$sql";
			$result = mysqli_query($db_handle,$sql);
			if (mysqli_num_rows($result) > 0) {
				echo "<h1>Vos consultation sont :</h1>";
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

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);


$nom = isset($_POST["Nom"])? $_POST["Nom"] : "";
$prenom = isset($_POST["Prénom"])? $_POST["Prénom"] : "";
$email = isset($_POST["Email"])? $_POST["Email"] : "";
$carte = isset($_POST["Carte"])? $_POST["Carte"] : "";
$paiement = isset($_POST["Paiement"])? $_POST["Paiement"] : "";
$adresse = isset($_POST["Adresse"])? $_POST["Adresse"] : "";
$mdp = isset($_POST["mdp"])? $_POST["mdp"] : "";
$tel = isset($_POST["tel"])? $_POST["tel"] : "";



$sql = "";

$errorMessage = "";


if ($db_found) {
	$erreur = false;
	if(isset($_POST['connexion'])) { 
		$sql = "SELECT Mot_de_passe FROM Client WHERE Email ='$email' ";
		echo "$sql";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_fetch_assoc($result) ==0){
			echo "Pas de compte avec cette adresse mail créez un compte ou réessayez";
			$erreur = true;
		}else{
			$mot = mysqli_fetch_assoc($result);

			echo $mot['Mot_de_passe'];
			if ($mot['Mot_de_passe'] == $mdp){
				echo "bon mdp";
			}else {
				echo "pas bon mdp";
				$erreur = true;
			}
		}
		if ($erreur == false){
			echo " Bonjour ".$prenom." !";
			affichage($db_handle, $email);
		}
		

	}
	if(isset($_POST['creation'])) { 
		if ($nom == "" || $prenom == "" || $email == "" ||$carte == "" || $paiement == ""|| $adresse == ""){
			
			echo("<p>"."Une valeur est nulle"."</p>");

		}else{
			$sql = "SELECT * FROM Client WHERE Email = '$email'";
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) > 0) {
				echo  "<p>Un compte avec cette adresse mail existe déjà.</p>";
			} else {
				$sql = "INSERT INTO Client(ID_Client,Nom, Prénom, Email, Carte_etudiante, Adresse,Téléphone, Mot_de_passe) VALUES(2,'$nom', '$prenom', '$email', '$carte', '$adresse','$tel','$mdp')";
				echo($sql);
				$stmt = mysqli_prepare($db_handle, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssss', $nom, $prenom, $email, $carte, $adresse, $tel, $mdp);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Compte créé avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de la création du compte : " . mysqli_error($db_handle) . "</p>";
                }
			}

		}
	}
	if (isset($_POST['supprimer'])){

		$email = isset($_POST["Email"])? $_POST["Email"] : "";
		$consultation = isset($_POST["consultation"])? $_POST["consultation"] : "";
		$sql = "DELETE FROM Consultation WHERE ID_Consultation = '$consultation' ";
		$result = mysqli_query($db_handle, $sql);
		echo "<p>Votre rendez-vous a bien été supprimé</p><p>Voici vos prohaines consultations</p>";
		affichage($db_handle, $email);
	}

}