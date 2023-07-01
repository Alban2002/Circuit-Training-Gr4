<?php
// Connexion à la base de données

$BDD_host="localhost";
$BDD_user="root";
$BDD_password=""; // vide sous windows
$db = 'grp4_circuit_training';

class SeanceManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchListeExercises($userId)
    {
        $query = "SELECT * FROM exercices ORDER BY nom ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $exercises;
    }

    public function enregistrerSeance($userId, $listeExercices, $seanceValues)
    {
        //Extraire les valeur du forme de la séance
        $seance_nom = $seanceValues[0]['nom'];
        $seance_description = $seanceValues[0]['description'];
        $seance_duree = $seanceValues[0]['duree'];
        $seance_difficulte = $seanceValues[0]['difficulte'];
        $seance_type = $seanceValues[0]['type_seance'];

        // Insert the session into the `seances` table
        $insertSeanceQuery = "
        INSERT INTO seance (ID_coach,nom, type, description, duree, difficulte)
        VALUES (:ID_coach, :nom, :type_seance, :description, :duree, :difficulte)
    ";

        $stmt = $this->db->prepare($insertSeanceQuery);
        $stmt->bindParam(':ID_coach', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $seance_nom, PDO::PARAM_STR);
        $stmt->bindParam(':type_seance', $seance_type, PDO::PARAM_STR);
        $stmt->bindParam(':description', $seance_description, PDO::PARAM_STR);
        $stmt->bindParam(':duree', $seance_duree, PDO::PARAM_STR);
        $stmt->bindParam(':difficulte', $seance_difficulte, PDO::PARAM_STR);
        $stmt->execute();

        // Retrieve the ID of the inserted session
        $seanceId = $this->db->lastInsertId();

        // Insert the exercises of the session into the `contenu_seance` table
        $insertContenuQuery = "
        INSERT INTO contenu_seance (ID_seance, ID_exo, rang_exo, duree, quantite)
        VALUES (:seanceId, :ID_exo, :rang_exo, :duree, :quantite)
    ";

        $stmt = $this->db->prepare($insertContenuQuery);

        foreach ($listeExercices as $exercise) {
            $stmt->bindParam(':seanceId', $seanceId, PDO::PARAM_INT);
            $stmt->bindParam(':ID_exo', $exercise['exercice'], PDO::PARAM_INT);
            $stmt->bindParam(':rang_exo', $exercise['index'], PDO::PARAM_INT);
            //Expression ternaire en fonction du configurateur
            $duree = $exercise['configurateur'] === 'duree' ? $exercise['valeur'] : null;
            $quantite = $exercise['configurateur'] === 'quantite' ? $exercise['valeur'] : null;
            
            $stmt->bindParam(':duree', $duree, PDO::PARAM_INT);
            $stmt->bindParam(':quantite', $quantite , PDO::PARAM_INT);

            $stmt->execute();
        }

        return true;
    }

    function supprimerSeance($id_seance) {
        // Effectuer ici la suppression de la séance dans la base de données en utilisant l'ID spécifié

        $deleteSeanceQuery = "DELETE FROM seance WHERE ID_seance = :id_seance";
        $stmt = db->prepare($deleteSeanceQuery);
        $stmt->bindParam(':id_seance', $id_seance, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    // Vous pouvez ajouter d'autres méthodes pour d'autres fonctionnalités ici
}

// Connexion à la base de données
$db = new PDO("mysql:host=$BDD_host;dbname=$db", $BDD_user, $BDD_password);

$seanceManager = new SeanceManager($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'fetchListeExercises':
            if (isset($_POST['userId'])) {
                $exercises = $seanceManager->fetchListeExercises($_POST['userId']);
                echo json_encode($exercises);
            }
            break;
        case 'enregistrerSeance':
            // Récupérer les données envoyées dans la requête AJAX
            $userId = $_POST['userId'];
            $listeExercices = $_POST['ListeExercices'];
            $seanceValues = $_POST['seance'];
            // Appeler la fonction enregistrerExercices avec les données récupérées
            $success = $seanceManager->enregistrerSeance($userId, $listeExercices, $seanceValues);

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                $errorMessage = 'Erreur lors de l\'enregistrement de la séance';
                $jsonError = json_last_error_msg();
                if ($jsonError !== false) {
                    $errorMessage .= ': ' . $jsonError;
                }
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            }

            break;
        case 'supprimerSeance':
            if (isset($_POST['seanceId'])) {
                $exercises = $seanceManager->supprimerSeance($_POST['seanceId']);
                echo json_encode(['success' => true]);
            }
            else{
                echo json_encode(['success' => false]);
            }
            break;
        // ...
    }
}

?>