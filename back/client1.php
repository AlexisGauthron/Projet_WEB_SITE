<?php
	$database = "Projet";
	$db_handle = mysqli_connect('localhost', 'root', 'root');
	$db_found = mysqli_select_db($db_handle, $database);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>
    <link rel="stylesheet" href="style_back.css">
    <link rel="stylesheet" href="style_planning.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="planning">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#">Sportify</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../acceuil.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="client.php">Retour</a></li>
                <li class="nav-item"><a class="nav-link" href="#">A propos</a></li>
                </ul>
            </div>
        </nav>

        <div class="container_titre_plan"> 
            <h1><spam class ="auto-typing"></spam></h1> 
        </div>
	</header>
	<main class="main">
		<?php

			session_start();


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
			$message ="";

			function affichage($db_handle, $email){
				$sql = "SELECT ID_Consultation,Date,Heure,Commentaire,NomCoach,PrénomCoach,Specialité FROM Consultation,Client,Coach WHERE IDclient = ID_Client AND EmailClient = '$email' AND IDcoach = ID_Coach ORDER BY Date,Heure ASC ;";
				$result = mysqli_query($db_handle,$sql);

				if (mysqli_num_rows($result) > 0) {
					echo "<div class='cl'>";
					echo "<table class ='tableauclient'>";
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
						echo "<td class='es'>" . substr($data['Heure'],0,5) . "</td>";
						echo "<td>" . $data['Commentaire'] . "</td>";
						echo "<td>" . $data['NomCoach']." ".$data['PrénomCoach'] . "</td>";
						echo "<td>" . $data['Specialité']."</td>";
						echo '<form method="post" action ="">';
						echo '<input type="hidden" name="consultation" value='.$data["ID_Consultation"].'>';
						echo '<input type="hidden" name="Email" value='.$email.'>';
						echo '<td class="ese"><input type="submit" name="supprimer" value="Annuler ce RDV"></td>';
						echo"</form";
						echo "</tr>";
					}
					echo "</table>";
					echo "</div>";
				}else echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";
			}

			function connexion($db_handle,$email1,$mdp1) {

				$sql = "SELECT Mot_de_passe,ID_Client FROM Client WHERE EmailClient ='$email1' ";
					//echo "$sql";
					$result = mysqli_query($db_handle,$sql);
					$mot = mysqli_fetch_assoc($result);
					
					$_SESSION['ID_Client'] = $mot["ID_Client"];
					if ( $mot ==0){
						echo "Pas de compte avec cette adresse mail créez un compte ou réessayez";
						$erreur = true;
					}else{
						echo $mot['Mot_de_passe'];
						if ($mot['Mot_de_passe'] == $mdp1){
							//echo "bon mdp";
						}else {
							echo "pas bon mdp";
							header('Location: client.html');
							$erreur = true;
						}
					}
					if ($erreur == false){
						affichage($db_handle, $email1);
					}
			}


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
							header('Location : client.html');

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
								$_SESSION['ID_Client'] = $row["id_max"];
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
					$message = "Votre rendez-vous a bien été supprimé<br>Voici vos prohaines consultations";
					if ($message) {
						echo "<p id='error-message' class ='php'>$message</p>";
					}
					affichage($db_handle, $email1);
				}

			}

		
		?>

	</main>

	<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Vos consultations !<b><i>'],
            typeSpeed: 150,
            backSpeed: 2000,
            onComplete: (self) => {
                document.querySelector('.typed-cursor').style.display = 'none';
            }
        });

		window.onload = function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 3000); // 3000 millisecondes = 3 secondes
            }
        };
	</script>
</body>
</html>






<?php
