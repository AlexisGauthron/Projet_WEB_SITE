<?php 
    $database = "Projet";
    $db_handle = mysqli_connect('localhost', 'root', 'root');
    $db_found = mysqli_select_db($db_handle, $database);
    $sql = "SELECT ID_Coach,PrénomCoach, NomCoach, Photo, EmailCoach FROM Coach WHERE Specialité = 'Plongeon'";
    $result = mysqli_query($db_handle, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plongeon</title>
    <link rel="stylesheet" href="competition.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="plongeon">
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

        <div class="container">
        <div class="row">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4">';
                echo '<div class="card mb-4">';
                echo '<img class="card-img-top" src="images/' . $row['Photo'] . '" alt="Photo de ' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['PrénomCoach'] . ' ' . $row['NomCoach'] . '</h5>';
                echo '<p class="card-text">Email: ' . $row['EmailCoach'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<form method="post" action ="../back/planning.php">';
                echo '<input type="hidden" name="idcoach" value="' . $row['ID_Coach'] . '">';
                echo '<input type="submit" name="RDV" value="Prendre un RDV">';
                echo '</form>';
            }
            ?>
        </div>
        
        <button>Communiquer avec le coach</button>
        <button>Voir son CV</button>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Plongeon<b><i>'],
            typeSpeed: 150,
            backSpeed: 2000,
            onComplete: (self) => {
                document.querySelector('.typed-cursor').style.display = 'none';
            }
        });
    </script>
</body>
</html>