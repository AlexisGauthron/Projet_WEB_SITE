<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Administrateur</title>
    <link rel="stylesheet" href="style_back.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="administrateur">
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

            if (!$db_found) {
                $error_message = "Erreur de connexion à la base de données.";
            }

            if (isset($_POST['admin_connexion'])) {
                $admin_email = $_POST['admin_email'];
                $admin_mdp = $_POST['admin_mdp'];
                
                $sql = "SELECT * FROM Administrateur WHERE EmailAdmin = '$admin_email' AND NomAdmin = '$admin_mdp'";
                $result = mysqli_query($db_handle, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $_SESSION['admin_logged_in'] = true;
                    header("Location: admin_logi.php");
                } else {
                    $error_message = "Identifiants incorrects.";
                }
            }
            ?>

            
			<form action="" method="post">
				<table class="tableau">
					<tr>
						<td><label for="admin_email">Email:</label></td>
						<td><input class="gradient" type="email" id="admin_email" name="admin_email" required></td>
					</tr>
					<tr>
						<td><label for="admin_mdp">Mot de passe:</label></td>
						<td><input class="gradient" type="password" id="admin_mdp" name="admin_mdp" required></td>
					</tr>
					<tr>
						<td colspan="2" class="connect">
							<input class="gradient" type="submit" name="admin_connexion" value="Connexion">
						</td>
					</tr>
				</table>
			</form>

            <?php
            if ($error_message) {
                echo "<p id='error-message' class ='php'>$error_message</p>";
            }
            ?>
            
        </div>
    </header>


    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Administrateur<b><i>'],
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



					
