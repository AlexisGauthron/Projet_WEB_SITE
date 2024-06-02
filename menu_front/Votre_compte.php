<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Compte</title>
    <link rel="stylesheet" href="menu_front.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="Votre_Compte">
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

    <main class="main">
        <div class="block_compte">
            <h1><i> Vous êtes un ? </i></h1>
        </div>
        <div class= "ligne">
            <div class="card">
                <div class="card-image">
                    <a href="../back/client.html">
                        <img src="image/client.webp" alt="">
                        <div class= "texte_p">
                            <h2><i> Client </i></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-image">
                    <a href="../back/coach.html">
                        <img src="image/coach.webp" alt="">
                        <div class= "texte_p">
                            <h2><i> Coach / Personnel de Sport</i></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-image">
                    <a href="../back/admin.html">
                        <img src="image/administrateur.webp" alt="">
                        <div class= "texte_p">
                            <h2><i> Administrateur </i></h2>
                        </div>
                    </a>
                </div>
            </div>
    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Votre Compte !<b><i>'],
            typeSpeed: 150,
            backSpeed: 150,
            onComplete: (self) => {
                document.querySelector('.typed-cursor').style.display = 'none';
            }
        });
    </script>
</body>
</html>

