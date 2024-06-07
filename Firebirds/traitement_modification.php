<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $id = isset($_POST["id"]) ? $_POST["id"] : '';
    $date_naissance = isset($_POST["date_naissance"]) ? $_POST["date_naissance"] : '';
    $taille = isset($_POST["taille"]) ? $_POST["taille"] : '';
    $categorie = isset($_POST["categorie"]) ? $_POST["categorie"] : '';
    $poids = isset($_POST["poids"]) ? $_POST["poids"] : '';
    $inscription = isset($_POST["inscription"]) ? 1 : 0;
    $tranche1 = isset($_POST["tranche1"]) ? 1 : 0;
    $tranche2 = isset($_POST["tranche2"]) ? 1 : 0;
    $tranche3 = isset($_POST["tranche3"]) ? 1 : 0;
    $assurance = isset($_POST["assurance"]) ? 1 : 0;
    $telephone = isset($_POST["telephone"]) ? $_POST["telephone"] : '';
    $telephone_pere = isset($_POST["telephone_pere"]) ? $_POST["telephone_pere"] : '';
    $telephone_mere = isset($_POST["telephone_mere"]) ? $_POST["telephone_mere"] : '';
    $dorcas = isset($_POST["dorcas"]) ? $_POST["dorcas"] : '';

    // Gestion des fichiers téléchargés
    $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
    $fiche_evaluation = isset($_FILES['fiche_evaluation']['name']) ? $_FILES['fiche_evaluation']['name'] : '';

    // Connexion à la base de données
    include 'config.php';

    // Préparation de la requête SQL pour mettre à jour les informations du joueur
    $sql = "UPDATE joueurs SET 
            date_naissance=?, 
            taille=?, 
            categorie=?, 
            poids=?, 
            inscription=?, 
            tranche1=?, 
            tranche2=?, 
            tranche3=?, 
            assurance=?, 
            telephone=?, 
            telephone_pere=?, 
            telephone_mere=?, 
            dorcas=?";

    // Ajout de la photo et de la fiche d'évaluation si téléchargés
    if (!empty($photo)) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $sql .= ", photo=?";
    }

    if (!empty($fiche_evaluation)) {
        $target_dir = "docs/";
        $target_file = $target_dir . basename($fiche_evaluation);
        move_uploaded_file($_FILES["fiche_evaluation"]["tmp_name"], $target_file);
        $sql .= ", fiche_evaluation=?";
    }

    $sql .= " WHERE id=?";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    if (!empty($photo) && !empty($fiche_evaluation)) {
        $stmt->bind_param("sdssdsssssssssi", $date_naissance, $taille, $categorie, $poids, $inscription, $tranche1, $tranche2, $tranche3, $assurance, $telephone, $telephone_pere, $telephone_mere, $dorcas, $photo, $fiche_evaluation, $id);
    } elseif (!empty($photo)) {
        $stmt->bind_param("sdssdsssssssssi", $date_naissance, $taille, $categorie, $poids, $inscription, $tranche1, $tranche2, $tranche3, $assurance, $telephone, $telephone_pere, $telephone_mere, $dorcas, $photo, $id);
    } elseif (!empty($fiche_evaluation)) {
        $stmt->bind_param("sdssdsssssssssi", $date_naissance, $taille, $categorie, $poids, $inscription, $tranche1, $tranche2, $tranche3, $assurance, $telephone, $telephone_pere, $telephone_mere, $dorcas, $fiche_evaluation, $id);
    } else {
        $stmt->bind_param("sdssdssssssssi", $date_naissance, $taille, $categorie, $poids, $inscription, $tranche1, $tranche2, $tranche3, $assurance, $telephone, $telephone_pere, $telephone_mere, $dorcas, $id);
    }

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Les informations du joueur ont été mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour des informations du joueur: " . $stmt->error;
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
}
?>
