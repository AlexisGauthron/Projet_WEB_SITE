<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="menu_front.css">
    <link rel="stylesheet" href="../style_coach.css">
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

        <div class="container_titre_recherche"> 
            <h1><spam class ="auto-typing"></spam></h1> 
            <div class="espace"></div>
            <?php 
                $database = "Projet";
                $db_handle = mysqli_connect('localhost', 'root', 'root');

                $requete = isset($_POST["requete"])? $_POST["requete"] : "";
                $db_found = mysqli_select_db($db_handle, $database);

                $error_message = '';

                if (!$db_found) {
                    $error_message = "Erreur de connexion à la base de données.";
                }
                else {
                    $test = 0;
                    $sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE Specialité = '$requete'";

                    $result = mysqli_query($db_handle, $sql);
                    $row = mysqli_fetch_assoc($result);

                    if ($row){
                        $test =1;
                    } 
                    else{
                        $sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach,Specialité FROM Coach WHERE PrénomCoach = '$requete'";
                        $result = mysqli_query($db_handle, $sql);
                        $row = mysqli_fetch_assoc($result);
                        if ($row > 0){
                            $test =1;
                        }
                        else{
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
                            }
                        }  
                    }

                    if ($test == 1){
                        $error_message = "Il y a des résultats.";
                    } else $error_message = "Il n'y a pas de résultats.";
                }
            ?>

            <form action="" method="post">
                <table class="tableau">
                    <tr><td><input class="gradient" type="text" name="requete" size="40"></td></tr>
                    <tr><td colspan="2" class="connect_recher"><input class="gradient" type="submit" name="boutton" value="Rechercher"></td></tr>
                </table>
            </form>

            <?php 
                if ($error_message) {
                    echo "<p id='error-message' class ='php'>$error_message</p>";
                }
                //header('Location: planning.php');
                //exit();
		    ?>
        </div> 
    </header>   
    
    <main class ="main">
        <div class= "ligne_coach">
            <?php
            if ($test == 1) {
                echo '<div class="carte rouge">';
                        echo '<div class="entete">';
                            echo '<div class="photo">';
                                echo '<img class="photo_coach" src="images/' . $row['Photo'] . '" alt="Photo de ' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '">';
                            echo '</div>';
                            echo '<div class="infos-coach">';
                                echo '<h1 class="card-title">' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '</h1>';
                                echo '<h2 class="card-text">Email: ' . $row['EmailCoach'] . '</h2>';
                            echo '</div>';
                        echo '</div>';
                    
                        echo '<div class="boutons">';
                            echo '<div class="service-button">';
                                echo '<form class="form-reset" method="post" action="../back/planning.php">';
                                    echo '<input type="hidden" name="idcoach" value="' . $row['ID_Coach'] . '">';
                                    echo '<input type="submit" name="RDV" value="Prendre un RDV">';
                                echo '</form>';
                            echo '</div>';
                            echo '<button class="service-button">Communiquer avec le coach</button>';
                            echo '<button class="service-button">Voir son CV</button>';
                        echo '</div>';
                    echo '</div>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="carte rouge">';
                        echo '<div class="entete">';
                            echo '<div class="photo">';
                                echo '<img class="photo_coach" src="images/' . $row['Photo'] . '" alt="Photo de ' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '">';
                            echo '</div>';
                            echo '<div class="infos-coach">';
                                echo '<h1 class="card-title">' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '</h1>';
                                echo '<h2 class="card-text">Email: ' . $row['EmailCoach'] . '</h2>';
                            echo '</div>';
                        echo '</div>';
                    
                        echo '<div class="boutons">';
                            echo '<div class="service-button">';
                                echo '<form class="form-reset" method="post" action="../back/planning.php">';
                                    echo '<input type="hidden" name="idcoach" value="' . $row['ID_Coach'] . '">';
                                    echo '<input type="submit" name="RDV" value="Prendre un RDV">';
                                echo '</form>';
                            echo '</div>';
                            echo '<button class="service-button">Communiquer avec le coach</button>';
                            echo '<button class="service-button">Voir son CV</button>';
                        echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </main>    

    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Que Recherchez-vous ?<b><i>'],
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

