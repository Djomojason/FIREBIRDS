<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['event_id'])) {
        // Récupérer les détails de l'événement sélectionné
        $event_id = $_POST['event_id'];
        $sql = "SELECT * FROM evenements WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();
    } elseif (isset($_POST['update_event'])) {
        // Mettre à jour les détails de l'événement
        $event_id = $_POST['update_event'];
        $categorie = $_POST['categorie'];
        $adversaire = $_POST['adversaire'];
        $date_heure = $_POST['date_heure'];
        $lieu = $_POST['lieu'];

        $date_evenement = date('Y-m-d', strtotime($date_heure));
        $heure = date('H:i:s', strtotime($date_heure));

        $sql = "UPDATE evenements SET categorie = ?, adversaire = ?, date_evenement = ?, heure = ?, lieu = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $categorie, $adversaire, $date_evenement, $heure, $lieu, $event_id);

        if ($stmt->execute()) {
            echo "Événement modifié avec succès!";
        } else {
            echo "Erreur lors de la modification de l'événement: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    // Récupérer tous les événements pour les afficher dans la liste de sélection
    $sql = "SELECT id, categorie, adversaire, date_evenement, heure, lieu FROM evenements ORDER BY date_evenement, heure";
    $result = $conn->query($sql);

    $evenements = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $evenements[] = $row;
        }
    } elseif (!$result) {
        die('Erreur de requête : ' . $conn->error);
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un événement - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Modifier un événement</h1>
    </header>
    <main>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($event)): ?>
            <form action="modifier_evenement.php" method="post">
                <input type="hidden" name="update_event" value="<?php echo $event['id']; ?>">
                <label for="categorie">Catégorie :</label>
                <select id="categorie" name="categorie" required>
                    <option value="U10M" <?php if ($event['categorie'] == 'U10M') echo 'selected'; ?>>U10M</option>
                    <option value="U10F" <?php if ($event['categorie'] == 'U10F') echo 'selected'; ?>>U10F</option>
                    <option value="U12M" <?php if ($event['categorie'] == 'U12M') echo 'selected'; ?>>U12M</option>
                    <option value="U12F" <?php if ($event['categorie'] == 'U12F') echo 'selected'; ?>>U12F</option>
                    <option value="U14M" <?php if ($event['categorie'] == 'U14M') echo 'selected'; ?>>U14M</option>
                    <option value="U14F" <?php if ($event['categorie'] == 'U14F') echo 'selected'; ?>>U14F</option>
                    <option value="U16M" <?php if ($event['categorie'] == 'U16M') echo 'selected'; ?>>U16M</option>
                    <option value="U16F" <?php if ($event['categorie'] == 'U16F') echo 'selected'; ?>>U16F</option>
                    <option value="U18M" <?php if ($event['categorie'] == 'U18M') echo 'selected'; ?>>U18M</option>
                    <option value="U18F" <?php if ($event['categorie'] == 'U18F') echo 'selected'; ?>>U18F</option>
                    <option value="U20M" <?php if ($event['categorie'] == 'U20M') echo 'selected'; ?>>U20M</option>
                    <option value="U20F" <?php if ($event['categorie'] == 'U20F') echo 'selected'; ?>>U20F</option>
                    <option value="SENIOR M" <?php if ($event['categorie'] == 'SENIOR M') echo 'selected'; ?>>SENIOR M</option>
                    <option value="SENIOR F" <?php if ($event['categorie'] == 'SENIOR F') echo 'selected'; ?>>SENIOR F</option>
                </select><br>
                <label for="adversaire">Adversaire :</label>
                <input type="text" id="adversaire" name="adversaire" value="<?php echo $event['adversaire']; ?>" required><br>
                <label for="date_heure">Date et Heure :</label>
                <input type="datetime-local" id="date_heure" name="date_heure" value="<?php echo date('Y-m-d\TH:i', strtotime($event['date_evenement'] . ' ' . $event['heure'])); ?>" required><br>
                <label for="lieu">Lieu :</label>
                <input type="text" id="lieu" name="lieu" value="<?php echo $event['lieu']; ?>" required><br>
                <input type="submit" value="Modifier l'événement">
            </form>
        <?php else: ?>
            <form action="modifier_evenement.php" method="post">
                <label for="event_id">Sélectionnez un événement à modifier :</label>
                <select id="event_id" name="event_id" required>
                    <?php foreach ($evenements as $evenement): ?>
                        <option value="<?php echo $evenement['id']; ?>">
                            <?php echo date('d/m/Y H:i', strtotime($evenement['date_evenement'] . ' ' . $evenement['heure'])) . ' - ' . $evenement['categorie'] . ' - ' . $evenement['adversaire']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
                <input type="submit" value="Sélectionner">
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
