<?php
echo '<meta charset="utf-8">';
//echo '<link rel="stylesheet" type="text/css" href="dupondStyle.css">';
//identifier votre BDD



$database = "Projet";
//identifier votre serveur, login et mot de passe
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
$erreur = false;
$errorMessage = "";

if ($db_found) {
	$existe = 1;
	if(isset($_POST['connexion'])) { 
		$sql = "SELECT * FROM Client WHERE Email ='$email' AND Mot_de_passe = '$mdp' ";
		echo "$sql";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_fetch_assoc($result) !=0){
			echo "Bonjour ".$prenom." !";
			$existe =0;
		}
		// METTRE LE SERVICE DE LA SALLE DE SPORT !!
		$sql = "SELECT ID_Coach,ID_Client, Date,Heure,Commentaire FROM Consultation,Client WHERE Email = '$email' ";
		$result = mysqli_query($db_handle,$sql);
		if (mysqli_num_rows($result) > 0) {
			echo "<h1>Vos consultation sont :</h1>";
			//echo "Requete :".$sql."<br>";
			echo "<table border=\"1\">";
			echo "<tr>";
			echo "<th>" . "ID" . "</th>";
			echo "<th>" . "Nom" . "</th>";
			echo "<th>" . "Prénom" . "</th>";
			echo "<th>" . "Statut" . "</th>";
			echo "<th>" . "Date de naissance" . "</th>";
			echo "<th>" . "Photo" . "</th>";
			echo "</tr>";
				//afficher le résultat
			//INSERT INTO `Consultation`(`ID_Consultation`, `ID coach`, `ID client`, `Date`, `Heure`, `Commentaire`) VALUES ('1','1','1','02/05/2024','14','Aucun')
			while ($data = mysqli_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>" . $data['ID'] . "</td>";
				echo "<td>" . $data['Titre'] . "</td>";
				echo "<td>" . $data['Auteur'] . "</td>";
				echo "<td>" . $data['Année'] . "</td>";
				echo "<td>" . $data['Editeur'] . "</td>";
				$image = $data['Couverture'];
				echo "<td>" . "<img src='$image' height='60' width='80'>" . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}else echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";

	}
	if(isset($_POST['creation'])) { 
		if ($nom == "" || $prenom == "" || $email == "" ||$carte == "" || $paiement == ""){
			
			echo("<p>"."Une valeur est nulle"."</p>");

		}else{
			$sql = "SELECT * FROM Client WHERE Email = '$email'";
			$result = mysqli_query($db_handle, $sql);
			if (mysqli_num_rows($result) > 0) {
				$existe = 0;
				echo  "<p>Un compte avec cette adresse mail existe déjà.</p>";
			} else {
				$sql = "INSERT INTO Client(ID_Client,Nom, Prénom, Email, Carte_etudiante, Adresse,Téléphone, Mot_de_passe) VALUES(2,'$nom', '$prenom', '$email', '$carte', '2 av','$tel','$mdp')";
				echo($sql);
				//$result = mysqli_query($db_handle, $sql);
				//echo "<p>Votre compte a été créé avec succès</p>";
				$stmt = mysqli_prepare($db_handle, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssss', $nom, $prenom, $email, $carte, $adresse, $tel, $mdp);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Compte créé avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de la création du compte : " . mysqli_error($db_handle) . "</p>";
                }
				
				//$sql = "SELECT * FROM Client ORDER BY ID DESC LIMIT 1";
			}

		}
	}

}