<?php
/**
 * Script pour enregistrer les coordonnées GPS envoyées par l'application Android
 */
require_once 'db_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lat = isset($_POST['latitude']) ? $_POST['latitude'] : null;
    $lon = isset($_POST['longitude']) ? $_POST['longitude'] : null;

    if ($lat !== null && $lon !== null) {
        try {
            $sql = "INSERT INTO positions (latitude, longitude, date) VALUES (?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$lat, $lon]);

            echo json_encode(["status" => "success", "message" => "Position enregistrée avec succès"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Erreur lors de l'insertion : " . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Données manquantes (latitude ou longitude)"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}
?>