<?php 
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$database = "Projet";
		$db_handle = mysqli_connect('localhost', 'root', 'root');

		$id = isset($_POST["id"])? $_POST["id"] : "";
		$date = isset($_POST["dates"])? $_POST["dates"] : "";
		$heure = isset($_POST["heure"])? $_POST["heure"] : "";
		$form_id = isset($_POST["form_id"])? $_POST["form_id"] : "";
		$idcoach = 2;

		$db_found = mysqli_select_db($db_handle, $database);
		if ($form_id==1){
			$sql = "SELECT MAX(ID_Consultation) AS id_max FROM Consultation";

			$result = mysqli_query($db_handle, $sql);
			$row = mysqli_fetch_assoc($result);
			$id_max = $row['id_max'];
			$id_max = $id_max +1;
			//$sql = "INSERT INTO Consultation(ID_Consultation,IDcoach,IDclient,Date, Heure, Commentaire) VALUES('$id_max','2', '2', '$aujourdhui', '$id', 'aucun')";
			//$sql = "SELECT Date,Heure FROM Consultation WHERE Date =$date AND Heure = $heure AND IDcoach = $idcoach ";


			$sql = "INSERT INTO Consultation(ID_Consultation,IDcoach,IDclient,Date, Heure, Commentaire) VALUES('$id_max','$idcoach', '2', '$date', '$heure', 'aucun')";
			$result = mysqli_query($db_handle, $sql);
		}	
		if ($form_id==2){

		}
		//echo "$id $date $heure";
		echo "$sql";

		header('Location: test.php');
		exit();

	}
?>;