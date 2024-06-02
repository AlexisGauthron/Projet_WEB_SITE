<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="menu_front.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="Recherche">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#">Sportify</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../acceuil.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">A propos</a></li>
                </ul>
            </div>
        </nav>

        <div class="container_titre"> 
            <h1><spam class ="auto-typing"></spam></h1> 
        </div>
    </header>
    </body>
</html>

<?php 
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	$database = "Projet";
	$db_handle = mysqli_connect('localhost', 'root', 'root');

	$requete = isset($_POST["requete"])? $_POST["requete"] : "";

	$db_found = mysqli_select_db($db_handle, $database);

	$test = 0;
	$sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE Specialité = '$requete'";

	$result = mysqli_query($db_handle, $sql);
	$row = mysqli_fetch_assoc($result);
	if ($row){
		$test =1;
	} else{
		$sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE PrénomCoach = '$requete'";
		$result = mysqli_query($db_handle, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row > 0){
			$test =1;
	}else{
		$sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE NomCoach = '$requete'";
		$result = mysqli_query($db_handle, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row > 0){
			$test =1;

	}else{
		$sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE EmailCoach = '$requete'";
		$result = mysqli_query($db_handle, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row > 0){
			$test =1;
		}
	}}}
	if ($test = 1){
		echo "<h1>Prenom : ".$row['PrénomCoach']." Nom :".$row['NomCoach']." Spécialité : ".$row['Specialité']."</h1>";
	} else echo "<h1>Pas de résultat</h1>";


     //header('Location: planning.php');
	//exit();

?>;