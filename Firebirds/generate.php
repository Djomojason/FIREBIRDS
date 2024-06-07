<?php
include 'config.php';  // Inclure le fichier de configuration de la base de données
require('fpdf.php');  // Inclure la bibliothèque FPDF

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Préparer la déclaration SQL pour récupérer les données du joueur
    $stmt = $conn->prepare("SELECT * FROM joueurs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $joueur = $result->fetch_assoc();

        // Création du PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Détails du Joueur');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, 'Nom : ' . $joueur['nom']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Prénom : ' . $joueur['prenom']);
        // Ajouter d'autres champs ici

        $pdf->Output();
    } else {
        echo "Joueur non trouvé";
    }

    $stmt->close();
}
?>
