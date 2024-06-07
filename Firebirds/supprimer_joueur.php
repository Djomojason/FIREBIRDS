<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "firebirds_db";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupération des joueurs
$sql = "SELECT id, nom, prenom FROM joueurs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un joueur - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmDelete(playerId, playerName) {
            if (confirm("Voulez-vous vraiment supprimer le joueur " + playerName + " ?")) {
                window.location.href = "supprimer_joueur_action.php?id=" + playerId;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Supprimer un joueur</h1>
    </header>
    <main>
        <h2>Liste des joueurs</h2>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>" . $row["nom"] . " " . $row["prenom"] . " <button onclick=\"confirmDelete(" . $row["id"] . ", '" . $row["nom"] . " " . $row["prenom"] . "')\">Supprimer</button></li>";
                }
            } else {
                echo "Aucun joueur trouvé.";
            }
            $conn->close();
            ?>
        </ul>
    </main>
</body>
</html>
