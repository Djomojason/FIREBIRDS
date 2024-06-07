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

// Vérification si un ID est passé en paramètre
if (isset($_GET["id"])) {
    $id = $conn->real_escape_string($_GET["id"]);

    // Requête SQL pour supprimer le joueur
    $sql = "DELETE FROM joueurs WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Le joueur a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du joueur: " . $conn->error;
    }
} else {
    echo "ID de joueur non spécifié.";
}

// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression du joueur - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Suppression du joueur</h1>
    </header>
    <main>
        <button onclick="location.href='supprimer_joueur.php'">Retour à la liste des joueurs</button>
    </main>
</body>
</html>
