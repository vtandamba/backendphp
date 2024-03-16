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

 

// Endpoint pour ajouter un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Récupérer les données de l'utilisateur à partir du corps de la requête POST
      $_POST = json_decode(file_get_contents("php://input"), true);
    /**
       * Lorsque vous utilisez json_decode(file_get_contents("php://input"), true), 
       * vous récupérez les données envoyées dans le corps de la requête HTTP au format JSON. 
       * Cette méthode est utilisée lorsque vous envoyez des données au format JSON depuis un 
       * client, comme dans le cas d'une requête AJAX ou d'une soumission de formulaire via 
       * JavaScript.
       * Si vous n'ajoutez pas cette ligne, PHP ne saura pas comment extraire les 
       * données envoyées dans le corps de la requête. Par conséquent, $_POST restera vide, car il
       * est destiné à contenir les données envoyées via le corps d'une requête HTTP en utilisant le format de contenu application/x-www-form-urlencoded (par exemple, les données d'un formulaire HTML standard).
       * En résumé, si vous utilisez json_decode(file_get_contents("php://input"),
       * true) pour récupérer les données JSON, vous n'avez pas besoin d'utiliser $_POST. Si vous
       * envoyez des données au format application/x-www-form-urlencoded, alors $_POST sera 
       * automatiquement rempli avec ces données et vous n'aurez pas besoin de json_decode(). 
       */

      // Vérifier si les données sont valides
      if (!isset($_POST['name']) || !isset($_POST['email'])) {
          http_response_code(400);
          echo json_encode(array('message' => 'Paramètres manquants'));
          exit;
      
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
    }

    // Insérer les données de l'utilisateur dans la base de données
    $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);

    $success = $statement->execute();

    // Vérifier si l'insertion a réussi
    if ($success) {
        // Retourner un message de succès
        http_response_code(201); // Code 201 pour création réussie
        echo json_encode(array('message' => 'Utilisateur ajouté avec succès'));
    } else {
        // Retourner une erreur si l'insertion a échoué
        http_response_code(500); // Code 500 pour erreur interne du serveur
        echo json_encode(array('message' => 'Erreur lors de l\'ajout de l\'utilisateur'));
    }
}

?>