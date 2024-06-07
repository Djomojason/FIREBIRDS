<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categorie = $_POST['categorie'];
    $adversaire = $_POST['adversaire'];
    $date_heure = $_POST['date_heure'];
    $lieu = $_POST['lieu'];

    // Séparer la date et l'heure de la variable date_heure
    $date_evenement = date('Y-m-d', strtotime($date_heure));
    $heure = date('H:i:s', strtotime($date_heure));

    // Préparation de la requête SQL pour insérer l'événement
    $sql = "INSERT INTO evenements (categorie, adversaire, date_evenement, heure, lieu) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vérifiez si la préparation de la requête a réussi
    if ($stmt === false) {
        die('Erreur de requête : ' . $conn->error);
    }

    // Liaison des paramètres
    $stmt->bind_param("sssss", $categorie, $adversaire, $date_evenement, $heure, $lieu);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Événement ajouté avec succès!";
    } else {
        echo "Erreur lors de l'ajout de l'événement: " . $stmt->error;
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un événement - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Ajouter un événement</h1>
    </header>
    <main>
        <form action="ajouter_evenement.php" method="post">
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <option value="U10M">U10M</option>
                <option value="U10F">U10F</option>
                <option value="U12M">U12M</option>
                <option value="U12F">U12F</option>
                <option value="U14M">U14M</option>
                <option value="U14F">U14F</option>
                <option value="U16M">U16M</option>
                <option value="U16F">U16F</option>
                <option value="U18M">U18M</option>
                <option value="U18F">U18F</option>
                <option value="U20M">U20M</option>
                <option value="U20F">U20F</option>
                <option value="SENIOR M">SENIOR M</option>
                <option value="SENIOR F">SENIOR F</option>
            </select><br>
            <label for="adversaire">Adversaire :</label>
            <input type="text" id="adversaire" name="adversaire" required><br>
            <label for="date_heure">Date et Heure :</label>
            <input type="datetime-local" id="date_heure" name="date_heure" required><br>
            <label for="lieu">Lieu :</label>
            <input type="text" id="lieu" name="lieu" required><br>
            <input type="submit" value="Ajouter l'événement">
        </form>
    </main>
</body>
</html>
