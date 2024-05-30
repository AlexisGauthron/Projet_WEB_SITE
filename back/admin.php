<style>
body {
	background-color: #eeeeee;
}
h1 {
text-align: center;
color: white;
background-color: black;
padding: 20px;
width: 650px;
margin: 0 auto 20px auto;
border-radius: 8px;
}
table {
width: 650px;
margin: auto;
background-color: #9999ee;
border-radius: 8px;
}

#delete {
padding-left: 50px;
}
input {
background-color: #3355AA;
}
</style>

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
$courriel = isset($_POST["Courriel"])? $_POST["Courriel"] : "";

$sql = "";
$erreur = false;
$errorMessage = "";

if ($db_found) {
	$existe = 1;
	if(isset($_POST['connexion'])) { 
		$sql = "SELECT * FROM Administrateur WHERE Nom = '$nom' AND Prénom = '$prenom' AND Courriel = '$courriel'";

		$result = mysqli_query($db_handle,$sql);
		if (mysqli_fetch_assoc($result) !=0){
			echo "Bonjour ".$prenom." !";
			$existe =0;
		}
	}

}