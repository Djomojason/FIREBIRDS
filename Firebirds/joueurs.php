<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FIREBIRDS - Liste des Joueurs</h1>
    </header>
    <main>
        <?php
            // Informations de connexion à la base de données
            $servername = "localhost";
            $username = "root"; // Remplacez par votre nom d'utilisateur
            $password = ""; // Remplacez par votre mot de passe
            $dbname = "firebirds_db"; // Remplacez par le nom de votre base de données

            // Création de la connexion
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Connexion échouée: " . $conn->connect_error);
            }

            // Requête SQL pour récupérer les joueurs
            $sql = "SELECT id, nom, prenom FROM joueurs";
            $result = $conn->query($sql);

            // Vérification des résultats
            if ($result->num_rows > 0) {
                // Affichage des résultats pour chaque joueur
                while($row = $result->fetch_assoc()) {
                    echo '<a href="modifier_joueur.php?id=' . $row["id"] . '">' . $row["nom"] . ' ' . $row["prenom"] . '</a><br>';
                }
            } else {
                echo "Aucun joueur trouvé.";
            }

            // Fermeture de la connexion
            $conn->close();
        ?>
    </main>
</body>
</html>


