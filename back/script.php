<?php
echo '<meta charset="utf-8">';

$database = "Projet";
$db_handle = mysqli_connect('localhost', 'root', 'root');
$db_found = mysqli_select_db($db_handle, $database);

if (!$db_found) {
    die("<p>Erreur de connexion à la base de données.</p>");
}

function affichage($db_handle, $email){
    $sql = "SELECT ID_Consultation, Date, Heure, Commentaire, NomCoach, PrénomCoach, Specialité FROM Consultation, Client, Coach WHERE IDclient = ID_Client AND EmailClient = '$email' AND IDcoach = ID_Coach;";
    $result = mysqli_query($db_handle, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Vos consultations sont :</h1>";
        echo "<table border=\"1\">";
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Heure</th>";
        echo "<th>Commentaire</th>";
        echo "<th>Coach</th>";
        echo "<th>Activité</th>";
        echo "</tr>";
        while ($data = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $data['Date'] . "</td>";
            echo "<td>" . $data['Heure'] . "</td>";
            echo "<td>" . $data['Commentaire'] . "</td>";
            echo "<td>" . $data['NomCoach'] . " " . $data['PrénomCoach'] . "</td>";
            echo "<td>" . $data['Specialité'] . "</td>";
            echo '<form method="post" action="script.php">';
            echo '<input type="hidden" name="consultation" value="' . $data["ID_Consultation"] . '">';
            echo '<input type="hidden" name="Email" value="' . $email . '">';
            echo '<td><input type="submit" name="supprimer" value="Annuler ce RDV"></td>';
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Vous n'avez pas de consultation passées ou prévues.</p>";
    }
}

if ($db_found) {
    $nom = isset($_POST["Nom"]) ? $_POST["Nom"] : "";
    $prenom = isset($_POST["Prénom"]) ? $_POST["Prénom"] : "";
    $email = isset($_POST["Email"]) ? $_POST["Email"] : "";
    $carte = isset($_POST["Carte"]) ? $_POST["Carte"] : "";
    $paiement = isset($_POST["Paiement"]) ? $_POST["Paiement"] : "";
    $adresse = isset($_POST["Adresse"]) ? $_POST["Adresse"] : "";
    $mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : "";

    if (isset($_POST['connexion'])) {
        $sql = "SELECT Mot_de_passe, PrénomClient FROM Client WHERE EmailClient = '$email'";
        $result = mysqli_query($db_handle, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $mot = mysqli_fetch_assoc($result);
            if ($mot['Mot_de_passe'] == $mdp) {
                echo "Bonjour " . $mot['PrénomClient'] . " !";
                affichage($db_handle, $email);
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Pas de compte avec cette adresse mail. Créez un compte ou réessayez.";
        }
    }

    if (isset($_POST['creation'])) {
        if ($nom == "" || $prenom == "" || $email == "" || $carte == "" || $paiement == "" || $adresse == "" || $mdp == "") {
            echo "<p>Une valeur est nulle.</p>";
        } else {
            $sql = "SELECT * FROM Client WHERE EmailClient = '$email'";
            $result = mysqli_query($db_handle, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<p>Un compte avec cette adresse mail existe déjà.</p>";
            } else {
                $sql = "SELECT MAX(ID_Client) AS id_max FROM Client";
                $result = mysqli_query($db_handle, $sql);
                $row = mysqli_fetch_assoc($result);
                $id_max = $row['id_max'] + 1;
                $sql = "INSERT INTO Client (ID_Client, NomClient, PrénomClient, EmailClient, Carte_etudiante, Adresse, Téléphone, Mot_de_passe) VALUES ($id_max, '$nom', '$prenom', '$email', '$carte', '$adresse', '$tel', '$mdp')";
                if (mysqli_query($db_handle, $sql)) {
                    echo "<p>Compte créé avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de la création du compte : " . mysqli_error($db_handle) . "</p>";
                }
            }
        }
    }

    if (isset($_POST['supprimer'])) {
        $consultation = isset($_POST["consultation"]) ? $_POST["consultation"] : "";
        $email = isset($_POST["Email"]) ? $_POST["Email"] : "";
        $sql = "DELETE FROM Consultation WHERE ID_Consultation = '$consultation'";
        if (mysqli_query($db_handle, $sql)) {
            echo "<p>Votre rendez-vous a bien été supprimé.</p><p>Voici vos prochaines consultations :</p>";
            affichage($db_handle, $email);
        } else {
            echo "<p>Erreur lors de la suppression du rendez-vous : " . mysqli_error($db_handle) . "</p>";
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
} else {
    echo "<p>Erreur de connexion à la base de données.</p>";
}
?>
