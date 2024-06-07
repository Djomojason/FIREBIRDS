<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $photo = $_FILES['photo']['name'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $sexe = $_POST['sexe'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $date_inscription = $_POST['date_inscription'];
    $ancien_centre = $_POST['ancien_centre'];
    $categorie = $_POST['categorie'];
    $lieu_residence = $_POST['lieu_residence'];
    $ecole_frequentee = $_POST['ecole_frequentee'];
    $main_forte = $_POST['main_forte'];
    $telephone = $_POST['telephone'];
    $telephone_pere = $_POST['telephone_pere'];
    $telephone_mere = $_POST['telephone_mere'];
    $inscription = isset($_POST['inscription']) ? 1 : 0;
    $tranche1 = isset($_POST['tranche1']) ? 1 : 0;
    $tranche2 = isset($_POST['tranche2']) ? 1 : 0;
    $tranche3 = isset($_POST['tranche3']) ? 1 : 0;
    $assurance = isset($_POST['assurance']) ? 1 : 0;
    $fiche_evaluation = $_FILES['fiche_evaluation']['name'];
    $dorcas = $_POST['dorcas'];

    // Déplacer les fichiers téléchargés vers le répertoire approprié
    move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . $photo);
    move_uploaded_file($_FILES['fiche_evaluation']['tmp_name'], 'docs/' . $fiche_evaluation);

    // Échapper les valeurs pour éviter les injections SQL
    $photo = $conn->real_escape_string($photo);
    $nom = $conn->real_escape_string($nom);
    $prenom = $conn->real_escape_string($prenom);
    $date_naissance = $conn->real_escape_string($date_naissance);
    $sexe = $conn->real_escape_string($sexe);
    $taille = $conn->real_escape_string($taille);
    $poids = $conn->real_escape_string($poids);
    $date_inscription = $conn->real_escape_string($date_inscription);
    $ancien_centre = $conn->real_escape_string($ancien_centre);
    $categorie = $conn->real_escape_string($categorie);
    $lieu_residence = $conn->real_escape_string($lieu_residence);
    $ecole_frequentee = $conn->real_escape_string($ecole_frequentee);
    $main_forte = $conn->real_escape_string($main_forte);
    $telephone = $conn->real_escape_string($telephone);
    $telephone_pere = $conn->real_escape_string($telephone_pere);
    $telephone_mere = $conn->real_escape_string($telephone_mere);
    $fiche_evaluation = $conn->real_escape_string($fiche_evaluation);
    $dorcas = $conn->real_escape_string($dorcas);

    // Préparer la déclaration SQL pour insérer les données du joueur
    $sql = "INSERT INTO joueurs (photo, nom, prenom, date_naissance, sexe, taille, poids, date_inscription, ancien_centre, categorie, lieu_residence, ecole_frequentee, main_forte, telephone, telephone_pere, telephone_mere, inscription, tranche1, tranche2, tranche3, assurance, fiche_evaluation, dorcas) 
            VALUES ('$photo', '$nom', '$prenom', '$date_naissance', '$sexe', '$taille', '$poids', '$date_inscription', '$ancien_centre', '$categorie', '$lieu_residence', '$ecole_frequentee', '$main_forte', '$telephone', '$telephone_pere', '$telephone_mere', $inscription, $tranche1, $tranche2, $tranche3, $assurance, '$fiche_evaluation', '$dorcas')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouveau joueur ajouté avec succès!";
    } else {
        echo "Erreur lors de l'exécution de la requête: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Joueur - FIREBIRDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FIREBIRDS - Ajouter un Joueur</h1>
    </header>
    <main>
        <form action="ajouter_joueur.php" method="post" enctype="multipart/form-data">
            <label for="photo">Photo :</label>
            <input type="file" id="photo" name="photo" required></br>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required></br>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required></br>
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" required></br>
            <label for="sexe">Sexe :</label>
            <select id="sexe" name="sexe">
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
            </select></br>
            <label for="taille">Taille :</label>
            <input type="number" id="taille" name="taille" step="0.01" required></br>
            <label for="poids">Poids :</label>
            <input type="number" id="poids" name="poids" step="0.01" required></br>
            <label for="date_inscription">Date d'inscription :</label>
            <input type="date" id="date_inscription" name="date_inscription" required></br>
            <label for="ancien_centre">Ancien centre de basket :</label>
            <input type="text" id="ancien_centre" name="ancien_centre"></br>
            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie">
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
            </select></br>
            <label for="lieu_residence">Lieu de résidence :</label>
            <input type="text" id="lieu_residence" name="lieu_residence" required></br>
            <label for="ecole_frequentee">École fréquentée :</label>
            <input type="text" id="ecole_frequentee" name="ecole_frequentee" required></br>
            <label for="main_forte">Main forte :</label>
            <select id="main_forte" name="main_forte">
                <option value="gauche">Gauche</option>
                <option value="droite">Droite</option>
            </select></br>
            <label for="telephone">Numéro de téléphone :</label>
            <input type="text" id="telephone" name="telephone" required></br>
            <label for="telephone_pere">Numéro de téléphone du père :</label>
            <input type="text" id="telephone_pere" name="telephone_pere"></br>
            <label for="telephone_mere">Numéro de téléphone de la mère :</label>
            <input type="text" id="telephone_mere" name="telephone_mere"></br>
            <label for="argent_verse">Argent versé :</label></br>
            <label for="inscription">Inscription (35000frs):</label>
            <input type="checkbox" id="inscription" name="inscription"><br>
            <label for="tranche1">Tranche 1 (5000frs):</label>
            <input type="checkbox" id="tranche1" name="tranche1"><br>
            <label for="tranche2">Tranche 2 (5000frs):</label>
            <input type="checkbox" id="tranche2" name="tranche2"><br>
            <label for="tranche3">Tranche 3 (5000frs):</label>
            <input type="checkbox" id="tranche3" name="tranche3"><br>
            <label for="assurance">Assurance (6000frs):</label>
            <input type="checkbox" id="assurance" name="assurance"><br>
            <label for="fiche_evaluation">Fiche d'évaluation :</label>
            <input type="file" id="fiche_evaluation" name="fiche_evaluation"></br>
            <label for="dorcas">Dorcas :</label>
            <input type="text" id="dorcas" name="dorcas"></br>
            <input type="submit" value="Ajouter le joueur">
        </form>
    </main>
</body>
</html>
