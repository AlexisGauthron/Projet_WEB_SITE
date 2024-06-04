<?php 
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$database = "Projet";
		$db_handle = mysqli_connect('localhost', 'root', 'root');
		session_start();

		$id = isset($_POST["id"])? $_POST["id"] : "";
		$date = isset($_POST["dates"])? $_POST["dates"] : "";
		$heure = isset($_POST["heure"])? $_POST["heure"] : "";
		$idcoach = isset($_POST["id_coach"])? $_POST["id_coach"] : "";


		$db_found = mysqli_select_db($db_handle, $database);

		$sql = "SELECT MAX(ID_Consultation) AS id_max FROM Consultation";

		$result = mysqli_query($db_handle, $sql);
		$row = mysqli_fetch_assoc($result);
		$id_max = $row['id_max'];
		$id_max = $id_max +1;
		//$sql = "INSERT INTO Consultation(ID_Consultation,IDcoach,IDclient,Date, Heure, Commentaire) VALUES('$id_max','2', '2', '$aujourdhui', '$id', 'aucun')";
		//$sql = "SELECT Date,Heure FROM Consultation WHERE Date =$date AND Heure = $heure AND IDcoach = $idcoach ";

		$idclient = $_SESSION['ID_Client'];
		$sql = "INSERT INTO Consultation(ID_Consultation,IDcoach,IDclient,Date, Heure, Commentaire) VALUES('$id_max','$idcoach','$idclient', '$date', '$heure', 'aucun')";
		$result = mysqli_query($db_handle, $sql);

		//echo "$id $date $heure";
		echo "$sql";
		
		echo '<form id="autoSubmitForm" method="post" action="planning.php">';
    echo '<input type="hidden" name="idcoach" value="' . htmlspecialchars($idcoach) . '">';
    echo '</form>';
    echo '<script type="text/javascript">
            document.getElementById("autoSubmitForm").submit();
          </script>';
         //header('Location: planning.php');
		exit();

	}
?>;