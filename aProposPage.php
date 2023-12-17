<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="styles.css">
    <script>
        function reloadHomePage() {
            window.location.href = 'index.html';
        }
    </script>
</head>
<body>

    <header>
        <div class="left-content">
            <img src="image/logo.png" alt="Logo Ecolo'jeu" id="logo" onclick="reloadHomePage()">
        </div>
        <h1>Ecolo'jeux</h1>
        <div class="right-content">
            <a href="a-propos.html"></a>
        </div>
    </header>
    <main class="center-text">
    <!-- Votre contenu ici -->
    <p>La Nuit de l'Info est une compétition nationale qui réunit étudiants, enseignants et entreprises à travers la France dont l'objectif est de développer, en équipe, une application web en une nuit sur un thème proposé par des entreprises ou des associations.</p>
    <p>Nous sommes l’équipe “Fromage et dessert”, un ensemble de 12 étudiants motivés pour créer un site web original et innovant, répondant à une problématique donnée au début de la nuit.</p>

    <!-- Image centrée -->
    <div class="image-container">
        <img src="image/photoDeLaTeam.png" alt="Description de l'image"  width="40%" height="40%">
    </div>
    </main>
    <footer>
    <p>&copy;<a href="https://github.com/Nirvanas-V/Fromage-et-Dessert">lien vers le dépot github</a></p>
        <p>&copy;<a href="https://youtu.be/veO9ynDU1kk?si=E4-kxfTH3LY14rmH">lien vers la vidéo ytb (pitch)</a></p>
    </footer>

</body>
</html>