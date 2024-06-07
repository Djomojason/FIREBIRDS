<?php
include 'config.php';

// Requête SQL modifiée pour sélectionner les colonnes date_evenement et heure
$sql = "SELECT * FROM evenements ORDER BY date_evenement, heure";
$result = $conn->query($sql);

$evenements = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
} elseif (!$result) {
    die('Erreur de requête : ' . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier des événements - FIREBIRDS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
        .date {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }
        .heure {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function confirmerSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet événement?")) {
                window.location.href = "supprimer_evenement.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Calendrier des événements</h1>
        <table>
            <tr>
                <th>Date et Heure</th>
                <th>Catégorie</th>
                <th>Adversaire</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
            <?php foreach ($evenements as $evenement): ?>
                <tr>
                    <td class="date"><?php echo date('d/m/Y', strtotime($evenement['date_evenement'])); ?><br><?php echo date('H:i', strtotime($evenement['heure'])); ?></td>
                    <td><?php echo $evenement['categorie']; ?></td>
                    <td><?php echo $evenement['adversaire']; ?></td>
                    <td><?php echo $evenement['lieu']; ?></td>
                    <td>
                        <button onclick="confirmerSuppression(<?php echo $evenement['id']; ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
