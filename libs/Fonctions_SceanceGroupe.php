<?php
// Connexion à la base de données
$BDD_host="localhost";
$BDD_user="root";
$BDD_password=""; // vide sous windows
$db = 'grp4_circuit_training';

class GestionnaireSeances
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchGroupes()
    {
        $query = "SELECT ID_groupe, description FROM groupes";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $groupes;
    }

    public function fetchSeances()
    {
        $query = "SELECT ID_seance, nom FROM seance";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $seances;
    }
    public function fetchGroupSeances($groupeId)
    {
        $query = "
        SELECT a.ID_attribution_seance, s.nom ,a.date
        FROM seance s
        JOIN attribution_seance a ON s.ID_seance = a.ID_seance
        WHERE a.ID_groupe = :groupeId
    ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':groupeId', $groupeId, PDO::PARAM_INT);
        $stmt->execute();

        $seances = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $seances;
    }

    public function deleteAttribution($attributionId)
    {
        $query = "DELETE FROM attribution_seance WHERE ID_attribution_seance = :attributionId";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':attributionId', $attributionId, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }



    public function insertAttribution($groupes, $seance, $date)
    {
        $query = "INSERT INTO attribution_seance (ID_groupe, ID_seance, date) VALUES (:groupes, :seance, :date)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':groupes', $groupes, PDO::PARAM_INT);
        $stmt->bindParam(':seance', $seance, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);

        $stmt->execute();
    }
}

// Connexion à la base de données
$db = new PDO("mysql:host=$BDD_host;dbname=$db", $BDD_user, $BDD_password);

$seanceManager = new GestionnaireSeances($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'getGroupes':
            $groupes = $seanceManager->fetchGroupes();
            echo json_encode($groupes);
            break;

        case 'getSeances':
            $seances = $seanceManager->fetchSeances();
            echo json_encode($seances);
            break;

        case 'deleteAttribution':
            if (isset($_POST['attributionId'])) {
                $result = $seanceManager->deleteAttribution($_POST['attributionId']);

                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Séance supprimée avec succès']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'La suppression a échoué']);
                }
            }
            break;



        case 'insertAttribution':
            if (isset($_POST['groupes']) && isset($_POST['seance']) && isset($_POST['date'])) {
                $seanceManager->insertAttribution($_POST['groupes'], $_POST['seance'], $_POST['date']);
                echo "Séance ajoutée avec succès";
            }
            break;
        case 'getGroupSeances':
            if (isset($_POST['groupeId'])) {
                $seances = $seanceManager->fetchGroupSeances($_POST['groupeId']);
                echo json_encode($seances);
            }
            break;

    }
}
?>

