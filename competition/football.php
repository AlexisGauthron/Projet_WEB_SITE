<?php 
    $database = "Projet";
    $db_handle = mysqli_connect('localhost', 'root', 'root');
    $db_found = mysqli_select_db($db_handle, $database);
    $sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach FROM Coach WHERE Specialité = 'Football'";
    $result = mysqli_query($db_handle, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football</title>
    <link rel="stylesheet" href="../style_coach.css">
    <link rel="stylesheet" href="competition.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="football">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#">Sportify</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../acceuil.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="competitions.html">Sport de Compétition</a></li>
                <li class="nav-item"><a class="nav-link" href="#">A propos</a></li>
                </ul>
            </div>
        </nav>

        <div class="container_titre"> 
            <h1><spam class ="auto-typing"></spam></h1> 
        </div>
    </header>

    <main class ="main">
        <div class= "ligne_coach">
            <?php
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
                    echo '<button class="service-button"><a href="../back/parler.html">Communiquer avec le coach</a></button>';
                    echo '<button class="service-button">Voir son CV</button>';
                    echo '</div>';
                echo '</div>';
                }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Football<b><i>'],
            typeSpeed: 150,
            backSpeed: 2000,
            onComplete: (self) => {
                document.querySelector('.typed-cursor').style.display = 'none';
            }
        });
    </script>
</html>
