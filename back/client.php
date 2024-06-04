<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Client</title>
    <link rel="stylesheet" href="style_back.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="client">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#">Sportify</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../acceuil.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="../menu_front/Votre_compte.php">Retour</a></li>
                <li class="nav-item"><a class="nav-link" href="#">A propos</a></li>
                </ul>
            </div>
        </nav>

        <div class="container_titre"> 
			<h1><spam class ="auto-typing"></spam></h1> 
			<div class="espace"></div>
			<div class="espace"></div>
			<h2><u>S'inscrire !</u></h2>
			<div class="espace"></div>

			 <?php
            session_start();

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
					$sql = "SELECT Mot_de_passe,ID_Client FROM Client WHERE EmailClient ='$email1' ";
					//echo "$sql";
					$result = mysqli_query($db_handle,$sql);
					$mot = mysqli_fetch_assoc($result);
					$_SESSION['ID_Client'] = $mot["ID_Client"];
					if ( $mot ==0){
						$message1 = "Pas de compte avec cette adresse mail créez un compte ou réessayez";
						$erreur = true;
					}else{
						if ($mot['Mot_de_passe'] == $mdp1){
							//echo "bon mdp";
						}else {
							$message1 = "pas bon mdp";;
							$erreur = true;
						}
					}
					if ($erreur == false){
						echo '<form method="post" action ="">';
						echo '<input type="hidden" name="Email" value='.$email.'>';
						header('Location: client1.php');
					}
					
				}
				if(isset($_POST['creation'])) { 
					if ($nom == "" || $prenom == "" || $email2 == "" ||$carte == "" || $paiement == ""|| $adresse == ""||$mdp2 ==""){
						$message = "Une valeur est nulle";

					}else{
						$sql = "SELECT * FROM Client WHERE EmailClient = '$email'";
						
						$result = mysqli_query($db_handle, $sql);
						if (mysqli_num_rows($result) > 0) {
							$message =  "Un compte avec cette adresse mail existe déjà";

						} else {
							$sql = "SELECT MAX(ID_Client) AS id_max FROM Client";
							$result = mysqli_query($db_handle, $sql);
							$row = mysqli_fetch_assoc($result);
							$id_max = $row['id_max'];
							$id_max = $id_max +1;
							$sql = "INSERT INTO Client(ID_Client,NomClient, PrénomClient, EmailClient, Carte_etudiante, Adresse,Téléphone, Mot_de_passe) VALUES($id_max,'$nom', '$prenom', '$email2', '$carte', '$adresse','$tel','$mdp2')";
							
							$stmt = mysqli_prepare($db_handle, $sql);
							mysqli_stmt_bind_param($stmt, 'sssssss', $nom, $prenom, $email2, $carte, $adresse, $tel, $mdp2);
							
							if (mysqli_stmt_execute($stmt)) {
								$message = "Compte créé avec succès.";
								$_SESSION['ID_Client'] = $row["id_max"];
							} else {
								$message = "Erreur lors de la création du compte : " . mysqli_error($db_handle);
							}
						}

					}
				}
			}
			else {
				$error_message = "Erreur de connexion à la base de données.";
			}
            ?>

			<form action="client1.php" method="post">
				<table class="tableau">
					<tr>
						<td>Nom</td>
						<td><input class="gradient" type="text" name="Nom" size="40"> </td>
					</tr>
					<tr>
						<td>Prénom</td>
						<td><input class="gradient" type="text" name="Prénom" size="40"> </td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input class="gradient" type="text" name="Email1" size="40"> </td>
					</tr>
					<tr>
						<td>Carte Etudiante</td>
						<td><input class="gradient" type="number" name="Carte" size="40"> </td>
					</tr>
					<tr>
						<td>Carte de paiement</td>
						<td><input class="gradient" type="number" name="Paiement" size="40"> </td>
					</tr>
					<tr>
						<td>Mot de passe</td>
						<td><input class="gradient" type="password" name="mdp1" size="40"> </td>
					</tr>
					<tr>
						<td>Téléphone</td>
						<td><input class="gradient" type="tel" name="tel" size="40"> </td>
					</tr>
					<tr>
						<td>Adresse</td>
						<td><input class="gradient" type="text" name="Adresse" size="40"> </td>
					</tr>
						<td colspan="2" class="connect" >
							<input class="gradient" type="submit" name="creation" value="Creer">
						</td>
					</tr>
				</table>
				<div class="espace"></div>
				<?php
				if($error_message){
					echo "<p id='error-message' class ='php'>$error_message</p>";
				}
				if ($message) {
					echo "<p id='error-message' class ='php'>$message</p>";
				}
				?>
				<div class="espace"></div>
				<div class="espace"></div>
				<h2><u>Se Connecter !</u></h2>
				<div class="espace"></div>
				<table class="tableau">
					<tr>
						<td>Email</td>
						<td><input class="gradient" type="text" name="Email2" size="40"> </td>
					</tr>
					<tr>
						<td>Mot de passe</td>
						<td><input class="gradient" type="password" name="mdp2" size="40"> </td>
					</tr>
					<tr>
						<td colspan="2" class="connect">
							<input class="gradient" type="submit" name="connexion" value="Se connecter">
						</td>
					</tr>
				</table>
				<?php
				if ($message1) {
					echo "<p id='error-message' class ='php'>$message1</p>";
				}
				?>
				</form>
				<div class="espace"></div>
        </div>
    </header>

    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Client<b><i>'],
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