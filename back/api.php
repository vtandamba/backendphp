<?php
// fichier api.php qui servira de point d'entrée pour notre API.
// echo 'hi';
 
// Inclure le fichier de connexion à la base de données
 include './includes/db_connect.php';
/**
 * les entetes 
 * -----------  Problemes rencontré : 
 * Le message d'erreur indique que vous faites face à
 * un problème lié à la politique de même origine (Same Origin Policy) et 
 * aux en-têtes CORS (Cross-Origin Resource Sharing) manquants. 
 * Cela se produit lorsque vous essayez de faire une requête depuis un 
 * domaine différent de celui de votre API, et que le serveur de l'API ne 
 * renvoie pas les en-têtes CORS nécessaires pour permettre à votre 
 * application frontale d'accéder à l'API.
 * 
 * ---------   solution*
 * */
// Permettre l'accès depuis n'importe quel domaine
header('Access-Control-Allow-Origin: *');

// Permettre les méthodes GET et OPTIONS
header('Access-Control-Allow-Methods: GET, OPTIONS');

// Autoriser les en-têtes spécifiques dans la requête
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');




// Endpoint pour récupérer un utilisateur par son ID
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
//     // Récupérer l'ID de l'utilisateur à partir de la requête GET
//     $user_id = $_GET['id'];

//     // Exécuter une requête SQL pour récupérer les données de l'utilisateur
//     $query = "SELECT * FROM users WHERE id = :id";
//     $statement = $pdo->prepare($query);
//     $statement->execute(['id' => $user_id]);
//     $user = $statement->fetch(PDO::FETCH_ASSOC);

//     // Vérifier si l'utilisateur existe
//     if ($user) {
//         // Retourner les données de l'utilisateur au format JSON
//         http_response_code(200);
//         header('Content-Type: application/json');
//         echo json_encode($user);
//     } else {
//         // Retourner une erreur si l'utilisateur n'existe pas
//         http_response_code(404);
//         echo json_encode(array('message' => 'Utilisateur non trouvé'));
//     }
// }
 
// Endpoint pour récupérer tous les utilisateurs
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Exécuter une requête SQL pour récupérer toutes les données des utilisateurs
    $query = "SELECT * FROM users";
    $statement = $pdo->query($query);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données de tous les utilisateurs au format JSON
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    echo json_encode(['message' => "post"]);
}

?>