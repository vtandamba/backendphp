<?php
// fichier api.php qui servira de point d'entrée pour notre API.
echo 'hi';
 
// Inclure le fichier de connexion à la base de données
 include 'back\includes\db_connect.php';
echo 'correct';
// Endpoint pour récupérer un utilisateur par son ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Récupérer l'ID de l'utilisateur à partir de la requête GET
    $user_id = $_GET['id'];

    // Exécuter une requête SQL pour récupérer les données de l'utilisateur
    $query = "SELECT * FROM users WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $user_id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Retourner les données de l'utilisateur au format JSON
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($user);
    } else {
        // Retourner une erreur si l'utilisateur n'existe pas
        http_response_code(404);
        echo json_encode(array('message' => 'Utilisateur non trouvé'));
    }
}
 

?>