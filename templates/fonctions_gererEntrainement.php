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
    public function fetchUserSeances($userId)
    {
        $query = "
            SELECT as1.ID_seance, as1.date 
            FROM attribution_seance as1
            WHERE as1.ID_user = :userId
            ORDER BY as1.date ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $seances;
    }

    public function fetchExercises($seanceId)
    {
        $query = "SELECT e.ID_exo, e.description, e.nom, e.media, cs.duree, cs.quantite 
          FROM contenu_seance cs
          INNER JOIN exercices e ON cs.ID_exo = e.ID_exo
          WHERE cs.ID_seance = :seanceId
          ORDER BY cs.rang_exo ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seanceId', $seanceId, PDO::PARAM_INT);
        $stmt->execute();

        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $exercises;
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
        INSERT INTO seance (nom, type, description, duree, difficulte)
        VALUES (:nom, :type_seance, :description, :duree, :difficulte)
    ";

        $stmt = $this->db->prepare($insertSeanceQuery);
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
            $duree = $exercise['configurateur'] === 'duree' ? $exercise['valeur'] : null;
            $quantite = $exercise['configurateur'] === 'quantite' ? $exercise['valeur'] : null;
            $stmt->bindParam(':duree', $duree, PDO::PARAM_INT);
            $stmt->bindParam(':quantite', $quantite , PDO::PARAM_INT);

            $stmt->execute();
        }

        return true; // or you can return the seanceId if needed
    }
    // Vous pouvez ajouter d'autres méthodes pour d'autres fonctionnalités ici
}

// Connexion à la base de données
$db = new PDO("mysql:host=$BDD_host;dbname=$db", $BDD_user, $BDD_password);

$seanceManager = new SeanceManager($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'fetchExercises':
            if (isset($_POST['seanceId'])) {
                $exercises = $seanceManager->fetchExercises($_POST['seanceId']);
                echo json_encode($exercises);
            }
            break;

        case 'otherFunction':
            if (isset($_POST['otherData'])) {
                $result = $seanceManager->otherFunction($_POST['otherData']);
                echo json_encode($result);
            }
            break;
        case 'fetchUserSeances':
            if (isset($_POST['userId'])) {
                $seances = $seanceManager->fetchUserSeances($_POST['userId']);
                echo json_encode($seances);
            }
            break;

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
        // ...
    }
}

?>