<?php
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "firebirds_db");

// Vérification de la connexion
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Requêtes pour obtenir les données nécessaires
$result = $mysqli->query("SELECT COUNT(*) as total FROM joueurs");
$total_joueurs = $result->fetch_assoc()['total'];

$result = $mysqli->query("SELECT COUNT(*) as total, sexe FROM joueurs GROUP BY sexe");
$joueurs_par_sexe = [];
while ($row = $result->fetch_assoc()) {
    $joueurs_par_sexe[$row['sexe']] = $row['total'];
}

$result = $mysqli->query("SELECT * FROM evenements ORDER BY date_evenement DESC LIMIT 5");
$dernieres_rencontres = $result->fetch_all(MYSQLI_ASSOC);

$result = $mysqli->query("SELECT * FROM evenements ORDER BY date_evenement ASC LIMIT 5");
$prochaines_rencontres = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FIREBIRDS - Tableau de Bord</h1>
    </header>
    <main>
        <section>
            <h2>Saison en cours 2024</h2>
            <p>Nombre total de joueurs: <?php echo $total_joueurs; ?></p>
            <p>Nombre de garçons: <?php echo $joueurs_par_sexe['M'] ?? 0; ?></p>
            <p>Nombre de filles: <?php echo $joueurs_par_sexe['F'] ?? 0; ?></p>
        </section>
        <section>
            <h2>Dernières rencontres</h2>
            <ul>
                <?php foreach ($dernieres_rencontres as $rencontre) { ?>
                    <li><?php echo $rencontre['categorie'] . " vs " . $rencontre['adversaire'] . " - " . $rencontre['date_evenement']; ?></li>
                <?php } ?>
            </ul>
        </section>
        <section>
            <h2>Prochaines rencontres</h2>
            <ul>
                <?php foreach ($prochaines_rencontres as $rencontre) { ?>
                    <li><?php echo $rencontre['categorie'] . " vs " . $rencontre['adversaire'] . " - " . $rencontre['date_evenement']; ?></li>
                <?php } ?>
            </ul>
        </section>
    </main>
</body>
</html>
