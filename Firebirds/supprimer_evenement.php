<?php
include 'config.php';

// Vérifier si l'ID de l'événement à supprimer est défini et non vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Échapper les données entrantes pour éviter les injections SQL
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Préparer et exécuter la requête SQL pour supprimer l'événement avec l'ID spécifié
    $sql = "DELETE FROM evenements WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "L'événement a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'événement: " . $conn->error;
    }
} else {
    echo "ID de l'événement non spécifié.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
