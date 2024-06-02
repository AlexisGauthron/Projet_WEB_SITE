<h1>Retour à la page de <a href="admin_login.html">connexion</a></h1>
<?php
echo '<meta charset="utf-8">';

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);


if (!$db_found) {
    die("<p>Erreur de connexion à la base de données.</p>");
}

if (isset($_POST['admin_connexion'])) {
    $admin_email = $_POST['admin_email'];
    $admin_mdp = $_POST['admin_mdp'];
    
    $sql = "SELECT * FROM Administrateur WHERE EmailAdmin = '$admin_email' AND NomAdmin = '$admin_mdp'";
    $result = mysqli_query($db_handle, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Identifiants incorrects.</p>";
        exit();
    }
}



if (isset($_POST['create_coach'])) {
    $nomCoach = isset($_POST['NomCoach']) ? $_POST['NomCoach'] : '';
    $prenomCoach = isset($_POST['PrenomCoach']) ? $_POST['PrenomCoach'] : '';
    $emailCoach = isset($_POST['EmailCoach']) ? $_POST['EmailCoach'] : '';
    $specialite = isset($_POST['Specialite']) ? $_POST['Specialite'] : '';
    $photoCoach = $_FILES['PhotoCoach']['name'];
    $photoTmpName = $_FILES['PhotoCoach']['tmp_name'];
    $photoDir = 'uploads/';
    $photoPath = $photoDir . basename($photoCoach);

    if ($nomCoach != '' && $prenomCoach != '' && $emailCoach != '' && $specialite != '' && $photoCoach != '') {
        if (move_uploaded_file($photoTmpName, $photoPath)) {
            $sql = "INSERT INTO Coach (NomCoach, PrénomCoach, EmailCoach, Specialité, PhotoCoach) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db_handle, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $nomCoach, $prenomCoach, $emailCoach, $specialite, $photoPath);
            if (mysqli_stmt_execute($stmt)) {
                echo "<p>Coach créé avec succès.</p>";
            } else {
                echo "<p>Erreur lors de la création du coach : " . mysqli_error($db_handle) . "</p>";
            }
        } else {
            echo "<p>Erreur lors du téléchargement de la photo.</p>";
        }
    } else {
        echo "<p>Tous les champs sont requis.</p>";
    }
}

if (isset($_POST['delete_coach'])) {

    $idCoach = isset($_POST['ID_Coach']) ? $_POST['ID_Coach'] : '';

    if ($idCoach != '') {
        $sql = "DELETE FROM Coach WHERE ID_Coach = ?";
        $stmt = mysqli_prepare($db_handle, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $idCoach);
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Coach supprimé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la suppression du coach : " . mysqli_error($db_handle) . "</p>";
        }
    } else {
        echo "<p>L'ID du coach est requis pour la suppression.</p>";
    }
}
?>
<h1>Retour à la page de <a href="admin_logi.html">admin</a></h1>
