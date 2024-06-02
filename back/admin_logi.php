<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="style_back.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="admin_logi">
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
            
            <?php
            session_start();

            $database = "Projet";
            $db_handle = mysqli_connect('localhost', 'root', 'root');
            $db_found = mysqli_select_db($db_handle, $database);

            $error_message = '';
            $error_message2 = '';


            if (!$db_found) {
                $error_message = "Erreur de connexion à la base de données.";
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
                            $error_message = "Coach créé avec succès.";
                        } else {
                            $error_message = "Erreur lors de la création du coach : " . mysqli_error($db_handle) ;
                        }
                    } else {
                        $error_message = "Erreur lors du téléchargement de la photo.";
                    }
                } else {
                    $error_message = "Tous les champs sont requis.";
                }
            }

            ?>

            <h2>Création de coach</h2>

            <form method="post" action="" enctype="multipart/form-data">
                <table class="tableau">
                    <tr>
                        <td><label for="NomCoach">Nom:</label></td>
                        <td><input class="gradient" type="text" id="NomCoach" name="NomCoach" required></td>
                    </tr>
                    <tr>
                        <td><label for="PrenomCoach">Prénom:</label></td>
                        <td><input class="gradient" type="text" id="PrenomCoach" name="PrenomCoach" required></td>
                    </tr>
                    <tr>
                        <td><label for="EmailCoach">Email:</label></td>
                        <td><input class="gradient" type="email" id="EmailCoach" name="EmailCoach" required></td>
                    </tr>
                    <tr>
                        <td><label for="Specialite">Spécialité:</label></td>
                        <td><input class="gradient" type="text" id="Specialite" name="Specialite" required></td>
                    </tr>
                    <tr>
                        <td><label for="PhotoCoach">Photo:</label></td>
                        <td><input class="gradient" type="file" id="PhotoCoach" name="PhotoCoach" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="connect">
                            <input class="gradient" type="submit" name="create_coach" value="Créer un coach">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            if ($error_message) {
                echo "<p id='error-message' class ='php'>$error_message</p>";
            }
            ?>

            <div class="espace"></div>
            <h2>Suppression de coach</h2>

            <?php
            
            if (isset($_POST['delete_coach'])) {

                $idCoach = isset($_POST['ID_Coach']) ? $_POST['ID_Coach'] : '';
            
                if ($idCoach != '') {
                    $sql = "DELETE FROM Coach WHERE ID_Coach = ?";
                    $stmt = mysqli_prepare($db_handle, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $idCoach);
                    if (mysqli_stmt_execute($stmt)) {
                        $error_message2 = "Coach supprimé avec succès.";
                    } else {
                        $error_message2 = "Erreur lors de la suppression du coach : " . mysqli_error($db_handle);
                    }
                } else {
                    $error_message2 = "L'ID du coach est requis pour la suppression.";
                }
            }

            ?>


            <form method="post" action="">
                <table class="tableau">
                    <tr>
                        <td><label for="ID_Coach">ID du coach:</label></td>
                        <td><input class="gradient" type="text" id="ID_Coach" name="ID_Coach" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="connect">
                            <input class="gradient" type="submit" name="delete_coach" value="Supprimer un coach">
                        </td>
                    </tr>
                </table>
            </form>
            
            <?php
            if ($error_message2) {
                echo "<p id='error-message' class ='php'>$error_message2</p>";
            }
            ?>

            <div class="espace"></div>
            <div class="espace"></div>
            
            <h1><a href="logout.php">Déconnexion</a></h1>
            
        </div>
    </header>


    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Bienvenue, Administrateur<b><i>'],
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
