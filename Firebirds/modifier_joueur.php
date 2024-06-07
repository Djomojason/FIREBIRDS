<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Joueur - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FIREBIRDS - Modifier Joueur</h1>
    </header>
    <main>
        <?php
            // Récupération de l'ID du joueur depuis l'URL
            $id = $_GET["id"];

            // Connexion à la base de données
            include 'config.php';

            // Requête SQL pour récupérer les informations du joueur
            $sql = "SELECT * FROM joueurs WHERE id=$id";
            $result = $conn->query($sql);

            // Vérification des résultats
            if ($result->num_rows > 0) {
                // Affichage des informations du joueur dans un formulaire
                $row = $result->fetch_assoc();
                echo '<form action="traitement_modification.php" method="POST" enctype="multipart/form-data">';
                echo '<label for="photo">Photo :</label>';
                echo '<input type="file" id="photo" name="photo"><br>';
                if (!empty($row["photo"])) {
                    echo '<img src="img/' . $row["photo"] . '" alt="Photo du joueur" width="100"><br>';
                }
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo 'Nom: <input type="text" name="nom" value="' . $row["nom"] . '" readonly><br>';
                echo 'Prénom: <input type="text" name="prenom" value="' . $row["prenom"] . '" readonly><br>';
                echo 'Sexe: <input type="text" name="sexe" value="' . $row["sexe"] . '" readonly><br>';
                echo 'Date de naissance: <input type="date" name="date_naissance" value="' . $row["date_naissance"] . '"><br>';
                echo 'Taille: <input type="number" name="taille" value="' . $row["taille"] . '" step="0.01"><br>';
                echo 'Poids: <input type="number" name="poids" value="' . $row["poids"] . '" step="0.01"><br>';
                echo 'Date d\'inscription: <input type="date" name="date_inscription" value="' . $row["date_inscription"] . '"><br>';
                echo 'Ancien centre de basket: <input type="text" name="ancien_centre" value="' . $row["ancien_centre"] . '"><br>';
                echo 'Catégorie: <select name="categorie">';
                $categories = ["U10M", "U10F", "U12M", "U12F", "U14M", "U14F", "U16M", "U16F", "U18M", "U18F", "U20M", "U20F", "SENIOR M", "SENIOR F"];
                foreach ($categories as $categorie) {
                    $selected = $row["categorie"] == $categorie ? "selected" : "";
                    echo "<option value=\"$categorie\" $selected>$categorie</option>";
                }
                echo '</select><br>';
                echo 'Lieu de résidence: <input type="text" name="lieu_residence" value="' . $row["lieu_residence"] . '"><br>';
                echo 'École fréquentée: <input type="text" name="ecole_frequentee" value="' . $row["ecole_frequentee"] . '"><br>';
                echo 'Main forte: <select name="main_forte">';
                $main_forte_options = ["gauche", "droite"];
                foreach ($main_forte_options as $option) {
                    $selected = $row["main_forte"] == $option ? "selected" : "";
                    echo "<option value=\"$option\" $selected>$option</option>";
                }
                echo '</select><br>';
                echo 'Numéro de téléphone: <input type="text" name="telephone" value="' . $row["telephone"] . '"><br>';
                echo 'Numéro de téléphone du père: <input type="text" name="telephone_pere" value="' . $row["telephone_pere"] . '"><br>';
                echo 'Numéro de téléphone de la mère: <input type="text" name="telephone_mere" value="' . $row["telephone_mere"] . '"><br>';
                echo 'Argent versé:<br>';
                echo '<label for="inscription">Inscription (35000frs):</label>';
                echo '<input type="checkbox" id="inscription" name="inscription" ' . ($row["inscription"] ? "checked" : "") . '><br>';
                echo '<label for="tranche1">Tranche 1 (5000frs):</label>';
                echo '<input type="checkbox" id="tranche1" name="tranche1" ' . ($row["tranche1"] ? "checked" : "") . '><br>';
                echo '<label for="tranche2">Tranche 2 (5000frs):</label>';
                echo '<input type="checkbox" id="tranche2" name="tranche2" ' . ($row["tranche2"] ? "checked" : "") . '><br>';
                echo '<label for="tranche3">Tranche 3 (5000frs):</label>';
                echo '<input type="checkbox" id="tranche3" name="tranche3" ' . ($row["tranche3"] ? "checked" : "") . '><br>';
                echo '<label for="assurance">Assurance (6000frs):</label>';
                echo '<input type="checkbox" id="assurance" name="assurance" ' . ($row["assurance"] ? "checked" : "") . '><br>';
                if (!empty($row["fiche_evaluation"])) {
                    echo 'Fiche d\'évaluation: <a href="docs/' . $row["fiche_evaluation"] . '" target="_blank">Voir la fiche d\'évaluation</a><br>';
                }
                echo '<label for="fiche_evaluation">Nouvelle fiche d\'évaluation :</label>';
                echo '<input type="file" id="fiche_evaluation" name="fiche_evaluation"><br>';
                echo '<input type="submit" value="Enregistrer">';
                echo '</form>';
            } else {
                echo "Aucun résultat trouvé pour cet ID";
            }

            // Fermeture de la connexion à la base de données
            $conn->close();
        ?>
    </main>
</body>
</html>
