<?php

$BDD_host="localhost";
$BDD_user="root";
$BDD_password="";
$BDD_base="grp4_circuit_training"; // nom de la base de données


$db = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);

$userID = $_SESSION['idUser'];
// Récupération des données pour suivre le pourcentage de séances effectuées
$sql = "SELECT COUNT(*) AS total_seances, SUM(statut_seance = 'fait') AS seances_effectuees FROM attribution_seance WHERE ID_user = $userID AND statut_seance != 'a faire' ";
$result = $db->query($sql);

if ($result) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalSeances = $row['total_seances'];
    $seancesEffectuees = $row['seances_effectuees'];

    // Calcul des pourcentages des séances effectuées
    $pourcentage = ($seancesEffectuees / $totalSeances) * 100;
} else {
    echo "Erreur lors de l'exécution de la requête : " . $db->error;
}

//Récupération des données pour les ressentis des séances
$sql = "SELECT MONTHNAME(date) AS mois, AVG(RessentitSeance) AS moyenne_notation FROM attribution_seance WHERE ID_user = $userID AND RessentitSeance != 0 AND date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY MONTH(date)";

$resultatNotation = $db->query($sql);

$mois = array();
$moyennesNotation = array();

while ($ligne = $resultatNotation->fetch(PDO::FETCH_ASSOC)) {
    $mois[] = $ligne['mois'];
    $moyennesNotation[] = $ligne['moyenne_notation'];
}

?>



<html>

<head>
    <title>Statistiques des séances</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .graphique-container {
            display: inline-block;
            margin: 20px auto;
            text-align: center;
        }

        h1 {
            text-align : center;
        }
    </style>

</head>

<body>
    <h1>Statistiques des séances</h1>

    
    <div style="display: flex; justify-content: center;">
        <div style="margin-right: 20px;">
            <canvas id="graphique-seances" style="width: 400px; height: 400px;"></canvas>
        </div>
        <div style="margin-left: 20px;">
            <canvas id="diagramme-barres" style="width: 400px; height: 400px;"></canvas>
        </div>
    </div>
    
    <script>

        var totalSeances = <?php echo $totalSeances; ?>;
        var seancesEffectuees = <?php echo $seancesEffectuees; ?>;
        var pourcentage = <?php echo $pourcentage; ?>;

        // Configurer les données du graph
        var data = {
            labels: ['Séances effectuées', 'Séances non effectuées'],
            datasets: [{
                data: [seancesEffectuees, totalSeances - seancesEffectuees],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        };

        var options = {
            responsive: false
        };

        // Graph
        document.write("Nombre total de séances : " + totalSeances + "<br>");
        document.write("Nombre de séances effectuées : " + seancesEffectuees + "<br>");
        document.write("Pourcentage de séances effectuées : " + pourcentage + "%<br>");

        var ctx = document.getElementById('graphique-seances').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });

        // Création des données pour le diagramme en barres
        var donneesDiagrammeBarres = {
            labels: <?php echo json_encode($mois); ?>,
            datasets: [{
                label: 'Ressenti moyen des séances par mois',
                data: <?php echo json_encode($moyennesNotation); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Configuration des options du diagramme en barres
        var optionsDiagrammeBarres = {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    reverse: true
                }
            }
        };

        // Affichage du diagramme en barres
        var contexteDiagrammeBarres = document.getElementById('diagramme-barres').getContext('2d');

        var monDiagrammeBarres = new Chart(contexteDiagrammeBarres, {
            type: 'bar',
            data: donneesDiagrammeBarres,
            options: optionsDiagrammeBarres
        });
        
    </script> 

</body>
</html>
