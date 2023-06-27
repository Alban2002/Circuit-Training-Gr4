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
            SELECT as1.ID_seance, as1.date , as1.statut_seance 
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
    public function updateSeanceStatus($seanceId, $status)
    {
        $query = "
        UPDATE attribution_seance
        SET statut_seance = :status
        WHERE ID_seance = :seanceId
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seanceId', $seanceId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
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
    public function fetchSeanceDetails($seanceId)
    {
        $query = "
            SELECT description, difficulte, duree, type 
            FROM seance
            WHERE ID_seance = :seanceId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':seanceId', $seanceId, PDO::PARAM_INT);
        $stmt->execute();

        $seanceDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $seanceDetails;
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

        case 'fetchSeanceDetails':
            if (isset($_POST['seanceId'])) {
                $seanceDetails = $seanceManager->fetchSeanceDetails($_POST['seanceId']);
                echo json_encode($seanceDetails);
            }
            break;
        case 'updateSeanceStatus':
            if (isset($_POST['seanceId']) && isset($_POST['status'])) {
                $seanceManager->updateSeanceStatus($_POST['seanceId'], $_POST['status']);
            }
            break;


    }
}

?>