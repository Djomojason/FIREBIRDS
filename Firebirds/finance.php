<?php
include 'config.php';

// Récupérer la liste des joueurs qui n'ont pas terminé de payer leurs frais
$sql = "SELECT id, nom, prenom, inscription, tranche1, tranche2, tranche3, assurance 
        FROM joueurs 
        WHERE inscription = 0 OR tranche1 = 0 OR tranche2 = 0 OR tranche3 = 0 OR assurance = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Finance - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS pour masquer la colonne ID */
        .hidden { display: none; }
    </style>
</head>
<body>
    <header>
        <h1>FIREBIRDS - Finance</h1>
    </header>
    <main>
        <h1>Liste des joueurs avec des frais non payés</h1>
        <?php
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th class='hidden'>ID</th><th>Nom</th><th>Prénom</th><th>Inscription</th><th>Tranche 1</th><th>Tranche 2</th><th>Tranche 3</th><th>Assurance</th><th>Frais non payés</th></tr>";
            
            while($row = $result->fetch_assoc()) {
                $fraisNonPayes = [];
                if ($row['inscription'] == 0) {
                    $fraisNonPayes[] = "Inscription (35000frs)";
                }
                if ($row['tranche1'] == 0) {
                    $fraisNonPayes[] = "Tranche 1 (5000frs)";
                }
                if ($row['tranche2'] == 0) {
                    $fraisNonPayes[] = "Tranche 2 (5000frs)";
                }
                if ($row['tranche3'] == 0) {
                    $fraisNonPayes[] = "Tranche 3 (5000frs)";
                }
                if ($row['assurance'] == 0) {
                    $fraisNonPayes[] = "Assurance (6000frs)";
                }
                
                echo "<tr>";
                echo "<td class='hidden'>" . $row['id'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prenom'] . "</td>";
                echo "<td>" . ($row['inscription'] ? "Payé" : "Non payé") . "</td>";
                echo "<td>" . ($row['tranche1'] ? "Payé" : "Non payé") . "</td>";
                echo "<td>" . ($row['tranche2'] ? "Payé" : "Non payé") . "</td>";
                echo "<td>" . ($row['tranche3'] ? "Payé" : "Non payé") . "</td>";
                echo "<td>" . ($row['assurance'] ? "Payé" : "Non payé") . "</td>";
                echo "<td>" . implode(", ", $fraisNonPayes) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "Tous les joueurs ont terminé de payer leurs frais.";
        }

        $conn->close();
        ?>
    </main>
</body>
</html>

