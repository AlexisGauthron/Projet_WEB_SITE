<?php 
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	$database = "Projet";
	$db_handle = mysqli_connect('localhost', 'root', 'root');

	$requete = isset($_POST["requete"])? $_POST["requete"] : "";
	$requete = 'Alex';

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