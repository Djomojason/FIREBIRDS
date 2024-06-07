<?php
include 'config.php';

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;
$evenements = [];
$categories = [];

// Récupérer toutes les catégories
$sql = "SELECT DISTINCT categorie FROM evenements";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row['categorie'];
    }
} elseif (!$result) {
    die('Erreur de requête : ' . $conn->error);
}

// Si une catégorie est sélectionnée, récupérer tous les matchs de cette catégorie
if ($categorie) {
    $sql = "SELECT * FROM evenements WHERE categorie='$categorie' ORDER BY date_evenement, heure";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $evenements[] = $row;
        }
    } elseif (!$result) {
        die('Erreur de requête : ' . $conn->error);
    }
}

// Mettre à jour le score si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['score'])) {
    $id = $_POST['id'];
    $score = $_POST['score'];

    $sql = "UPDATE evenements SET score_final = '$score' WHERE id = $id AND score_final IS NULL";
    if ($conn->query($sql) === TRUE) {
        header('Location: statistique.php?categorie=' . $_POST['categorie']);
        exit();
    } else {
        echo "Erreur de mise à jour du score: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Catégories - FIREBIRDS</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1e8e873;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            background-color: #f85206;
            color: rgb(5, 5, 5);
            padding: 10px 0;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #333;
            color: #fff;
            margin: 10px 0;
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        .score-form {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .score-form input {
            margin-left: 5px;
        }
    </style>
    <script>
        function afficherMatchs(categorie) {
            window.location.href = "statistique.php?categorie=" + categorie;
        }

        function afficherCourbe(evenements) {
            const ctx = document.getElementById('courbeResultats').getContext('2d');
            const dates = [];
            const scores = [];
            let victoires = 0, nuls = 0, defaites = 0;

            evenements.forEach(evenement => {
                dates.push(evenement.date);
                const score = evenement.score.split('-');
                const scoreEquipe = parseInt(score[0]);
                const scoreAdversaire = parseInt(score[1]);

                if (scoreEquipe > scoreAdversaire) {
                    scores.push(1); // Victoire
                    victoires++;
                } else if (scoreEquipe === scoreAdversaire) {
                    scores.push(0); // Nul
                    nuls++;
                } else {
                    scores.push(-1); // Défaite
                    defaites++;
                }
            });

            const data = {
                labels: dates,
                datasets: [{
                    label: 'Résultats',
                    data: scores,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Courbe d\'évolution des résultats'
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Résultat'
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value === 1) return 'Victoire';
                                    if (value === 0) return 'Nul';
                                    if (value === -1) return 'Défaite';
                                }
                            }
                        }
                    }
                }
            };
            new Chart(ctx, config);

            const totalMatchs = victoires + nuls + defaites;
            const pourcentageVictoires = totalMatchs ? (victoires / totalMatchs) * 100 : 0;
            const pourcentageNuls = totalMatchs ? (nuls / totalMatchs) * 100 : 0;
            const pourcentageDefaites = totalMatchs ? (defaites / totalMatchs) * 100 : 0;

            document.getElementById('pourcentageVictoires').innerText = 'Pourcentage de Victoires: ' + pourcentageVictoires.toFixed(2) + '%';
            document.getElementById('pourcentageNuls').innerText = 'Pourcentage de Nuls: ' + pourcentageNuls.toFixed(2) + '%';
            document.getElementById('pourcentageDefaites').innerText = 'Pourcentage de Défaites: ' + pourcentageDefaites.toFixed(2) + '%';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Statistiques des Catégories</h1>
        <?php if (!$categorie): ?>
            <ul>
                <?php foreach ($categories as $categorie): ?>
                    <li onclick="afficherMatchs('<?php echo $categorie; ?>')"><?php echo $categorie; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h2>Matchs de la catégorie <?php echo $categorie; ?></h2>
            <table>
                <tr>
                    <th>Date et Heure</th>
                    <th>Adversaire</th>
                    <th>Lieu</th>
                    <th>Score</th>
                    <th>Action</th>
                </tr>
                <?php
                $matchData = [];
                foreach ($evenements as $evenement):
                    $matchData[] = [
                        'date' => date('d/m/Y', strtotime($evenement['date_evenement'])),
                        'score' => $evenement['score_final']
                    ];
                ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($evenement['date_evenement'])); ?><br><?php echo date('H:i', strtotime($evenement['heure'])); ?></td>
                        <td><?php echo $evenement['adversaire']; ?></td>
                        <td><?php echo $evenement['lieu']; ?></td>
                        <td>
                            <?php if (is_null($evenement['score_final'])): ?>
                                <form action="statistique.php" method="post" class="score-form">
                                    <input type="hidden" name="id" value="<?php echo $evenement['id']; ?>">
                                    <input type="hidden" name="categorie" value="<?php echo $categorie; ?>">
                                    <input type="text" name="score" value="<?php echo $evenement['score_final']; ?>">
                                    <button type="submit">Mettre à jour</button>
                                </form>
                            <?php else: ?>
                                <?php echo $evenement['score_final']; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick="afficherCourbe(<?php echo htmlspecialchars(json_encode($matchData)); ?>)">Voir Courbe</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <canvas id="courbeResultats"></canvas>
            <div class="stats">
                <p id="pourcentageVictoires"></p>
                <p id="pourcentageNuls"></p>
                <p id="pourcentageDefaites"></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($categorie && count($evenements) > 0): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const matchData = <?php echo json_encode($matchData); ?>;
                afficherCourbe(matchData);
            });
        </script>
    <?php endif; ?>
</body>
</html>
